<?php
function mb_strrev($str){
    $r = '';
    for ($i = mb_strlen($str); $i>=0; $i--) { // on prend tout la longueur et on fais -1 a chaque fois pour l'indice
        $r .= mb_substr($str, $i, 1); // on créer la chaine en commencant a $i et uniqument le résultat final
        // (si on enleve 1 toute les étapes sont écrites lorqu'on lancent le programme)
    }
    return $r;
}

echo mb_strrev("salut tout le monde !");
?>
