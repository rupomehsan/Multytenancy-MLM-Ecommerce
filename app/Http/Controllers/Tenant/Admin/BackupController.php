<?php

namespace App\Http\Controllers\Tenant\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use ZipArchive;
use File;
use App\Http\Controllers\Controller;

class BackupController extends Controller
{

    /**
     * Return the first non-empty public directory from a list of candidate names.
     * Each candidate is interpreted relative to public_path().
     * Returns full path or null if none found.
     */
    private function locatePublicDir(array $candidates)
    {
        foreach ($candidates as $cand) {
            $dir = public_path($cand);
            if (File::isDirectory($dir) && count(File::files($dir)) > 0) {
                return $dir;
            }
        }

        return null;
    }

    /**
     * Create a reliable ZIP backup of files from a directory
     * Returns download response or redirects back with error
     */
    private function createBackupZip($sourceDir, $zipFileName, $errorMessage = 'No files found')
    {
        if (!File::isDirectory($sourceDir)) {
            Toastr::error($errorMessage, 'Error');
            return back();
        }

        $files = File::files($sourceDir);

        if (count($files) === 0) {
            Toastr::error($errorMessage, 'Error');
            return back();
        }

        // Store ZIP in storage/app/backups
        $storagePath = storage_path('app/backups');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        $zipPath = $storagePath . '/' . $zipFileName;

        // Remove old zip if exists and wait a bit
        if (file_exists($zipPath)) {
            @unlink($zipPath);
            clearstatcache();
            usleep(50000); // 0.05 seconds
        }

        $zip = new ZipArchive();
        $openResult = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        if ($openResult !== true) {
            Toastr::error('Failed to create ZIP file. Error: ' . $openResult, 'Error');
            return back();
        }

        $fileCount = 0;

        foreach ($files as $file) {
            try {
                $filePath = $file->getRealPath();

                if (!file_exists($filePath) || !is_readable($filePath) || !is_file($filePath)) {
                    continue;
                }

                // Use just the filename, not full path
                $result = $zip->addFile($filePath, basename($filePath));

                if ($result) {
                    $fileCount++;
                }
            } catch (\Exception $e) {
                // Skip files that cause errors
                continue;
            }
        }

        // Critical: ensure ZIP is closed properly
        if (!$zip->close()) {
            Toastr::error('Failed to finalize ZIP file', 'Error');
            return back();
        }

        // Clear stat cache after closing
        clearstatcache();

        // Wait for filesystem to sync
        usleep(100000); // 0.1 seconds

        if ($fileCount === 0) {
            if (file_exists($zipPath)) {
                @unlink($zipPath);
            }
            Toastr::error($errorMessage, 'Error');
            return back();
        }

        // Verify ZIP exists and has valid size
        if (!file_exists($zipPath)) {
            Toastr::error('ZIP file was not created', 'Error');
            return back();
        }

        $fileSize = filesize($zipPath);
        if ($fileSize < 22) {
            @unlink($zipPath);
            Toastr::error('ZIP file is corrupted (too small)', 'Error');
            return back();
        }

        // Final validation: try to open the ZIP to verify it's valid
        $testZip = new ZipArchive();
        $testResult = $testZip->open($zipPath, ZipArchive::CHECKCONS);

        if ($testResult !== true) {
            @unlink($zipPath);
            Toastr::error('ZIP file validation failed. Error: ' . $testResult, 'Error');
            return back();
        }
        $testZip->close();

        // Return download response
        return response()->download($zipPath, $zipFileName, [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
        ])->deleteFileAfterSend(true);
    }

