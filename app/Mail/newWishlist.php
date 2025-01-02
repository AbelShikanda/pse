<?php

namespace App\Mail;

use App\Models\Products;
use App\Models\WishList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newWishlist extends Mailable
{
    use Queueable, SerializesModels;

    public Products $product;

    /**
     * Create a new message instance.
     */
    public function __construct(Products $product)
    {
        $this->product = $product;
    }

    public function build()
    {
        $email = $this->subject('New Product in Wishlist')
            ->from('info@printshopeld.com')
            ->view('emails.newWishlist')
            ->with([
                'product' => $this->product,
            ]);

        return $email;
    }
}
