<?php

$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška pri konekciji: " . $connection->connect_error);
}

$querySveVesti = "SELECT IDVesti FROM vesti";
$sveVesti = $connection->query($querySveVesti);

while ($row = $sveVesti->fetch_assoc()) {
    $idVesti = (int)$row['IDVesti'];

    $queryProsek = "
        SELECT AVG(Ocena) AS Prosek
        FROM ocene
        WHERE IDVesti = $idVesti
    ";
    $res = $connection->query($queryProsek);
    $data = $res->fetch_assoc();

    $prosek = $data['Prosek'] !== null ? round($data['Prosek'], 2) : 0;

    $connection->query("
        UPDATE vesti
        SET Ocena = $prosek
        WHERE IDVesti = $idVesti
    ");
}


$queryAutori = "SELECT IDkorisnika FROM korisnici WHERE Tip = 2";
$sviAutori = $connection->query($queryAutori);

while ($row = $sviAutori->fetch_assoc()) {
    $idAutora = (int)$row['IDkorisnika'];

    $queryProsekAutora = "
        SELECT AVG(Ocena) AS ProsekAutora
        FROM vesti
        WHERE IDkorisnika = $idAutora
    ";
    $res = $connection->query($queryProsekAutora);
    $data = $res->fetch_assoc();

    $prosekAutora = $data['ProsekAutora'] !== null ? round($data['ProsekAutora'], 2) : 0;

    $connection->query("
        UPDATE korisnici
        SET Ocena = $prosekAutora
        WHERE IDkorisnika = $idAutora
    ");
}

$connection->close();
echo "Ažurirane prosečne ocene za sve vesti i autore.";
?>
