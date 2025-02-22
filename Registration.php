<?php
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $accountType = $_POST['accountType'];

    $dbConnection = new mysqli("localhost", "root", "", "bazag01");
    $queryText = "INSERT INTO `korisnici` (`Ime`, `Prezime`, `Telefon`, `Email`, `Sifra`, `Adresa`, `tip`) VALUES
    ('$name', '$lastname', '$phone', '$email', '$password', '$address', '$accountType');";
    $dbConnection->query($queryText);

    header('Location: LoginPage.php');

?>