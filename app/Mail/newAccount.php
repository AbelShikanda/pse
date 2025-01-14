<?php

namespace App\Mail;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newAccount extends Mailable
{
    use Queueable, SerializesModels;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $email = $this->subject('New Account Created')
            ->from('info@printshopeld.com')
            ->markdown('emails.newAccount') 
            ->with([
                'user_id' => $this->user->id,
                'user_id' => $this->user->first_name,
                'user_id' => $this->user->last_name,
                'user_id' => $this->user->location,
                'user_id' => $this->user->created_at,
            ]);

        return $email;
    }
}
