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

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $email = $this->subject('Welcome to PrintShopEld')
            ->from('info@printshopeld.com')
            ->view('emails.newPost')
            ->with([
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'gender' => $this->user->gender,
                'location' => $this->user->location,
                'user_id' => $this->user->id,
            ]);

        return $email;
    }
}
