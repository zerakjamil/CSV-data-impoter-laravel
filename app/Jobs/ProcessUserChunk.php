<?php
namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessUserChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function handle()
    {
        try {
            foreach ($this->users as $user) {
                User::create([
                    'user_id' => $user['User Id'],
                    'first_name' => $user['First Name'],
                    'last_name' => $user['Last Name'],
                    'sex' => $user['Sex'],
                    'email' => $user['Email'],
                    'phone' => $user['Phone'],
                    'date_of_birth' => $user['Date of birth'],
                    'job_title' => $user['Job Title'],
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to process user chunk', [
                'error' => $e->getMessage(),
                'users' => $this->users,
            ]);
            throw $e;
        }
    }
}
