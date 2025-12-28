<?php
include 'db.php';

$sql = "SELECT 
            CONCAT(dispatcher.nume, ' ', dispatcher.prenume) AS dispatcher, 
            COUNT(apel.id_apel) AS numar_apeluri 
        FROM dispatcher
        JOIN apel ON dispatcher.id_dispatcher = apel.id_dispatcher
        GROUP BY dispatcher.id_dispatcher
        HAVING COUNT(apel.id_apel) = (
            SELECT MAX(numar_apeluri)
            FROM (
                SELECT COUNT(id_apel) AS numar_apeluri
                FROM apel
                GROUP BY id_dispatcher
            ) AS subquery
        )";

$result = $conn->query($sql);

echo "<h1>Dispatcherii care au gestionat cele mai multe apeluri</h1>";
if ($result->num_rows > 0) {
    echo "<table><tr><th>Dispatcher</th><th>Număr Apeluri</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['dispatcher']}</td><td>{$row['numar_apeluri']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "Nu există date.";
}
?>
<a href="admin.php">Înapoi la meniu</a>
