<!--//$dbuser = $_ENV['MYSQL_USER'];-->
<!--//$dbpass = $_ENV['MYSQL_PASS'];-->
<!--//$dbdsn = $_ENV['MYSQL_DSN'];-->
<!--//-->
<!--//try {-->
<!--//    $pdo = new PDO($dbdsn, $dbuser, $dbpass);-->
<!--//    $statement = $pdo->prepare("SELECT * FROM posts");-->
<!--//    $statement->execute();-->
<!--//    $posts = $statement->fetchAll(PDO::FETCH_OBJ);-->
<!--//-->
<!--//    echo "<h2>Posts</h2>";-->
<!--//    echo "<ul>";-->
<!--//    foreach ($posts as $post ) {-->
<!--//        echo "<li>".$post->title."</li>";-->
<!--//    }-->
<!--//    echo "</ul>";-->
<!--//-->
<!--//} catch(PDOException $e) {-->
<!--//    echo $e->getMessage();-->
<!--//}-->
<!---->
<!---->
<!--//phpinfo();-->

<?php
function namespaceAutoload($rawClass)
{
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $rawClass);

    $path = str_replace(["\\", "file"], [DIRECTORY_SEPARATOR, $class], $rawClass);
    if (file_exists($path . ".php")) {
        require_once "$path.php";
    }
}
spl_autoload_register("namespaceAutoload");
?>
<!doctype html>
<html lang="pt-br">
    <body>
    <!-- Main Content -->
    <?php include("View/dashboard.php"); ?>
    <!-- Main Content -->
    </body>
</html>

