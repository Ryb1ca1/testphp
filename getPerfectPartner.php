<?php
require_once 'functions.php';

function getPerfectPartner($surname, $name, $patronomyc, $persons_array) {
    // Приведение фамилии, имени и отчества к нормальному регистру
    $surname = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE);
    $name = mb_convert_case($name, MB_CASE_TITLE_SIMPLE);
    $patronomyc = mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE);

    // Составление полного имени
    $fullname = getFullnameFromParts($surname, $name, $patronomyc);

    // Определение пола для полного имени
    $gender = getGenderFromName($fullname);

    // Исключаем неопределенные полы
    if ($gender === 0) {
        return "Невозможно определить пол для $fullname.";
    }

    do {
        // Случайный выбор партнера из массива
        $partner = $persons_array[array_rand($persons_array)];
        $partnerGender = getGenderFromName($partner['fullname']);
    } while ($gender === $partnerGender || $partnerGender === 0);

    // Составление сокращенных имен
    $shortName1 = getShortName($fullname);
    $shortName2 = getShortName($partner['fullname']);

    // Случайный процент совместимости от 50% до 100%
    $compatibility = round(rand(5000, 10000) / 100, 2);

    return "$shortName1 + $shortName2 = ♡ Идеально на $compatibility% ♡";
}
?>
