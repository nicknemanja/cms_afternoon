<?php
echo "Lista svih artikala | archive.php";
?>

<h3>
    <?php
    echo "Ukupno clanaka: " . $results['totalRows'];
    ?>
</h3>

<table>
    <thead>
        <tr>
            <td>ID</td>    
            <td>Naslov</td>
            <td>Sadrzaj</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results['articles'] as $article) { ?>
            <tr>
                <td><?php echo $article->id ?></td>
                <td><?php echo $article->title ?></td>
                <td><?php echo $article->content ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php if ($results['pageShown'] > 1) echo "<a href=\"index.php?action=archive&page=1\">Prva</a>&nbsp;" ?>
<?php if ($results['pageShown'] > 1) echo "<a href=\"index.php?action=archive&page=" . ($results['pageShown'] - 1) . "\">Prethodna</a>&nbsp;" ?>
<?php if ($results['pageShown'] < $results['totalPages']) echo "<a href=\"index.php?action=archive&page=" . ($results['pageShown'] + 1) . "\">Sljedeća</a>&nbsp;" ?>
<?php if ($results['pageShown'] < $results['totalPages']) echo "<a href=\"index.php?action=archive&page=" . ($results['totalPages']) . "\">Posljednja</a>&nbsp;" ?>
