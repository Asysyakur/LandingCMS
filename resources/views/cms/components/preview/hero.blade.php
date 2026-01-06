<!-- Hero Component Preview -->
<section class="relative bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                {{ $title ?? 'Hero Title' }}
            </h1>
            @if($subtitle ?? false)
                <p class="text-xl mb-8 opacity-90">
                    {{ $subtitle }}
                </p>
            @endif
            @if($cta_text ?? false)
                <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    {{ $cta_text }}
                </button>
            @endif
        </div>
    </div>
    @if($bg_image ?? false)
        <div class="absolute inset-0 opacity-20">
            <img src="{{ $bg_image }}" alt="Background" class="w-full h-full object-cover">
        </div>
    @endif
</section>
