<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserUnban extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
  

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('backend.Users.unlockUser')
            ->subject('Tài khoản mua sắm trên APCAKE đã được khôi phục')
            ->with([
                'user' => $this->user,
            ]);
    }
}