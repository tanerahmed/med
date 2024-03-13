
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article #{{ $body['article_id'] }} was edited</title>
</head>
<body>
    <p>Hello,</p>
    <p>Article  #ID : {{ $body['article_id'] }} with title : {{ $body['title'] }} was edited. </p>
    <p><a href="https://blmprime.com/review/{{ $body['article_id'] }}">Link to article</a></p>

    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>