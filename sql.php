<?php
// Connexion
try {
    $mysqlClient = new PDO(
        'mysql:host=localhost;dbname=jo;charset=utf8',
        'root',
        ''
    );
} catch (PDOException $e) {
    die($e->getMessage());
}

// Requête SQL
$sth = $mysqlClient->prepare("SELECT * FROM `100`;");
$sth->execute();

// Récupération des données
$data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Affichage dans un tableau HTML -->
<table border="1">
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
