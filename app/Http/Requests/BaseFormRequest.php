<?php


namespace App\Http\Requests;


use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ResoultType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BaseFormRequest extends FormRequest
{

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();//validasyon hatalarına ek kolonlar eklemek için
        throw new HttpResponseException(
            (new ApiController)->apiResponse(ResoultType::Error, $errors, 'Validation Error', JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}