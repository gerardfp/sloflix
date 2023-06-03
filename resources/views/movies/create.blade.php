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