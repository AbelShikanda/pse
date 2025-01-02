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

<<<<<<< HEAD
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
=======
    /**
     * Create a new message instance.
     */
    public function __construct(public User $user)
>>>>>>> 13b75d815679ffd73381c0dfde26250cc365014e
    {
        $this->user = $user;
    }

    public function build()
    {
        $email = $this->subject('Welcome to PrintShopEld')
            ->from('info@printshopeld.com')
<<<<<<< HEAD
            ->markdown('emails.newAccount') 
=======
            ->view('emails.newPost')
>>>>>>> 13b75d815679ffd73381c0dfde26250cc365014e
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
