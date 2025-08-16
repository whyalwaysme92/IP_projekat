<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom: " . $connection->connect_error);
}

// Paginacija
$vestiPoStranici = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$stranica = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($stranica < 1) $stranica = 1;

$offset = ($stranica - 1) * $vestiPoStranici;
$ukupnoVesti = $connection->query("SELECT COUNT(*) as total FROM vesti")->fetch_assoc()['total'];

$sql = "SELECT IDVesti, Naslov, Apstrakt, Datum, Ocena, PrvaSlikaVesti 
        FROM vesti 
        ORDER BY Datum DESC
        LIMIT $vestiPoStranici OFFSET $offset";

$result = $connection->query($sql);
?>

<!DOCTYPE html> 
<html>
<head>
    <title>Najnovije vesti - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_News.css"> 
    <link rel="stylesheet" type="text/css" href="css/style_Authors.css">
    <link rel="stylesheet" type="text/css" href="css/style_Buttons.css"> 
    <style>
        .custom-font {
            font-family: inherit;
        }
        .navigation-buttons-container {
            display: flex !important;
            justify-content: center !important;
            gap: 30px !important;
            margin-top: 30px !important;
        }
        .navigation-buttons-container form {
            padding: 0 !important;
            margin: 0 !important;
        }
        .navigation-buttons-container .ButtonCustomStyle {
            min-width: 150px !important;
        }
    </style>
</head>
<body data-user-type="<?php echo (session_status() === PHP_SESSION_NONE) ? 3 : (isset($_SESSION['tip']) ? (int)$_SESSION['tip'] : 3);?>">
    <div class="PageContentDiv">
        <div class="PageContent">
            <?php include 'Navigation.php'; ?>

            <div class="News">
                <div class="HeadingDiv">
                    <h1>Najnovije vesti</h1>
                    <form method="GET" style="margin-top: 10px;">
                        <label for="limit" class="Body" style="font-family: 'nunitoBold'; font-size: 15px;">Broj vesti po stranici:</label>
                        <select name="limit" id="limit" onchange="this.form.submit()" class="custom-font">
                            <?php
                            $opcije = [3, 5, 10, 15];
                            foreach ($opcije as $opcija) {
                                $selected = ($vestiPoStranici == $opcija) ? 'selected' : '';
                                echo "<option value='$opcija' $selected>$opcija</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" name="page" value="1">
                    </form>
                </div>

                <div class="AllArticles">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $date = new DateTime($row['Datum']);
                        ?>
                            <div class="OneArticle">
                                <div class="ArticleImageDiv">
                                    <img src="<?= !empty($row['PrvaSlikaVesti']) ? htmlspecialchars($row['PrvaSlikaVesti']) : 'images/default-news.png'; ?>" alt="Slika vesti">
                                </div>
                        
                                <div class="ArticleInformations">
                                    <div class="ArticleHeadingDiv">
                                        <a href="ShowArticle.php?id=<?= htmlspecialchars($row['IDVesti']); ?>">
                                            <?= htmlspecialchars($row['Naslov']); ?>
                                        </a>
                                    </div>
                        
                                    <div class="ArticleDateDiv">
                                        <p>Ocena: </p><p><?= htmlspecialchars($row['Ocena']); ?></p><p> | </p>
                                        <p><?= $date->format('d-m-Y'); ?></p>
                                    </div>
                        
                                    <div class="ArticleAbstractDiv">
                                        <p><?= htmlspecialchars($row['Apstrakt']); ?></p>
                                    </div>
                                </div>
                        
                                <div class="AuthorButtons">
                                    <a href="UpdateArticle.php?id=<?= $row['IDVesti']; ?>">
                                        <button id="Update">Ažuriraj</button>
                                    </a>
                                    <a href="DeleteArticle.php?id=<?= $row['IDVesti']; ?>" >
                                        <button>Briši</button>
                                    </a>
                                </div>
                            </div>
                        <?php
                        }                        
                        
                    } else {
                        echo "<p>Nema dostupnih vesti.</p>";
                    }
                    ?>
                </div>

                <!-- Navigacija -->
                <div style="text-align: center; margin-top: 20px;">
                    <?php if ($stranica > 1): ?>
                        <form method="GET" class="Buttons" style="display: inline-block; margin-right: 10px;">
                            <input type="hidden" name="limit" value="<?= $vestiPoStranici ?>">
                            <input type="hidden" name="page" value="<?= $stranica - 1 ?>">
                            <button type="submit" class="ButtonCustomStyle">Prethodna strana</button>
                        </form>
                    <?php endif; ?>

                    <?php if (($stranica * $vestiPoStranici) < $ukupnoVesti): ?>
                        <form method="GET" class="Buttons" style="display: inline-block;">
                            <input type="hidden" name="limit" value="<?= $vestiPoStranici ?>">
                            <input type="hidden" name="page" value="<?= $stranica + 1 ?>">
                            <button type="submit" class="ButtonCustomStyle">Sledeća strana</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="js/scriptFile.js"></script>
</body>
</html>
