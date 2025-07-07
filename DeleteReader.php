<?php
$connection = new mysqli("localhost", "root", "", "bazag01");

if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT * FROM korisnici WHERE IDkorisnika = $id AND Tip = '3'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $reader = $result->fetch_assoc();
    } else {
        echo "Čitaoc nije pronađen.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($reader['Slika']) && file_exists($reader['Slika'])) {
        unlink($reader['Slika']);
    }

    $delete_query = "DELETE FROM korisnici WHERE IDkorisnika = ?";
    $stmt = $connection->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: Readers.php");
        exit();
    } else {
        echo "Došlo je do greške pri brisanju čitaoca.";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Obriši čitaoca - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_Register.css"> 
</head>
<body>
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

            <div class="RegisterForm">
                <form action="DeleteReader.php?id=<?php echo $reader['IDkorisnika']; ?>" method="POST">
                    <div class="FormHeading">
                        <h1>Brisanje čitaoca</h1>
                    </div>
                    <p>Da li ste sigurni da želite da obrišete čitaoca?</p>
                    <div class="ReaderDetails">
                        <p><strong>Ime:</strong> <?php echo htmlspecialchars($reader['Ime']); ?></p>
                        <p><strong>Prezime:</strong> <?php echo htmlspecialchars($reader['Prezime']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($reader['Email']); ?></p>
                    </div>
                    <button type="submit" style="background-color: red;">Obriši čitaoca</button>
                    <a href="Readers.php"><button type="button">Otkaži</button></a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php $connection->close(); ?>