    public function downloadDBBackup()
    {

        $tables = array();
        $allTables = DB::select('SHOW TABLES');
        foreach ($allTables as $table) {
            foreach ($table as $key => $value)
                $tables[] = $value;
        }

        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = '';
        foreach ($tables as $table) {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            foreach ($show_table_result as $show_table_row) {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }

            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            for ($count = 0; $count < $total_row; $count++) {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
            }
        }

        $file_name = 'database_backup.sql';
        $file_handle = fopen(public_path($file_name), 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        return response()->download(public_path($file_name));
        // header('Content-Description: File Transfer');
        // header('Content-Type: application/octet-stream');
        // header('Content-Disposition: attachment; filename=' . basename($file_name));
        // header('Content-Transfer-Encoding: binary');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate');
        // header('Pragma: public');
        // header('Content-Length: ' . filesize($file_name));
        // ob_clean();
        // flush();
        // readfile($file_name);
        // unlink($file_name);
    }

    public function downloadProductFilesBackup()
    {
        $productDir = $this->locatePublicDir([
            'uploads/productImages',
            'productImages',
            'uploads/productiamges',
        ]);

        if (is_null($productDir)) {
            Toastr::error('No Product Images Found', 'Error');
            return back();
        }

        return $this->createBackupZip($productDir, 'ProductImagesBackup.zip', 'No Product Images Found');
    }

    public function downloadUserFilesBackup()
    {
        $userDir = $this->locatePublicDir([
            'uploads/userProfileImages',
            'userProfileImages',
            'uploads/userprofileimages',
        ]);

        if (is_null($userDir)) {
            Toastr::error('No User Images Found', 'Error');
            return back();
        }

        return $this->createBackupZip($userDir, 'UserImagesBackup.zip', 'No User Images Found');
    }

    public function downloadBannerFilesBackup()
    {
        $dir = $this->locatePublicDir(['uploads/banner_img', 'banner', 'uploads/banner']);
        if (is_null($dir)) {
            Toastr::error('No Banner Images Found', 'Error');
            return back();
        }

        return $this->createBackupZip($dir, 'BannerImagesBackup.zip', 'No Banner Images Found');
    }

    public function downloadCategoryFilesBackup()
    {
        $dir = $this->locatePublicDir(['uploads/category_images', 'category_images']);
        if (is_null($dir)) {
            Toastr::error('No Category Images Found', 'Error');
            return back();
        }

        return $this->createBackupZip($dir, 'CategoryImagesBackup.zip', 'No Category Images Found');
    }

    public function downloadSubcategoryFilesBackup()
    {
        $dir = $this->locatePublicDir(['uploads/subcategory_images', 'subcategory_images']);
        if (is_null($dir)) {
            Toastr::error('No Subcategory Images Found', 'Error');
            return back();
        }

        return $this->createBackupZip($dir, 'SubcategoryImagesBackup.zip', 'No Subcategory Images Found');
    }

    public function downloadTicketFilesBackup()
    {
        $dir = $this->locatePublicDir(['uploads/support_ticket_attachments', 'support_ticket_attachments']);
        if (is_null($dir)) {
            Toastr::error('No Ticket Attachments Found', 'Error');
            return back();
        }

        return $this->createBackupZip($dir, 'TicketFilesBackup.zip', 'No Ticket Files Found');
    }

    public function downloadBlogFilesBackup()
    {
        $dir = $this->locatePublicDir(['uploads/blogImages', 'blogImages']);
        if (is_null($dir)) {
            Toastr::error('No Blog Images Found', 'Error');
            return back();
        }

        return $this->createBackupZip($dir, 'BlogFilesBackup.zip', 'No Blog Images Found');
    }

    public function downloadOtherFilesBackup()
    {
        $dir = $this->locatePublicDir(['uploads/images', 'images']);
        if (is_null($dir)) {
            Toastr::error('No Other Images Found', 'Error');
            return back();
        }

        return $this->createBackupZip($dir, 'OtherImagesBackup.zip', 'No Other Images Found');
    }

    public function downloadFlagFilesBackup()
    {
        $dir = $this->locatePublicDir(['uploads/flag_icons', 'flag_icons']);
        if (is_null($dir)) {
            Toastr::error('No Flag Icons Found', 'Error');
            return back();
        }

        return $this->createBackupZip($dir, 'FlagImagesBackup.zip', 'No Flag Icons Found');
    }

    public function downloadAllImagesBackup()
    {
        $uploadsPath = public_path('uploads');

        // Check if uploads directory exists
        if (!File::isDirectory($uploadsPath)) {
            Toastr::error('Uploads directory not found', 'Error');
            return back();
        }

        $timestamp = date('Y-m-d_H-i-s');
        $masterZipName = 'AllImagesBackup_' . $timestamp . '.zip';

        // Store ZIP in storage/app to avoid scanning it
        $storagePath = storage_path('app/backups');

        // Create backup directory if not exists
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        $masterZipPath = $storagePath . '/' . $masterZipName;

        // Remove old zip if exists
        if (file_exists($masterZipPath)) {
            @unlink($masterZipPath);
        }

        $zip = new ZipArchive();
        $result = $zip->open($masterZipPath, ZipArchive::CREATE);

        if ($result !== true) {
            Toastr::error('Cannot create ZIP file. Error code: ' . $result, 'Error');
            return back();
        }

        $hasFiles = false;
        $fileCount = 0;

        // Get all subdirectories in uploads folder
        $directories = File::directories($uploadsPath);

        foreach ($directories as $dir) {
            $folderName = basename($dir);

            // Get all files in this subdirectory
            if (!File::isDirectory($dir)) {
                continue;
            }

            $files = File::allFiles($dir); // Use allFiles to get files recursively

            foreach ($files as $file) {
                $filePath = $file->getRealPath();

                // Skip if not readable or is a directory
                if (!is_file($filePath) || !is_readable($filePath)) {
                    continue;
                }

                // Get relative path from the subdirectory
                $relativePath = $file->getRelativePathname();

                // Create proper path in ZIP: foldername/relativepath
                $zipPath = $folderName . '/' . $relativePath;

                // Normalize path separators for cross-platform compatibility
                $zipPath = str_replace('\\', '/', $zipPath);

                if ($zip->addFile($filePath, $zipPath)) {
                    $hasFiles = true;
                    $fileCount++;
                }
            }
        }

        // Close the zip file - MUST close before any file operations
        if (!$zip->close()) {
            Toastr::error('Failed to finalize ZIP file', 'Error');
            return back();
        }

        // Clear file stat cache
        clearstatcache();

        if (!$hasFiles) {
            if (file_exists($masterZipPath)) {
                @unlink($masterZipPath);
            }
            Toastr::error('No files found in uploads subdirectories', 'Error');
            return back();
        }

        // Verify the ZIP was created and is valid
        if (!file_exists($masterZipPath)) {
            Toastr::error('ZIP file creation failed', 'Error');
            return back();
        }

        $fileSize = filesize($masterZipPath);
        if ($fileSize < 22) {
            @unlink($masterZipPath);
            Toastr::error('ZIP file is too small (corrupted)', 'Error');
            return back();
        }

        // Test if ZIP can be opened
        $testZip = new ZipArchive();
        if ($testZip->open($masterZipPath, ZipArchive::CHECKCONS) !== true) {
            @unlink($masterZipPath);
            Toastr::error('ZIP file is corrupted and cannot be opened', 'Error');
            return back();
        }
        $testZip->close();

        Toastr::success('Backup created: ' . $fileCount . ' files (' . round($fileSize / 1024 / 1024, 2) . ' MB)', 'Success');

        // Download the file
        return response()->download($masterZipPath, $masterZipName, [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }
}
