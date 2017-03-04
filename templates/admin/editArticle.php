<?php
//$articleForEditing = new Article($_SESSION['articleForEditing']);
?>

<form method="GET" action="admin.php">
    <input type="hidden" name="action" value="editArticle">
    <input type="hidden" name="articleEdited" value="true">
    <input type="text" name="title" value=<?php echo $_SESSION['articleForEditing']->title ?> >
    <input type="text" name="summary" value=<?php echo $_SESSION['articleForEditing']->summary ?> >
    <input type="text" name="content" value=<?php echo $_SESSION['articleForEditing']->content ?> >
    <input type="submit" value="Izmijeni">
</form>
