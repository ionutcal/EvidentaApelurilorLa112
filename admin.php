<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meniu Administrativ</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 300px;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .admin-menu {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .section {
            flex: 1 1 calc(50% - 20px);
            max-width: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .section h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #007bff;
        }

        .section p {
            font-size: 14px;
            color: #333;
            margin: 5px 0 10px;
        }

        a {
            display: block;
            margin: 5px 0;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

        .logout-container {
            margin-top: 20px;
            text-align: center;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #a71d2a;
        }

        @media (max-width: 768px) {
            .section {
                flex: 1 1 100%;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 20px;
            }

            .section h2 {
                font-size: 16px;
            }

            a {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h1>Bine ai venit, <?php echo $_SESSION['nume'] . " " . $_SESSION['prenume']; ?>!</h1>

    <div class="admin-menu">
        <div class="section">
            <h2>Intervenții</h2>
            <a href="vizualizeaza_interventii.php">Vizualizează</a>
            <a href="add_interventie.php">Adaugă</a>
            <a href="update_interventie.php">Modifică</a>
            <a href="delete_interventie.php">Șterge</a>
        </div>

        <div class="section">
            <h2>Apeluri</h2>
            <a href="vizualizeaza_apel.php">Vizualizează</a>
            <a href="add_apel.php">Adaugă</a>
            <a href="update_apel.php">Modifică</a>
            <a href="delete_apel.php">Șterge</a>
        </div>

        <div class="section">
            <h2>Echipaje</h2>
            <a href="vizualizeaza_echipaj.php">Vizualizează</a>
            <a href="add_echipaj.php">Adaugă</a>
            <a href="update_echipaj.php">Modifică</a>
        </div>

        <div class="section">
            <h2>Interogări Simple</h2>
            <p>Listează toate intervențiile cu locațiile și apelanții asociate.</p>
            <a href="interogare1.php">Interogarea 1</a>
            <p>Listează toate apelurile împreună cu detalii despre dispatcher și apelant.</p>
            <a href="interogare2.php">Interogarea 2</a>
            <p>Listează echipajele și intervențiile asociate acestora.</p>
            <a href="interogare3.php">Interogarea 3</a>
            <p>Listează tipurile de intervenții ordonate după prioritate.</p>
            <a href="interogare4.php">Interogarea 4</a>
        </div>

        <div class="section">
            <h2>Interogări Complexe</h2>
            <p>Listează toate apelurile care au dus la intervenții în orașe cu cele mai multe apeluri și care au implicat echipaje specializate.</p>
            <a href="interogare_complexa1.php">Interogarea 1</a>
            <p></p>
            <p>Listează dispatcherii care au gestionat intervenții în orașe unde s-au desfășurat cele mai multe echipaje, iar intervențiile au fost prioritare.</p>
            <a href="interogare_complexa2.php">Interogarea 2</a>
            <p></p>
            <p>Listează apelanții care au solicitat intervenții prioritare în orașe unde numărul de apeluri este mai mare decât media pe orașe.</p>
            <a href="interogare_complexa3.php">Interogarea 3</a>
            <p></p>
            <p>Listează dispatcherii care au gestionat cele mai multe apeluri.</p>
            <a href="interogare_complexa4.php">Interogarea 4</a>
        </div>
    </div>

    <div class="logout-container">
        <a href="logout.php" class="logout-button">Deconectare</a>
    </div>
</body>
</html>
