
<div class="container">
        <button class="btn btn-default" id="load">Load</button>
        <button class="btn btn-default" id="send">Send</button>
<div class="row">
    
    <div class="col-md-12">
    <div id="editor">function foo(items) {
        var x = "All this is syntax highlighted";
        return x;
    }</div>
    </div>
    
</div>
</div>




<script>
    
    $(document).ready(function(){
        var tempData;
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/iplastic");
        editor.session.setMode("ace/mode/c_cpp");
        editor.setValue("new value");
        
        editor.setOptions( {
            fontSize: "18px",
		    enableBasicAutocompletion: true,
            enableSnippets           : true,
		    enableLiveAutocompletion : false
	    } );

         

        //var text = $.get("<?php echo base_url().'assets/file/sample.c' ?>");
        $("#load").click(function(){
            $.get("<?php echo base_url().'assets/file/sample.c' ?>", function(data, status){
            //alert("Data: " + data + "\nStatus: " + status);
            editor.setValue(data);
            editor.focus(); // To focus the ace editor

            var row = editor.session.getLength() - 1;
            console.log(row);
            var column = editor.session.getLine(row).length;
            console.log(column); // or simply Infinity
            editor.gotoLine(row + 1, column);

            // Prevent editing first and last line of editor
            editor.commands.on("exec", function(e) { 
            var rowCol = editor.selection.getCursor();
            if ((rowCol.row == 0) || ((rowCol.row + 1) == editor.session.getLength())) {
                e.preventDefault();
                e.stopPropagation();
                }
            });

            //editor.setReadOnly(true);
            /*
            var n = editor.getSession().getValue().split("\n").length;
            editor.gotoLine(n);
            tempData = data;
            */
        });
        });

        $("#send").click(function(){
            var content = editor.getValue();
            console.log(content);
            $.post("<?php echo base_url().'test/proc_data' ?>",{content: content}, function(data, status){
                console.log("Data: " + data + "\nStatus: " + status);
            });
            
        });
        //editor.setValue(tempData);

        console.log(tempData);
    });
    

    

    
</script>

<script>
        
    </script>