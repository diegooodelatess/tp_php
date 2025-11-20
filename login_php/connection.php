<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nom'])) {
        $_SESSION['nom'] = $_POST['nom'];
    }
}

if (!isset($_SESSION['nom'])) {
    ?>
    <form method="post">
        <label for="nom">nom :</label>
        <input type="text" name="nom" id="nom">
        <button type="submit">Envoyer</button>
    </form>
    <?php
} else {
    echo "<p><strong>Votre nom est :" .($_SESSION['nom']) ."<strong></p>";
    echo '<a href = "déconnection.php"> changer de nom</a>';
}
?>