<?php
require('databaseConnect.php');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Статейки</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<header>
    <p>Статейки</p>
    <a href="admin.php">админка</a>
</header>
<div class="articles">

    <?php
    $articles = $conn->query("SELECT  `id`, `title`, `content` FROM `w2s4x573ahdrmzjg`.`articles`  ORDER BY `id` DESC")
        ->fetch_all(MYSQLI_ASSOC);

    foreach ($articles as $article){
        $title = $article["title"];
        $content = $article["content"];

        echo '<article>' . '<h2>' . $title . '</h2>' . '<p class="content">' . $content . '</p>' . '</article>';
    }
    ?>


</div>




</body>