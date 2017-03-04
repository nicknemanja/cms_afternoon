<?php ?>
<div id="adminHeader">
    <h2>Widget News Admin</h2>
    <?php if (isset($_SESSION['username'])) { ?>
        <p>Logovani ste kao <b><?php echo htmlspecialchars($_SESSION['username']) ?></b>.
            <a href="admin.php?action=logout">Log out</a>
        </p>
    <?php } ?>

    <h3>
        <?php
        echo "Ukupno clanaka: " . $results['totalRows'];
        ?>
    </h3>
        <h4>
            <a href="admin.php?action=newArticle">Novi članak</a>
        </h4>
    <table>
        <thead>
        <td>Naslov</td>
        <td>Sadrzaj</td>
        <td>Obriši</td>
        <td>Izmijeni</td>
        <thead>
        <tbody>
            <?php foreach ($results['articles'] as $article) { ?>
                <tr>
                    <td><?php echo $article->title ?></td>
                    <td><?php echo $article->content ?></td>
                    <td><a href=<?php echo "admin.php?action=deleteArticle&articleId=" . $article->id ?>>Obriši</a></td>
                    <td><a href=<?php echo "admin.php?action=editArticle&articleId=" . $article->id ?>>Izmijeni</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


