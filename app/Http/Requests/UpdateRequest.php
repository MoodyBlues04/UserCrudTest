<?php

namespace App\Http\Requests;

interface UpdateRequest
{
    public function getDataToUpdate(): array;
}
