<?php
include 'db.php';

$sql = "SELECT 
            interventie.id_interventie, 
            locatie.adresa, 
            locatie.oras, 
            CONCAT(apelant.nume, ' ', apelant.prenume) AS apelant 
        FROM interventie
        JOIN locatie ON interventie.id_locatie = locatie.id_locatie
        JOIN apel ON interventie.id_apel = apel.id_apel
        JOIN apelant ON apel.id_apelant = apelant.id_apelant";

$result = $conn->query($sql);

echo "<h1>Intervenții cu locații și apelant</h1>";
if ($result->num_rows > 0) {
    echo "<table><tr><th>ID Intervenție</th><th>Adresă</th><th>Oraș</th><th>Apelant</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['id_interventie']}</td><td>{$row['adresa']}</td><td>{$row['oras']}</td><td>{$row['apelant']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "Nu există date.";
}
?>
<a href="admin.php">Înapoi la meniu</a>
