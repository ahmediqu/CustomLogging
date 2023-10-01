# Laravel Custom Logging Package


### Documentation, Installation, and Usage Instructions


## Installation



Via Composer

``` bash
$ composer require customlogcreator/customlogging
```


``` bash
$ php artisan vendor:publish --tag=customlogging
```
### added app/config.php

```
$ CustomLogCreator\CustomLogging\CustomLoggingServiceProvider::class,

```
### Usage Instructions
```
Log::channel('dynamic_logs')->info('Log message here');
```
## Configuration
In the custom-logging.php configuration file, you can customize the behavior of the package by modifying the provided configuration array. Here are the configuration options:

- namespace: The namespace where custom log handlers and formatters are located.

- is_folder: Indicates whether a folder structure should be used for organizing log files.

- folder_name: The name of the folder where log files will be stored when 'is_folder' is set to true.

- path_name: The path name where log files will be stored when 'is_folder' is set to false.

- is_upload_s3_bucket: Indicates whether log files should be uploaded to an Amazon S3 bucket.

- aws_destination_path: The destination path in the S3 bucket where log files should be uploaded. This is applicable only when 'is_upload_s3_bucket' is set to true.

###### config/customlogging.php






```
return [
    'namespace' => 'App\CustomLogging',
    'is_folder' => true,
    'folder_name' => '',
    'path_name' => '',
    'is_upload_s3_bucket' => false,
    'aws_destination_path' => '',
];
```