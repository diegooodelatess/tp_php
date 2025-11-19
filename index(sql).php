<?php
// Connexion à MySQL avec PDO (WAMP = mot de passe vide)
try {
    $mysqlClient = new PDO(
        'mysql:host=localhost;dbname=jo;charset=utf8',
        'root',
        'Doris10101010!'
    );
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

// Requête SQL
$sth = $mysqlClient->prepare("SELECT * FROM `100`;");
$sth->execute();

// Récupération propre des données
$data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Table 100 - JO</title>
</head>
<body>

<h2>Résultats de la course 100m</h2>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Pays</th>
            <th>Course</th>
            <th>Temps</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($data as $value) { ?>
            <tr>
                <td><?php echo $value["nom"]; ?></td>
                <td><?php echo $value["pays"]; ?></td>
                <td><?php echo $value["course"]; ?></td>
                <td><?php echo $value["temps"]; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
