<?php

namespace App\Core\Application\Service\Pagination;

class PaginationRequest
{
    private int $page;
    private int $per_page;
    private ?string $sort;
    private ?bool $desc;
    private ?string $search;
    private ?array $filter;
    private ?string $start_date;
    private ?string $end_date;

    public function __construct(int $page, int $per_page, ?string $sort, ?bool $desc, ?string $search, ?array $filter, ?string $start_date, ?string $end_date)
    {
        $this->page = $page;
        $this->per_page = $per_page;
        $this->sort = $sort;
        $this->desc = $desc;
        $this->search = $search;
        $this->filter = $filter;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->per_page;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function getDesc(): ?bool
    {
        return $this->desc;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function getFilter(): ?array
    {
        return $this->filter;
    }

    public function getStartDate(): ?string
    {
        return $this->start_date;
    }

    public function getEndDate(): ?string
    {
        return $this->end_date;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function setPerPage(int $per_page): void
    {
        $this->per_page = $per_page;
    }
}