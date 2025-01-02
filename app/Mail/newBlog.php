<?php

namespace App\Mail;

use App\Models\BlogImages;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newBlog extends Mailable
{
    use Queueable, SerializesModels;

    public Blog $blog;
    public BlogImages $blogImages;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct( $blog, $user, $blogImages)
    {
        $this->blog = $blog;
        $this->user = $user;
        $this->blogImages = $blogImages;
    }

    public function build()
    {
        $email = $this->subject('Story Update')
            ->from('info@printshopeld.com')
            ->view('emails.newPost')
            ->with([
                'user' => $this->user,
                'blog' => $this->blog,
                'blogImages' => $this->blogImages,
            ]);

        return $email;
    }
}
