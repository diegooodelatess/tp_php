<?php

$contact = ["Alice Dupont", "John Doe", "Jean Martin", "coucou"];
$filename = "contact.txt";

// On crée un tableau vide pour stocker les contacts déjà présents dans le fichier.
$contacts_existants = []; 

// Vérifie si le fichier $filename existe.
if (file_exists($filename)) {
    // Lit tout le contenu du fichier et le stocke dans $contenu.
    $contenu = file_get_contents($filename);
    // Transforme la chaîne du fichier en tableau, une ligne par élément
    $contacts_existants = explode("\n", $contenu);
}

// Ouvre le fichier en mode ajout ("a")
$fichier = fopen($filename, "a");

// Parcourt chaque contact à ajouter
foreach ($contact as $nom) {
    // Vérifie si le contact n'existe pas déjà
    if (!in_array($nom, $contacts_existants)) {
        // Écrit le contact dans le fichier suivi d'un saut de ligne
        fwrite($fichier, $nom . "\n");
        // Met à jour le tableau pour éviter les doublons
        $contacts_existants[] = $nom;
    }
}

// Ferme le fichier
fclose($fichier);

?>
