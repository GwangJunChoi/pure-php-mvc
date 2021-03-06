<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=ENV['APP_NAME']?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link href="/css/board.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/board.js"></script>
    <script src="https://kit.fontawesome.com/3d828ebbb1.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app" class="app">
        <header>
            <h1>Simple Board</h1>
        </header>
        <?php require __DIR__ . "/{$_content_path}.php";?>
        <footer>footer</footer>
    </div>
</body>
</html>