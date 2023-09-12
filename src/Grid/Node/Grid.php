<?php

namespace FileToObject\Grid\Node;

class Grid
{
    private string $name;

    /** @var QueryPart[] */
    private array $query;

    public function getQuery(): array
    {
        return $this->query;
    }

    public function setQuery(array $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
