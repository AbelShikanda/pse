<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .button {
            display: inline-block;
            background-color: #3490dc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <h1>New Contact</h1>

    <div class="container">
        <div class="info-item">
            <span class="info-label">Contact: </span>{{ $contact->name }}
        </div>
        <div class="info-item">
            <span class="info-label">Email: </span>{{ $contact->email }}
        </div>
        <div class="info-item">
            <span class="info-label">Subject: </span>{{ $contact->subject }}
        </div>
        <div class="info-item">
            <span class="info-label">Message: </span>{{ $contact->message }}
        </div>
    </div>

    <p>If you wish to see more information, click on the button below.</p>

    <a href="{{ url('/contact/') }}" class="button">View Message</a>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>

</html>
