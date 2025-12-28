<?php
include 'db.php';

$sql = "SELECT 
            denumire, 
            descriere, 
            prioritate 
        FROM tip_interventie 
        ORDER BY prioritate DESC";

$result = $conn->query($sql);

echo "<h1>Tipuri de intervenții ordonate după prioritate</h1>";
if ($result->num_rows > 0) {
    echo "<table><tr><th>Denumire</th><th>Descriere</th><th>Prioritate</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['denumire']}</td><td>{$row['descriere']}</td><td>{$row['prioritate']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "Nu există date.";
}
?>
<a href="admin.php">Înapoi la meniu</a>
