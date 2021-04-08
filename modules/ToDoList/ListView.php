<?php

require_once("Buttons_List.php");
require_once('include/utils/CommonUtils.php');
require_once('modules/Calendar/CalendarCommon.php');
$request = null;

?>

<html>
<head>
<script type="text/javascript" src="modules/ToDoList/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="modules/ToDoList/scriptaculous/scriptaculous.js?load=effects"></script>
<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<link rel="stylesheet" type="text/css" media="all" href="themes/softed/style.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-fr.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="modules/ToDoList/todo.js"></script>
<script type="text/javascript" src="modules/ToDoList/style.css"></script>
</head>
<body onload="init()">

<div id=main>

<div id=status>
</div>
<br>
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
 
<form action="javascript:addToList();void(0)" id=todoForm>
<table align="center" class="small">
<tr><td colspan=6 class="detailedViewHeader" align="left"><b>Information Tache</b></td></tr>
<tr>
  <td class="dvtCellLabel" align=right><b>Tache</b></td>
  <td align=left class="dvtCellInfo" width="100">
    <textarea cols=10 name="bigtext" rows=2 style="display:none"></textarea>
    <input type=text size=30 name="smalltext">
	<input type=hidden name="todoID">
	<br><font size=1><em old="(yyyy-mm-dd)"><a id=spaceToggle href="javascript:toggleMoreText();void(0)">Agrandir</a></em></font>
  </td>	
 <td class="dvtCellLabel" align=right><b>Date</b></td> 
 
 <td align="left" class="dvtCellInfo">
	<input type="text" name="datetodo" id="jscal_field_datetodo" value="<?php echo date("d-m-Y") ?>" class="textbox" style="width:90px" >
	<img border=0 src="modules/ToDoList/img/btnL3Calendar.gif" id="jscal_trigger_datetodo">
	<br><font size=1><em old="(yyyy-mm-dd)">dd-mm-yyyy</em></font>
<script type="text/javascript" id='massedit_calendar_datetodo'>
Calendar.setup ({
	inputField : "jscal_field_datetodo", ifFormat : "%d-%m-%Y", showsTime : false, button : "jscal_trigger_datetodo", singleClick : true, step : 1
})
</script>
</td>
 <td align="left" class="dvtCellInfo"><?php echo getTimeComboSimple(); ?></td>
  <td class="dvtCellInfo">   
      <input class="crmbutton small save" type=button value="Ajouter" onclick='addToList()'  style="width:70px"/>
  </td>
	
	</tr>
	
<tr>
   <td colspan="6">
		<div class=todoList id=todoList width="100%"></div>
	</td>
</tr>

</table>	


</div> <!--main-->
</form>
</body>
</html>
