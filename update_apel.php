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
        max-width: 400px;
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
        max-width: 400px;
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
    $id_apel = $_POST['id_apel'];
    $data_apel = $_POST['data_apel'];
    $ora_apel = $_POST['ora_apel'];
    $tip_urgenta = $_POST['tip_urgenta'];
    $nume_prenume = $_POST['nume_prenume'];
    $telefon = $_POST['telefon'];
    $nume_dispatcher = $_POST['dispatcher'];

    // separare nume si prenume
    $nume_prenume_array = explode(" ", $nume_prenume, 2);
    $nume = $nume_prenume_array[0];
    $prenume = isset($nume_prenume_array[1]) ? $nume_prenume_array[1] : "";

    // adaugare/verificare apelant in tabela apelant
    $sql_apelant = "SELECT id_apelant FROM apelant WHERE nume = ? AND prenume = ? AND telefon = ?";
    $stmt_apelant = $conn->prepare($sql_apelant);
    $stmt_apelant->bind_param("sss", $nume, $prenume, $telefon);
    $stmt_apelant->execute();
    $result_apelant = $stmt_apelant->get_result();

    if ($result_apelant->num_rows > 0) {
        // apelantul exista deja
        $row_apelant = $result_apelant->fetch_assoc();
        $id_apelant = $row_apelant['id_apelant'];
    } else {
        // adaugare nou apelant
        $sql_insert_apelant = "INSERT INTO apelant (nume, prenume, telefon) VALUES (?, ?, ?)";
        $stmt_insert_apelant = $conn->prepare($sql_insert_apelant);
        $stmt_insert_apelant->bind_param("sss", $nume, $prenume, $telefon);
        $stmt_insert_apelant->execute();
        $id_apelant = $conn->insert_id;
    }

    // actualizare date apel
    $sql = "UPDATE apel 
            SET data_apel = ?, 
                ora_apel = ?, 
                tip_urgenta = ?, 
                id_apelant = ?, 
                id_dispatcher = (SELECT id_dispatcher FROM dispatcher WHERE CONCAT(nume, ' ', prenume) = ?)
            WHERE id_apel = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $data_apel, $ora_apel, $tip_urgenta, $id_apelant, $nume_dispatcher, $id_apel);

    if ($stmt->execute() === TRUE) {
        echo "<div class='message success'>Apelul a fost actualizat cu succes.</div>";
    } else {
        echo "<div class='message error'>Eroare: " . $conn->error . "</div>";
    }
}
?>

<h1>Actualizează Apel</h1>
<form method="post">
    <label for="id_apel">Selectează ID Apel:</label>
    <select id="id_apel" name="id_apel" required>
        <option value="">--Selectează un ID Apel--</option>
        <?php
        $result = $conn->query("SELECT id_apel, data_apel FROM apel");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_apel'] . "'>ID: " . $row['id_apel'] . " - Data: " . $row['data_apel'] . "</option>";
        }
        ?>
    </select>
    
    <label for="data_apel">Data Apel:</label>
    <input type="date" id="data_apel" name="data_apel" required>
    
    <label for="ora_apel">Ora Apel:</label>
    <input type="time" id="ora_apel" name="ora_apel" required>
    
    <label for="tip_urgenta">Tip Urgență:</label>
    <input type="text" id="tip_urgenta" name="tip_urgenta" required>
    
    <label for="nume_prenume">Nume și Prenume Apelant:</label>
    <input type="text" id="nume_prenume" name="nume_prenume" required>
    
    <label for="telefon">Telefon Apelant:</label>
    <input type="text" id="telefon" name="telefon" required>
    
    <label for="dispatcher">Selectează Dispatcher:</label>
    <select id="dispatcher" name="dispatcher" required>
        <option value="">--Selectează Dispatcher--</option>
        <?php
        $result = $conn->query("SELECT CONCAT(nume, ' ', prenume) AS nume_complet FROM dispatcher");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['nume_complet'] . "'>" . $row['nume_complet'] . "</option>";
        }
        ?>
    </select>
    
    <button type="submit" name="submit">Actualizează Apel</button>
</form>

<a href="admin.php">Înapoi la meniu</a>
