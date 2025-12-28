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

$sql = "SELECT apel.id_apel, apel.data_apel, apel.ora_apel, apel.tip_urgenta,
               apelant.nume AS nume_apelant, apelant.prenume AS prenume_apelant,
               dispatcher.nume AS nume_dispatcher, dispatcher.prenume AS prenume_dispatcher
        FROM apel
        JOIN apelant ON apel.id_apelant = apelant.id_apelant
        JOIN dispatcher ON apel.id_dispatcher = dispatcher.id_dispatcher";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID Apel</th>
                <th>Data Apel</th>
                <th>Ora Apel</th>
                <th>Tip Urgență</th>
                <th>Apelant</th>
                <th>Dispatcher</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_apel']}</td>
                <td>{$row['data_apel']}</td>
                <td>{$row['ora_apel']}</td>
                <td>{$row['tip_urgenta']}</td>
                <td>{$row['nume_apelant']} {$row['prenume_apelant']}</td>
                <td>{$row['nume_dispatcher']} {$row['prenume_dispatcher']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nu există apeluri înregistrate.";
}
?>
<a href="admin.php">Înapoi la meniu</a>
