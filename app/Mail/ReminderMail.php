<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $pesanevent;
    public $gambarevent;

    /**
     * Create a new message instance.
     */
    public function __construct($messageContent, $pesanevent, $gambarevent)
    {
        $this->messageContent = $messageContent;
        $this->pesanevent = $pesanevent;
        $this->gambarevent = $gambarevent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test',
            with: ['messageContent' => $this->messageContent, 'pesanevent' => $this->pesanevent, 'gambarevent' => $this->gambarevent]

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
