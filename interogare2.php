<?php
include 'db.php';

$sql = "SELECT 
            apel.id_apel, 
            apel.data_apel, 
            apel.ora_apel, 
            CONCAT(dispatcher.nume, ' ', dispatcher.prenume) AS dispatcher, 
            CONCAT(apelant.nume, ' ', apelant.prenume) AS apelant 
        FROM apel
        JOIN dispatcher ON apel.id_dispatcher = dispatcher.id_dispatcher
        JOIN apelant ON apel.id_apelant = apelant.id_apelant";

$result = $conn->query($sql);

echo "<h1>Apeluri cu detalii despre dispatcher și apelant</h1>";
if ($result->num_rows > 0) {
    echo "<table><tr><th>ID Apel</th><th>Data Apel</th><th>Ora Apel</th><th>Dispatcher</th><th>Apelant</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['id_apel']}</td><td>{$row['data_apel']}</td><td>{$row['ora_apel']}</td><td>{$row['dispatcher']}</td><td>{$row['apelant']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "Nu există date.";
}
?>
<a href="admin.php">Înapoi la meniu</a>
