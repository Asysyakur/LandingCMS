<!-- Features Component Preview -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">
            {{ $section_title ?? 'Our Features' }}
        </h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(isset($items) && is_array($items))
                @foreach($items as $item)
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            @if($item['icon'] ?? false)
                                <img src="{{ $item['icon'] }}" alt="{{ $item['title'] }}" class="w-8 h-8">
                            @else
                                <span class="text-blue-600 text-2xl">✓</span>
                            @endif
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
