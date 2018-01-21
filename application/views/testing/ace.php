<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <div id="editor">function foo(items) {
        var x = "All this is syntax highlighted";
        return x;
    }</div>
    <br><BR><br><BR><br><BR><br><BR><br><BR>
    </div>
    <div class="col-md-2"></div>
</div>

<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/javascript");
</script>