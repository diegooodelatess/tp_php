<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nom'])) {
        $_SESSION['nom'] = $_POST['nom'];
    }
}

if (!isset($_SESSION['nom'])) {
?>
    <form method="post" action="connection.php">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom">
        <button type="submit">Envoyer</button>
    </form>
<?php
} else {
    echo "<p><strong>bonjour : " . htmlspecialchars($_SESSION['nom']) . " !</strong></p>";
    echo '<a href="supression_session.php">supression de session</a>';
}
?>
