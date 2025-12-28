<?php
include 'db.php';

$sql = "SELECT 
            echipaj.nume_echipaj, 
            interventie.id_interventie 
        FROM interventie_echipaj
        JOIN echipaj ON interventie_echipaj.id_echipaj = echipaj.id_echipaj
        JOIN interventie ON interventie_echipaj.id_interventie = interventie.id_interventie";

$result = $conn->query($sql);

echo "<h1>Echipaje asociate cu intervenții</h1>";
if ($result->num_rows > 0) {
    echo "<table><tr><th>Nume Echipaj</th><th>ID Intervenție</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['nume_echipaj']}</td><td>{$row['id_interventie']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "Nu există date.";
}
?>
<a href="admin.php">Înapoi la meniu</a>
