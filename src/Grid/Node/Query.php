<?php

namespace FileToObject\Grid\Node;

class Query
{
    /** @var QueryPart[] */
    private array $parts;

    public function getParts(): array
    {
        return $this->parts;
    }

    public function setParts(array $parts): self
    {
        $this->parts = $parts;

        return $this;
    }
}
