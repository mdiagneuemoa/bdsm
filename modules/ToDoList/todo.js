
       
function onServerError()
{
    alert("There is a problem accessing the server. " + 
                "You should reload the page.");
}

function TodoItem(scriptid, text, creationDate)
{
    var div = document.createElement('div');
    div.style.marginBottom = "3px";
    div.style.fontFamily = "Trebuchet MS";
    div.style.fontSize = "10pt";
    div.style.textAlign = "left";
    div.itemID = null;
    div.scriptids = scriptid;
    div.originalText = text;
    div.creationDate = creationDate;
    
    //---------------------------------------------------------------------
    // create div for the delete | edit | []
    textDelete = document.createTextNode('supprimer');
    aDelete = document.createElement('a');
    aDelete.href="javascript:deleteClicked(" + scriptid + ");void(0)";
    aDelete.appendChild( textDelete );
    aEdit = document.createElement('a');
    aEdit.href="javascript:editClicked(" + scriptid + ");void(0)";
    div.editTextNode = document.createTextNode('editer');
    aEdit.appendChild( div.editTextNode );
    links = document.createElement( 'div' );
    links.style.fontSize = "8pt";
    links.appendChild( aDelete );
    links.appendChild( document.createTextNode( '  |  ' ) );
    var img = document.createElement('img');
    img.setAttribute("src", "modules/ToDoList/img/undone.png");
    img.style.verticalAlign = "middle";
    img.div = div;
    img.onclick = function() {
        if ( this.div.itemID == null ) {
            onServerError();
            return;
        }

        this.div.setDone( !this.div.done );

        this.div.sendToServer();
    }
    div.checkImg = img;
    links.appendChild( img );

    //--------------------------------------------------------------------
    // create a table to contain the title bar
    td1 = document.createElement('td');
   // td1.appendChild(document.createTextNode(dateToFriendlyString(div.creationDate)));
    td1.appendChild(document.createTextNode(div.creationDate));
    td2 = document.createElement('td');
    td2.appendChild(links);
    td2.style.textAlign = "right";
    tr = document.createElement('tr');
    tr.appendChild(td1);
    tr.appendChild(td2);
    tbody = document.createElement('tbody');
    tbody.appendChild(tr);
    table = document.createElement('table');
    table.setAttribute("width", "100%");
    table.appendChild(tbody);
    
    //---------------------------------------------------------------------
    // Create title bar to contain the links.

    titleBar = document.createElement('div');
    titleBar.appendChild(table);
    div.appendChild(titleBar);
    div.titleBar = titleBar;
    
    div.done = false;

    function textToElements( div, text )
    {
        // split on \n.
        parray = text.split('\n');

        // for each resulting string,
        for( var i = 0; i < parray.length; i++ ) {
            // add a paragraph element with child as the text.
            t = document.createTextNode(parray[i]);
            p = document.createElement("p");
            p.style.marginTop = "0px";
            if ( i == parray.length-1 ) {
                p.style.marginBottom = "0px";
            } else {
                p.style.marginBottom = "0.5em";
            }
            p.appendChild(t);
            p.autoCreated = true;
            div.appendChild(p);
        }
    }

    div.setDone = function( done )
    {
        div.titleBar.style.background = "rgb(199,207,213)";
        if ( !done ) {
            div.style.border = "1px solid rgb(199,207,213)";
            div.style.background = "rgb(241,245,249)";
            div.style.opacity = "1.0";
            div.checkImg.setAttribute("src", "modules/ToDoList/img/undone.png");
        } else {
            div.style.border = "1px solid rgb(199,255,213)";
            div.style.background = "rgb(255,255,175)";
            div.style.opacity = "0.7";
            div.checkImg.setAttribute("src", "modules/ToDoList/img/done.png");
        }

        div.done = done;
    }

    div.editMode = false;

    div.editClicked = function()
    {
        this.editMode = !this.editMode;

        if ( this.editMode ) {
            // remove all the pararaph elements.
            for( var i = this.childNodes.length-1; i >= 0; i-- ) {
                if ( this.childNodes[i].autoCreated == true ) {
                    this.removeChild( this.childNodes[i] );
                }
            }

            // create a form containing the text area.
            textArea = document.createElement("textarea");
            textArea.setAttribute("name", "bigtext");
            textArea.appendChild(document.createTextNode( this.originalText ) );
            textArea.setAttribute("cols", "5");
            textArea.setAttribute("rows", "5");
            form = document.createElement("form");
            form.appendChild(textArea);
            form.bigtext = textArea;
            this.appendChild( form );
            this.editTextNode.nodeValue = "sauver";
            form.parentNode.style.textAlign = "center";
        } else {
            // find the form text.
            var form = null;
            for ( var i = this.childNodes.length-1; i>= 0; i-- ) {
                if ( this.childNodes[i].nodeName == "FORM" ) {
                    form = this.childNodes[i];
                    break;
                }
            }

            if ( form == null ) {
                alert("can't find form error");
                return;
            }

            form.parentNode.style.textAlign = "left";

            this.originalText = form.bigtext.value;
            this.removeChild( form );
            textToElements( this, this.originalText );
            div.sendToServer();
            this.editTextNode.nodeValue = "editer";
        }
    }

    div.sendToServer = function() {

    var done = (this.done ? "1" : "0");
    var url = "&status="+done+"&ID="+this.itemID;
	new Ajax.Request(
            'index.php',
             {
					
                    queue: {position: 'end', scope: 'command'},
                    method: 'post',
					postBody:"module=ToDoList&action=ToDoListAjax&file=saveTodo&doneTodo=true"+url,
                     onComplete: function(response)
					 {
						//window.location.reload();
                     }
             }
                        );	  
    }

    div.setDone( false );
    textToElements( div, text );

    return div;
}


