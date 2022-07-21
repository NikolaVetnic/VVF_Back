<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Movie Created</title>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <h3>Movie created</h3>
    <p>A new movie is added to the system:</p>
    <p>Title : {{ $movie->title }}</p>
    <p>Genre : {{ $movie->genre }}</p>
    <p>Description : {{ $movie->description }}</p>
    <p>Image URL : {{ $movie->image_url }}</p>
</body>

</html>