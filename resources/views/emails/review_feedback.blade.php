<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Feedback</title>
</head>
<body>
    <p>Hello,</p>
    <p><strong>{{ $body['reviwer_name'] }}</strong>  reviewed Article # <strong>{{ $body['articleId'] }}</strong> - <strong>{{ $body['article_title'] }}</strong></p>
    <br>
    <p>With rating: <strong>{{ $body['rating'] }}</strong></p>
    <br>
    <p>Comments: {{ $body['review_comments']}}</p>
    {{-- <p>manuscript: {{ $body['manuscript']}}</p>
    <p>figures: {{ $body['figures']}}</p>
    <p>tables: {{ $body['tables']}}</p>
    <p>supplementary: {{ $body['supplementary']}}</p>
    <p>coverLetter: {{ $body['coverLetter']}}</p>
    <p>keywords: {{ $body['keywords']}}</p>
    <p>title: {{ $body['title']}}</p>
    <p>abstract: {{ $body['abstract']}}</p> --}}
    <br>
    <p>Sincerely,</p>
    <p>Your Team</p>
</body>
</html>
