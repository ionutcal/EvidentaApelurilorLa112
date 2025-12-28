<?php
include 'db.php';

$sql = "
SELECT apel.id_apel, apel.data_apel, apel.ora_apel, echipaj.nume_echipaj, locatie.oras
FROM apel
JOIN interventie ON apel.id_apel = interventie.id_apel
JOIN locatie ON interventie.id_locatie = locatie.id_locatie
JOIN interventie_echipaj ON interventie.id_interventie = interventie_echipaj.id_interventie
JOIN echipaj ON interventie_echipaj.id_echipaj = echipaj.id_echipaj
WHERE locatie.oras IN (
    SELECT locatie.oras
    FROM apel
    JOIN interventie ON apel.id_apel = interventie.id_apel
    JOIN locatie ON interventie.id_locatie = locatie.id_locatie
    GROUP BY locatie.oras
    HAVING COUNT(apel.id_apel) > (
        SELECT AVG(numar_apeluri)
        FROM (
            SELECT COUNT(apel.id_apel) AS numar_apeluri
            FROM apel
            JOIN interventie ON apel.id_apel = interventie.id_apel
            JOIN locatie ON interventie.id_locatie = locatie.id_locatie
            GROUP BY locatie.oras
        ) AS subquery_apeluri
    )
)
AND echipaj.tip_echipaj = 'specializat';
";

$result = $conn->query($sql);

echo "<h1>Apeluri cu intervenții ale echipajelor specializate</h1>";
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID Apel</th>
                <th>Data</th>
                <th>Ora</th>
                <th>Nume Echipaj</th>
                <th>Oraș</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_apel']}</td>
                <td>{$row['data_apel']}</td>
                <td>{$row['ora_apel']}</td>
                <td>{$row['nume_echipaj']}</td>
                <td>{$row['oras']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nu există rezultate.</p>";
}
?>
<a href="admin.php">Înapoi la meniu</a>
