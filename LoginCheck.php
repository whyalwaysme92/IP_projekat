<?php
    $eMail = $_POST['email'];
    $password = $_POST['pass'];

    $dbConnection = new mysqli("localhost", "root", "", "bazag01");
    $queryText = "SELECT * FROM KORISNICI WHERE Email = '{$eMail}'";
    $queryResult = $dbConnection->query($queryText);

    if($queryResult->num_rows > 0){
        $resultRow = $queryResult->fetch_array(MYSQLI_ASSOC);
        if($resultRow['Sifra'] == $password){
            session_start();
            $_SESSION['tip']=$resultRow['tip'];
            echo($_SESSION['tip']);
            header("Location: MainPage.php");

        }
        else{
            echo("Pogresno logovanje");
        }
    }
    else{
        echo("Nepostojeci korinik");
    }
    $dbConnection->close();
?>