<?php
// -----------------------------------------------------------
// Connexion simple (réutilisée dans tous les fichiers)
// -----------------------------------------------------------

try {
    $bdd = new PDO("mysql:host=localhost;dbname=jo;charset=utf8", "root", "Doris10101010!");
} catch (Exception $e) {
    die("Erreur de connexion à la base.");
}
