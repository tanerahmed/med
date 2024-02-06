<!-- resources/views/emails/co_author_request.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Request Email</title>
</head>
<body>
    <p>Hello,</p>
    <p> {{ $body['user'] }} accept to be reviewer on Article #ID - {{ $body['article_id'] }}</p>

    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>
