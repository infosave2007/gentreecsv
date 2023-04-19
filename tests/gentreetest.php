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

// Создание объектов TreeNode из данных CSV
$treeNodes = [];
foreach ($csvData as $row) {
    $treeNode = new TreeNode($row[0], $row[1], $row[2], $row[3]);
    $treeNodes[] = $treeNode;
}

// Создание структуры дерева на основе объектов TreeNode
$treeBuilder = new TreeBuilder($treeNodes);
$tree = $treeBuilder->buildTree();

// Преобразование дерева в массив
$treeArray = [];
foreach ($tree as $node) {
    $treeArray[] = $node->toArray();
}

// Конвертирование массива в JSON
$jsonOutput = json_encode($treeArray, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Сравнение результата с эталонным JSON-файлом
$expectedJson = file_get_contents(__DIR__ . '/output.json');
if ($jsonOutput === $expectedJson) {
    echo "Тест успешно пройден.\n";
} else {
    echo "Тест не пройден. Результаты не совпадают.\n";
}

// Запись JSON в выходной файл
file_put_contents($outputFile, $jsonOutput);

echo "JSON успешно сохранен в файле {$outputFile}\n";
?>
