<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $toAddress;
    public $product;
    public $images;

    /**
     * Create a new message instance.
     */
    public function __construct(array $details)
    {
        $this->toAddress = $details['to'];
        $this->product = $details['product'];
        $this->images = $details['images'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Attach images
        foreach ($this->images as $image) {
            $this->attach($image['path'], [
                'as' => $image['name'],
                'mime' => $image['mime'],
            ]);
        }

        // Set email subject and send to admin
        return $this->markdown('emails.admin_notification')
        ->subject('New Product Registration');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin_notification',
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
