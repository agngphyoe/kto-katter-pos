<?php

namespace App\Actions;

class HandlePagination
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function pagination()
    {

        return [
            'links' => $this->data->links('layouts.paginator')->toHtml(),
            'total' => $this->data->total(),
            'per_page' => $this->data->perPage(),
            'current_page' => $this->data->currentPage(),
            'last_page' => $this->data->lastPage(),
            'has_more_pages' => $this->data->hasMorePages(),
            'records_per_page' => count($this->data)
        ];
    }
}
