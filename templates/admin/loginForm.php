<?php ?>

<hr>

<?php
if (isset($_results['errorMessage'])) {
    echo $_results['errorMessage'];
    unset($results['errorMessage']);
}
?>

<form method="POST" action="admin.php?action=login">
    <input type="text" name="username" placeholder="Username">
    <input type="hidden" name="login">
    <input type="password" name="password">
    <input type="submit" value="login">
</form>
