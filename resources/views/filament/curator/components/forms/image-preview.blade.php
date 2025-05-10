@if($imageUrl)

    {{dd($imageUrl)}}
    <div class="space-y-2">
        <label class="text-xs font-medium text-gray-500">Current Image</label>
        <div class="relative group">
            <img
                    src="{{ $imageUrl }}"
                    alt="Current image"
                    class="rounded-lg border border-gray-200 w-full max-w-[400px] h-auto object-contain"
            >
            <a
                    href="{{ $imageUrl }}"
                    target="_blank"
                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all opacity-0 group-hover:opacity-100"
            >
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                </svg>
            </a>
        </div>
    </div>
@endif