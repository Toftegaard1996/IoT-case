<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div id="app">
        <temperature-graph></temperature-graph>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
