<?php

namespace Gentree;

class Gentree
{
    private string $itemName;
    private ?string $parent;
    private string $type;
    private ?string $relation;
    private array $children = [];

    // Конструктор с 4 аргументами
    public function __construct(string $itemName, ?string $parent, string $type, ?string $relation)
    {
    $this->itemName = $itemName;
    $this->parent = empty($parent) ? null : $parent;
    $this->type = $type;
    $this->relation = empty($relation) ? null : $relation;
    }

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    // Исправленный метод addChild
    public function addChild(Gentree $child): void
    {
        $this->children[] = $child;
    }

    public function setChildren(array $children): void
    {
        $this->children = $children;
    }

    public function toArray(): array
    {
        $childrenArray = [];

        foreach ($this->children as $child) {
            $childrenArray[] = $child->toArray();
        }

        return [
            'itemName' => $this->itemName,
            'parent' =>  empty($this->parent) ? null : $this->parent,
            'children' => empty($childrenArray) ? [] : $childrenArray,
        ];
    }
}

