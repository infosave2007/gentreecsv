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
print_r($csvData);
// Создание объектов TreeNode из данных CSV
$treeNodes = [];
foreach ($csvData as $row) {
    if (isset($row[0], $row[1], $row[2], $row[3])) {
        $treeNode = new TreeNode([
            'Item Name' => $row[0],
            'Type' => $row[1],
            'Parent' => $row[2],
            'Relation' => $row[3]
        ]);
        $treeNodes[] = $treeNode;
    } else {
        echo "Ошибка: неправильный формат данных CSV.\n";
        exit(1);
    }
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
