<?php

namespace FileToObject\Grid\Node;

class QueryPart
{
    private ?string $select;
    private ?string $from;
    private ?string $join;
    private ?string $leftJoin;
    private ?string $with;
    private ?string $addOrderBy;

    public function getSelect(): ?string
    {
        return $this->select;
    }

    public function setSelect(?string $select): self
    {
        $this->select = $select;

        return $this;
    }

    public function getFrom(): ?string
    {
        return $this->from;
    }

    public function setFrom(?string $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getJoin(): ?string
    {
        return $this->join;
    }

    public function setJoin(?string $join): self
    {
        $this->join = $join;

        return $this;
    }

    public function getLeftJoin(): ?string
    {
        return $this->leftJoin;
    }

    public function setLeftJoin(?string $leftJoin): self
    {
        $this->leftJoin = $leftJoin;

        return $this;
    }

    public function getWith(): ?string
    {
        return $this->with;
    }

    public function setWith(?string $with): self
    {
        $this->with = $with;

        return $this;
    }

    public function getAddOrderBy(): ?string
    {
        return $this->addOrderBy;
    }

    public function setAddOrderBy(?string $addOrderBy): self
    {
        $this->addOrderBy = $addOrderBy;

        return $this;
    }
}
