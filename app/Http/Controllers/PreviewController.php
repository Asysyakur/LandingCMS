<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageComponent;
use Illuminate\Http\Request;

class PreviewController extends Controller
{
    /**
     * Get preview data for a page
     */
    public function getPreview(Request $request, $pageId)
    {
        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $pageId)
            ->with(['pageComponents' => function($query) {
                $query->orderBy('order_index')
                      ->where('is_active', true)
                      ->with('component');
            }])
            ->firstOrFail();

        // Transform data for frontend consumption
        $previewData = [
            'page_id' => $page->id,
            'business' => $this->formatBusinessProfile($page->business_profile),
            'metadata' => $page->metadata,
            'sections' => $page->pageComponents->map(function ($pc) {
                return [
                    'id' => $pc->id,
                    'type' => $pc->component->slug,
                    'order' => $pc->order_index,
                    'is_active' => $pc->is_active,
                    'fields' => $pc->content
                ];
            })->toArray(),
            'last_saved_at' => $page->updated_at->toISOString()
        ];

        return response()->json([
            'status' => true,
            'data' => $previewData
        ]);
    }

    /**
     * Get public preview (no authentication required)
     */
    public function getPublicPreview($pageSlug)
    {
        $page = Page::where('slug', $pageSlug)
            ->where('status', 'published')
            ->with(['pageComponents' => function($query) {
                $query->orderBy('order_index')
                      ->where('is_active', true)
                      ->with('component');
            }])
            ->firstOrFail();

        $previewData = [
            'page_id' => $page->id,
            'business' => $this->formatBusinessProfile($page->business_profile),
            'metadata' => $page->metadata,
            'sections' => $page->pageComponents->map(function ($pc) {
                return [
                    'id' => $pc->id,
                    'type' => $pc->component->slug,
                    'order' => $pc->order_index,
                    'is_active' => $pc->is_active,
                    'fields' => $pc->content
                ];
            })->toArray(),
            'last_saved_at' => $page->updated_at->toISOString()
        ];

        return response()->json([
            'status' => true,
            'data' => $previewData
        ]);
    }

    /**
     * Get responsive preview HTML
     */
    public function getResponsivePreview(Request $request, $pageId)
    {
        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $pageId)
            ->with(['pageComponents' => function($query) {
                $query->orderBy('order_index')
                      ->where('is_active', true)
                      ->with('component');
            }])
            ->firstOrFail();

        $device = $request->get('device', 'desktop'); // desktop, tablet, mobile
        
        return view('cms.preview.responsive', [
            'page' => $page,
            'device' => $device,
            'businessProfile' => $this->formatBusinessProfile($page->business_profile),
            'sections' => $page->pageComponents
        ]);
    }

    /**
     * Get component schema for preview
     */
    public function getComponentSchema($componentSlug)
    {
        $component = \App\Models\Component::where('slug', $componentSlug)->firstOrFail();
        
        return response()->json([
            'status' => true,
            'data' => [
                'id' => $component->id,
                'name' => $component->name,
                'slug' => $component->slug,
                'schema' => $component->default_schema
            ]
        ]);
    }

    /**
     * Format business profile for frontend
     */
    private function formatBusinessProfile($businessProfile)
    {
        if (!$businessProfile) {
            return [
                'name' => '',
                'tagline' => '',
                'description' => '',
                'logo_url' => '',
                'favicon_url' => '',
                'location' => ''
            ];
        }

        return [
            'name' => $businessProfile['name'] ?? '',
            'tagline' => $businessProfile['tagline'] ?? '',
            'description' => $businessProfile['description'] ?? '',
            'logo_url' => $businessProfile['logo_url'] ?? '',
            'favicon_url' => $businessProfile['favicon_url'] ?? '',
            'location' => $businessProfile['location'] ?? ''
        ];
    }

    /**
     * Generate HTML for component preview
     */
    public function getComponentPreview(Request $request, $componentSlug)
    {
        $component = \App\Models\Component::where('slug', $componentSlug)->firstOrFail();
        $content = $request->get('content', []);
        
        // Generate preview HTML based on component type
        $html = $this->generateComponentHtml($componentSlug, $content);
        
        return response()->json([
            'status' => true,
            'data' => [
                'html' => $html,
                'component' => $component
            ]
        ]);
    }

    /**
     * Generate HTML for component based on type
     */
    private function generateComponentHtml($componentSlug, $content)
    {
        switch ($componentSlug) {
            case 'hero':
                return view('cms.components.preview.hero', $content)->render();
            case 'features':
                return view('cms.components.preview.features', $content)->render();
            case 'about':
                return view('cms.components.preview.about', $content)->render();
            case 'contact':
                return view('cms.components.preview.contact', $content)->render();
            default:
                return '<div class="p-4 border rounded">Component preview not available</div>';
        }
    }
}
