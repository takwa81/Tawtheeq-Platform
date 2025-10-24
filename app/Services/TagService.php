<?php

namespace App\Services;

use App\Interfaces\TagRepositoryInterface;

class TagService
{
    protected TagRepositoryInterface $tagRepo;

    public function __construct(TagRepositoryInterface $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }
    public function createTag(array $data)
    {
        return $this->tagRepo->createTag($data);
    }

}
