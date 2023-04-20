<?php

namespace Gentree;

class TreeNode
{
    private array $data; // Данные узла
    private array $children = []; // Массив для хранения дочерних узлов

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // Возвращает значение атрибута 'item name'
    public function getItemName(): string
    {
        return $this->data['Item Name'];
    }

    // Возвращает значение атрибута 'parent'
    public function getParent(): string
    {
        return $this->data['Parent'];
    }

    // Добавляет дочерний узел к текущему узлу
    public function addChild(TreeNode $child): void
    {
        $this->children[] = $child;
    }

    // Преобразует узел и его дочерние узлы в ассоциативный массив
    public function toArray(): array
    {
        $result = [
            'itemName' => $this->data['Item Name'],
            'parent' => empty($this->data['Parent']) ? null:$this->data['Parent'],
            'children' => [],
        ];
        if (!empty($this->children)) {
            $result['children'] = array_map(function ($child) {
                return $child->toArray();
            }, $this->children);
        }
        return $result;
    }
    public static function buildTree(array $nodes): array
{
    $tree = [];
    $nodesById = [];

    // Создание массива узлов с индексом по item name
    foreach ($nodes as $node) {
        $nodesById[$node->getItemName()] = $node;
    }

    // Добавление дочерних узлов к родительским узлам и формирование иерархии
    foreach ($nodes as $node) {
        $parentName = $node->getParent();
        if ($parentName != null) {
            if (isset($nodesById[$parentName])) {
                $nodesById[$parentName]->addChild($node);
            }
        } else {
            $tree[] = $node;
        }
    }

    return $tree;
}
}

