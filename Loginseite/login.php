<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "bfma";

// Benutzereingaben aus dem Formular entgegennehmen
$usernameInput = $_POST['username'];
$passwordInput = $_POST['password'];
$_SESSION['loggedin'];

// Verbindung zur MySQL-Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $database);

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}



// SQL-Abfrage, um Benutzerdaten abzurufen
$sql = "SELECT * FROM your_table WHERE username = '$usernameInput';";
$result = $conn->query($sql);




// Überprüfen, ob ein Benutzer mit dem angegebenen Benutzernamen existiert
if (mysqli_num_rows($result) == 1) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];
   
    // Überprüfen, ob das eingegebene Passwort korrekt ist
    if ($passwordInput == $storedPassword) {
        

        $_SESSION['loggedin'] = true;

        header("Location: ../startseite/startseite.php");
        exit(); // Beenden des aktuellen Skripts

       

    } else {

        header("Location: ../loginseite/loginseite.php");
        exit(); // Beenden des aktuellen Skripts
        
    }
} else {

    header("Location: ../loginseite/loginseite.php");
        exit(); // Beenden des aktuellen Skripts
    
}

// Verbindung schließen
$conn->close();
?>