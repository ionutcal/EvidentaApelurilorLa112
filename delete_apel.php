<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $id_apel = $_POST['id_apel'];

    // stergem interventiile echipajelor asociate cu acest apel
    $sql_interventie_echipaj = "DELETE FROM interventie_echipaj 
                                WHERE id_interventie IN (
                                    SELECT id_interventie FROM interventie WHERE id_apel = '$id_apel'
                                )";
    if ($conn->query($sql_interventie_echipaj) === TRUE) {
        // stergem interventiile asociate cu acest apel
        $sql_interventie = "DELETE FROM interventie WHERE id_apel = '$id_apel'";
        if ($conn->query($sql_interventie) === TRUE) {
            // stergem apelul
            $sql_apel = "DELETE FROM apel WHERE id_apel = '$id_apel'";
            if ($conn->query($sql_apel) === TRUE) {
                echo "<div class='message success'>Apelul și înregistrările asociate au fost șterse cu succes!</div>";
            } else {
                echo "<div class='message error'>Eroare la ștergerea apelului: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='message error'>Eroare la ștergerea intervențiilor: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='message error'>Eroare la ștergerea intervențiilor echipajelor: " . $conn->error . "</div>";
    }
}

// preluam apelurile existente pentru selectie
$sql = "SELECT a.id_apel, a.data_apel, a.ora_apel, ap.telefon
        FROM apel a
        JOIN apelant ap ON a.id_apelant = ap.id_apelant";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Șterge Apel</title>
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

        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #a71d2a;
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
        <h1>Șterge Apel</h1>
        <form method="post">
            <label for="id_apel">Selectează Apel:</label>
            <select id="id_apel" name="id_apel" required>
                <option value="">-- Alege un apel --</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_apel'] . "'>
                                Data: " . $row['data_apel'] . ", Ora: " . $row['ora_apel'] . ", Telefon: " . $row['telefon'] . "
                              </option>";
                    }
                } else {
                    echo "<option value=''>Nu există apeluri</option>";
                }
                ?>
            </select>
            <button type="submit" name="submit">Șterge Apel</button>
        </form>
        <a href="admin.php">Înapoi la meniu</a>
    </div>
</body>
</html>