function TodoList(div)
{
    div.TodoList = this;
    this.div = div;
   // this.nextId = 1;
    this.add = function(item) {
        item.style.display = 'none';
        //this.div.insertBefore( item, this.div.firstChild );
        this.div.appendChild( item );
        new Effect.BlindDown( item, {duration: .5} );
    }

    this.findByScriptId = function(scriptid) {
        for( i = 0; i < this.div.childNodes.length; i++ ) {
            if ( this.div.childNodes[i].scriptids == scriptid ) {
                return this.div.childNodes[i];
            }
        }
        return null;
    }

    this.remove = function( scriptId ) {
        var item = this.findByScriptId( scriptId );
        if ( item.removing ) {
            return;
        }
        item.removing = true;
        new Effect.BlindUp(this.findByScriptId(scriptId),
                { duration: .5});
    }

    return this;
}

function addToList()
{
    var todoForm = document.getElementById('todoForm');
	
    var todotask;
    if ( todoForm.bigtext.style.display == "none" ) {
        todotask = todoForm.smalltext.value;
    } else {
        todotask = todoForm.bigtext.value;
    }

    if ( todotask == "" ) {
        return;
    }
	
	var datetodo = todoForm.datetodo.value;
	var hourtodo = todoForm.hourtodo.value;
	var mintodo = todoForm.mintodo.value;
    var url = "&dateTodo="+datetodo+"&hourTodo="+hourtodo+"&minTodo="+mintodo+"&task="+todotask+"&status=0";
	 new Ajax.Request(
            'index.php',
             {
					
                    queue: {position: 'end', scope: 'command'},
                     method: 'post',
					postBody:"module=ToDoList&action=ToDoListAjax&file=saveTodo&addTodo=true"+url,
                     onComplete: function(response)
					 {
						window.location.reload();
                     }
             }
                        );	
}

function addItem(response,todotask,datetodo)
{
	 var insertedID= eval(response.responseText);
	 var item = new TodoItem(insertedID, todotask, datetodo);
  //  sleep(1);
	// alert(insertedID);
	 todoList.add( item );	
	 //window.location.reload(true); 
}

var todoList = null;

function editClicked(scriptid)
{
    var item = todoList.findByScriptId( scriptid );
    if ( item.itemID == null ) {
        // not added to server yet.
        onServerError();
        return;
    }

    item.editClicked();
}

function deleteClicked(scriptid)
{
    //alert(scriptid);
	var item = todoList.findByScriptId( scriptid );
	
    if ( item.itemID == null ) 
	{
        onServerError();
        return;
    }
    todoList.remove( scriptid );
	var url = "&ID="+scriptid;
	new Ajax.Request(
            'index.php',
             {
                     queue: {position: 'end', scope: 'command'},
                     method: 'post',
					postBody:"module=ToDoList&action=ToDoListAjax&file=saveTodo&dellTodo=true"+url,
                     onComplete: function(response)
					 {
                        //alert(response.responseText);
	                 }
             }
                        );	
}

function clearList()
{
    todoList = null;
	
    makeAjaxRequest("index.php",
            { delallitem:1}, 
            null, 
            null
            );
}

function init()
{
   
    todoList = new TodoList(document.getElementById('todoList'));

    function fillItems(response)
    {
        items = eval(response.responseText);
        for( i = 0; i < items.length; i++ ) {
            items[i].creationDate = items[i].date;
			//alert(items[i].id+"-"+items[i].item+"-"+items[i].creationDate);
            var item = new TodoItem(items[i].id, items[i].item,items[i].creationDate);
			if(items[i].status==1)
				item.setDone(true);
			else
				item.setDone(false);
            item.itemID = items[i].id;
            todoList.add(item);
        }
    }

    new Ajax.Request(
            'index.php',
             {
                     queue: {position: 'end', scope: 'command'},
                     method: 'post',
					postBody:"module=ToDoList&action=ToDoListAjax&file=saveTodo&allTodo=true",
                     onComplete: function(response)
					 {
						fillItems(response);	
					 }
             }
                        );	
}

function toggleMoreText()
{
    var todoForm = document.getElementById('todoForm');
    var link = document.getElementById('spaceToggle');
    if ( todoForm.bigtext.style.display == "none" ) {
        todoForm.bigtext.style.display = "inline";
        todoForm.smalltext.style.display = "none";
        link.firstChild.nodeValue = "Reduire";
    } else {
        todoForm.bigtext.style.display = "none";
        todoForm.smalltext.style.display = "inline";
        link.firstChild.nodeValue = "Agrandir";
    }
}


function replaceNodeText(elem, text)
{
    for( var i = elem.childNodes.length-1; i >= 0; i-- ) {
        elem.removeChild( elem.childNodes[i] );
    }
    elem.appendChild(document.createTextNode(text));
}


function addParagraph(elem, text)
{
    var p = document.createElement("p");
    p.appendChild(document.createTextNode(text));
    elem.appendChild(p);
}