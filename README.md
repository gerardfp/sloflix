## install
```bash
curl -s https://laravel.build/example-app | bash
cd example-app
vendor/bin/sail up
```


## database
```bash
vendor/bin/sail php artisan make:model Movie --all
```` 

`database/migrations/create_movies_table.php`

```php
$table->string('title');
$table->string('plot');
$table->string('poster');
```

`database/factories/MovieFactory.php`
```php
return [
    'title' => $this->faker->name(),
    'plot' => $this->faker->text(200),
    'poster' => $this->faker->imageUrl($width = 400, $height = 400),
];
```

`database/seeders/MovieSeeder.php`
```php
    public function run(): void
    {
        Movie::factory(10)->create();
    }
```

```bash
vendor/bin/sail php artisan migrate:fresh --seed`
```

## list

`app/Http/Controllers/MovieController.php`

```php
public function index() {
    return view('movies.movies')->with('movies', Movie::all());
}
```

`routes/web.php`
```php
Route::get('/movies', [MovieController::class, 'index']);
```

`resources/view/movies/movies.blade.php`
```html
<!DOCTYPE html>

@forelse($movies as $movie)
<div>
    <p>{{$movie->title}}
    <img src="{{ $movie->poster }}" style="width: 100%"/>
</div>
@empty
<p>No hay pelis :()
@endforelse
```

## create

`app/Http/Controllers/MovieController.php`

```php
    public function create()
    {
        return view('movies.create');
    }

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
```

Guarda los ficheros subidos en la carpeta `storage/app/public`

`app/Http/Requests/StoreMovieRequest.php`
```php
    public function authorize(): bool {
        return true;
    }
```

```bash
vendor/bin/sail php artisan storage:link
```

Crea un enlace simbólico `public/storage --> storage/app/public`

`resources/views/movies/create.blade.php`

```html
<x-layout>
<h1>Create Movie</h1>

<form method="post" action={{ route('storeMovie') }} enctype="multipart/form-data">
@csrf
<input name="title" placeholder="Title" />
@error('title')
<div class="error">{{ $message}}</div>
@enderror

<input name="plot" placeholder="Plot..." />
@error('plot')
<div class="error">{{ $message}}</div>
@enderror

<input type="file" name="poster"/>

<input type="submit" value="Crear" />
</form>
</x-layout>
```