<x-app-layout>
        <div>
            <a href="/movies/create">Add movie</a>
        </div>
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
