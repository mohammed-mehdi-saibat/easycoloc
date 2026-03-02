<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ColocationInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Join my ledger on Coloc.',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invite', 
        );
    }
}