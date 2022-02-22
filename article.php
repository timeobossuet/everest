<?php
include 'app/config.php';
include 'app/simplify.php';
include 'app/functions.php';

$article_code = htmlspecialchars($_GET['n']);

if (isset($article_code) and !empty($article_code))
{

    $article = $connect->prepare('SELECT * FROM films WHERE link = ?');
    $article->execute(array(
        $article_code
    ));

    if ($article->rowCount() == 1)
    {
        $article = $article->fetch();
        $name = $article['name'];
        $description = $article['description'];
    }
    else
    {
        header('Location: ./');
        exit();
    }

    $query = $tags;
    $suggestions = $connect->query('SELECT * FROM films WHERE CONCAT(categorie, tags) LIKE "%' . $query . '%" AND id != ' . $id . ' ORDER BY id DESC');
}
?>

   <? echo $name
?>
   <? echo $description ?>
   <? echo $tags ?>
