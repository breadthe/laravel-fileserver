<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteLivewireTmpFilesCommand extends Command
{
    protected $signature = 'livewire:delete-tmp-files
        {older-than=20 : Delete files older than XX minutes}
    ';

    protected $description = 'Deletes temp files created by Livewire';

    public function handle()
    {
        $path = 'livewire-tmp';
        $olderThanMinutes = $this->argument('older-than');
        if ($olderThanMinutes < 1) {
            $olderThanMinutes = 1;
        }

        if (Storage::disk('local')->exists($path)) {
            $files = Storage::disk('local')->files($path);

            if ($files) {
                foreach ($files as $file) {
                    $lastModifiedDate = Carbon::createFromTimestamp(Storage::disk('local')->lastModified($file));

                    if ((int)$lastModifiedDate->diff()->i > $olderThanMinutes) {
                        $this->info("📄 Deleting <fg=magenta>{$file}</> created <fg=yellow>{$lastModifiedDate->diffForHumans()}</>");
                        Storage::disk('local')->delete($file);
                    }
                }

                $this->info('🏁 Done deleting!');
            } else {
                $this->info('🤷‍♀️ Nothing to delete.');
            }
        }

        return 0;
    }
}
