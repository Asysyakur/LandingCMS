<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview - {{ $page->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Device-specific styles */
        .device-desktop { width: 100%; max-width: 1200px; }
        .device-tablet { width: 768px; }
        .device-mobile { width: 375px; }
        
        .preview-container {
            margin: 0 auto;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .preview-header {
            background: #f9fafb;
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .preview-content {
            min-height: 400px;
            background: white;
        }
    </style>
</head>
<body class="bg-gray-100 p-4">
    <div class="preview-container device-{{ $device }}">
        <div class="preview-header">
            <div class="flex items-center space-x-2">
                <span class="text-sm font-medium text-gray-900">{{ $page->title }}</span>
                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">{{ $device }}</span>
            </div>
            <div class="text-xs text-gray-500">
                Last saved: {{ $page->updated_at->format('M j, Y H:i') }}
            </div>
        </div>
        
        <div class="preview-content">
            <!-- Hero Section -->
            @if($sections->where('component.slug', 'hero')->first())
                @php $hero = $sections->where('component.slug', 'hero')->first()->fields; @endphp
                <section class="relative bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
                    <div class="container mx-auto px-4">
                        <div class="text-center">
                            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                                {{ $hero['title'] ?? 'Hero Title' }}
                            </h1>
                            <p class="text-xl mb-8 opacity-90">
                                {{ $hero['subtitle'] ?? 'Hero Subtitle' }}
                            </p>
                            @if($hero['cta_text'] ?? false)
                                <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                                    {{ $hero['cta_text'] }}
                                </button>
                            @endif
                        </div>
                    </div>
                </section>
            @endif
            
            <!-- Features Section -->
            @if($sections->where('component.slug', 'features')->first())
                @php $features = $sections->where('component.slug', 'features')->first()->fields; @endphp
                <section class="py-16 bg-white">
                    <div class="container mx-auto px-4">
                        <h2 class="text-3xl font-bold text-center mb-12">
                            {{ $features['section_title'] ?? 'Our Features' }}
                        </h2>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @if(isset($features['items']) && is_array($features['items']))
                                @foreach($features['items'] as $item)
                                    <div class="text-center p-6">
                                        <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                            <span class="text-blue-600 text-2xl">✓</span>
                                        </div>
                                        <h3 class="text-xl font-semibold mb-2">
                                            {{ $item['title'] ?? 'Feature Title' }}
                                        </h3>
                                        <p class="text-gray-600">
                                            {{ $item['description'] ?? 'Feature description' }}
                                        </p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </section>
            @endif
            
            <!-- About Section -->
            @if($sections->where('component.slug', 'about')->first())
                @php $about = $sections->where('component.slug', 'about')->first()->fields; @endphp
                <section class="py-16 bg-gray-50">
                    <div class="container mx-auto px-4">
                        <div class="max-w-4xl mx-auto">
                            <h2 class="text-3xl font-bold text-center mb-12">
                                {{ $about['title'] ?? 'About Us' }}
                            </h2>
                            <div class="grid md:grid-cols-2 gap-12 items-center">
                                <div>
                                    <p class="text-lg text-gray-700 leading-relaxed">
                                        {{ $about['description'] ?? 'About description' }}
                                    </p>
                                </div>
                                @if($about['image'] ?? false)
                                    <div class="text-center">
                                        <img src="{{ $about['image'] }}" alt="About" class="rounded-lg shadow-lg max-w-full">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            
            <!-- Contact Section -->
            @if($sections->where('component.slug', 'contact')->first())
                @php $contact = $sections->where('component.slug', 'contact')->first()->fields; @endphp
                <section class="py-16 bg-white">
                    <div class="container mx-auto px-4">
                        <h2 class="text-3xl font-bold text-center mb-12">Contact Us</h2>
                        <div class="max-w-2xl mx-auto">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div>
                                    <div class="mb-6">
                                        <h4 class="font-semibold mb-2">Phone</h4>
                                        <p class="text-gray-600">{{ $contact['phone'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="mb-6">
                                        <h4 class="font-semibold mb-2">Email</h4>
                                        <p class="text-gray-600">{{ $contact['email'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-6">
                                        <h4 class="font-semibold mb-2">Address</h4>
                                        <p class="text-gray-600">{{ $contact['address'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            @if($contact['map_embed'] ?? false)
                                <div class="mt-8">
                                    {!! $contact['map_embed'] !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            @endif
            
            <!-- Default message if no components -->
            @if($sections->isEmpty())
                <div class="flex items-center justify-center h-96">
                    <div class="text-center">
                        <div class="text-gray-400 text-6xl mb-4">📄</div>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No Components Yet</h3>
                        <p class="text-gray-500">Add components to this page to see the preview.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
