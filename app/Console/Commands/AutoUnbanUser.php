<?php

namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserUnban;
class AutoUnbanUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ban:updateUnban';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update User Unban status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('banned_until', '<>', null)->where('banned_until', '<=', now())->get();

        foreach ($users as $user) {
            $user->banned_until = null;
            $user->save();
            Mail::to($user->email)->send(new UserUnban($user));
    }
}
}
