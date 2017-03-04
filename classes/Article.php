<?php

class Article {

    public $id = null;
    public $publicationDate = null;
    public $title = null;
    public $summary = null;
    public $content = null;

    public function __construct($data = array()) {

        if (isset($data['id']))
            $this->id = (int) $data['id'];
        if (isset($data['publicationDate']))
            $this->publicationDate = (int) $data['publicationDate'];
        if (isset($data['title']))
            $this->title = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title']);
        if (isset($data['summary']))
            $this->summary = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary']);
        if (isset($data['content']))
            $this->content = $data['content'];
    }

    public function storeFormValues($params) {
        $this->__construct($params);
    }

    public static function getById($id) {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql_query = "SELECT * , UNIX_TIMESTAMP(publicationDate) AS publiicatonDate FROM articles where id=:id";
        $st = $conn->prepare($sql_query);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ($row) {
            return new Article($row);
        } else {
            return null;
        }
    }

    public static function getList($numRows = 10, $page = 1, $order = "id ASC") {

        $list = array();

        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE active = 1 
            ORDER BY " . $order . " LIMIT :limit_from , :limit_to";
        $st = $conn->prepare($sql);
        $sql_limit_from = ($page - 1) * $numRows;
        $sql_limit_to = $numRows;
        $st->bindValue(":limit_from", $sql_limit_from, PDO::PARAM_INT);
        $st->bindValue(":limit_to", $sql_limit_to, PDO::PARAM_INT);

        $st->execute();
        $list = array();

        while ($row = $st->fetch()) {
            $article = new Article($row);
            $list[] = $article;
        }

        // Now get the total number of articles that matched the criteria
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query($sql)->fetch();
        $conn = null;
        return ( array("results" => $list, "totalRows" => $totalRows[0]) );
    }

    /**
     * Inserts the current Article object into the database, and sets its ID property.
     */
    public function insert() {

        // Does the Article object already have an ID?
        if (!is_null($this->id))
            trigger_error("Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR);
        try {
            // Insert the Article
            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $sql = "INSERT INTO articles ( publicationDate, title, summary, content ) VALUES ( FROM_UNIXTIME(:publicationDate), :title, :summary, :content )";
            $st = $conn->prepare($sql);
            $this->publicationDate = 1000;
            $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
            $st->bindValue(":title", $this->title, PDO::PARAM_STR);
            $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
            $st->bindValue(":content", $this->content, PDO::PARAM_STR);
            $st->execute();
            $this->id = $conn->lastInsertId();
            $conn = null;
        } catch (Exception $e) {
            echo "GRESKA PRILIKOM UPISA NOVOG ARTIKLA:" . $e->getMessage();
            die();
        }
    }

    /**
     * Updates the current Article object in the database.
     */
    public function update() {

        // Does the Article object have an ID?
        if (is_null($this->id))
            trigger_error("Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR);

        // Update the Article
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title, summary=:summary, content=:content WHERE id = :id";
        $st = $conn->prepare($sql);
        $this->publicationDate = 1000;
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    /**
     * Deletes the current Article object from the database.
     */
    public function delete() {
        file_put_contents("brisanje.txt", "Brisanje artikla!");
        // Does the Article object have an ID?
        if (is_null($this->id))
            trigger_error("Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR);

        // Delete the Article
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE articles SET active = 0 WHERE id = :id LIMIT 1";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

}

?>