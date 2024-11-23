<?php

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class orderApproval extends Mailable
{
    use Queueable, SerializesModels;

    public Orders $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $email = $this->subject('Order Confirmation')
            ->from('info@printshopeld.com')
            ->view('emails.orderApproval')
            ->with([
                'order' => $this->order,
            ]);

        return $email;
    }
}
