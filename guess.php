<?php
require_once __DIR__ . '/functions.php';

$min = 1;
$max = 100;

if (isset($_GET['reset'])) {
    reset_game();
    header('Location: guess.php');
    exit;
}

init_secret($min, $max);
$message = '';
$termine = $_SESSION['termine'] ?? false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$termine) {
    $proposition = intval($_POST['guess']);
    $resultat = check_guess($proposition);

    $message = $resultat['message'];
    if (in_array($resultat['etat'], ['correct', 'fin', 'termine'])) {
        $termine = true;
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Jeu du nombre mystère</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin-top: 50px;
    }

    input,
    button {
        padding: 10px;
        font-size: 16px;
    }

    a {
        display: block;
        margin-top: 15px;
        color: blue;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <h2>Devinez le nombre entre <?php echo $min; ?> et <?php echo $max; ?></h2>

    <?php if (!$termine): ?>
    <form method="post">
        <input type="number" name="guess" required min="<?php echo $min; ?>" max="<?php echo $max; ?>">
        <button type="submit">Proposer</button>
    </form>
    <?php endif; ?>

    <p><?php echo $message; ?></p>
    <a href="?reset=1">Recommencer le jeu</a>
</body>

</html>