<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newPost extends Mailable
{
    use Queueable, SerializesModels;

    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    public function build()
    {
        $email = $this->subject('New Product Available')
            ->from('info@printshopeld.com')
            ->view('emails.newPost')
            ->with([
                'product' => $this->product,
            ]);

            // dd($this->product->ProductImage);
        // Attach images inline with unique CIDs
        foreach ($this->product->ProductImage as $image) {
            // foreach ($item->products->productImage as $image) {
                $email->attachFromStorage(
                    'public/img/products/' . $image->thumbnail,  // Path relative to the storage/app directory
                    $image->thumbnail,                            // Filename for attachment
                    [
                        'as' => $image->thumbnail,
                        'mime' => 'image/jpeg',
                        'Content-ID' => $image->thumbnail,        // Unique CID for referencing in HTML
                        'disposition' => 'inline',                // Set as inline for inline display
                    ]
                );
            // }
        }

        return $email;
    }
}
