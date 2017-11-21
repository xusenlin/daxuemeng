<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function success($data=null)
    {
        return ['ok'=>true, 'data' => $data];
    }

    protected function error($errorMsg, $errorCode=null)
    {
        return ['ok'=>false, 'errorMsg'=>$errorMsg, 'errorCode'=>$errorCode];
    }

    protected function get_exception_error(ValidationException $e) {
        $response = $e->getResponse();
        $errorContent = json_decode($response->getContent(), true);
        $errors = array();
        foreach ($errorContent as $errorMsgs) {
            foreach ($errorMsgs as $msg) $errors[] = $msg;
        }
        return $errors;
    }

    protected function format_exception_error(ValidationException $e, $split="<br>") {
        $errors = $this->get_exception_error($e);
        $errors = $errors ? implode($split, $errors) : "";
        return $errors;
    }
}
