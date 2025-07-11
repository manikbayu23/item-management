<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResponseSubmission extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Permohonan Peminjaman Barang')
            ->from(Auth::user()->email, Auth::user()->username)
            ->view(
                'emails.reminder-submission',
                [
                    'data' => $this->data,
                    'user' => Auth::user(),
                ]
            );
    }
}
