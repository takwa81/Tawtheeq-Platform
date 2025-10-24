<?php

namespace App\Repositories;

use App\Interfaces\AttributeKeyOptionsRepositoryInterface;
use App\Models\AttributeKey;
use App\Models\AttributeKeyOption;

class AttributeKeyOptionsRepository implements AttributeKeyOptionsRepositoryInterface
{
    public function createAttributeKeyOptions(AttributeKey $attributeKey , array $data): void
    {
        $options = $attributeKey->options()->createMany(
            collect($data)->map(fn($value) => ['value' => $value])->toArray()
        );
        
    }
    // public function updateAttributeKeyOptions(int $id, array $data): AttributeKeyOption
    // {
    //     $attributeKey = AttributeKey::findOrFail($id);
    //     $attributeKey->update($data);
    //     return $attributeKey;
    // }


}