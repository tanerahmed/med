
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article #{{ $body['article_title'] }} was Rejected</title>
</head>
<body>
    <p>Hello,</p>
    <p>Article  #ID : {{ $body['article_id'] }} with title : {{ $body['article_title'] }} was Rejected with reasons! </p>
    <p> {{ $body['reason'] }} </p>


    <p>Sincerely,</p>
    <p>Your Team</p>
    
</body>
</html>