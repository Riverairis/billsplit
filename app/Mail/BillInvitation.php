<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;
    public $bill;

    public function __construct($invitation, $bill)
    {
        $this->invitation = $invitation;
        $this->bill = $bill;
    }

    public function build()
    {
        return $this->subject('Invitation to join ' . $this->bill->name)
                    ->markdown('emails.bill-invitation');
    }
}