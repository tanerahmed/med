<!-- resources/views/emails/co_author_request.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Request Email</title>
</head>
<body>
    <p>Hello, {{ $body['name'] }}</p>
    <p> We would like to invite you to be reviwer on article - {{ $body['article'] }}</p>

        <p>Click to the <a href="{{$body['link']}}">LINK</a>  to approve it</p>

    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>
