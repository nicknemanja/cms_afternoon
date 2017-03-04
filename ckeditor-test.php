<html>
    <head>
        <meta charset="UTF-8">
        <title>CKEditor test</title>
        <script src="ckeditor/ckeditor.js"></script>	
    </head>
    <body>
        <h1>CKEditor test</h1>
        <hr>
        <form action="admin.php" method="get">
            <input type="hidden" name="action" value="newArticle">
            <input type="hidden" name="title" value="CKEditor title">
            <textarea class="ckeditor" name="editor"></textarea>
            <input type="submit" value="Posalji">
        </form>
    </body>
</html>
