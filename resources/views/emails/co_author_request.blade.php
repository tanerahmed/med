<!-- resources/views/emails/co_author_request.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Co-Author Request Email</title>
</head>
<body>
    <p>Hello,</p>
    <p> {{ $body['name'] }} would like to invite you to collaborate as a co-author on our project - {{ $body['title'] }}</p>
        <p>If you have any objections, you can contact us at this link <a href="https://blmprime.com/contact-us">Contact Us</a> </p>

    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>
