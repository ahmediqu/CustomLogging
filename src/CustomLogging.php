<?php

namespace CustomLogCreator\CustomLogging;
use Illuminate\Support\Facades\Storage;
class CustomLogging
{
    // Build wonderful things
    public function uploadLog()
    {
        $s3Disk = Storage::disk('s3');
        $sourceDirectory = storage_path('logs');
        $destinationPath = config('customlogging.aws_destination_path') ?: 'Logs/web_server';

        // Get a list of log files in the storage/logs directory
        $logFiles = glob($sourceDirectory . '/*.log');
       

        foreach ($logFiles as $logFile) {
            $filename = basename($logFile);
                
                $s3Disk->put($destinationPath . $filename, file_get_contents($logFile));
                info("Uploaded $filename to S3");
        }

        info('Log files uploaded to S3 successfully.');

    }
}