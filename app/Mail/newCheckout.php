<?php

namespace App\Mail;

use App\Models\Orders;
use App\Models\ProductImages;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newCheckout extends Mailable
{
    use Queueable, SerializesModels;

    public Orders $order;
    public $image;
    public User $user;


    /**
     * Create a new message instance.
     */
    public function __construct(Orders $order, $image, User $user)
    {
        $this->order = $order;
        $this->image = $image;
        $this->user = $user;
    }

    public function build()
    {
        $email = $this->subject('Your Order Confirmation')
            ->from('info@printshopeld.com')
            ->view('emails.newCheckout')
            ->with([
                'order' => $this->order,
                'user' => $this->user,
            ]);
            
        foreach ($this->order->orderItems as $item) {
            foreach ($item->products->productImage as $image) {
                $email->attachFromStorage(
                    'public/img/products/' . $image->thumbnail,  
                    $image->thumbnail,                            
                    [
                        'as' => $image->thumbnail,
                        'mime' => 'image/jpeg',
                        'Content-ID' => $image->thumbnail,        
                        'disposition' => 'inline',                
                    ]
                );
            }
        }

        return $email;
    }
}
