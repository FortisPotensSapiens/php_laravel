<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class DeleteExpiredFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         Log::info("Deleted expired files! EEEEE! MAIN");
        $expiredFiles = File::where('expires_at', '<', now())->get();

        foreach ($expiredFiles as $file) {
            Storage::delete('files/' . $file->generated_name);
            $file->delete();
        }

        $this->info('Expired files deleted successfully.');
    }
}
