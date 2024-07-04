<?php

namespace App\Http\Requests;

interface CreateRequest
{
    public function getDataToCreate(): array;
}
