<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;

class MovieController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('movies.movies')->with('movies', Movie::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        $success = false;
        $error = '';
        try {

            $movie = new Movie;
            $movie->title = $request->input('title');
            $movie->plot  = $request->input('plot');
            $movie->poster  = $request->file('poster')->storePublicly('posters','public');   // falta el /storage en la URL

            $success = $movie->save();
        } catch (UploadFileException $exception) {
            $error = $exception->customMessage();
        } catch (\Illuminate\Database\QueryException $exception) {
            $error = "There was en error storing movie: " . $exception->getMessage();
        }
        return redirect()->action([MovieController::class, 'movies.create'], ['success' => $success])->withError($error);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
