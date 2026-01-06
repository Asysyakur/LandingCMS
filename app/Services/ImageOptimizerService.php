<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Exception;

class ImageOptimizerService
{
    /**
     * Maximum image dimensions
     */
    const MAX_WIDTH = 1920;
    const MAX_HEIGHT = 1080;
    
    /**
     * Maximum file size in bytes (5MB)
     */
    const MAX_SIZE = 5 * 1024 * 1024;
    
    /**
     * Quality for JPEG compression (0-100)
     */
    const JPEG_QUALITY = 85;
    
    /**
     * Supported image formats
     */
    const SUPPORTED_FORMATS = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    
    /**
     * Optimize and save uploaded image
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $filename
     * @return array
     */
    public function optimizeAndSave(UploadedFile $file, string $directory, ?string $filename = null): array
    {
        try {
            // Validate file
            $this->validateImage($file);
            
            // Generate filename if not provided
            if (!$filename) {
                $filename = $this->generateFilename($file);
            }
            
            // Create directory if not exists
            $this->ensureDirectoryExists($directory);
            
            // Process and optimize image
            $image = Image::make($file->getRealPath());
            
            // Get original dimensions
            $originalWidth = $image->width();
            $originalHeight = $image->height();
            
            // Resize if too large
            if ($originalWidth > self::MAX_WIDTH || $originalHeight > self::MAX_HEIGHT) {
                $image->resize(self::MAX_WIDTH, self::MAX_HEIGHT, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            
            // Determine output format and quality
            $extension = $this->getOptimalFormat($file);
            $quality = $this->getOptimalQuality($file, $image);
            
            // Save optimized image
            $fullPath = $directory . '/' . $filename . '.' . $extension;
            
            if ($extension === 'png') {
                $image->save(public_path($fullPath), 9); // PNG compression level 0-9
            } elseif ($extension === 'webp') {
                $image->save(public_path($fullPath), $quality);
            } else {
                $image->save(public_path($fullPath), self::JPEG_QUALITY);
            }
            
            // Get file info
            $fileSize = filesize(public_path($fullPath));
            $finalWidth = $image->width();
            $finalHeight = $image->height();
            
            return [
                'success' => true,
                'path' => $fullPath,
                'filename' => $filename . '.' . $extension,
                'size' => $fileSize,
                'size_formatted' => $this->formatBytes($fileSize),
                'dimensions' => [
                    'width' => $finalWidth,
                    'height' => $finalHeight
                ],
                'original_dimensions' => [
                    'width' => $originalWidth,
                    'height' => $originalHeight
                ],
                'format' => $extension,
                'optimization_ratio' => $this->calculateOptimizationRatio($file->getSize(), $fileSize)
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Validate uploaded image
     *
     * @param UploadedFile $file
     * @throws Exception
     */
    private function validateImage(UploadedFile $file): void
    {
        // Check if file is actually an image
        if (!$file->isValid() || !str_contains($file->getMimeType(), 'image/')) {
            throw new Exception('Invalid image file');
        }
        
        // Check file size
        if ($file->getSize() > self::MAX_SIZE) {
            throw new Exception('Image size exceeds maximum limit of ' . self::formatBytes(self::MAX_SIZE));
        }
        
        // Check format
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::SUPPORTED_FORMATS)) {
            throw new Exception('Unsupported image format. Supported formats: ' . implode(', ', self::SUPPORTED_FORMATS));
        }
    }
    
    /**
     * Generate unique filename
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateFilename(UploadedFile $file): string
    {
        return time() . '_' . uniqid() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    }
    
    /**
     * Ensure directory exists
     *
     * @param string $directory
     */
    private function ensureDirectoryExists(string $directory): void
    {
        $fullPath = public_path($directory);
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
    }
    
    /**
     * Get optimal output format for image
     *
     * @param UploadedFile $file
     * @return string
     */
    private function getOptimalFormat(UploadedFile $file): string
    {
        $originalFormat = strtolower($file->getClientOriginalExtension());
        
        // Convert GIF to PNG (except animated GIFs)
        if ($originalFormat === 'gif') {
            try {
                $image = Image::make($file->getRealPath());
                if ($image->framesCount() > 1) {
                    return 'gif'; // Keep animated GIFs
                }
            } catch (Exception $e) {
                // If we can't check frames, keep as GIF
                return 'gif';
            }
            return 'png';
        }
        
        // Convert PNG to WebP if it's large (for better compression)
        if ($originalFormat === 'png' && $file->getSize() > 1024 * 1024) { // 1MB
            return 'webp';
        }
        
        // Keep JPEG as JPEG
        if (in_array($originalFormat, ['jpg', 'jpeg'])) {
            return 'jpg';
        }
        
        // Default to WebP for modern browsers
        return 'webp';
    }
    
    /**
     * Get optimal quality setting
     *
     * @param UploadedFile $file
     * @param \Intervention\Image\Image $image
     * @return int
     */
    private function getOptimalQuality(UploadedFile $file, $image): int
    {
        $originalFormat = strtolower($file->getClientOriginalExtension());
        
        // Higher quality for smaller images
        if ($file->getSize() < 500 * 1024) { // 500KB
            return 90;
        }
        
        // Lower quality for larger images
        if ($file->getSize() > 2 * 1024 * 1024) { // 2MB
            return 75;
        }
        
        return self::JPEG_QUALITY;
    }
    
    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @return string
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
    
    /**
     * Calculate optimization ratio
     *
     * @param int $originalSize
     * @param int $optimizedSize
     * @return float
     */
    private function calculateOptimizationRatio(int $originalSize, int $optimizedSize): float
    {
        if ($originalSize === 0) {
            return 0;
        }
        
        return round((($originalSize - $optimizedSize) / $originalSize) * 100, 2);
    }
    
    /**
     * Create thumbnails
     *
     * @param string $imagePath
     * @param array $sizes
     * @return array
     */
    public function createThumbnails(string $imagePath, array $sizes = []): array
    {
        $defaultSizes = [
            'small' => [150, 150],
            'medium' => [300, 300],
            'large' => [800, 600]
        ];
        
        $sizes = array_merge($defaultSizes, $sizes);
        $thumbnails = [];
        
        try {
            $image = Image::make(public_path($imagePath));
            $pathInfo = pathinfo($imagePath);
            
            foreach ($sizes as $name => [$width, $height]) {
                $thumbnailPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . $name . '.' . $pathInfo['extension'];
                
                $thumbnail = clone $image;
                $thumbnail->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                });
                
                $thumbnail->save(public_path($thumbnailPath), self::JPEG_QUALITY);
                
                $thumbnails[$name] = [
                    'path' => $thumbnailPath,
                    'size' => filesize(public_path($thumbnailPath)),
                    'dimensions' => [$width, $height]
                ];
            }
            
            return [
                'success' => true,
                'thumbnails' => $thumbnails
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Get image metadata
     *
     * @param string $imagePath
     * @return array
     */
    public function getImageMetadata(string $imagePath): array
    {
        try {
            $image = Image::make(public_path($imagePath));
            
            return [
                'success' => true,
                'metadata' => [
                    'width' => $image->width(),
                    'height' => $image->height(),
                    'size' => filesize(public_path($imagePath)),
                    'mime' => $image->mime(),
                    'exif' => $image->exif(),
                    'iptc' => $image->iptc()
                ]
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
