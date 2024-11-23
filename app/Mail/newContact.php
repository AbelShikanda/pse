<?php

namespace App\Mail;

use App\Models\Contacts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newContact extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    /**
     * Create a new message instance.
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        $email = $this->subject('New Contact')
            ->view('emails.newContact')
            ->with([
                'contact' => $this->contact,
            ]);

        return $email;
    }
}
