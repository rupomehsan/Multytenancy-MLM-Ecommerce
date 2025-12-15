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
        $zip = new ZipArchive;
        $fileName = 'ProductImagesBackup.zip';

        // Try a list of possible locations for product images so backups still work
        // if files are stored under a tenant/admin subfolder (as you've created).
        $possible = [
            public_path('uploads/productImages'),
            public_path('productImages'),
            public_path('tenant/admin/productImages'),
            public_path('tenant/admin/productiamges'), // tolerate common typo
        ];

        $productDir = null;
        foreach ($possible as $dir) {
            if (File::isDirectory($dir) && count(File::files($dir)) > 0) {
                $productDir = $dir;
                break;
            }
        }

        if (is_null($productDir)) {
            Toastr::error('No Product Images Found in expected locations', 'Error');
            return back();
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files($productDir);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        // return response()->download(public_path($fileName));
        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        } else {
            Toastr::error('No Product Images Found', 'Success');
            return back();
        }
    }

    public function downloadUserFilesBackup()
    {
        $zip = new ZipArchive;
        $fileName = 'UserImagesBackup.zip';
        // Try several likely locations for user profile images (support tenant/admin path)
        $possible = [
            public_path('userProfileImages'),
            public_path('tenant/admin/userProfileImages'),
            public_path('tenant/admin/userprofileimages'),
            public_path('tenant/admin/userProfileimages'),
        ];

        $userDir = null;
        foreach ($possible as $dir) {
            if (File::isDirectory($dir) && count(File::files($dir)) > 0) {
                $userDir = $dir;
                break;
            }
        }

        if (is_null($userDir)) {
            Toastr::error('No User Images Found in expected locations', 'Error');
            return back();
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files($userDir);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        } else {
            Toastr::error('Failed to create user images backup', 'Error');
            return back();
        }
    }

    public function downloadBannerFilesBackup()
    {
        $zip = new ZipArchive;
        $fileName = 'BannerImagesBackup.zip';
        $dir = $this->locatePublicDir(['banner', 'tenant/admin/banner']);
        if (is_null($dir)) {
            Toastr::error('No Banner Images Found in expected locations', 'Error');
            return back();
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files($dir);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        } else {
            Toastr::error('Failed to create banner images backup', 'Error');
            return back();
        }
    }

    public function downloadCategoryFilesBackup()
    {
        $zip = new ZipArchive;
        $fileName = 'CategoryImagesBackup.zip';
        $dir = $this->locatePublicDir(['category_images', 'tenant/admin/category_images']);
        if (is_null($dir)) {
            Toastr::error('No Category Images Found in expected locations', 'Error');
            return back();
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files($dir);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        } else {
            Toastr::error('Failed to create category images backup', 'Error');
            return back();
        }
    }

    public function downloadSubcategoryFilesBackup()
    {
        $zip = new ZipArchive;
        $fileName = 'SubcategoryImagesBackup.zip';
        $dir = $this->locatePublicDir(['subcategory_images', 'tenant/admin/subcategory_images']);
        if (is_null($dir)) {
            Toastr::error('No Subcategory Images Found in expected locations', 'Error');
            return back();
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files($dir);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        } else {
            Toastr::error('Failed to create subcategory images backup', 'Error');
            return back();
        }
    }

    public function downloadTicketFilesBackup()
    {
        $zip = new ZipArchive;
        $fileName = 'TicketFilesBackup.zip';
        $dir = $this->locatePublicDir(['support_ticket_attachments', 'tenant/admin/support_ticket_attachments']);
        if (is_null($dir)) {
            Toastr::error('No Ticket Attachments Found in expected locations', 'Error');
            return back();
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files($dir);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        } else {
            Toastr::error('Failed to create ticket files backup', 'Error');
            return back();
        }
    }

    public function downloadBlogFilesBackup()
    {
        $zip = new ZipArchive;
        $fileName = 'BlogFilesBackup.zip';
        $dir = $this->locatePublicDir(['blogImages', 'tenant/admin/blogImages']);
        if (is_null($dir)) {
            Toastr::error('No Blog Images Found in expected locations', 'Error');
            return back();
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files($dir);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        } else {
            Toastr::error('Failed to create blog images backup', 'Error');
            return back();
        }
    }

    public function downloadOtherFilesBackup()
    {
        $zip = new ZipArchive;
        $fileName = 'OtherImagesBackup.zip';
        $dir = $this->locatePublicDir(['images', 'tenant/admin/images']);
        if (is_null($dir)) {
            Toastr::error('No Other Images Found in expected locations', 'Error');
            return back();
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files($dir);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        } else {
            Toastr::error('Failed to create other images backup', 'Error');
            return back();
        }
    }

    public function downloadFlagFilesBackup()
    {
        $zip = new ZipArchive;
        $fileName = 'FlagImagesBackup.zip';
        $dir = $this->locatePublicDir(['flag_icons', 'tenant/admin/flag_icons']);
        if (is_null($dir)) {
            Toastr::error('No Flag Icons Found in expected locations', 'Error');
            return back();
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files($dir);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        } else {
            Toastr::error('Failed to create flag icons backup', 'Error');
            return back();
        }

        // $storagePath = storage_path('app');
        // $zipFileName = 'storage.zip';
        // $zipFilePath = storage_path($zipFileName);

        // // Create a new zip archive
        // $zip = new ZipArchive;
        // if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        //     // Add all files and directories in the storage folder to the zip archive
        //     $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($storagePath));
        //     foreach ($files as $file) {
        //         if (!$file->isDir()) {
        //             $filePath = $file->getRealPath();
        //             $relativePath = 'storage/' . substr($filePath, strlen($storagePath) + 1);
        //             $zip->addFile($filePath, $relativePath);
        //         }
        //     }

        //     // Close the zip archive
        //     $zip->close();

        //     // Set appropriate headers for the download
        //     $headers = [
        //         'Content-Type' => 'application/octet-stream',
        //         'Content-Disposition' => 'attachment; filename=' . $zipFileName,
        //     ];

        //     // Return the zip file as a response
        //     return response()->download($zipFilePath, $zipFileName, $headers);
        // }
        // return back()->with('error', 'Failed to create the zip archive.');
    }
}
