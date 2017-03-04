<?php
require( "config.php" );
require TEMPLATE_PATH . '/include/header.php';

session_start();
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'archive':
        archive();
        break;
    case 'viewArticle':
        viewArticle();
        break;
    case 'ckeditor':
        handleCkeditor();
        break;
    default:
        homepage();
}

function archive() {
    $results = array();
    $page = -1;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    if ($page == -1) {
        $data = Article::getList(HOMEPAGE_NUM_ARTICLES);
    } else {
        $data = Article::getList(HOMEPAGE_NUM_ARTICLES, $page);
    }

    $results['pageShown'] = ($page != -1) ? $page : 1;
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['totalPages'] = (int) ($data['totalRows'] / HOMEPAGE_NUM_ARTICLES) + 1;
    $results['pageTitle'] = "Article Archive | Widget News";
    require( TEMPLATE_PATH . "/archive.php" );
}

function handleCkeditor(){
    $userInput = $_GET['editor'];
    echo $userInput;
}
function homepage() {
    $data = Article::getList(HOMEPAGE_NUM_ARTICLES);
    $results = array();

    $results['articles'] = $data['results'];
    $results['numOfArticles'] = $data['totalRows'];
    require TEMPLATE_PATH . '/homepage.php';
}
?>

<?php require TEMPLATE_PATH . '/include/footer.php'; ?>