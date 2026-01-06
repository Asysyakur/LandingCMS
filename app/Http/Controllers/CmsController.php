<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Component;
use App\Models\PageComponent;
use App\Models\PageVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    /**
     * Get all pages for the authenticated user
     */
    public function getPages(Request $request)
    {
        $pages = Page::where('created_by', $request->user()->id)
            ->with(['pageComponents.component', 'pageVersions'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $pages
        ]);
    }

    /**
     * Get single page with components
     */
    public function getPage(Request $request, $id)
    {
        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $id)
            ->with(['pageComponents' => function($query) {
                $query->orderBy('order_index')->with('component');
            }])
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'data' => $page
        ]);
    }

    /**
     * Create new page
     */
    public function createPage(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'business_profile' => 'nullable|array',
            'metadata' => 'nullable|array'
        ]);

        $page = Page::create([
            'id' => Str::uuid(),
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? Str::slug($validated['title']),
            'status' => 'draft',
            'created_by' => $request->user()->id,
            'business_profile' => $validated['business_profile'] ?? [],
            'metadata' => $validated['metadata'] ?? []
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Page created successfully',
            'data' => $page
        ], 201);
    }

    /**
     * Update page
     */
    public function updatePage(Request $request, $id)
    {
        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'business_profile' => 'nullable|array',
            'metadata' => 'nullable|array'
        ]);

        // Create version before updating
        $this->createPageVersion($page, 'Auto-save before update');

        $page->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? Str::slug($validated['title']),
            'status' => $validated['status'],
            'business_profile' => $validated['business_profile'] ?? $page->business_profile,
            'metadata' => $validated['metadata'] ?? $page->metadata
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Page updated successfully',
            'data' => $page
        ]);
    }

    /**
     * Delete page
     */
    public function deletePage(Request $request, $id)
    {
        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $page->delete();

        return response()->json([
            'status' => true,
            'message' => 'Page deleted successfully'
        ]);
    }

    /**
     * Get all available components
     */
    public function getComponents()
    {
        $components = Component::orderBy('name')->get();

        return response()->json([
            'status' => true,
            'data' => $components
        ]);
    }

    /**
     * Add component to page
     */
    public function addPageComponent(Request $request, $pageId)
    {
        $validated = $request->validate([
            'component_id' => 'required|uuid|exists:components,id',
            'content' => 'nullable|array',
            'order_index' => 'required|integer|min:0'
        ]);

        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $pageId)
            ->firstOrFail();

        // Create version before adding component
        $this->createPageVersion($page, 'Added component: ' . $validated['component_id']);

        $pageComponent = PageComponent::create([
            'id' => Str::uuid(),
            'page_id' => $pageId,
            'component_id' => $validated['component_id'],
            'order_index' => $validated['order_index'],
            'content' => $validated['content'] ?? [],
            'is_active' => true
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Component added successfully',
            'data' => $pageComponent->load('component')
        ], 201);
    }

    /**
     * Update page component
     */
    public function updatePageComponent(Request $request, $pageId, $componentId)
    {
        $validated = $request->validate([
            'content' => 'nullable|array',
            'order_index' => 'required|integer|min:0',
            'is_active' => 'required|boolean'
        ]);

        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $pageId)
            ->firstOrFail();

        $pageComponent = PageComponent::where('page_id', $pageId)
            ->where('id', $componentId)
            ->firstOrFail();

        // Create version before updating
        $this->createPageVersion($page, 'Updated component: ' . $componentId);

        $pageComponent->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Component updated successfully',
            'data' => $pageComponent->load('component')
        ]);
    }

    /**
     * Remove component from page
     */
    public function removePageComponent(Request $request, $pageId, $componentId)
    {
        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $pageId)
            ->firstOrFail();

        $pageComponent = PageComponent::where('page_id', $pageId)
            ->where('id', $componentId)
            ->firstOrFail();

        // Create version before removing
        $this->createPageVersion($page, 'Removed component: ' . $componentId);

        $pageComponent->delete();

        return response()->json([
            'status' => true,
            'message' => 'Component removed successfully'
        ]);
    }

    /**
     * Get page versions
     */
    public function getPageVersions(Request $request, $pageId)
    {
        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $pageId)
            ->firstOrFail();

        $versions = $page->pageVersions()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $versions
        ]);
    }

    /**
     * Restore page version
     */
    public function restorePageVersion(Request $request, $pageId, $versionId)
    {
        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $pageId)
            ->firstOrFail();

        $version = $page->pageVersions()->where('id', $versionId)->firstOrFail();

        // Create backup version before restoring
        $this->createPageVersion($page, 'Pre-restore backup');

        // Restore from version
        $snapshot = $version->data_snapshot;
        
        if (isset($snapshot['page_settings'])) {
            $page->update($snapshot['page_settings']);
        }

        // Restore components if exists
        if (isset($snapshot['components'])) {
            // Delete existing components
            $page->pageComponents()->delete();
            
            // Recreate components from snapshot
            foreach ($snapshot['components'] as $compData) {
                PageComponent::create([
                    'id' => Str::uuid(),
                    'page_id' => $pageId,
                    'component_id' => $compData['id'],
                    'order_index' => $compData['order'],
                    'content' => $compData['fields'],
                    'is_active' => $compData['is_active'] ?? true
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Page restored from version successfully',
            'data' => $page->load('pageComponents.component')
        ]);
    }

    /**
     * Helper: Create page version
     */
    private function createPageVersion(Page $page, string $description)
    {
        $snapshot = [
            'page_settings' => [
                'title' => $page->title,
                'slug' => $page->slug,
                'status' => $page->status,
                'business_profile' => $page->business_profile,
                'metadata' => $page->metadata
            ],
            'components' => $page->pageComponents()
                ->with('component')
                ->get()
                ->map(function ($pc) {
                    return [
                        'id' => $pc->component_id,
                        'type' => $pc->component->slug,
                        'order' => $pc->order_index,
                        'fields' => $pc->content,
                        'is_active' => $pc->is_active
                    ];
                })->toArray()
        ];

        return PageVersion::create([
            'id' => Str::uuid(),
            'page_id' => $page->id,
            'version_name' => 'v' . ($page->pageVersions()->count() + 1),
            'version_description' => $description,
            'data_snapshot' => $snapshot
        ]);
    }
}
