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

    // Properti publik untuk menyimpan data yang akan dikirimkan dalam email
    public $messageContent;
    public $pesanevent;
    public $gambarevent;

    /**
     * Create a new message instance.
     */
    // menerima data yang akan dikirimkan ke dalam email
    public function __construct($messageContent, $pesanevent, $gambarevent)
    {
        $this->messageContent = $messageContent;
        $this->pesanevent = $pesanevent;
        $this->gambarevent = $gambarevent;
    }

    /**
     * Get the message envelope.
     */
    // Fungsi ini digunakan untuk menentukan envelope atau header dari email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    // Fungsi ini digunakan untuk menentukan file yang dilampirkan dalam email
    public function content(): Content
    {
        return new Content(
            view: 'emails.test', // View yang digunakan untuk email
            with: [
                'messageContent' => $this->messageContent,
                'pesanevent' => $this->pesanevent,
                'gambarevent' => $this->gambarevent]

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
