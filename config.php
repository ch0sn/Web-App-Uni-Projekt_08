<?php
// Starte die Sitzung
session_start();

// Überprüfe, ob $_SESSION['loggedin'] den Wert true hat
if ($_SESSION['loggedin'] === true) {
    // Der Benutzer ist eingeloggt
    // Führe hier den Code aus, der für eingeloggte Benutzer bestimmt ist
    
   
} else {
   
    header("Location: ../loginseite/loginseite.php");
        exit(); // Beenden des aktuellen Skripts
}
?>