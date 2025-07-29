<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CleanExpiredFiles extends Command
{
    protected $signature = 'files:clean-expired';
    protected $description = 'Delete expired uploaded files (older than 30 days)';

    public function handle()
    {
        $metaFiles = Storage::disk('local')->files('meta');

        foreach ($metaFiles as $metaPath) {
            $meta = json_decode(Storage::disk('local')->get($metaPath), true);
            if (!isset($meta['expires_at'])) continue;

            $expiresAt = Carbon::parse($meta['expires_at']);
            if (Carbon::now()->greaterThan($expiresAt)) {
                $name = basename($metaPath, '.json');
                $filePath = "files/{$name}";

                Storage::disk('local')->delete([$filePath, $metaPath]);
                Log::info("Deleted expired file: {$filePath}");
            }
        }

        return Command::SUCCESS;
    }
}
