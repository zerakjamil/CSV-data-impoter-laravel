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
                User::insert([
                    $user
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
