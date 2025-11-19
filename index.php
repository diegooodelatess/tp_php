<?php
require "config.php";

// -----------------------------------------------------------
// Ajout d’un résultat
// -----------------------------------------------------------
$erreurs = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $pays = strtoupper($_POST["pays"]);
    $course = $_POST["course"];
    $temps = $_POST["temps"];

    if (strlen($pays) != 3) $erreurs[] = "Le pays doit faire 3 lettres.";
    if (!is_numeric($temps)) $erreurs[] = "Le temps doit être un nombre.";

    if (empty($erreurs)) {
        $req = $bdd->prepare("INSERT INTO `100` (nom, pays, course, temps) VALUES (?, ?, ?, ?)");
        $req->execute([$nom, $pays, $course, $temps]);
        header("Location: index.php");
        exit;
    }
}

// -----------------------------------------------------------
// Suppression d’un résultat
// -----------------------------------------------------------
if (isset($_GET['supprimer'])) {
    $id_suppr = $_GET['supprimer'];
    $req = $bdd->prepare("DELETE FROM `100` WHERE id = ?");
    $req->execute([$id_suppr]);
    header("Location: index.php");
    exit;
}

// -----------------------------------------------------------
// Liste des courses
// -----------------------------------------------------------
$courses = $bdd->query("SELECT DISTINCT course FROM `100`")->fetchAll(PDO::FETCH_COLUMN);

// -----------------------------------------------------------
// Gestion tri
// -----------------------------------------------------------
$colonnes_valides = ["nom","pays","course","temps"];
$tri = $_GET["tri"] ?? "course";
$ordre = $_GET["ordre"] ?? "asc";

if (!in_array($tri, $colonnes_valides)) $tri = "course";
$ordre = strtolower($ordre) === "desc" ? "desc" : "asc";

// -----------------------------------------------------------
// Liste des résultats (recherche + tri)
$mot = $_GET["recherche"] ?? "";

if ($mot != "") {
    $sql = $bdd->prepare("SELECT * FROM `100` 
                          WHERE nom LIKE ? OR pays LIKE ? OR course LIKE ? 
                          ORDER BY $tri $ordre");
    $sql->execute(["%$mot%", "%$mot%", "%$mot%"]);
} else {
    $sql = $bdd->query("SELECT * FROM `100` ORDER BY $tri $ordre");
}

$resultats = $sql->fetchAll();

// -----------------------------------------------------------
// Fonction pour générer lien de tri avec flèche
// -----------------------------------------------------------
function lien_tri($colonne, $tri_courant, $ordre_courant, $mot) {
    $nouvel_ordre = "asc";
    $fleche = "";
    if ($tri_courant == $colonne) {
        if ($ordre_courant == "asc") {
            $nouvel_ordre = "desc";
            $fleche = "▲";
        } else {
            $nouvel_ordre = "asc";
            $fleche = "▼";
        }
    }
    return "<a href='?tri=$colonne&ordre=$nouvel_ordre&recherche=".urlencode($mot)."'>$colonne $fleche</a>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>100m - Résultats</title>
</head>
<body>

<h2>Ajouter un résultat</h2>

<?php foreach ($erreurs as $e) echo "<p style='color:red;'>$e</p>"; ?>

<form method="post">
    Nom : <input type="text" name="nom" required><br><br>
    Pays : <input type="text" name="pays" maxlength="3" required><br><br>

    Course :
    <select name="course">
        <?php foreach ($courses as $c) echo "<option>$c</option>"; ?>
    </select><br><br>

    Temps : <input type="text" name="temps" required><br><br>

    <button type="submit">Ajouter</button>
</form>

<hr>

<h2>Résultats</h2>

<form method="get">
    Recherche :
    <input type="text" name="recherche" value="<?= htmlspecialchars($mot) ?>">
    <button>OK</button>
</form>

<br>

<table border="1" cellpadding="5">
<tr>
    <th><?= lien_tri("nom", $tri, $ordre, $mot) ?></th>
    <th><?= lien_tri("pays", $tri, $ordre, $mot) ?></th>
    <th><?= lien_tri("course", $tri, $ordre, $mot) ?></th>
    <th><?= lien_tri("temps", $tri, $ordre, $mot) ?></th>
    <th>Modifier</th>
    <th>Supprimer</th>
</tr>

<?php
foreach ($resultats as $ligne) {
    echo "<tr>";
    echo "<td>{$ligne['nom']}</td>";
    echo "<td>{$ligne['pays']}</td>";
    echo "<td>{$ligne['course']}</td>";
    echo "<td>{$ligne['temps']}</td>";
    echo "<td><a href='edit.php?id={$ligne['id']}'>Modifier</a></td>";
    echo "<td><a href='?supprimer={$ligne['id']}' onclick=\"return confirm('Voulez-vous vraiment supprimer ce résultat ?')\">Supprimer</a></td>";
    echo "</tr>";
}
?>
</table>

</body>
</html>
