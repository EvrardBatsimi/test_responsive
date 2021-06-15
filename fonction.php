<?php
// Prend le résultat d'une requête en paramètre
function resultAsArray($res)
{
    $result = array(); // Déclaration d'un tableau vide
    while ($resultRow = mysqli_fetch_assoc($res)) { // Itération sur tous les résultats de la requête
        array_push($result, $resultRow);  // Push de chaque résultat dans le tableau déclaré plus tôt
    }
    return $result; // Retourne le tableau de résultat
}