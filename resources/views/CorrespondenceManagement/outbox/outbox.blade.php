<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

    <h1>Outbox</h1>
    <table class="outbox-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Recipient</th>
                <th>Subject</th>
                <th>Date Sent</th>
            </tr>
        </thead>
        <tbody>
            @foreach($outboxItems as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->recipient }}</td>
                    <td>{{ $item->subject }}</td>
                    <td>{{ $item->date_sent }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    </body>
    </html>

</body>
</html>