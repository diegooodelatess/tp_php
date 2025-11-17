<?php
function my_str_contains($grandMot, $petitMot){
    $longueurGrand = strlen($grandMot);
    $longueurPetit = strlen($petitMot);


    if ($longueurPetit == 0) {
    return false;
    }
    else if ($petitMot == " ") {
    return true;
    }


    for ($i = 0; $i <= $longueurGrand - $longueurPetit; $i++) { //i pour les caracteres du grand mot
        $mot_trouve = true;

        for ($j = 0; $j < $longueurPetit; $j++) { //j pour les caracteres du petit mot
            if ($grandMot[$i + $j] != $petitMot[$j]) { // // Vérifie si la lettre du grand mot est différente de celle du petit mot
                $mot_trouve = false;
                break; //on sort apres de la boucle
            }
        }

        if ($mot_trouve) {
            return true;
        }
    }

    return false;
}

var_dump(my_str_contains("bonjour le monde", "le"));
var_dump(my_str_contains("bonjour le monde", "mon"));
var_dump(my_str_contains("bonjour le monde", "salut"));
var_dump(my_str_contains("bonjour le monde",""));
var_dump(my_str_contains("bonjour le monde"," "));
?>
