

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article #{{ $body['article_id'] }} was Deleted</title>
</head>
<body>
    <p>Hello, admin</p>
    <p>Article  #ID : {{ $body['article_id'] }} with title : {{ $body['article_title'] }} was deleted from Author '{{$body['author']}}'. </p>

    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>