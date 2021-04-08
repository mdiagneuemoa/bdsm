<?php
class Intervention
{
    private static $fields = array( 'ID', 'date', 'client', 'dossierClient', 'tache', 'duree');
    public $properties = array();

    function __set_state($an_array) {
        $obj = new Intervention;
        $obj->properties = $an_array['properties'];
        return $obj;
    }

    function set($property, $value) {
        $this->properties[$property] = $value;
    }

    function get($property) {
        return $this->properties[$property];
    }

    function toJson() {
        $str = "{";
        $first = true;
        foreach( $this->properties as $key => $value ) {
            if ( !$first ) {
                $str .= ",";
            }
            $first = false;
            $str .= "$key:\"" . str_replace(
                    array("\n", "\r"), array("\\n", "\\r"),
                    $value ) . "\"";
        }
        $str .= "}";
        return $str;
    }

    function mergeFrom($item) {
        foreach( self::$fields as $field ) {
            if ( isset( $item->properties[$field] ) ) {
                $this->properties[$field] = $item->properties[$field];
            }
        }
    }
    
    static function createFromPost()
    {
        global $_POST;
        $item = new Intervention();
		foreach ( self::$fields as $field ) {
            $item->set( $field, $_POST[$field] );
        }

        return $item;
    }
}

class AddItemRequest
{
    function serve() {
		$instance = new SessionTodoDb();
        return $instance->addItem( Intervention::createFromPost() ) ;
    }
}

class DelItemRequest
{
    function serve() {
        global $_POST;
        getDb()->delItem( $_POST['ID'] );
        return "ok";
    }
}

class SetItemInfoRequest
{
    function serve() {
        getDb()->changeItem( Intervention::createFromPost() ) ;
        return "ok";
    }
}


function mergeSessionWithDb()
{
    global $_SESSION;
    foreach( $_SESSION['interventions'] as $item ) {
        getDb()->addItem( $item );
    }
    unset($_SESSION['interventions']);
}

class GetItemsRequest
{
    function serve()
    {
        $todo = getDb()->getItems();

        $str = "[";
        $first = true;
        foreach( $todo as $item ) {
            if ( !$first ) {
                $str .= ',';
            }
            $first = false;
            $str .= $item->toJson();
        }
        $str .= ']';
        return $str;
    }
}

function getDb()
{
    static $instance;
    if (!is_object($instance) ) {
        global $_SESSION;
       // if ( isset($_SESSION['username'] ) ) {
          if ( isset($_SESSION['authenticated_user_id'] ) ) {
			// Logged in -- access mysql database.
            global $DatabaseName;
            $instance = new PermanentTodoDb($DatabaseName);
			$_SESSION['instance']="PermanentTodoDb";
        } else {
            // Not logged in -- use cookies.
			$_SESSION['instance']="SessionTodoDb";
            $instance = new SessionTodoDb();
        }
    }

    return $instance;
}

class Database {
    private $source;

    function __construct( $source ) {
        $this->source = $source;
    }
    
    function connectDb() {
        require_once('DB.php');
        $db = DB::connect($this->source);
        if ( DB::iserror($db)) {
            die($db->getMessage());
        }

        return $db;
    }
}

class SessionTodoDb
{
    function addItem( $item ) 
    {
        global $_SESSION, $interventions;
        $nextID = $_SESSION['nextID'];
        $_SESSION['interventions'][$nextID] = serialize($item->properties);
		//print_r($item);
        $item->set('ID', $nextID);
        $_SESSION['nextID'] += 1;
		//$_SESSION['date']=$item->get('date');
        return $nextID;
    }

    function delItem( $id )
    {
        unset($_SESSION['interventions'][$id]);
    }

    function changeItem( $item )
    {
        global $_SESSION;
        $_SESSION['interventions'][$item->get('ID')]->mergeFrom($item);
    }

    function getItems()
    {
        global $_SESSION;
        return $_SESSION['interventions'];
    }
	function delAllItem( )
    {
        unset($_SESSION['interventions']);
    }
}

class PermanentTodoDb extends Database
{
    function __construct($source) {
        parent::__construct($source);
    }

    function addItem( $item ) 
    {
        global $_SESSION;
        $db = $this->connectDb();
        $ID = $db->nextId("todoid");
        $item->set('ID', $ID);

        $username = $db->escapeSimple($_SESSION['username']);
        $blob = $db->escapeSimple(var_export($item, TRUE));

        $sql = <<<EOF
            INSERT INTO Todo
            (ID, username, item)
            VALUES
            ("$ID", "$username", "$blob");
EOF;
        $q = $db->query($sql);
        if (DB::iserror($q)) {
            return $q->getMessage();
        }

        $q = $db->commit();
        if (DB::iserror($q)) {
            return $q->getMessage();
        }
        return $ID;
    }

    function delItem( $id )
    {
        global $_SESSION;
        $db = $this->connectDb();
        $username = $db->escapeSimple($_SESSION['username']);
        $ID = $db->escapeSimple($id);

        $sql = <<<EOF
            DELETE FROM Todo WHERE ID = "$id" AND username = "$username";
EOF;
        $db = $this->connectDb();
        $q = $db->query($sql);
        if (DB::iserror($q)) {
            echo "<pre>$sql</pre>";
            die($q->getMessage());
        }
        $db->commit();
    }

    function changeItem( $newitem )
    {
        global $_SESSION;
        $db = $this->connectDb();
        $username = $db->escapeSimple($_SESSION['username']);
        $ID = $db->escapeSimple($newitem->get('ID'));
        $sql = <<<EOF
            SELECT * FROM Todo 
            WHERE username="$username" AND ID="$ID";
EOF;
        $q = $db->query($sql);
        if ( DB::iserror($q)) {
            die($q->getMessage());
        }

        $row = $q->fetchRow(DB_FETCHMODE_OBJECT);
        if ( $row == null || $row->password != $password ) {
            return false;
        }
        
        eval("\$item = $row->item;");
        $item->mergeFrom($newitem);
        $blob = $db->escapeSimple(var_export($item, TRUE));
        
        $sql = <<<EOF
            UPDATE Todo
            SET item="$blob"
            WHERE username="$username" AND ID="$ID";
EOF;

        $q = $db->query($sql);
        if (DB::iserror($q)) {
            echo "<pre>$sql</pre>";
            die($q->getMessage());
        }

        $db->commit();
    }

    function getItems()
    {
        global $_SESSION;
        $db = $this->connectDb();
        $username = $db->escapeSimple($_SESSION['username']);

        $sql = "SELECT * FROM Todo WHERE username=\"$username\" ORDER BY ID;";

        $items = array();

        // look for record for given user name.
        $q = $db->query($sql);
        if ( DB::iserror($q)) {
            die($q->getMessage());
        }

        for($i = 0;;$i++) {
            $row = $q->fetchRow(DB_FETCHMODE_OBJECT);
            if ( $row == NULL ) {
                break;
            }

            eval("\$items[] = $row->item;");
        }

        return $items;
    }
}
?>