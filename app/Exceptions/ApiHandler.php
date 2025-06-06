<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ApiHandler
{
    public static function handleValidation(ValidationException $e, Request $request)
    {
        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        }
    }
}
