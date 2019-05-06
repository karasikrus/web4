<?php


// db
$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);

$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'],'/');

// Create connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// /db
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Статейки</title>
</head>

<body>
<header>
    <p>Админка</p>
        <a href="index.php">статейки</a>
</header>
<?php
if ($_POST) {
    if (isset($_POST["action"]) && $_POST["action"] == "POST" && isset($_POST["title"]) && isset($_POST["content"])) {
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $content = mysqli_real_escape_string($conn, $_POST["content"]);
        $insert = $conn->query("INSERT INTO `w2s4x573ahdrmzjg`.`articles` (`title`, `content`) VALUES (\"" . $title . "\",\"" .$content . "\")");
        if ($insert && mysqli_affected_rows($conn) > 0) {
            echo '<div class="success-message">Опубликовано</div>';
        } else {
            echo '<div class="error-message">Что-то пошло не так</div>';
        }
    } elseif (isset($_POST["action"]) && $_POST["action"] == "DELETE" && isset($_POST["id"])) {
        $id = (int)$_POST["id"];
        $delete = $conn->query("DELETE FROM `w2s4x573ahdrmzjg`.`articles` WHERE id = " . $id);
        if ($delete && mysqli_affected_rows($conn) > 0) {
            echo '<div class="info-message">Удалено</div>';
        } else {
            echo '<div class="error-message">Что-то сломалось</div>';
        }
    } else {
        echo '<div class="error-message">странно</div>';
    }
}
?>

<div class="new-article-form">
    <form method="post" class="article-form">
        <input type="hidden" name="action" value="POST">
        <label for="title">
            Заголовок
            <input name="title" required>
        </label>
        <label for="text">
            Текст
            <textarea name="content" required cols="50" rows="7"></textarea>
        </label>
        <input class="submit-button" type="submit" value="Отправить"/>
    </form>

</div>
<div class="articles">

    <?php
    $articles = $conn->query("SELECT  `id`, `title`, `content` FROM `w2s4x573ahdrmzjg`.`articles`  ORDER BY `id` DESC")
        ->fetch_all(MYSQLI_ASSOC);


    foreach ($articles as $article){
        $title = $article["title"];
        $content = mb_substr($article["content"], 0, 30);
        $id = $article["id"];


        echo '<article>' . '<h2>' . $title . '</h2>' . '<p class="content">' . $content
            . '</p>' . '</article>' .
            '<form method="post">' .
            '<input type="hidden" name="action" value="DELETE">' .
            '<input type="hidden" name="id" value="' . $id . '">' .
            '<input class="delete-button" type="submit" value="Удалить">' .
            '</form>' .
            '</article>';
    }
    ?>


</div>

</body>