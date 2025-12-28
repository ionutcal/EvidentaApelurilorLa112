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

$sql = "SELECT id_echipaj, nume_echipaj, tip_echipaj FROM echipaj";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID Echipaj</th>
                <th>Nume Echipaj</th>
                <th>Tip Echipaj</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_echipaj']}</td>
                <td>{$row['nume_echipaj']}</td>
                <td>{$row['tip_echipaj']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nu există echipaje înregistrate.";
}
?>
<a href="admin.php">Înapoi la meniu</a>
