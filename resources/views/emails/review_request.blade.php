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

        <p>Click to the {!! $body['link'] !!} </p>

        {{-- TODO --}}

        Link za potvrajdenie 

    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>
