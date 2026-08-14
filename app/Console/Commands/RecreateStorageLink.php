<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class RecreateStorageLink extends Command
{
    protected $signature = 'storage:recreate';
    protected $description = 'Recreate the storage symbolic link';

    public function handle()
    {
        $filesystem = new Filesystem();
        
        $publicPath = public_path('storage');
        $targetPath = storage_path('app/public');
        
        // Remove existing link/directory
        if ($filesystem->exists($publicPath)) {
            $filesystem->deleteDirectory($publicPath);
            $this->info('Removed existing storage link/directory.');
        }
        
        // Create target directory if it doesn't exist
        if (!$filesystem->exists($targetPath)) {
            $filesystem->makeDirectory($targetPath, 0755, true);
            $this->info('Created target directory.');
        }
        
        // Create the symbolic link
        if ($filesystem->link($targetPath, $publicPath)) {
            $this->info('Storage link created successfully.');
        } else {
            $this->error('Failed to create storage link.');
        }
    }
}