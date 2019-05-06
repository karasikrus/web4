<?php
echo 'e';

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
echo "Connection was successfully established!";
// /db
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Статейки</title>
</head>

<body>
<header>
    <p>Статейки</p>
    <a href="admin.php">админка</a>
</header>
<div class="articles">

    <?php
    $articles = $conn->query("SELECT  `title`, `content` FROM `w2s4x573ahdrmzjg`.`articles`  ORDER BY `id` DESC")
        ->fetch_all(MYSQLI_ASSOC);

    foreach ($articles as $article){
        $title = $article["title"];
        $content = $article["content"];

        echo '<article>' . '<h2>' . $title . '</h2>' . '<p class="content">' . $content . '</p>' . '</article>';
    }
    ?>


</div>




</body>