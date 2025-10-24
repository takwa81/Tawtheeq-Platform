<?php

namespace App\Interfaces;

use App\Models\AttributeKeyOption;
use App\Models\AttributeKey;

interface AttributeKeyOptionsRepositoryInterface
{
    public function createAttributeKeyOptions(AttributeKey $attributeKey ,array $data): void;
    // public function updateAttributeKeyOptions(int $id,array $data): AttributeKeyOption;
}