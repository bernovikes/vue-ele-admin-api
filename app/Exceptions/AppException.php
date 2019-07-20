<?php

namespace App\Exceptions;

use App\Http\Classes\Code;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppException extends Exception
{
    //
    public function render()
    {
        $response = response()->json(['code' => Code::ERROR, 'msg' => $this->getMessage()]);
        throw (new HttpResponseException($response));
    }
}
