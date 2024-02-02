<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewArticleEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject, $body, $zipFilePath;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $body, $zipFilePath = null)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->zipFilePath = $zipFilePath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('tanerahmed@example.com', 'Танер Ахмед'),
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.review_feedback'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Attach the zip file if the file path is provided
        if (!empty($this->zipFilePath)) {
            return [
                Attachment::fromPath($this->zipFilePath)
                    ->as('article_files.zip')
                    ->withMime('application/zip')
            ];
        }

        return [];
    }
}
