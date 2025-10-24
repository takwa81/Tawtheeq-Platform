<?php

namespace App\Repositories;

use App\Interfaces\AttributeKeyRepositoryInterface;
use App\Models\AttributeKey;
use App\Models\AttributeKeyOption;

class AttributeKeyRepository implements AttributeKeyRepositoryInterface
{
    public function createAttributeKey(array $data): AttributeKey
    {

        return AttributeKey::create($data);
    }
    public function updateAttributeKey(int $id, array $data): AttributeKey
    {
        $attributeKey = AttributeKey::findOrFail($id);
        $attributeKey->update($data);
        return $attributeKey;
    }
    public function getAllAttributeKeys($user){
        return $user->dataEntry->attributeKeys()->with('options')->get();
    }

    public function getAttributeKey($id){
        return AttributeKey::findOrFail($id);
    }

    public function deleteAttributeKey($id){
        $attributeKey = AttributeKey::findOrFail($id);
        $attributeKey->delete();
    }

}