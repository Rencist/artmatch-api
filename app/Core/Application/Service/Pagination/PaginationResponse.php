<?php

namespace App\Core\Application\Service\Pagination;

use JsonSerializable;

class PaginationResponse implements JsonSerializable
{
    private array $data_per_page;
    private array $meta;

    public function __construct(array $data_per_page, array $meta)
    {
        $this->data_per_page = $data_per_page;
        $this->meta = $meta;
    }

    public function jsonSerialize(): array
    {
        return[
            'data_per_page' => $this->data_per_page,
            'meta' => $this->meta
        ];
    }
}
