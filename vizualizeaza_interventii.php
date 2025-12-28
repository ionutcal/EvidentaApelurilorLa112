<?php
include 'db.php';

echo "<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 18px;
        text-align: left;
    }
    table th, table td {
        padding: 12px;
        border: 1px solid #ddd;
    }
    table th {
        background-color: #f4f4f4;
        color: #333;
    }
    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    table tr:hover {
        background-color: #f1f1f1;
    }
    a {
        display: inline-block;
        margin: 20px 0;
        padding: 10px 15px;
        background-color: #007BFF;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }
    a:hover {
        background-color: #0056b3;
    }
</style>";

$sql = "SELECT 
            interventie.id_interventie, 
            interventie.data_interventie, 
            interventie.ora_sosire,
            locatie.adresa, 
            locatie.oras,
            CONCAT(apelant.nume, ' ', apelant.prenume) AS nume_prenume_apelant,
            tip_interventie.denumire AS denumire_interventie,
            tip_interventie.descriere AS descriere_interventie,
            CONCAT(dispatcher.nume, ' ', dispatcher.prenume) AS nume_prenume_dispatcher
        FROM interventie
        JOIN locatie ON interventie.id_locatie = locatie.id_locatie
        JOIN apel ON interventie.id_apel = apel.id_apel
        JOIN apelant ON apel.id_apelant = apelant.id_apelant
        JOIN tip_interventie ON interventie.id_tip = tip_interventie.id_tip
        JOIN dispatcher ON interventie.id_dispatcher = dispatcher.id_dispatcher";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID Intervenție</th>
                <th>Data Intervenție</th>
                <th>Ora Sosire</th>
                <th>Adresă</th>
                <th>Oraș</th>
                <th>Apelant</th>
                <th>Denumire Intervenție</th>
                <th>Descriere</th>
                <th>Dispatcher</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_interventie']}</td>
                <td>{$row['data_interventie']}</td>
                <td>{$row['ora_sosire']}</td>
                <td>{$row['adresa']}</td>
                <td>{$row['oras']}</td>
                <td>{$row['nume_prenume_apelant']}</td>
                <td>{$row['denumire_interventie']}</td>
                <td>{$row['descriere_interventie']}</td>
                <td>{$row['nume_prenume_dispatcher']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nu există intervenții înregistrate.";
}
?>
<a href="admin.php">Înapoi la meniu</a>
