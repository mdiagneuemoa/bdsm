<?php
require_once('include/database/PearDatabase.php');

class TodoItem
{
    private static $fields = array( 'ID', 'dateTodo', 'task', 'status' );

    public $properties = array();

    function __set_state($an_array) {
        $obj = new TodoItem;
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
        $item = new TodoItem();
        foreach ( self::$fields as $field ) {
            $item->set( $field, $_POST[$field] );
        }

        return $item;
    }
}

class AddItemRequest
{
    function serve() {
        return getDb()->addItem( TodoItem::createFromPost() ) ;
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
        getDb()->changeItem( TodoItem::createFromPost() ) ;
        return "ok";
    }
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
    if (!is_object($instance) ) 
	{
       $instance = new PermanentTodoDb();
       
    }
    return $instance;
}

class PermanentTodoDb
{
	private $db;
    function __construct() {
        $this->db = new PearDatabase();
    }

    function addItem( $item ) 
    {
        $_SESSION['todos'] = serialize($item->properties);    
        $userid = $current_user->user_name;
        $blob = $item->get('task');
        
        $sql = "INSERT INTO todolist(userid, item,date) VALUES (?,?,?)";
		$this->db->pquery($sql, array($userid,$blob,$item->get('dateTodo')));
        echo $current_user->user_name;   
    }

    function delItem( $id )
    {
       $userid = $this->db->escapeSimple($current_user->user_name);
       $ID = $db->escapeSimple($id);
		$sql = "DELETE FROM todolist WHERE ID = ? AND userid = ?";
		$this->db->pquery($sql, array($id,$userid));
    }

    function getItems()
    {
       $userid = $this->db->escapeSimple($_SESSION['autenticate_user_id']);
       $sql = "SELECT * FROM todolist WHERE userid=? ORDER BY ID;";
	   $result = $this->db->pquery($sql, array($userid));
        $items = array();

        
        
        return $items;
        
    }
}

?>

