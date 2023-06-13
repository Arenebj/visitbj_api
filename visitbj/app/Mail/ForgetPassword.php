<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $_randomNumber;

    public function __construct($randomNumber)
    {
        $this->_randomNumber = $randomNumber;
    }

    public function build()
{
    return $this->from('Yemi@iwajutech.com')
                ->subject('Reset Password')
                ->view('code',['ramdomNumber' => $this->_randomNumber,]);
}

}
