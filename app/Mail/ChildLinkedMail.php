<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChildLinkedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $parent;
    public $child;

    public function __construct($parent, $child)
    {
        $this->parent = $parent;
        $this->child = $child;
    }

    public function build()
    {
        return $this->subject('New Child Linked')->markdown('emails.child_linked');
    }
}
