@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto p-6 pt-16">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-white sm:text-5xl">
                <span class="block bg-gradient-to-r from-indigo-400 to-purple-500 bg-clip-text text-transparent">
                    ISBN Lookup
                </span>
            </h1>
            <p class="mt-3 text-lg text-zinc-400">
                Instantly fetch metadata from the Google Books database.
            </p>
        </div>

        <livewire:isbn-search />
        
        <footer class="fixed bottom-0 left-0 w-full bg-zinc-950 border-t border-zinc-800 py-4 text-center z-999">
            <p class="text-[10px] text-zinc-500 uppercase font-medium">
                Powered by <span class="text-zinc-300">Google Books API</span>
            </p>
        </footer>
    </div>
@endsection