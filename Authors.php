<?php
$connection = new mysqli("localhost", "root", "", "bazag01");

if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}

$query = "SELECT IDkorisnika, Ime, Prezime, Telefon, Email, Adresa, Slika FROM korisnici WHERE Tip = '2'";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Autori - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_Authors.css"> 
</head>
<body>
    <div class="PageContentDiv">
        <div class="PageContent">
            <div class="Header">
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
            </div>
            
            <div class="Authors">
                <div class="HeadingDiv">
                    <h1>Autori</h1>
                </div>
                <div class="AllAuthors">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="OneAuthor">
                            <div class="AuthorImageDiv">
                                <img src="<?php echo htmlspecialchars($row['Slika']); ?>" alt="">
                            </div>
                            <div class="AuthorInformations">
                                <div class="AuthorHeadingDiv">
                                    <a href="#"> <?php echo htmlspecialchars($row['Ime']); ?> </a>
                                </div>
                                <div class="AuthorHeadingDiv">
                                    <a href="#"> <?php echo htmlspecialchars($row['Prezime']); ?> </a>
                                </div>
                                <div class="AuthorEmailDiv">
                                    <a href="mailto:<?php echo htmlspecialchars($row['Email']); ?>">
                                        <?php echo htmlspecialchars($row['Email']); ?>
                                    </a>
                                </div>
                                <div class="AuthorPhoneAndAddressDiv">
                                    <div class="PhoneDiv">
                                        <p>Telefon: </p>
                                        <a href="tel:<?php echo htmlspecialchars($row['Telefon']); ?>">
                                            <?php echo htmlspecialchars($row['Telefon']); ?>
                                        </a>
                                    </div>
                                    <div class="AddressDiv">
                                        <p class="AddressText">Adresa: <?php echo htmlspecialchars($row['Adresa']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="AuthorButtons">
                                <a href="UpdateAuthor.php?id=<?php echo $row['IDkorisnika']; ?>">
                                    <button>Ažuriraj</button>
                                </a>
                                <a href="DeleteAuthor.php?id=<?php echo $row['IDkorisnika']; ?>" onclick="return confirm('Da li ste sigurni?');">
                                    <button>Briši</button>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php $connection->close(); ?>
