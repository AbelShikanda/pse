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
    <h1>Order Confirmation</h1>

    <p>Hi {{ $order->user->first_name }}, Your order for reference number {{ $order->reference }} has been confirmed.</p>
    <br>
    <ul>
        <li>
            <p>Your order will take one business day to be completed</p>
        </li>
        <li>
            <p>We will deliver to your clossest location ({{ $order->user->location }})</p>
        </li>
    </ul>
    <br>
    <p>If you wish to see more information, click on the button below.</p>

    <a href="{{ url('/profile/') }}"
        style="background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">More...</a>

    <p>Thanks,<br>
    <p>Sincerely,<br>
        {{ config('app.name') }}</p>
        <p>info@Printshopeld.com</p>
</body>

</html>
