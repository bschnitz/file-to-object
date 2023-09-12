<?php

namespace FileToObject\Grid\Node;

use FileToObject\Attribute\Keyed;

class GridConfig
{
    /** @var array|array<string, Grid> */
    #[Keyed(class: Grid::class, key: 'name')]
    private ?array $grids;

    public function getGrids(): ?array
    {
        return $this->grids;
    }

    public function setGrids(?array $grids): self
    {
        $this->grids = $grids;

        return $this;
    }
}
