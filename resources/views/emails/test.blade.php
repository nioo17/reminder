<!DOCTYPE html>
<html>
<head>
    <title>Reminder Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .event-image {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pemberitahuan!</h2>
        <p>{{ $messageContent }}</p>

        @if(!empty($gambarevent) && file_exists(public_path('images/poster/' . basename($gambarevent))))
            <img src="{{ $gambarevent }}" alt="Event Image" class="event-image">
        @else
            <p></p>
        @endif

        @if(!empty($pesanevent))
            <p>{{ $pesanevent }}</p>
        @endif
    </div>
</body>
</html>
