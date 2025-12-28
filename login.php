<?php
session_start();

include 'db.php';

// preluare date din formular
$telefon_serviciu = $_POST['telefon_serviciu'] ?? null;
$parola = $_POST['parola'] ?? null;

$message = "";
$messageType = "";

// verificare date introduse
if ($telefon_serviciu && $parola) {
    // interogare pentru verificarea autentificarii
    $sql = "SELECT nume, prenume FROM Dispatcher WHERE telefon_serviciu = ? AND parola = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $telefon_serviciu, $parola);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // autentificare reusita
        $row = $result->fetch_assoc();
        $_SESSION['logged_in'] = true;
        $_SESSION['telefon_serviciu'] = $telefon_serviciu;
        $_SESSION['nume'] = $row['nume'];
        $_SESSION['prenume'] = $row['prenume'];

        $message = "Bine ai venit, " . $row['nume'] . " " . $row['prenume'] . "!";
        $messageType = "success";
    } else {
        // eroare la autentificare
        $message = "Număr de telefon sau parolă incorectă!";
        $messageType = "error";
    }
    $stmt->close();
} else {
    $message = "Te rugăm să completezi toate câmpurile!";
    $messageType = "error";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meniu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message-box {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        .message-box.success {
            border: 2px solid #28a745;
            color: #28a745;
        }
        .message-box.error {
            border: 2px solid #dc3545;
            color: #dc3545;
        }
        .message-box h1 {
            font-size: 20px;
            margin: 0 0 10px;
        }
        .message-box p {
            font-size: 16px;
            margin: 0;
        }
        .back-link, .admin-link {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .back-link:hover, .admin-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="message-box <?php echo $messageType; ?>">
        <h1><?php echo ($messageType === "success") ? "Succes" : "Eroare"; ?></h1>
        <p><?php echo $message; ?></p>
        <?php if ($messageType === "success") { ?>
            <a href="admin.php" class="admin-link">Meniu Administrativ</a>
        <?php } ?>
        <a href="login.html" class="back-link">Înapoi la Login</a>
    </div>
</body>
</html>
