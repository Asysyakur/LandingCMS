<?php

namespace App\Services;

use App\Models\Page;
use App\Models\PageVersion;
use App\Models\PageComponent;
use Illuminate\Support\Facades\DB;
use Exception;

class ContentVersioningService
{
    /**
     * Create a new version of page content
     *
     * @param Page $page
     * @param string $versionName
     * @param string $description
     * @return PageVersion
     */
    public function createVersion(Page $page, string $versionName, string $description = ''): PageVersion
    {
        // Generate complete snapshot
        $snapshot = $this->generateSnapshot($page);
        
        // Create version record
        return PageVersion::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'page_id' => $page->id,
            'version_name' => $versionName,
            'version_description' => $description,
            'data_snapshot' => $snapshot
        ]);
    }
    
    /**
     * Auto-save version (for automatic backups)
     *
     * @param Page $page
     * @param string $reason
     * @return PageVersion
     */
    public function autoSave(Page $page, string $reason = 'Auto-save'): PageVersion
    {
        $versionName = 'v' . ($page->pageVersions()->count() + 1) . ' (auto)';
        return $this->createVersion($page, $versionName, $reason);
    }
    
    /**
     * Restore page to specific version
     *
     * @param Page $page
     * @param PageVersion $version
     * @return array
     */
    public function restoreVersion(Page $page, PageVersion $version): array
    {
        try {
            DB::beginTransaction();
            
            // Create backup version before restoring
            $this->autoSave($page, 'Pre-restore backup');
            
            $snapshot = $version->data_snapshot;
            
            // Restore page settings
            if (isset($snapshot['page_settings'])) {
                $page->update($snapshot['page_settings']);
            }
            
            // Restore components
            if (isset($snapshot['components'])) {
                $this->restoreComponents($page->id, $snapshot['components']);
            }
            
            DB::commit();
            
            return [
                'success' => true,
                'message' => 'Page restored successfully',
                'restored_version' => $version->version_name
            ];
            
        } catch (Exception $e) {
            DB::rollBack();
            
            return [
                'success' => false,
                'message' => 'Failed to restore page: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Compare two versions
     *
     * @param PageVersion $version1
     * @param PageVersion $version2
     * @return array
     */
    public function compareVersions(PageVersion $version1, PageVersion $version2): array
    {
        $snapshot1 = $version1->data_snapshot;
        $snapshot2 = $version2->data_snapshot;
        
        $differences = [
            'page_settings' => $this->compareArrays(
                $snapshot1['page_settings'] ?? [],
                $snapshot2['page_settings'] ?? []
            ),
            'components' => $this->compareComponents(
                $snapshot1['components'] ?? [],
                $snapshot2['components'] ?? []
            )
        ];
        
        return [
            'version1' => [
                'id' => $version1->id,
                'name' => $version1->version_name,
                'created_at' => $version1->created_at
            ],
            'version2' => [
                'id' => $version2->id,
                'name' => $version2->version_name,
                'created_at' => $version2->created_at
            ],
            'differences' => $differences
        ];
    }
    
    /**
     * Get version history with statistics
     *
     * @param Page $page
     * @return array
     */
    public function getVersionHistory(Page $page): array
    {
        $versions = $page->pageVersions()
            ->orderBy('created_at', 'desc')
            ->get();
        
        $history = [];
        
        foreach ($versions as $version) {
            $snapshot = $version->data_snapshot;
            
            $history[] = [
                'id' => $version->id,
                'name' => $version->version_name,
                'description' => $version->version_description,
                'created_at' => $version->created_at,
                'statistics' => [
                    'components_count' => count($snapshot['components'] ?? []),
                    'has_business_profile' => !empty($snapshot['page_settings']['business_profile'] ?? []),
                    'has_metadata' => !empty($snapshot['page_settings']['metadata'] ?? []),
                    'file_size' => strlen(json_encode($snapshot))
                ]
            ];
        }
        
        return $history;
    }
    
    /**
     * Clean up old versions (keep only N most recent)
     *
     * @param Page $page
     * @param int $keepCount
     * @return array
     */
    public function cleanupOldVersions(Page $page, int $keepCount = 10): array
    {
        $versions = $page->pageVersions()
            ->orderBy('created_at', 'desc')
            ->skip($keepCount)
            ->get();
        
        $deletedCount = 0;
        
        foreach ($versions as $version) {
            $version->delete();
            $deletedCount++;
        }
        
        return [
            'deleted_count' => $deletedCount,
            'remaining_count' => min($keepCount, $page->pageVersions()->count())
        ];
    }
    
    /**
     * Create version from external data (import)
     *
     * @param Page $page
     * @param array $externalData
     * @param string $versionName
     * @param string $description
     * @return PageVersion
     */
    public function createVersionFromData(Page $page, array $externalData, string $versionName, string $description = ''): PageVersion
    {
        // Normalize external data to match snapshot format
        $snapshot = $this->normalizeExternalData($externalData);
        
        return PageVersion::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'page_id' => $page->id,
            'version_name' => $versionName,
            'version_description' => $description,
            'data_snapshot' => $snapshot
        ]);
    }
    
    /**
     * Export version data
     *
     * @param PageVersion $version
     * @param string $format
     * @return array
     */
    public function exportVersion(PageVersion $version, string $format = 'json'): array
    {
        $snapshot = $version->data_snapshot;
        
        switch (strtolower($format)) {
            case 'json':
                return [
                    'success' => true,
                    'data' => json_encode($snapshot, JSON_PRETTY_PRINT),
                    'format' => 'json'
                ];
                
            case 'php':
                return [
                    'success' => true,
                    'data' => var_export($snapshot, true),
                    'format' => 'php'
                ];
                
            case 'yaml':
                if (!function_exists('yaml_emit')) {
                    return [
                        'success' => false,
                        'message' => 'YAML extension not available'
                    ];
                }
                
                return [
                    'success' => true,
                    'data' => yaml_emit($snapshot),
                    'format' => 'yaml'
                ];
                
            default:
                return [
                    'success' => false,
                    'message' => 'Unsupported format: ' . $format
                ];
        }
    }
    
    /**
     * Generate complete snapshot of page
     *
     * @param Page $page
     * @return array
     */
    private function generateSnapshot(Page $page): array
    {
        return [
            'page_settings' => [
                'title' => $page->title,
                'slug' => $page->slug,
                'status' => $page->status,
                'business_profile' => $page->business_profile,
                'metadata' => $page->metadata
            ],
            'components' => $page->pageComponents()
                ->with('component')
                ->orderBy('order_index')
                ->get()
                ->map(function ($pc) {
                    return [
                        'id' => $pc->component_id,
                        'type' => $pc->component->slug,
                        'order' => $pc->order_index,
                        'content' => $pc->content,
                        'is_active' => $pc->is_active
                    ];
                })
                ->toArray(),
            'snapshot_metadata' => [
                'created_at' => now()->toISOString(),
                'created_by' => auth()->id(),
                'version' => $page->pageVersions()->count() + 1
            ]
        ];
    }
    
    /**
     * Restore components from snapshot
     *
     * @param string $pageId
     * @param array $components
     */
    private function restoreComponents(string $pageId, array $components): void
    {
        // Delete existing components
        PageComponent::where('page_id', $pageId)->delete();
        
        // Recreate components from snapshot
        foreach ($components as $componentData) {
            PageComponent::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'page_id' => $pageId,
                'component_id' => $componentData['id'],
                'order_index' => $componentData['order'],
                'content' => $componentData['content'],
                'is_active' => $componentData['is_active'] ?? true
            ]);
        }
    }
    
    /**
     * Compare two arrays and return differences
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    private function compareArrays(array $array1, array $array2): array
    {
        $differences = [];
        
        // Check for added/modified keys
        foreach ($array2 as $key => $value) {
            if (!array_key_exists($key, $array1)) {
                $differences['added'][$key] = $value;
            } elseif ($array1[$key] !== $value) {
                $differences['modified'][$key] = [
                    'old' => $array1[$key],
                    'new' => $value
                ];
            }
        }
        
        // Check for removed keys
        foreach ($array1 as $key => $value) {
            if (!array_key_exists($key, $array2)) {
                $differences['removed'][$key] = $value;
            }
        }
        
        return $differences;
    }
    
    /**
     * Compare components arrays
     *
     * @param array $components1
     * @param array $components2
     * @return array
     */
    private function compareComponents(array $components1, array $components2): array
    {
        $differences = [
            'added' => [],
            'removed' => [],
            'modified' => []
        ];
        
        // Index components by ID for easier comparison
        $indexed1 = [];
        $indexed2 = [];
        
        foreach ($components1 as $component) {
            $indexed1[$component['id']] = $component;
        }
        
        foreach ($components2 as $component) {
            $indexed2[$component['id']] = $component;
        }
        
        // Find added components
        foreach ($indexed2 as $id => $component) {
            if (!isset($indexed1[$id])) {
                $differences['added'][] = $component;
            }
        }
        
        // Find removed components
        foreach ($indexed1 as $id => $component) {
            if (!isset($indexed2[$id])) {
                $differences['removed'][] = $component;
            }
        }
        
        // Find modified components
        foreach ($indexed2 as $id => $component) {
            if (isset($indexed1[$id])) {
                $oldComponent = $indexed1[$id];
                
                if ($component['content'] !== $oldComponent['content'] ||
                    $component['order'] !== $oldComponent['order'] ||
                    $component['is_active'] !== $oldComponent['is_active']) {
                    
                    $differences['modified'][] = [
                        'id' => $id,
                        'type' => $component['type'],
                        'changes' => [
                            'content' => [
                                'old' => $oldComponent['content'],
                                'new' => $component['content']
                            ],
                            'order' => [
                                'old' => $oldComponent['order'],
                                'new' => $component['order']
                            ],
                            'is_active' => [
                                'old' => $oldComponent['is_active'],
                                'new' => $component['is_active']
                            ]
                        ]
                    ];
                }
            }
        }
        
        return $differences;
    }
    
    /**
     * Normalize external data to snapshot format
     *
     * @param array $externalData
     * @return array
     */
    private function normalizeExternalData(array $externalData): array
    {
        // Basic normalization - can be extended based on import format
        return [
            'page_settings' => $externalData['page_settings'] ?? [],
            'components' => $externalData['components'] ?? [],
            'snapshot_metadata' => [
                'created_at' => now()->toISOString(),
                'created_by' => auth()->id(),
                'imported' => true
            ]
        ];
    }
}
