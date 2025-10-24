<?php

namespace App\Interfaces;

use App\Models\AttributeKey;

interface AttributeKeyRepositoryInterface
{
    public function createAttributeKey(array $data): AttributeKey;
    public function updateAttributeKey(int $id,array $data): AttributeKey;
    public function getAllAttributeKeys($user);
    public function getAttributeKey($id);
}