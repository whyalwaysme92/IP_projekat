<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID vesti nije prosleđen.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $naslov = $_POST['Naslov'] ?? '';
    $datum = $_POST['Datum'] ?? '';
    $apstrakt = $_POST['Apstrakt'] ?? '';
    $tekst = $_POST['Tekst'] ?? '';

    // Obrada slika
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Postojeće putanje iz baze (ako korisnik ne doda nove slike)
    $result = $connection->query("SELECT PrvaSlikaVesti, DrugaSlikaVesti FROM vesti WHERE IDVesti = $id");
    $row = $result->fetch_assoc();
    $prvaSlikaPath = $row['PrvaSlikaVesti'];
    $drugaSlikaPath = $row['DrugaSlikaVesti'];

    if (!empty($_FILES['PrvaSlikaVesti']['name'])) {
        $prvaSlikaPath = $targetDir . basename($_FILES['PrvaSlikaVesti']['name']);
        move_uploaded_file($_FILES['PrvaSlikaVesti']['tmp_name'], $prvaSlikaPath);
    }

    if (!empty($_FILES['DrugaSlikaVesti']['name'])) {
        $drugaSlikaPath = $targetDir . basename($_FILES['DrugaSlikaVesti']['name']);
        move_uploaded_file($_FILES['DrugaSlikaVesti']['tmp_name'], $drugaSlikaPath);
    }

    $stmt = $connection->prepare("UPDATE vesti SET Naslov = ?, Datum = ?, Apstrakt = ?, Tekst = ?, PrvaSlikaVesti = ?, DrugaSlikaVesti = ? WHERE IDVesti = ?");
    $stmt->bind_param("ssssssi", $naslov, $datum, $apstrakt, $tekst, $prvaSlikaPath, $drugaSlikaPath, $id);

    if ($stmt->execute()) {
        if ($_SESSION['tip'] == 1) {
            header("Location: RecentNewsAdmins.php");
        } else {
            header("Location: MyNews.php");
        }
        exit();
    }
     else {
        echo "Greška pri ažuriranju: " . $stmt->error;
    }
    $stmt->close();
}

// Prikaz forme sa popunjenim podacima
$query = $connection->prepare("SELECT * FROM vesti WHERE IDVesti = ?");
$query->bind_param("i", $id);
$query->execute();
$vest = $query->get_result()->fetch_assoc();

if (!$vest) {
    die("Vest nije pronađena.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Izmeni vest</title>
    <link rel="stylesheet" type="text/css" href="css/style_AddArticle.css"> 
</head>
<body>
    <div class="PageContentDiv">
        <div class="PageContent">
            <?php include 'Navigation.php'; ?>  
            <div class="AddArticleDiv">
                <div class="HeadingDiv"><h1>Izmeni vest</h1></div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="LeftPartForm">
                        <div class="ArticleHeadingDiv">
                            <input type="text" name="Naslov" value="<?= htmlspecialchars($vest['Naslov']) ?>" required />
                        </div>
                        <div class="ArticleDateDiv">
                            <input type="date" name="Datum" value="<?= substr($vest['Datum'], 0, 10) ?>" required />
                        </div>
                        <div class="ArticleAbstractDiv">
                            <textarea name="Apstrakt"><?= htmlspecialchars($vest['Apstrakt']) ?></textarea>
                        </div>
                    </div>
                    <div class="FirstArticleImage">
                        <input type="file" name="PrvaSlikaVesti" />
                    </div>
                    <div class="ArticleMainText">
                        <textarea name="Tekst" required><?= htmlspecialchars($vest['Tekst']) ?></textarea>
                    </div>
                    <div class="SecondArticleImage">
                        <input type="file" name="DrugaSlikaVesti" />
                    </div>
                    <button type="submit">Sačuvaj izmene</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
