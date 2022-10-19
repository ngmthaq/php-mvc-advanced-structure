<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ assets("img/favicon.ico") }}" type="image/x-icon">
    <title>{{ trans("_503") }}</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 80px;
            color: orange;
            margin: 0;
        }

        p {
            font-size: 24px;
            color: #999999;
            margin: 0;
            text-transform: uppercase;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
        }
    </style>
</head>

<body>
    <h1>503</h1>
    <p>{{ trans("_503") }}</p>
</body>

</html>
