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
    <h1>Thank you for your business</h1>

    <p>Hi {{ $user->first_name }}, you have placed a new order successfully.<br>
        (Pending confirmation)</p>

    <p>Your order reference is: {{ $order->reference }}</p>
    @if ($order->promoCode)
        <p>You applied this: {{ $order->promoCode->code }} Promo code</p>
    @else
        <p>No promo code was applied.</p>
    @endif

    <h3>Order Details</h3>

    <div style="padding: 10px; border: 1px solid #ddd;">
        <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; border: 1px solid #ddd;">
            <thead>
                <tr style="background-color: #f9f9f9;">
                    <th style="border: 1px solid #ddd; text-align: left;">Image</th>
                    <th style="border: 1px solid #ddd; text-align: left;">Name</th>
                    <th style="border: 1px solid #ddd; text-align: left;">Color</th>
                    <th style="border: 1px solid #ddd; text-align: left;">Size</th>
                    <th style="border: 1px solid #ddd; text-align: left;">Quantity</th>
                    <th style="border: 1px solid #ddd; text-align: left;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $o)
                    <tr>
                        <td style="border: 1px solid #ddd; text-align: center;">
                            @foreach ($o->products->productImage as $image)
                                <img src="{{ url('storage/img/products/' . $image->thumbnail) }}" alt="Product Image"
                                    style="width: 90px; height: auto;">
                            @endforeach
                        </td>
                        <td style="border: 1px solid #ddd;">{{ $o->products->name }}</td>
                        <td style="border: 1px solid #ddd;">{{ $o->color->name }}</td>
                        <td style="border: 1px solid #ddd;">{{ $o->size->name }}</td>
                        <td style="border: 1px solid #ddd;">{{ $o->quantity }}</td>
                        <td style="border: 1px solid #ddd;">Ksh{{ number_format($o->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <p><strong>Delivery</strong> Ksh300</p>
    <p><strong>Total Price:</strong> Ksh{{ $order->price }}</p>

    <p>If you wish to see more information, click on the button below.</p>

    <a href="{{ url('/profile/') }}"
        style="background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">View
        Order</a>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>

</html>
