<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class welcomeemail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailmessage;
    public $subject;
    // public $detils;

    // define veribale private or protected using this method
    private $detils;
    /**
     * Create a new message instance.
     */
    public function __construct($message, $subject, $detils)
    {
        $this->mailmessage = $message;
        $this->subject     = $subject;
        $this->detils      = $detils;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.welcome-mail',

            // define veribale private or protected using this method
            with: [
                'name'    => $this->detils['name'],
                'product' => $this->detils['product'],
                'price'   => $this->detils['price'],
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
        return [];
    }
}
