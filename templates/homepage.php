<h3>
    <?php
    echo "Ukupno clanaka: " . $results['numOfArticles'] . "<br>";
    ?>
</h3>
<table>
    <thead>
        <tr>
            <td>Naslov</td>
            <td>Sadrzaj</td>
        </tr>

    </thead>
    <tbody>
        <?php foreach ($results['articles'] as $article) { ?>
            <tr>
                <td><?php echo $article->title ?></td>
                <td><?php echo $article->content ?></td>
            </tr>    
        <?php } ?>
    </tbody>
</table>
<a href="./?action=archive">Lista svih artikala</a>