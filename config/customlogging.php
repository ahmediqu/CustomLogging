<?php /**
 * Custom Logging Configuration
 *
 * This configuration array is used to customize the behavior of the custom logging package in Laravel.
 *
 * @return array
 */
return [
    

    /**
     * Is Folder
     *
     * Indicates whether a folder structure should be used for organizing log files.
     * If set to `true`, log files will be organized into folders.
     */
    'is_directory' => true,

    /**
     * Folder Name
     *
     * The name of the folder where log files will be stored when 'is_folder' is set to `true`.
     * Leave it empty to use the default log folder.
     */
    'directory_name' => '',

    /**
     * Path Name
     *
     * The path name where log files will be stored when 'is_folder' is set to `false`.
     * Leave it empty to use the default Laravel log path.
     */
    'file_name' => '',

    /**
     * Is Upload to S3 Bucket
     *
     * Indicates whether log files should be uploaded to an Amazon S3 bucket.
     * Set to `true` if you want to upload logs to S3, otherwise set to `false`.
     */
    'is_upload_s3_bucket' => false,

    /**
     * AWS Destination Path
     *
     * The destination path in the S3 bucket where log files should be uploaded.
     * This is applicable only when 'is_upload_s3_bucket' is set to `true`.
     * Leave it empty to use the root of the S3 bucket.
     */
    'aws_destination_path' => '',
];
