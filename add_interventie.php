<?php
session_start();
include 'db.php';

// obtin lista dispatcherilor
$dispatcheri = [];
$query_dispatcheri = "SELECT id_dispatcher, nume, prenume FROM dispatcher";
$result_dispatcheri = $conn->query($query_dispatcheri);
if ($result_dispatcheri->num_rows > 0) {
    while ($row = $result_dispatcheri->fetch_assoc()) {
        $dispatcheri[] = $row;
    }
}

// obtin lista apelurilor
$apeluri = [];
$query_apeluri = "SELECT apel.id_apel, apel.data_apel, apel.ora_apel, apel.tip_urgenta, apelant.nume, apelant.prenume 
                  FROM apel 
                  JOIN apelant ON apel.id_apelant = apelant.id_apelant";
$result_apeluri = $conn->query($query_apeluri);
if ($result_apeluri->num_rows > 0) {
    while ($row = $result_apeluri->fetch_assoc()) {
        $apeluri[] = $row;
    }
}

// obtin lista tipurilor de interventii
$tipuri_interventii = [];
$query_tipuri = "SELECT id_tip, denumire, prioritate FROM tip_interventie";
$result_tipuri = $conn->query($query_tipuri);
if ($result_tipuri->num_rows > 0) {
    while ($row = $result_tipuri->fetch_assoc()) {
        $tipuri_interventii[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id_dispatcher = $_POST['dispatcher'];
    $id_apel = $_POST['id_apel'];
    $id_tip = $_POST['tip_interventie'];
    $data_interventie = $_POST['data_interventie'];
    $ora_sosire = $_POST['ora_sosire'];
    $oras = $_POST['oras'];
    $adresa = $_POST['adresa'];
    $descriere = $_POST['descriere'];

    try {
        // actualizam descrierea in tabelul tip_interventie
        $update_descriere = $conn->prepare("UPDATE tip_interventie SET descriere = ? WHERE id_tip = ?");
        $update_descriere->bind_param("si", $descriere, $id_tip);
        $update_descriere->execute();

        // adaugam locatia daca nu exista deja
        $query_locatie = $conn->prepare("SELECT id_locatie FROM locatie WHERE oras = ? AND adresa = ?");
        $query_locatie->bind_param("ss", $oras, $adresa);
        $query_locatie->execute();
        $result_locatie = $query_locatie->get_result();

        if ($result_locatie->num_rows > 0) {
            $id_locatie = $result_locatie->fetch_assoc()['id_locatie'];
        } else {
            $insert_locatie = $conn->prepare("INSERT INTO locatie (oras, adresa) VALUES (?, ?)");
            $insert_locatie->bind_param("ss", $oras, $adresa);
            $insert_locatie->execute();
            $id_locatie = $conn->insert_id;
        }

        // inserăm interventia
        $insert_interventie = $conn->prepare(
            "INSERT INTO interventie (data_interventie, ora_sosire, id_locatie, id_dispatcher, id_apel, id_tip) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $insert_interventie->bind_param("ssiiii", $data_interventie, $ora_sosire, $id_locatie, $id_dispatcher, $id_apel, $id_tip);
        $insert_interventie->execute();

        echo "<div class='success-message'>Intervenția a fost adăugată cu succes!</div>";
    } catch (Exception $e) {
        echo "<div class='error-message'>Eroare: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Intervenție</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input, select, textarea, button {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
        .success-message, .error-message {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Adaugă Intervenție</h1>
        <form method="POST">
            <label for="dispatcher">Dispatcher:</label>
            <select id="dispatcher" name="dispatcher" required>
                <option value="">Selectează Dispatcher...</option>
                <?php foreach ($dispatcheri as $dispatcher): ?>
                    <option value="<?= $dispatcher['id_dispatcher'] ?>">
                        <?= $dispatcher['nume'] . ' ' . $dispatcher['prenume'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_apel">Apel:</label>
            <select id="id_apel" name="id_apel" required>
                <option value="">Selectează Apel...</option>
                <?php foreach ($apeluri as $apel): ?>
                    <option value="<?= $apel['id_apel'] ?>">
                        <?= "Apel: " . $apel['id_apel'] . " - " . $apel['nume'] . " " . $apel['prenume'] . " - " . $apel['data_apel'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="tip_interventie">Tip Intervenție:</label>
            <select id="tip_interventie" name="tip_interventie" required>
                <option value="">Selectează Tipul...</option>
                <?php foreach ($tipuri_interventii as $tip): ?>
                    <option value="<?= $tip['id_tip'] ?>">
                        <?= $tip['denumire'] ?> - Prioritate: <?= $tip['prioritate'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="data_interventie">Data Intervenție:</label>
            <input type="date" id="data_interventie" name="data_interventie" required>

            <label for="ora_sosire">Ora Sosire:</label>
            <input type="time" id="ora_sosire" name="ora_sosire" required>

            <label for="oras">Oraș:</label>
            <input type="text" id="oras" name="oras" required>

            <label for="adresa">Adresă:</label>
            <input type="text" id="adresa" name="adresa" required>

            <label for="descriere">Descriere:</label>
            <textarea id="descriere" name="descriere" rows="4" required></textarea>

            <button type="submit" name="submit">Adaugă Intervenție</button>
        </form>
        <a href="admin.php">Înapoi la meniu</a>
    </div>
</body>
</html>
