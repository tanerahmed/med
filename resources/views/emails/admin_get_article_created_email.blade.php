<!-- resources/views/emails/co_author_request.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Co-Author Request Email</title>
</head>
<body>
    <p>Hello, Admin</p>
    <p>The author: {{ $body['name'] }} created article with title: {{ $body['title'] }}</p>

    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>
