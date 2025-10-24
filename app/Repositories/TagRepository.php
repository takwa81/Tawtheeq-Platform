<?php

namespace App\Repositories;

use App\Interfaces\TagRepositoryInterface;

use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    public function createTag(array $data): Tag
    {
        return Tag::create($data);
    }

}
