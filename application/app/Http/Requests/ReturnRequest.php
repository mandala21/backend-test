<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnResponse
{
    const statusOk = 'success';
    const statusFail = 'fail';
    const codeOk = 200;
    const codeFail = 400;
    
    public $status;
    public $messages = [];
    public $result = [];

}
