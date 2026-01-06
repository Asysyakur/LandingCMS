<!-- Contact Component Preview -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Contact Us</h2>
        <div class="max-w-2xl mx-auto">
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    @if($phone ?? false)
                        <div class="mb-6">
                            <h4 class="font-semibold mb-2">Phone</h4>
                            <p class="text-gray-600">{{ $phone }}</p>
                        </div>
                    @endif
                    @if($email ?? false)
                        <div class="mb-6">
                            <h4 class="font-semibold mb-2">Email</h4>
                            <p class="text-gray-600">{{ $email }}</p>
                        </div>
                    @endif
                </div>
                <div>
                    @if($address ?? false)
                        <div class="mb-6">
                            <h4 class="font-semibold mb-2">Address</h4>
                            <p class="text-gray-600">{{ $address }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @if($map_embed ?? false)
                <div class="mt-8">
                    {!! $map_embed !!}
                </div>
            @endif
        </div>
    </div>
</section>
