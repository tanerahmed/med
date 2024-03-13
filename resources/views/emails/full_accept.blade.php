<!-- resources/views/emails/co_author_request.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article #{{ $body['articleId'] }} full accept</title>
</head>
<body>
    <p>Hello, </p>
    <p> Your article #{{ $body['articleId'] }} is full accept!</p>

    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>
