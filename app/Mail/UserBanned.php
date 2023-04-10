<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserBanned extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $bannedDays;
    public $unbanDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $bannedDays, $unbanDate)
    {
        $this->user = $user;
        $this->bannedDays = $bannedDays;
        $this->unbanDate = $unbanDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('backend.Users.email')
            ->subject('Tài khoản mua sắm trên APCAKE đã bị khóa')
            ->with([
                'user' => $this->user,
                'bannedDays' => $this->bannedDays,
                'unbanDate' => $this->unbanDate,
            ]);
    }
}