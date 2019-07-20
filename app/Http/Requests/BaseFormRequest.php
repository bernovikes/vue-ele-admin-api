<?php


namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
//        $error = (new ValidationException($validator))
//            ->errorBag($this->errorBag);
        $error = $validator->errors()->all();
        $response = response()->json(['code' => 500,'result'=>'', 'msg' => $error[0]]);
        throw (new HttpResponseException($response));
    }
}
