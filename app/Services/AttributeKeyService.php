<?php

namespace App\Services;

use App\Repositories\AttributeKeyOptionsRepository;
use App\Repositories\AttributeKeyRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class AttributeKeyService
{
    protected AttributeKeyRepository $attributeKeyRepo;
    protected AttributeKeyOptionsRepository $attributeKeyOptionRepo;

    public function __construct(AttributeKeyRepository $attributeKeyRepo , AttributeKeyOptionsRepository $attributeKeyOptionRepo)
    {
        $this->attributeKeyRepo = $attributeKeyRepo;
        $this->attributeKeyOptionRepo = $attributeKeyOptionRepo;
    }

    public function getAttributeKeys($user){
        return $this->attributeKeyRepo->getAllAttributeKeys($user);
    }

    public function getAttributeKey ($id){
        return $this->attributeKeyRepo->getAttributeKey($id);
    }

    public function createAttributeKey(array $data)
    {
        try{
        DB::beginTransaction();
        $data['data_type'] === "Select" ? $data['has_predefined_options'] = true : $data['has_predefined_options'] = false;
        $attributeKey = $this->attributeKeyRepo->createAttributeKey(['key_name' => $data['key_name'],
        'data_type' => $data['data_type'],
        'has_predefined_options' => $data['has_predefined_options'],
        'creator_user_type' => $data['creator_user_type'],
        'creator_user_id' => $data['creator_user_id']
    ]);
    //add options
    if (!empty($data['attribute_key_options']) && $data['data_type'] === 'Select') {
    $this->attributeKeyOptionRepo->createAttributeKeyOptions($attributeKey, $data['attribute_key_options']);
    $attributeKey->load('options');
    }
        
        DB::commit();
        return $attributeKey;
        }catch(Exception $e){
                DB::rollback();
                throw $e;
            }
    }

    public function deleteAttributeKey($id){
        $this->attributeKeyRepo->deleteAttributeKey($id);
    }

    public function updateAttributeKey(int $id, array $data)
    {
        try{
        DB::beginTransaction();
        $data['data_type'] === "Select" ? $data['has_predefined_options'] = true : $data['has_predefined_options'] = false;
        $attributeKey = $this->attributeKeyRepo->updateAttributeKey($id , ['key_name' => $data['key_name'],
        'data_type' => $data['data_type'],
        'has_predefined_options' => $data['has_predefined_options'],
    ]);
    //update options
    $attributeKey->options()->delete();
    if (!empty($data['attribute_key_options']) && $data['data_type'] === 'Select') {
        $this->attributeKeyOptionRepo->createAttributeKeyOptions($attributeKey, $data['attribute_key_options']);
         $attributeKey->load('options');
        }
       
        DB::commit();
        return $attributeKey;
        }catch(Exception $e){
                DB::rollback();
                throw $e;
            }
    }

 
}
