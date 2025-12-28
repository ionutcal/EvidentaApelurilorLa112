<?php
include 'db.php';

$sql = "
SELECT DISTINCT apelant.nume, apelant.prenume, apelant.telefon
FROM apel
JOIN apelant ON apel.id_apelant = apelant.id_apelant
JOIN interventie ON apel.id_apel = interventie.id_apel
WHERE interventie.id_tip IN (
    SELECT id_tip
    FROM tip_interventie
    WHERE prioritate = 'ridicată'
)
AND interventie.id_locatie IN (
    SELECT locatie.id_locatie
    FROM locatie
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
            ) AS subquery
        )
    )
);
";

$result = $conn->query($sql);

echo "<h1>Apelanți cu intervenții prioritare în orașe cu multe apeluri</h1>";
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Telefon</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['nume']}</td>
                <td>{$row['prenume']}</td>
                <td>{$row['telefon']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nu există rezultate.</p>";
}
?>
<a href="admin.php">Înapoi la meniu</a>
