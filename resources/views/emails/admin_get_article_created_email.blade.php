<!-- resources/views/emails/co_author_request.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $body['name'] }} - Created Article</title>
</head>
<body>
    <p>Hello, Admin</p>
    <p>The author: {{ $body['name'] }} created article with title: {{ $body['title'] }}</p>
    <p> Go to <a href="https://blmprime.com/admin/dashboard">Dashboard</a></p>
    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>
