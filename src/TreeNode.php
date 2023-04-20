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
            'parent' => $this->data['Parent'],
        ];
        if (!empty($this->children)) {
            $result['children'] = array_map(function ($child) {
                return $child->toArray();
            }, $this->children);
        }
        return $result;
    }
}
