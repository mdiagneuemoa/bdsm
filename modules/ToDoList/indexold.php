<?php
include_once("modules/ToDoList/classes.php");
$DatabaseName = "mysql://root@localhost/Todo";



// ----------------------------------------------------------------------------
// Main web page stuff
// ----------------------------------------------------------------------------
// create the session. Make sure it lasts as long as possible.
session_set_cookie_params(604800); // one week
session_start();

if ( isset( $_GET['logout'] ) ) {
    unset($_SESSION['username']);
    unset($_SESSION['todo']);
}

// if there isn't anything in the session already, initialize it.
if ( !isset($_SESSION['todo'] ) ) {
    $_SESSION['todo'] = array();
    $_SESSION['nextID'] = 1;
}

$todo = $_SESSION['todo'];

$request = null;

if ( isset( $_POST['additem'] ) ) {
    $request = new AddItemRequest();
} else if ( isset( $_POST['delitem'] ) ) {
    $request = new DelItemRequest();
} else if ( isset( $_POST['setiteminfo'] ) ) {
    $request = new SetItemInfoRequest();
} else if ( isset( $_POST['getitems'] ) ) {
    $request = new GetItemsRequest();
} else if ( isset( $_POST['createAccount'] ) ) {
    $request = new CreateAccountRequest();
} else if ( isset( $_POST['login'] ) ) {
    $request = new LoginRequest();
}

if ( isset($_GET['dump'] ) ) {
    echo "<pre>".var_export($_SESSION)."</pre>";
}

if ( $request ) {
    echo $request->serve();
    exit(0);
}

?>

<html>
<head>
<script type="text/javascript" src="modules/ToDoList/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="modules/ToDoList/scriptaculous/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="modules/ToDoList/todo.js"></script>
<script type="text/javascript">
<link rel="stylesheet" type="text/css" href="modules/ToDoList/style.css"/>

<?php
if ( isset( $_SESSION['username'] ) ) {
    echo 'var username = "' . $_SESSION["username"] . '";';
} else {
    echo "var username = null;\n";
}
?>


</style>
</head>

<body onload="init()">

<div id=main>

<div style="text-align:right">
<div class=loading id=signInWait>
Loading...
</div></div>
<div id=status>
</div>
<div id=signin class=signin>
<form action="javascript:signIn();void(0)" id=signInForm>
    <div class=loginResult id=loginResult>
        
    </div>
    Username: <input type=text size=15 name="username">
    Password: <input type=password size=15 name="password">
    <input type=submit value="Sign in"><br>
    <a href="javascript:createAccount();void(0)">Create account</a>
</form>
</div> <!--signin-->

<h1 class=title>My Todo List.ca </h1>

<form action="javascript:addToList();void(0)" id=todoForm>
    <textarea cols=60 name="bigtext" rows=10 style="display:none"
    ></textarea>
    <input type=text size=60 name="smalltext">
    <input type=button value="Add" onclick='addToList()'/><br>
    <a id=spaceToggle href="javascript:toggleMoreText();void(0)">More space</a>
</form>

<div class=todoList id=todoList>
</div>

</div> <!--main-->

<center>
<div id=createAccount class=createAccount>
<div> <!-- Wrapper need by scriptaculous --> 
<h1>Create Account</h1>
<form id=newAccount action="javascript:submitAccount();void(0)">
<p align=left style='margin:1em;'>
Creating an account will allow you to save your todo list on our server, so you
can access it later.
</p>
<div id=accountCreateErrors></div>

<table>
<tr><td>User name:</td><td><input type=text name=username size=30></td></tr>
<tr><td>Password:</td><td><input type=password name=password size=30></td></tr>
<tr><td>Re-enter password:</td><td><input type=password name=password2 size=30></td></tr>
<tr><td>Email Address:</td><td><input type=text name=email size=30></td></tr>
</table>
<input type=submit value="Create Account">
<input type=button value="Go Back" onclick="javascript:backFromCreateAccount()">
<input type=hidden name="login" value="1">
</form>
</div>
</div>
</center>
<a name="#createAccount">

</body>
</html>
