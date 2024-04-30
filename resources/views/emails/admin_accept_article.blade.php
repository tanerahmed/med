
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article {{ $body['article_title'] }} was Accepted</title>
</head>
<body>
    <p>Dear {{$body['author_name'] }}</p>,
    <br>
    <p></p>We are pleased to advise that your article {{ $body['article_id'] }} - {{ $body['article_title'] }} was accepted by the editorial board and now is being sent for review process 
    <br>
    <a href="https://blmprime.com/editorial-peer-review-process"> peer review process</a>
     </p>
     <br>

    <p>Sincerely,</p>
    <p>Your Team</p>
    
</body>
</html>