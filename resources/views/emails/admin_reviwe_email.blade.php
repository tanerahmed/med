
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article {{ $body['article_title'] }} was Reviwed</title>
</head>
<body>
    <p>Dear Admin</p>,
    <br>
    <p>Revier {{ $body['reviwer_name'] }},  reviwed article ' {{ $body['article_title']}} ' with rating ' {{ $body['rating']}}'</p>
    <br>


    <p>Sincerely,</p>
    <p>Your Team</p>
    
</body>
</html>