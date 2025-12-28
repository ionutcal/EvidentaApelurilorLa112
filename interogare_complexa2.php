<?php
include 'db.php';

$sql = "
SELECT DISTINCT dispatcher.nume, dispatcher.prenume
FROM dispatcher
JOIN apel ON dispatcher.id_dispatcher = apel.id_dispatcher
JOIN interventie ON apel.id_apel = interventie.id_apel
WHERE interventie.id_locatie IN (
    SELECT locatie.id_locatie
    FROM locatie
    WHERE locatie.oras IN (
        SELECT locatie.oras
        FROM locatie
        JOIN interventie ON locatie.id_locatie = interventie.id_locatie
        JOIN interventie_echipaj ON interventie.id_interventie = interventie_echipaj.id_interventie
        GROUP BY locatie.oras
        HAVING COUNT(interventie_echipaj.id_echipaj) > 3
    )
)
AND interventie.id_tip IN (
    SELECT id_tip
    FROM tip_interventie
    WHERE prioritate = 'ridicată'
);
";

$result = $conn->query($sql);

echo "<h1>Dispatcherii care au gestionat intervenții prioritare în orașe cu multe echipaje</h1>";
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Nume</th>
                <th>Prenume</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['nume']}</td>
                <td>{$row['prenume']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nu există rezultate.</p>";
}
?>
<a href="admin.php">Înapoi la meniu</a>
