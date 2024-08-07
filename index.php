<?php
require_once 'persons_array.php';
require_once 'functions.php';
require_once 'getPerfectPartner.php';

// Вывод всех ФИО, их частей и сокращенных имен
foreach ($example_persons_array as $person) {
    $fullname = $person['fullname'];
    echo "Полное имя: $fullname" . PHP_EOL;
    
    $parts = getPartsFromFullname($fullname);
    echo "Фамилия: " . $parts['surname'] . PHP_EOL;
    echo "Имя: " . $parts['name'] . PHP_EOL;
    echo "Отчество: " . $parts['patronomyc'] . PHP_EOL;
    
    $shortName = getShortName($fullname);
    echo "Сокращенное имя: $shortName" . PHP_EOL;
    
    $gender = getGenderFromName($fullname);
    $genderText = $gender === 1 ? 'Мужской' : ($gender === -1 ? 'Женский' : 'Неопределенный');
    echo "Пол: $genderText" . PHP_EOL;
    
    echo str_repeat('-', 20) . PHP_EOL;
}

// Вывод гендерного состава
echo getGenderDescription($example_persons_array) . PHP_EOL;

// Пример использования функции для подбора идеальной пары
$randomPerson = $example_persons_array[array_rand($example_persons_array)];
$parts = getPartsFromFullname($randomPerson['fullname']);
echo getPerfectPartner($parts['surname'], $parts['name'], $parts['patronomyc'], $example_persons_array) . PHP_EOL;
?>
