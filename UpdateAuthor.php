<?php
$connection = new mysqli("localhost", "root", "", "bazag01");

if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM korisnici WHERE IDkorisnika = $id AND Tip = '2'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $author = $result->fetch_assoc();
    } else {
        echo "Autor nije pronađen.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Ime = $_POST['Ime'];
    $Prezime = $_POST['Prezime'];
    $Telefon = $_POST['Telefon'];
    $Email = $_POST['Email'];
    $Adresa = $_POST['Adresa'];
    $Slika = $_POST['Slika'];
    
    $update_query = "UPDATE korisnici SET Ime = ?, Prezime = ?, Telefon = ?, Email = ?, Adresa = ?, Slika = ? WHERE IDkorisnika = ?";
    $stmt = $connection->prepare($update_query);
    $stmt->bind_param("ssssssi", $Ime, $Prezime, $Telefon, $Email, $Adresa, $Slika, $id);

    if ($stmt->execute()) {
        header("Location: Authors.php");
        exit(); 
    } else {
        echo "Došlo je do greške pri ažuriranju autora.";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ažuriraj autora - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_Register.css"> 
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

            <div class="RegisterForm">
                <form action="UpdateAuthor.php?id=<?php echo $author['IDkorisnika']; ?>" method="POST">
                    <div class="FormHeading">
                        <h1>Ažuriraj autora</h1>
                    </div>

                    <label for="UploadFile" class="CustomUploadFile">
                            <input id="UploadFile" type="file" required="required"/>
                            <div class="ImageContainer">
                                <img src="images/ProfileIcon.png" alt="">
                            </div>
                        </label>

                    <input type="text" name="Ime" value="<?php echo htmlspecialchars($author['Ime']); ?>" placeholder="Unesite ime autora" required="required"/>
                    <input type="text" name="Prezime" value="<?php echo htmlspecialchars($author['Prezime']); ?>" placeholder="Unesite prezime autora" required="required"/>
                    <input type="text" name="Telefon" value="<?php echo htmlspecialchars($author['Telefon']); ?>" placeholder="Unesite telefon autora" pattern="\+[0-9]{3}[0-9]{7,12}" required="required"/>
                    <input type="email" name="Email" value="<?php echo htmlspecialchars($author['Email']); ?>" placeholder="Unesite email autora" required="required"/>
                    <input type="text" name="Adresa" value="<?php echo htmlspecialchars($author['Adresa']); ?>" placeholder="Unesite adresu autora" required="required"/>

                    <button type="submit">Ažuriraj autora</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/scriptFile.js"></script>
</body>
</html>

<?php $connection->close(); ?>
