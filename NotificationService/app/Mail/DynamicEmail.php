<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DynamicEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $templateView;
    protected $templateData;

    public function __construct(string $templateView, string $subject, array $templateData)
    {
        $this->templateView = $templateView;
        $this->subject = $subject;
        $this->templateData = $templateData;
    }

    public function build()
    {
        return $this->view($this->templateView)
                    ->with($this->templateData)
                    ->subject($this->subject);
    }
}
