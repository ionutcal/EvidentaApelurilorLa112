<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_echipaj = $_POST['id_echipaj'];
    $nume_echipaj = $_POST['nume_echipaj'];
    $tip_echipaj = $_POST['tip_echipaj'];

    $sql = "UPDATE echipaj SET nume_echipaj = ?, tip_echipaj = ? WHERE id_echipaj = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nume_echipaj, $tip_echipaj, $id_echipaj);

    if ($stmt->execute()) {
        echo "<div class='message success'>Echipajul a fost actualizat cu succes.</div>";
    } else {
        echo "<div class='message error'>Eroare: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizează Echipaj</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #007bff;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        select, input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Actualizează Echipaj</h1>
        <form method="post">
            <label for="id_echipaj">Selectează Echipaj:</label>
            <select id="id_echipaj" name="id_echipaj" required>
                <option value="">--Selectează un Echipaj--</option>
                <?php
                $result = $conn->query("SELECT id_echipaj, nume_echipaj FROM echipaj");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_echipaj'] . "'>ID: " . $row['id_echipaj'] . " - " . $row['nume_echipaj'] . "</option>";
                }
                ?>
            </select>

            <label for="nume_echipaj">Nume Echipaj:</label>
            <input type="text" id="nume_echipaj" name="nume_echipaj" required>

            <label for="tip_echipaj">Tip Echipaj:</label>
            <input type="text" id="tip_echipaj" name="tip_echipaj" required>

            <button type="submit">Actualizează</button>
        </form>
        <a href="admin.php">Înapoi la meniu</a>
    </div>
</body>
</html>
