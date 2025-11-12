<?php
session_start();


function init_secret($min = 1, $max = 100) {
    if (!isset($_SESSION['secret'])) {
        $_SESSION['secret'] = rand($min, $max);
        $_SESSION['tentatives'] = 0;
        $_SESSION['termine'] = false; 
    }
}


function reset_game() {
    unset($_SESSION['secret']);
    unset($_SESSION['tentatives']);
    unset($_SESSION['termine']);
}


function check_guess($proposition) {
    if (!isset($_SESSION['secret'])) {
        return ['etat' => 'erreur', 'message' => 'Le jeu n\'a pas encore commencé.'];
    }

    
    if ($_SESSION['termine']) {
        return ['etat' => 'termine', 'message' => "La partie est terminée ! Le nombre correct était {$_SESSION['secret']}."];
    }

    $_SESSION['tentatives']++;
    $secret = $_SESSION['secret'];

    if ($proposition == $secret) {
        $_SESSION['termine'] = true;
        return ['etat' => 'correct', 'message' => "🎉 Bravo ! Vous avez trouvé le nombre en {$_SESSION['tentatives']} tentative(s)."];
    } elseif ($_SESSION['tentatives'] >= 3) { 
        $_SESSION['termine'] = true;
        return ['etat' => 'fin', 'message' => "Vous avez épuisé vos 3 tentatives ! Le nombre correct était {$secret}."];
    } elseif ($proposition < $secret) {
        return ['etat' => 'bas', 'message' => '⬆ Le nombre est plus grand !'];
    } else {
        return ['etat' => 'haut', 'message' => '⬇ Le nombre est plus petit !'];
    }
}


function tentatives() {
    return $_SESSION['tentatives'] ?? 0;
}
?>
