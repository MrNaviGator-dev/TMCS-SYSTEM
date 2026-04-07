<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SyncStorageFiles extends Command
{
    protected $signature = 'storage:sync';
    protected $description = 'Sync files from storage/app/public to public/storage';

    public function handle()
    {
        $this->info('Syncing storage files...');
        
        $source = storage_path('app/public');
        $destination = public_path('storage');
        
        // Ensure destination exists
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        
        // Copy all files and directories
        $this->copyDirectory($source, $destination);
        
        $this->info('Storage files synced successfully!');
        
        return 0;
    }
    
    private function copyDirectory($source, $destination)
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        
        $files = scandir($source);
        
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $sourcePath = $source . '/' . $file;
                $destPath = $destination . '/' . $file;
                
                if (is_dir($sourcePath)) {
                    $this->copyDirectory($sourcePath, $destPath);
                } else {
                    copy($sourcePath, $destPath);
                }
            }
        }
    }
}
