function edittaskscript($){

	function NumberBox(element){
		var elementId = element.attr("id");
		var boxId = '#'+elementId+'-number-box';
		var str = "";
		for(var i = 1; i <= 30; i++){
			str += '<a href="#'+i+'" class="box_cel">'+i+'</a> ';
			if(!(i % 5)){
				str+="<br>";
			}
		}
		element.after('<div id="'+elementId+'-number-box" style="display:none;" class="box">'+str+'</div>');
		element.focus(function(){
			var pos = element.position();
			$(boxId).css('display', 'block');
			$(boxId).css({
				position: 'absolute',
				top: (pos.top+40)+'px'
				//left: (pos.left)+'px'
			});
		});

		element.blur(function(){
			setTimeout(function(){$(boxId).css('display', 'none');},500);
		});

		$('.box_cel').click(function(){
			element.attr('value', $(this).text());
		});
	}



    $(document).ready(function(){
		NumberBox($('#select_date_days'));
        //UI to set the date for executing the task.
    	$('#check_select_date').click(function(){
    	    if($(this).attr('checked')){
    	        $('#select_date').css('display', 'block');
    	    }else{
    	        $('#select_date').css('display', 'none');
    	    }
    	});
    });
}