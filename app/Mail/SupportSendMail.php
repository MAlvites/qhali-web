<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportSendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $emailFrom;
    private $userName;
    private $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $emailFrom, string $userName, string $content)
    {
        $this->emailFrom = $emailFrom;
        $this->userName = $userName;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.support.support')
                    ->subject('Support Contact - '.$this->userName)
                    ->from($this->emailFrom, $this->userName)
                    ->with([
                        'content' => $this->content,
                        'user_name' => $this->userName
                    ]);
    }
}
