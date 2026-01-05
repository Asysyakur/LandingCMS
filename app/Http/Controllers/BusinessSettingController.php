<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\UploadsFiles;

class BusinessSettingController extends Controller
{
    use UploadsFiles;

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

    public function update(Request $request, Page $page): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'tagline' => 'nullable|string',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:1024',
            'location' => 'nullable|string',
        ]);

        $fileMap = [
            'logo' => 'logos',
            'favicon' => 'favicons'
        ];

        foreach($fileMap as $field => $folderName){
            if($request->hasFile($field)){
                $path = $this->uploadFile($request->file($field), $folderName);

                $validated[$field . '_url'] = $path;
            }
        }

        $page->update([
            'business_profile' => array_merge(
                $page->business_profile ?? [],
                $validated ?? []
            ),
        ]);


        return response()->json([
            'status' => true,
            'message' => 'Business setting updated',
            'data' => $page
        ]);
    }

    public function destroy(Page $page): JsonResponse
    {
        $page->update([
            'business_profile' => null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Business setting deleted'
        ]);
    }
}