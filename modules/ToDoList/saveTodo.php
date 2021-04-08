<?php

require_once('include/database/PearDatabase.php');
 $db = new PearDatabase();
 $str ="";
if ( isset( $_POST['addTodo'] ) ) 
{
	
	 $sql = "INSERT INTO todolist(username, item,date) VALUES (?,?,?)";
	 $d = new DateTime($_POST['dateTodo']);
	 $d->setTime(intval($_POST['hourTodo']),intval($_POST['minTodo']));
	 $dateTodo = $d->format("Y-m-d H:i");
	 $db->pquery($sql, array($current_user->user_name,$_POST['task'],$dateTodo)) or die("Error add Todo: ".mysql_error());
	 $select = 'select max(id) as id from todolist';
	 $res = $db->pquery($select, array());
	 $insertedID = $db->query_result($res,0,'id');
	 echo $insertedID;
}

if ( isset( $_POST['dellTodo'] ) ) 
{
    $username = $current_user->user_name;
    $dellID = intval($_POST['ID']);
	$sql = "DELETE FROM todolist WHERE ID = ? AND username = ?";
	$db->pquery($sql, array($dellID,$username)) or die("Error delete Todo: ".mysql_error());
	echo $dellID;
} 

if ( isset( $_POST['doneTodo'] ) ) 
{
    $username = $current_user->user_name;
    $doneID = intval($_POST['ID']);
	$status = intval($_POST['status']);
	$sql = "update todolist set status=? WHERE ID = ? AND username = ?";
	$db->pquery($sql, array($status,$doneID,$username)) or die("Error delete Todo: ".mysql_error());
	echo $doneID;
} 

if ( isset( $_POST['allTodo'] ) ) 
{
    $username = $current_user->user_name;
    $sql = "select * FROM todolist WHERE username = ? order by date";
	$result = $db->pquery($sql, array($username));
	$todos = array();
	$i=0;
	$str = "[";
    $first = true;
	$num_rows=$db->num_rows($result);
	for($i=0; $i<$num_rows;$i++)
	{
			//$rowTodo= new array();
			$rowTodo['id'] = $db->query_result($result,$i,"id");
			$date = $db->query_result($result,$i,"date");
			$d = new DateTime($date);
			$rowTodo['date'] = $d->format("d-m-Y H:i");
			$rowTodo['item']= $db->query_result($result,$i,"item");
			$rowTodo['status'] = $db->query_result($result,$i,"status");
			if ( !$first ) {$str .= ',';}
            $first = false;
            $str .= toJson($rowTodo);
    }
    $str .= ']';	
	echo $str;
}	
 

function toJson($row) {
        $str = "{";
        $first = true;
        foreach( $row as $key => $value ) {
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
?>