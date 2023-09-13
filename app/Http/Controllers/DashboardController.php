<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard')->with('movies', Movie::all());
    }
}
