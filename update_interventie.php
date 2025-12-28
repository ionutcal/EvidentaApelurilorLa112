<?php
include 'db.php';

echo "<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f9f9f9;
        color: #333;
    }
    form {
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    form input, form select, form button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }
    form input:focus, form select:focus {
        border-color: #007BFF;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    form button {
        background-color: #007BFF;
        color: white;
        border: none;
        cursor: pointer;
    }
    form button:hover {
        background-color: #0056b3;
    }
    h1 {
        text-align: center;
        color: #333;
    }
    .message {
        text-align: center;
        margin: 20px auto;
        padding: 10px;
        border-radius: 5px;
        max-width: 500px;
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

if (isset($_POST['submit'])) {
    $id_interventie = $_POST['id_interventie'];
    $data_interventie = $_POST['data_interventie'];
    $ora_sosire = $_POST['ora_sosire'];
    $oras = $_POST['oras'];
    $adresa = $_POST['adresa'];
    $data_apel = $_POST['data_apel'];
    $ora_apel = $_POST['ora_apel'];
    $tip_urgenta = $_POST['tip_urgenta'];
    $nume_prenume_apelant = $_POST['nume_prenume_apelant'];
    $telefon = $_POST['telefon'];
    $dispatcher = $_POST['dispatcher'];
    $tip_interventie = $_POST['tip_interventie'];

    // separare nume si prenume apelant
    $apelant_array = explode(" ", $nume_prenume_apelant, 2);
    $nume_apelant = $apelant_array[0];
    $prenume_apelant = isset($apelant_array[1]) ? $apelant_array[1] : "";

    // Verificare si/sau adaugare locatie
    $sql_locatie = "SELECT id_locatie FROM locatie WHERE oras = ? AND adresa = ?";
    $stmt_locatie = $conn->prepare($sql_locatie);
    $stmt_locatie->bind_param("ss", $oras, $adresa);
    $stmt_locatie->execute();
    $result_locatie = $stmt_locatie->get_result();

    if ($result_locatie->num_rows > 0) {
        $row_locatie = $result_locatie->fetch_assoc();
        $id_locatie = $row_locatie['id_locatie'];
    } else {
        $sql_insert_locatie = "INSERT INTO locatie (oras, adresa) VALUES (?, ?)";
        $stmt_insert_locatie = $conn->prepare($sql_insert_locatie);
        $stmt_insert_locatie->bind_param("ss", $oras, $adresa);
        $stmt_insert_locatie->execute();
        $id_locatie = $conn->insert_id;
    }

    // verificare si/sau adaugare apelant
    $sql_apelant = "SELECT id_apelant FROM apelant WHERE nume = ? AND prenume = ? AND telefon = ?";
    $stmt_apelant = $conn->prepare($sql_apelant);
    $stmt_apelant->bind_param("sss", $nume_apelant, $prenume_apelant, $telefon);
    $stmt_apelant->execute();
    $result_apelant = $stmt_apelant->get_result();

    if ($result_apelant->num_rows > 0) {
        $row_apelant = $result_apelant->fetch_assoc();
        $id_apelant = $row_apelant['id_apelant'];
    } else {
        $sql_insert_apelant = "INSERT INTO apelant (nume, prenume, telefon) VALUES (?, ?, ?)";
        $stmt_insert_apelant = $conn->prepare($sql_insert_apelant);
        $stmt_insert_apelant->bind_param("sss", $nume_apelant, $prenume_apelant, $telefon);
        $stmt_insert_apelant->execute();
        $id_apelant = $conn->insert_id;
    }

    // actualizare interventie
    $sql_update_interventie = "UPDATE interventie 
                               SET data_interventie = ?, 
                                   ora_sosire = ?, 
                                   id_locatie = ?, 
                                   id_dispatcher = ?, 
                                   id_tip = ? 
                               WHERE id_interventie = ?";
    $stmt_interventie = $conn->prepare($sql_update_interventie);
    $stmt_interventie->bind_param("ssiisi", $data_interventie, $ora_sosire, $id_locatie, $dispatcher, $tip_interventie, $id_interventie);
    $stmt_interventie->execute();

    // actualizare apel
    $sql_update_apel = "UPDATE apel 
                        SET data_apel = ?, 
                            ora_apel = ?, 
                            tip_urgenta = ?, 
                            id_apelant = ? 
                        WHERE id_apel = (SELECT id_apel FROM interventie WHERE id_interventie = ?)";
    $stmt_apel = $conn->prepare($sql_update_apel);
    $stmt_apel->bind_param("sssii", $data_apel, $ora_apel, $tip_urgenta, $id_apelant, $id_interventie);
    $stmt_apel->execute();

    echo "<div class='message success'>Intervenția a fost actualizată cu succes.</div>";
}
?>

<h1>Actualizează Intervenție</h1>
<form method="post">
    <label for="id_interventie">Selectează Intervenție:</label>
    <select id="id_interventie" name="id_interventie" required>
        <option value="">--Selectează o Intervenție--</option>
        <?php
        $result = $conn->query("SELECT id_interventie, data_interventie, ora_sosire FROM interventie");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_interventie'] . "'>ID: " . $row['id_interventie'] . " - Data: " . $row['data_interventie'] . " - Ora: " . $row['ora_sosire'] . "</option>";
        }
        ?>
    </select>

    <label for="data_interventie">Data Intervenție:</label>
    <input type="date" id="data_interventie" name="data_interventie" required>

    <label for="ora_sosire">Ora Sosire:</label>
    <input type="time" id="ora_sosire" name="ora_sosire" required>

    <label for="oras">Oraș:</label>
    <input type="text" id="oras" name="oras" required>

    <label for="adresa">Adresă:</label>
    <input type="text" id="adresa" name="adresa" required>

    <label for="data_apel">Data Apel:</label>
    <input type="date" id="data_apel" name="data_apel" required>

    <label for="ora_apel">Ora Apel:</label>
    <input type="time" id="ora_apel" name="ora_apel" required>

    <label for="tip_urgenta">Tip Urgență:</label>
    <input type="text" id="tip_urgenta" name="tip_urgenta" required>

    <label for="nume_prenume_apelant">Nume și Prenume Apelant:</label>
    <input type="text" id="nume_prenume_apelant" name="nume_prenume_apelant" required>

    <label for="telefon">Telefon Apelant:</label>
    <input type="text" id="telefon" name="telefon" required>

    <label for="dispatcher">Selectează Dispatcher:</label>
    <select id="dispatcher" name="dispatcher" required>
        <option value="">--Selectează Dispatcher--</option>
        <?php
        $result = $conn->query("SELECT id_dispatcher, CONCAT(nume, ' ', prenume) AS nume_complet FROM dispatcher");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_dispatcher'] . "'>" . $row['nume_complet'] . "</option>";
        }
        ?>
    </select>

    <label for="tip_interventie">Selectează Tip Intervenție:</label>
    <select id="tip_interventie" name="tip_interventie" required>
        <option value="">--Selectează Tipul--</option>
        <?php
        $result = $conn->query("SELECT id_tip, denumire FROM tip_interventie");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_tip'] . "'>" . $row['denumire'] . "</option>";
        }
        ?>
    </select>

    <button type="submit" name="submit">Actualizează Intervenție</button>
</form>

<a href="admin.php">Înapoi la meniu</a>
