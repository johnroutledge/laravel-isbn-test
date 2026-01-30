<div class="space-y-6">
    <div class="bg-zinc-800 p-6 rounded-xl">
        <div class="flex flex-col gap-3">
            <label for="isbn" class="text-sm font-medium text-zinc-400">Enter ISBN</label>
            <div class="flex gap-2">
                <input 
                    type="text" 
                    id="isbn"
                    wire:model="isbn" 
                    placeholder="e.g. 9780132350884" 
                    class="flex-1 bg-zinc-950 border-zinc-700 text-zinc-200 rounded-lg shadow-inner focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3 border placeholder-zinc-600 outline-none transition-all"
                >
                <button 
                    wire:click="search" 
                    wire:loading.attr="disabled"
                    class="bg-zinc-100 hover:bg-white text-zinc-900 font-semibold px-6 py-2 rounded-lg transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove wire:target="search">Search</span>
                    <span wire:loading wire:target="search" class="flex items-center">
                        <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24"></svg>
                        Searching...
                    </span>
                </button>
            </div>
            @error('isbn') 
                <span class="text-red-400 text-xs font-medium">{{ $message }}</span> 
            @enderror
        </div>
    </div>

    <div wire:loading.flex wire:target="search" class="justify-center items-center py-12">
        <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-indigo-500"></div>
        <span class="ml-4 text-zinc-400 font-medium">Querying Google Books API...</span>
    </div>

    @if($book)
        <div wire:loading.remove wire:target="search" class="bg-zinc-800 rounded-xl overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
            <div class="md:flex">
                @if($book['thumbnail'])
                    <div class="md:shrink-0 bg-zinc-950 flex items-center justify-center p-6 border-r border-zinc-800">
                        <img class="h-56 w-full object-contain md:w-40 rounded shadow-2xl" src="{{ $book['thumbnail'] }}" alt="{{ $book['title'] }}">
                    </div>
                @endif
                <div class="p-8">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-0.5 bg-indigo-500/10 text-indigo-400 text-xs font-bold uppercase rounded-full border border-indigo-500/20">
                            Match Found
                        </span>
                    </div>
                    <h2 class="text-3xl font-bold text-zinc-100 ">{{ $book['title'] }}</h2>
                    <p class="mt-1 text-zinc-400 text-lg">
                        <span class="text-zinc-500">by</span> {{ implode(', ', $book['authors']) }}
                    </p>
                    
                    @if($book['description'])
                        <div class="mt-2 pt-6 border-t border-zinc-800">
                            <p class="text-zinc-400 italic">
                                "{{ Str::limit($book['description'], 350) }}"
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>