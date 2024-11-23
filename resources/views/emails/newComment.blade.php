<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Add inline CSS for better email styling */
        .product-image {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Comment on your blog</h1>

    <p>Hi Printshopeld, you have a new comment.</p>

    <div style="padding: 10px; border: 1px solid #ddd;">
        <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; border: 1px solid #ddd;">
            <thead>
                <tr style="background-color: #f9f9f9;">
                    <th style="border: 1px solid #ddd; text-align: left;">blog</th>
                    <th style="border: 1px solid #ddd; text-align: left;">comment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #ddd;">{{ $comment->blog->title }}</td>
                    <td style="border: 1px solid #ddd;">{{ $comment->content }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <p>If you wish to see more information, click on the button below.</p>

    <a href="{{ url('/comment/') }}"
        style="background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">View
        Comment</a>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>

</html>
