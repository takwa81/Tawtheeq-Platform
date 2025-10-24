<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidationTrait
{
    use ResultTrait; 

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();

        throw new HttpResponseException(
            $this->errorResponse(
                __('messages.validation_failed'), 
                $errors,
                422
            )
        );
    }
}
