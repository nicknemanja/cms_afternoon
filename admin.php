<?php

require 'config.php';
echo "Welcome | admin.php";
session_start();

$action = isset($_GET['action']) ? $_GET['action'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";

if (isset($_SESSION['msgLogoutSuccess'])) {
    echo $_SESSION['msgLogoutSuccess'];
    unset($_SESSION['msgLogoutSuccess']);
}

if (isset($_SESSION['articleInsertSuccess'])) {
    echo $_SESSION['articleInsertSuccess'];
    unset($_SESSION['articleInsertSuccess']);
}

if (isset($_SESSION['articleEditSuccess'])) {
    echo '<h1>'.$_SESSION['articleEditSuccess'].'</h1>';
    unset($_SESSION['articleEditSuccess']);
}

if (isset($_GET['status'])) {
    echo $_GET['status'];
    unset($_GET['status']);
}

if (isset($_GET['error'])) {
    echo '<h1>' . $_GET['error'] . '</h1>';
    unset($_GET['status']);
}

if ($action != 'login' && $action != 'logout' && !$username) {
    login();
    exit;
}



switch ($action) {
    case 'login':
        login();
        break;
    case 'logout':
        logout();
        break;
    case 'newArticle':
        newArticle();
        break;
    case 'editArticle':
        editArticle();
        break;
    case 'deleteArticle':
        deleteArticle();
        break;
    default:
        listArticles();
        break;
}

function login() {

    $results = array();
    $results['pageTitle'] = "Admin Login | Widget News";

    if (isset($_POST['login'])) {

        // User has posted the login form: attempt to log the user in
        if ($_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD) {
            $_SESSION['username'] = ADMIN_USERNAME;
            unset($_POST['login']);
            header('Location: admin.php');
        } else {
            $results['errorMessage'] = "Incorrect username or password. Please try again.";
            require TEMPLATE_PATH . '/admin/loginForm.php';
        }
    } else {
        require TEMPLATE_PATH . '/admin/loginForm.php';
    }
}

function logout() {
    unset($_SESSION['username']);
    $_SESSION['msgLogoutSuccess'] = 'Logout uspjesan!';
    header("Location: admin.php");
}

function listArticles() {
    $results = array();
    $data = Article::getList();

    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = 'All Articles';
    require( TEMPLATE_PATH . "/admin/listArticles.php" );
}

function newArticle() {

    if (isset($_GET['title'])) {

        $articleParams = array();

        $articleParams['title'] = htmlspecialchars($_GET['title']);
        $articleParams['content'] = htmlspecialchars($_GET['editor']);
        $articleParams['summary'] = htmlspecialchars("summary");
        
        $article = new Article($articleParams);

        $article->insert();
        $_SESSION['articleInsertSuccess'] = '<h1>Uspjesno kreiran artikl.</h1>';
        header("Location: admin.php");
    } else {
        require TEMPLATE_PATH . '/admin/newArticle.php';
    }
}

function editArticle() {
    $id = -1;

    if (isset($_GET['articleId'])) {
        $id = $_GET['articleId'];
    }

    if ($id == -1 && (!isset($_SESSION['articleForEditing']))) {
        require TEMPLATE_PATH . '/admin/listArticles.php';
    }

    $article = null;

    if (!isset($_GET['articleEdited'])) {
        
        $article = Article::getById($id);
        $_SESSION['articleForEditing'] = $article;

        require TEMPLATE_PATH . '/admin/editArticle.php';
    } else {
        $article = $_SESSION['articleForEditing'];
        $article->title = $_GET['title'];
        $article->summary = $_GET['summary'];
        $article->content = $_GET['content'];
            
        $article->update();
        unset($_SESSION['articleForEditing']);
        $_SESSION['articleEditSuccess'] = "Artikl uspjesno izmjenjen!";
        header("Location: admin.php");
    }
}

function deleteArticle() {

    $id = -1;

    $id = ($_GET['articleId'] != null) ? $_GET['articleId'] : -1;


    if ($id != -1 && ($article = Article::getById($id) == null)) {
        header("Location: admin.php?error=articleNotFound");
        return;
    }
    $article = new Article();
    if ($article == null) {
        $article = new Article();
    }

    $article->id = $id;
    $article->delete();
    header("Location: admin.php?status=articleDeleted");
}

?>