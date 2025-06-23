<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class BorrowingSubmission extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $data;
    protected $roomItem;
    public function __construct($data, $roomItem)
    {
        $this->data = $data;
        $this->roomItem = $roomItem;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Permohonan Peminjaman Barang')
            ->from(Auth::user()->email, Auth::user()->username)
            ->view(
                'emails.submission',
                [
                    'data' => $this->data,
                    'user' => Auth::user(),
                    'roomItem' => $this->roomItem
                ]
            );
    }
}
