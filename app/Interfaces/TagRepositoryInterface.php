<?php

namespace App\Interfaces;

use App\Models\Tag;

interface TagRepositoryInterface
{
    public function createTag(array $data): Tag;

}
