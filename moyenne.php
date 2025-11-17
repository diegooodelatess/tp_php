<?php
$tab = [2,3,6,2,8];
function moyenne($tab) {
    $moy = array_sum($tab) / count($tab);
    return $moy;

}

echo(moyenne($tab));

?>