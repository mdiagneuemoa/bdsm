<?php /* Smarty version 2.6.18, created on 2009-06-04 16:31:35
         compiled from com_vtiger_workflow/taskforms/VTEntityMethodTask.tpl */ ?>
<script type="text/javascript" charset="utf-8">
var moduleName = '<?php echo $this->_tpl_vars['entityName']; ?>
';
var methodName = '<?php echo $this->_tpl_vars['task']->methodName; ?>
';
<?php echo '
	function entityMethodScript($){
		
		function jsonget(operation, params, callback){
			var obj = {
					module:\'com_vtiger_workflow\', 
					action:\'com_vtiger_workflowAjax\',	
					file:operation, ajax:\'true\'};
			$.each(params,function(key, value){
				obj[key] = value;
			});
			$.get(\'index.php\', obj, 
				function(result){
					var parsed = JSON.parse(result);
					callback(parsed);
			});
		}
		
		
		$(document).ready(function(){
			jsonget(\'entitymethodjson\', {module_name:moduleName}, function(result){
				if(result.length==0){
					$(\'#method_name_select\').css("display", "none");
					$(\'#message_text\').css("display", "inline");
				}else{
					$(\'#method_name_select\').css("display", "inline");
					$(\'#message_text\').css("display", "none");
					$.each(result, function(i, v){
						var optionText = \'<option value="\'+v+\'" \'+(v==methodName?\'selected\':\'\')+\'>\'+v+\'</option>\';
						$(\'#method_name_select\').append(optionText);
					});
				}
			});
		});
	}
'; ?>

entityMethodScript(jQuery);
</script>


<span>Method Name</span> : 
<select name="methodName" id="method_name_select"></select>
<sspan id="message_text">No method is available for this module.</sspan>