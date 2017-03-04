<?php

ini_set("display_errors", true);
date_default_timezone_set("Europe/Belgrade");

define("DB_DSN", 'mysql:dbname=cms_afternoon;host=localhost');
define("DB_USERNAME", 'root');
define("DB_PASSWORD", 'Nemanja1!!@');

define("CLASS_PATH", "classes");
define("TEMPLATE_PATH", "templates");

define("HOMEPAGE_NUM_ARTICLES", 10);
define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", "admin");

require (CLASS_PATH . '/Article.php');

function handleException($exception) {
    echo "Desila se greska.";
    file_put_contents('error' . time() . '.txt', $exception->getMessage());
}

set_exception_handler('handleException');
?>
