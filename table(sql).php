<?php
// -----------------------------------------------------------
// Connexion simple
// -----------------------------------------------------------
try {
    $bdd = new PDO("mysql:host=localhost;dbname=jo;charset=utf8", "root", "Doris10101010!");
} catch (Exception $e) {
    die("Erreur de connexion");
}


// -----------------------------------------------------------
// Ajout d’un résultat
// -----------------------------------------------------------
$erreurs = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom"];
    $pays = strtoupper($_POST["pays"]);
    $course = $_POST["course"];
    $temps = $_POST["temps"];

    if (strlen($pays) != 3) {
        $erreurs[] = "Le pays doit faire 3 lettres.";
    }

    if (!is_numeric($temps)) {
        $erreurs[] = "Le temps doit être un nombre.";
    }

    if (empty($erreurs)) {
        $requete = $bdd->prepare("INSERT INTO `100` (nom, pays, course, temps) VALUES (?, ?, ?, ?)");
        $requete->execute([$nom, $pays, $course, $temps]);

        header("Location: index.php");
        exit;
    }
}


// -----------------------------------------------------------
// Liste des courses
// -----------------------------------------------------------
$courses = $bdd->query("SELECT DISTINCT course FROM `100`")->fetchAll(PDO::FETCH_COLUMN);


// -----------------------------------------------------------
// Liste des résultats
// -----------------------------------------------------------
$mot = $_GET["recherche"] ?? "";

if ($mot != "") {
    $sql = $bdd->prepare("SELECT * FROM `100` WHERE nom LIKE ? OR pays LIKE ? OR course LIKE ? ORDER BY course, temps");
    $sql->execute(["%$mot%", "%$mot%", "%$mot%"]);
} else {
    $sql = $bdd->query("SELECT * FROM `100` ORDER BY course, temps");
}

$resultats = $sql->fetchAll();
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
    <th>Nom</th>
    <th>Pays</th>
    <th>Course</th>
    <th>Temps</th>
    <th>Modifier</th>
</tr>

<?php
foreach ($resultats as $ligne) {
    echo "<tr>";
    echo "<td>{$ligne['nom']}</td>";
    echo "<td>{$ligne['pays']}</td>";
    echo "<td>{$ligne['course']}</td>";
    echo "<td>{$ligne['temps']}</td>";
    echo "<td><a href='edit.php?id={$ligne['id']}'>Modifier</a></td>";
    echo "</tr>";
}
?>
</table>

</body>
</html>
