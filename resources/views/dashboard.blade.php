<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 55px"> 
        @forelse($movies as $movie)
        <div>
        <p>{{$movie->title}}
        <img src="{{ $movie->poster }}" style="width: 100%"/>
    </div>
    @empty
    <p>No hay pelis :()
    @endforelse
    
</x-app-layout>
