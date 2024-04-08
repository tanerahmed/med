<!-- resources/views/emails/co_author_request.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Force Review Email</title>
</head>
<body>
    <p>Hello, {{ $body['name'] }}</p>
    <p> Admin added you to be reviwer on article # - {{ $body['article'] }}</p>
    
    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>
