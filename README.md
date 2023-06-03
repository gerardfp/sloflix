# Install
```bash
curl -s https://laravel.build/sloflix | bash
cd sloflix
vendor/bin/sail up
```

## Actualizar Tailwind
```bash
vendor/bin/sail npm i -D tailwindcss postcss autoprefixer
```

## Instalar Bootstrap
```bash
vendor/bin/sail composer require laravel/ui --dev
vendor/bin/sail php artisan ui bootstrap
vendor/bin/sail npm i
```

`resources/js/app.js`
```javascript
import '../css/app.css';
import '../sass/app.scss';
```

## Iniciar servidor de desarrollo
```bash
vendor/bin/sail npm run dev
```

# Auth

```bash
vendor/bin/sail composer require laravel/breeze --dev
vendor/bin/sail php artisan breeze:install

```

# Database

## Definir modelo
```bash
vendor/bin/sail php artisan make:model Movie --all
```` 

`database/migrations/create_movies_table.php`

```php
$table->string('title');
$table->string('plot');
$table->string('poster');
```

## Añadir 10 películas _fake_ de prueba
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

## Aplicar cambios en la base de datos
```bash
vendor/bin/sail php artisan migrate:fresh --seed`
```

# Web 
## Listar películas

`routes/web.php`
```php
Route::get('/movies', [MovieController::class, 'index']);
```

`app/Http/Controllers/MovieController.php`

```php
public function index() {
    return view('movies.movies')->with('movies', Movie::all());
}
```

`resources/view/movies/movies.blade.php`
```html
<x-app-layout>

@forelse($movies as $movie)
<div>
    <p>{{$movie->title}}
    <img src="{{ $movie->poster }}" style="width: 100%"/>
</div>
@empty
<p>No hay pelis :()
@endforelse
</x-app-layout>
```

## Crear película

`routes/web.php`
```php
Route::get('/movies/create', [MovieController::class, 'create']);
Route::post('/movies/create', [MovieController::class, 'store'])->name('storeMovie');
```

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

El método `storePublicly`Guarda los ficheros subidos en la carpeta `storage/app/public`

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
<x-app-layout>
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
</x-app-layout>
```

