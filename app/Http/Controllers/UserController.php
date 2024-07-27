<?php
namespace App\Http\Controllers;

use App\Jobs\ProcessUserChunk;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Bus;

class UserController extends Controller
{
    public function import(): JsonResponse
    {
        $file = database_path('users-100.csv');
        $data = array_map('str_getcsv', file($file));

        $headers = array_shift($data);
        // Remove the 'Index' column
        array_shift($headers);

        $chunks = array_chunk($data, 10);

        $batch = Bus::batch([])->dispatch();

        foreach ($chunks as $chunk) {
            $users = array_map(function($user) use ($headers) {
                array_shift($user);
                return array_combine($headers, $user);
            }, $chunk);

            ProcessUserChunk::dispatch($users)->onQueue('default')->chain([
                new ProcessUserChunk($users)
            ]);
        }

        return response()->json(['batch_id' => $batch->id]);
    }

    public function checkBatchStatus($batchId): JsonResponse
    {
        $batch = Bus::findBatch($batchId);

        if ($batch->finished()) {
            return response()->json(['status' => 'finished']);
        }

        return response()->json(['status' => 'not finished']);
    }
}
