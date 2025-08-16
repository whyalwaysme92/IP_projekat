<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$connection = new mysqli("localhost", "root", "", "bazag01");

if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}

// Determine sorting method
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'alphabetical';
$orderBy = $sort === 'registration' ? 'DatumRegistracije DESC' : 'Ime ASC';

$query = "SELECT IDkorisnika, Ime, Prezime, Telefon, Email, Adresa, Slika, DatumRegistracije 
          FROM korisnici 
          WHERE Tip = '2' 
          ORDER BY $orderBy";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Autori - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_Authors.css">
    <link rel="stylesheet" type="text/css" href="css/style_Buttons.css"> 
</head>
<body data-user-type="<?php echo (session_status() === PHP_SESSION_NONE) ? 3 : (isset($_SESSION['tip']) ? (int)$_SESSION['tip'] : 3);?>">
    <div class="PageContentDiv">
        <div class="PageContent">
            <!-- <div class="Header">
                <div class="HeaderLogoImage">
                    <p>new<span>S</span></p>
                </div>
                <div class="HeaderNavigation">
                    <ul>
                        <li><a href="Admins.php">Naslovna</a></li>
                        <li><a href="RecentNewsAdmins.php">Najnovije&nbsp;vesti</a></li>
                        <li><a href="Authors.php">Autori</a></li>
                        <li><a href="Readers.php">Čitaoci</a></li>
                        <li><a href="Logout.php">Izloguj&nbsp;se</a></li>
                    </ul>
                </div>
            </div> -->

            <?php 
                include 'Navigation.php'; 
            ?>            
            
            <div class="Authors">
                <div class="HeadingDiv">
                    <h1>Autori</h1>
                    <div class="SortOptions" style="margin-top: 10px;">
                        <form method="GET" action="Authors.php" class="Buttons" style="display: inline-block; margin-right: 10px;">
                            <label for="sort" class="LabelCustomStyle">Sortiraj po:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()">
                                <option value="alphabetical" <?= $sort === 'alphabetical' ? 'selected' : '' ?>>Abecedno</option>
                                <option value="registration" <?= $sort === 'registration' ? 'selected' : '' ?>>Datum registracije</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="AllAuthors">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="OneAuthor">
                            <div class="AuthorImageDiv">
                                <img src="<?= !empty($row['Slika']) ? htmlspecialchars($row['Slika']) : 'images/default-profile.png'; ?>" alt="">
                            </div>
                            <div class="AuthorInformations">
                                <div class="AuthorHeadingDiv">
                                    <a href="Author.php?IDkorisnika=<?= urlencode($row['IDkorisnika']) ?>">
                                        <?= htmlspecialchars($row['Ime']) . ' ' . htmlspecialchars($row['Prezime']); ?>
                                    </a>
                                </div>
                                <div class="AuthorEmailDiv">
                                    <a href="mailto:<?= htmlspecialchars($row['Email']); ?>">
                                        <?= htmlspecialchars($row['Email']); ?>
                                    </a>
                                </div>
                                <div class="AuthorPhoneAndAddressDiv">
                                    <div class="PhoneDiv">
                                        <p>Telefon: </p>
                                        <a href="tel:<?= htmlspecialchars($row['Telefon']); ?>">
                                            <?= htmlspecialchars($row['Telefon']); ?>
                                        </a>
                                    </div>
                                    <div class="AddressDiv">
                                        <p class="AddressText">Adresa: <?= htmlspecialchars($row['Adresa']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="AuthorButtons">
                                <a href="UpdateAuthor.php?id=<?= $row['IDkorisnika']; ?>">
                                    <button>Ažuriraj</button>
                                </a>
                                <a href="DeleteAuthor.php?id=<?= $row['IDkorisnika']; ?>" onclick="return confirm('Da li ste sigurni?');">
                                    <button>Briši</button>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="js/scriptFile.js"></script>
</body>
</html>

<?php $connection->close(); ?>
