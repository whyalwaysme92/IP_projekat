<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$connection = new mysqli("localhost", "root", "", "bazag01");

// $naslov = $_SESSION['ArticleHeader'];
// $sqlOne = "SELECT IDVesti FROM vesti WHERE Naslov = $naslov";
// $articleId = $connection->execute($sqlOne);

$articleId = $_GET['id'];

// $sqlTwo = "SELECT * FROM vesti WHERE IDvesti = $articleId";
// $result = $connection->query($sqlTwo)->fetch_assoc();
$sqlTwo = $connection->prepare("SELECT * FROM vesti WHERE IDvesti = ?");
$sqlTwo->bind_param("i", $articleId);
$sqlTwo->execute();
$result = $sqlTwo->get_result()->fetch_assoc();

// $id = $_GET['id'] ?? 0;
// $stmt = $connection->prepare("SELECT Naslov FROM vesti WHERE IDVesti = ?");
// $stmt->bind_param("i", $articleId);
// $stmt->execute();
// $result = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($result['Naslov']);?> - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/style_ShowArticle.css"> 
</head>
<body>
    <div class="PageContentDiv">
        <div class="PageContent">
            <?php 
                include 'Navigation.php'; 
            ?>

            
        </div>
    </div>
</body>
</html>
