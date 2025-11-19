<?php
require "config.php"; // ← connexion PDO

$id = $_GET["id"] ?? 0;

$req = $bdd->prepare("SELECT * FROM `100` WHERE id = ?");
$req->execute([$id]);
$donnees = $req->fetch();

if (!$donnees) {
    die("Résultat introuvable.");
}

$erreurs = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom"];
    $pays = $_POST["pays"];
    $course = $_POST["course"];
    $temps = $_POST["temps"];

    if (strlen($pays) != 3) {
        $erreurs[] = "Le pays doit faire 3 lettres.";
    }

    if (!is_numeric($temps)) {
        $erreurs[] = "Le temps doit être un nombre.";
    }

    if (empty($erreurs)) {
        $update = $bdd->prepare("UPDATE `100` 
                                 SET nom=?, pays=?, course=?, temps=? 
                                 WHERE id=?");
        $update->execute([$nom, $pays, $course, $temps, $id]);

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier</title>
</head>
<body>

<h2>Modifier un résultat</h2>

<?php foreach ($erreurs as $e) echo "<p style='color:red;'>$e</p>"; ?>

<form method="post">

    Nom : <input type="text" name="nom" value="<?= $donnees['nom'] ?>" required><br><br>
    Pays : <input type="text" name="pays" maxlength="3" value="<?= $donnees['pays'] ?>" required><br><br>
    Course : <input type="text" name="course" value="<?= $donnees['course'] ?>" required><br><br>
    Temps : <input type="text" name="temps" value="<?= $donnees['temps'] ?>" required><br><br>

    <button type="submit">Enregistrer</button>

</form>

<br>
<a href="index.php">Retour</a>

</body>
</html>
