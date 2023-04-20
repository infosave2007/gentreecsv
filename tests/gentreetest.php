<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Gentree\Gentree;
use Gentree\TreeNode;
use Gentree\CsvReader;

// Проверка аргументов командной строки
if ($argc != 3) {
    echo "Использование: php gentreetest.php <input.csv> <output.json>\n";
    exit(1);
}

$inputFile = $argv[1];
$outputFile = $argv[2];

// Чтение данных из CSV файла
$csvReader = new CsvReader($inputFile);
$csvData = $csvReader->read();
$treeNodes = [];
foreach ($csvData as $row) {
    if (is_array($row) && count($row) === 4) {
        $treeNode = new TreeNode($row);
        $treeNodes[] = $treeNode;
    } else {
        echo "Ошибка: неправильный формат данных CSV.\n";
        exit(1);
    }
}
//print_r($treeNodes);
// Создание структуры дерева на основе объектов TreeNode

$treeRootNodes = TreeNode::buildTree($treeNodes);

// Преобразование дерева в массив
$treeArray = [];
foreach ($treeRootNodes as $node) {
    $treeArray[] = $node->toArray();
}

// Конвертирование массива в JSON
$jsonOutput = json_encode($treeArray, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Сравнение результата с эталонным JSON-файлом
$expectedJson = file_get_contents(__DIR__ . '/sample.json');
if ($jsonOutput === $expectedJson) {
    echo "Тест успешно пройден.\n";
} else {
    echo "Тест не пройден. Результаты не совпадают.\n";
}

// Запись JSON в выходной файл
file_put_contents($outputFile, $jsonOutput);

echo "JSON успешно сохранен в файле {$outputFile}\n";
?>
