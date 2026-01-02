<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            "status" => true,
            "data" => [
                "id" => 1,
                "name" => "John Doe",
                "email" => "john@example.com",
                "business" => [
                    "id" => 1,
                    "name" => "My Business",
                    "slug" => "my-business",
                    "is_published" => false
                ]
            ]
        ]);
    }
}
