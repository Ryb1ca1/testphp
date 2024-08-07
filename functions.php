<?php

function getFullnameFromParts($surname, $name, $patronomyc) {
    return "$surname $name $patronomyc";
}

function getPartsFromFullname($fullname) {
    $parts = explode(' ', $fullname);
    return ['surname' => $parts[0], 'name' => $parts[1], 'patronomyc' => $parts[2]];
}

function getShortName($fullname) {
    $parts = getPartsFromFullname($fullname);
    return $parts['name'] . ' ' . mb_substr($parts['surname'], 0, 1) . '.';
}

function getGenderFromName($fullname) {
    $parts = getPartsFromFullname($fullname);
    $genderScore = 0;

    if (mb_substr($parts['patronomyc'], -3) == 'вна') $genderScore--;
    if (mb_substr($parts['patronomyc'], -2) == 'ич') $genderScore++;
    if (mb_substr($parts['name'], -1) == 'а') $genderScore--;
    if (mb_substr($parts['name'], -1) == 'й' || mb_substr($parts['name'], -1) == 'н') $genderScore++;
    if (mb_substr($parts['surname'], -2) == 'ва') $genderScore--;
    if (mb_substr($parts['surname'], -1) == 'в') $genderScore++;

    return $genderScore > 0 ? 1 : ($genderScore < 0 ? -1 : 0);
}

function getGenderDescription($persons_array) {
    $total = count($persons_array);
    $maleCount = count(array_filter($persons_array, fn($person) => getGenderFromName($person['fullname']) === 1));
    $femaleCount = count(array_filter($persons_array, fn($person) => getGenderFromName($person['fullname']) === -1));
    $undefinedCount = $total - $maleCount - $femaleCount;

    $malePercent = round($maleCount / $total * 100, 1);
    $femalePercent = round($femaleCount / $total * 100, 1);
    $undefinedPercent = round($undefinedCount / $total * 100, 1);

    return "Гендерный состав аудитории:\n---------------------------\nМужчины - $malePercent%\nЖенщины - $femalePercent%\nНе удалось определить - $undefinedPercent%";
}
?>
