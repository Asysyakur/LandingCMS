<!-- About Component Preview -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">
                {{ $title ?? 'About Us' }}
            </h2>
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        {{ $description ?? 'About description' }}
                    </p>
                </div>
                @if($image ?? false)
                    <div class="text-center">
                        <img src="{{ $image }}" alt="About" class="rounded-lg shadow-lg max-w-full">
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
