<?php
// Connexion à MySQL avec PDO
try {
    $mysqlClient = new PDO(
        'mysql:host=localhost;dbname=jo;charset=utf8',
        'root',
        'Doris10101010!'
    );
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération des paramètres GET pour le tri et le filtre
$validColumns = ['nom', 'pays', 'course', 'temps']; // colonnes autorisées pour le tri
$sortColumn = isset($_GET['sort']) && in_array($_GET['sort'], $validColumns) ? $_GET['sort'] : 'nom';
$sortOrder = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';
$filterNom = isset($_GET['nom']) ? $_GET['nom'] : '';

// Préparation de la requête SQL avec filtre si nécessaire
$sql = "SELECT * FROM `100`";
$params = [];

if ($filterNom !== '') {
    $sql .= " WHERE nom = :nom";
    $params[':nom'] = $filterNom;
}

// Ajout du tri (sécurisé par vérification des colonnes autorisées)
$sql .= " ORDER BY $sortColumn $sortOrder";

$sth = $mysqlClient->prepare($sql);
$sth->execute($params);
$data = $sth->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour afficher la flèche de tri
function arrow($col, $currentSort, $currentOrder) {
    if ($col === $currentSort) {
        return $currentOrder === 'ASC' ? ' <span style="color:red">↑</span>' : ' <span style="color:red">↓</span>';
    }
    return '';
}

// Fonction pour générer les liens de tri
function sortLink($col, $currentSort, $currentOrder) {
    $order = ($col === $currentSort && $currentOrder === 'ASC') ? 'desc' : 'asc';
    $nomParam = isset($_GET['nom']) ? '&nom=' . urlencode($_GET['nom']) : '';
    return "<a href='?sort=$col&order=$order$nomParam'>$col" . arrow($col, $currentSort, $currentOrder) . "</a>";
}
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
            <th><?php echo sortLink('nom', $sortColumn, $sortOrder); ?></th>
            <th><?php echo sortLink('pays', $sortColumn, $sortOrder); ?></th>
            <th><?php echo sortLink('course', $sortColumn, $sortOrder); ?></th>
            <th><?php echo sortLink('temps', $sortColumn, $sortOrder); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($data) === 0): ?>
            <tr><td colspan="4">Aucun résultat trouvé</td></tr>
        <?php else: ?>
            <?php foreach ($data as $value): ?>
                <tr>
                    <td><?php echo htmlspecialchars($value['nom']); ?></td>
                    <td><?php echo htmlspecialchars($value['pays']); ?></td>
                    <td><?php echo htmlspecialchars($value['course']); ?></td>
                    <td><?php echo htmlspecialchars($value['temps']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>