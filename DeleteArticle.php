<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$connection = new mysqli("localhost", "root", "", "bazag01");

if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "SELECT * FROM vesti WHERE IDVesti = $id";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $vest = $result->fetch_assoc();
    } else {
        echo "Vest nije pronađena.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete_query = "DELETE FROM vesti WHERE IDVesti = ?";
    $stmt = $connection->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if (isset($_SESSION['tip'])) {
            if ($_SESSION['tip'] == 1) {
                header("Location: Admins.php");
            } elseif ($_SESSION['tip'] == 2) {
                header("Location: MyNews.php");
            }
        } else {
        echo "Došlo je do greške pri brisanju vesti.";
    }

    $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Obriši vest - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_Register.css">
</head>
<body>
    <div class="PageContentDiv">
        <div class="PageContent">
            <?php include 'Navigation.php'; ?>

            <div class="RegisterForm">
                <form action="DeleteArticle.php?id=<?php echo $vest['IDVesti']; ?>" method="POST">
                    <div class="FormHeading">
                        <h1>Brisanje vesti</h1>
                    </div>
                    <p>Da li ste sigurni da želite da obrišete ovu vest?</p>
                    <div class="AuthorDetails">
                        <p><strong>Naslov:</strong> <?php echo htmlspecialchars($vest['Naslov']); ?></p>
                        <p><strong>Datum:</strong> <?php echo (new DateTime($vest['Datum']))->format('d.m.Y'); ?></p>
                        <p><strong>Apstrakt:</strong> <?php echo htmlspecialchars($vest['Apstrakt']); ?></p>
                    </div>
                    <button type="submit" style="background-color: red;">Obriši vest</button>
                    <a href="MyNews.php"><button type="button">Otkaži</button></a>
                </form>
            </div>
        </div>
    </div>
    <script src="js/scriptFile.js"></script>
</body>
</html>

<?php $connection->close(); ?>
