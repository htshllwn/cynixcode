
<div class="container">
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
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/iplastic");
    editor.session.setMode("ace/mode/c_cpp");
</script>