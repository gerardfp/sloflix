<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sloflix</title>
        <style>
            /* * {
                box-sizing: border-box;
            }
            body {
                background-color: #111116;
                color: white;
                font-family:   -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
            }
            a, button {
                color: rgb(33, 159, 255);
            }

            input {
                padding: 8px;
                border: 2px solid rgb(10, 131, 223);
                border-radius: 4px;
            }

            [type="submit"], [type="file"] {
                background-color:rgb(33, 159, 255);
                color: white;
            }

            [type="submit"]:hover, [type="file"]:hover {
                background-color:rgb(10, 131, 223);
            } */

        </style>

    </head>
    <body class="antialiased">
        {{ $slot }}
    </body>
</html>
