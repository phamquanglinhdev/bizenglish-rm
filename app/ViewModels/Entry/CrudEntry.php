<?php

namespace App\ViewModels\Entry;

class CrudEntry
{
    private array $fields;
    private string $label;
    private string $entity;
    private ?string $currentId;

    public function __construct($entity, $currentId = null, $label = null,)
    {
        $this->fields = [];
        $this->entity = $entity;
        $this->label = $label ?? $entity;
        $this->currentId = $currentId ?? null;
    }

    public function addField($filed, $pos = null): void
    {
        $this->fields[] = $filed;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @return string|null
     */
    public function getCurrentId(): ?string
    {
        return $this->currentId??null;
    }


}
