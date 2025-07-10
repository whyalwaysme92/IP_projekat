<?php

$connection = new mysqli("localhost", "root", "", "bazag01");

// $naslov = $_SESSION['ArticleHeader'];
// $sqlOne = "SELECT IDVesti FROM vesti WHERE Naslov = $naslov";
// $articleId = $connection->execute($sqlOne);

$articleId = $_GET['id'];

// $sqlOne = "SELECT * FROM vesti WHERE IDvesti = $articleId";
// $result = $connection->query($sqlOne)->fetch_assoc();
$sqlOne = $connection->prepare("SELECT * FROM vesti WHERE IDvesti = ?");
$sqlOne->bind_param("i", $articleId);
$sqlOne->execute();
$result = $sqlOne->get_result()->fetch_assoc();

$connection->close();

$connection2 = new mysqli("localhost", "root", "", "bazag01");
$sqlTwo = $connection2->prepare("SELECT * FROM korisnici WHERE IDkorisnika = ?");
$sqlTwo->bind_param("i", $result['IDkorisnika']);
$sqlTwo->execute();
$resultTwo = $sqlTwo->get_result()->fetch_assoc();


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
    <link rel="stylesheet" type="text/css" href="css/style_ShowArticle.css"> 
</head>
<body>
    <div class="PageContentDiv">
        <div class="PageContent">
            <?php 
                include 'Navigation.php'; 
            ?>
        
            <div class="ArticleDiv">
                <div class="HeadingDiv">
                    <h1><?php echo($result['Naslov']);?></h1>
                </div>



            </div>
            <div class="ArticleDetailsAndImages"> 
                <div class="AuthorDetailsDiv">
                    <p>Autor: <?php echo($resultTwo['Ime'] . " " . $resultTwo['Prezime']); ?></p><p>
                        &nbsp;|&nbsp;</p><p>Datum: <?php $dateAndTime = new DateTime($result['Datum']); $dateOnly = $dateAndTime->format('d-m-y'); 
                        echo($dateOnly);?></p><p>&nbsp;|&nbsp;</p><p>Ocena: <?php echo($result['Ocena']);?></p>
                </div>                
                <img src="<?php echo($result['PrvaSlikaVesti']);?>" alt="<?php echo($result['Naslov']);?>">
                <div class="ArticleTextDiv">
                    <p><?php echo($result['Tekst']);?></p>
                </div>
                <div class="SecondImageDiv">
                    <img src="<?php echo($result['DrugaSlikaVesti']);?>" alt="<?php echo($result['Apstrakt']); ?>">
                </div>
            </div>            
        </div>
    </div>
</body>
</html>
