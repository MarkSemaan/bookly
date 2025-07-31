<?php

namespace App\Traits;

trait ResponseTrait
{
  static function responseJSON($payload, $status = "success", $status_code = 200)
     {
        return response()->json([
            "status" => $status,
             "payload" => $payload
        ], $status_code);
    }

    static function fail($errors, $status = "fail", $status_code = 400)
     {
        return response()->json([
            "status"   => $status,
            "payload"  => $errors
        ], $status_code);
    }

}
