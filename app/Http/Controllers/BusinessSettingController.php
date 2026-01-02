<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\JsonResponse;

class BusinessSettingController extends Controller
{
    public function show(Page $page): JsonResponse
    {
        $profile = $page->business_profile;

        if(!$profile){
            return response()->json([
                'status' => false,
                'message' => 'Business profile not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'user_id' => $page->created_by,
                'page_id' => $page->id,
                'business_info' => [
                    'business_name' => $profile['name'] ?? null,
                    'tagline'       => $profile['tagline'] ?? null,
                    'description'   => $profile['description'] ?? null,
                    'logo'          => $profile['logo_url'] ?? null,
                    'favicon'       => $profile['favicon_url'] ?? null,
                    'location'      => $profile['location'] ?? null,
                ],
            ]
        ]);
    }
}