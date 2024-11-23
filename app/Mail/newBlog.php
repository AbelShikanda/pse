<?php

namespace App\Mail;

use App\Models\BlogImages;
use App\Models\Blogs;
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

    public Blogs $blog;
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

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Story Update',
            from: 'info@printshopeld.com',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.newBlog',
            with: [
                'user' => $this->user,
                'blog' => $this->blog,
                'blogImages' => $this->blogImages,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // new Attachment(
            //     path: storage_path('app/public/yourfile.pdf'),
            //     as: 'Job_Approval_Document.pdf',
            //     mime: 'application/pdf',
            // ),
            ];
    }
}
