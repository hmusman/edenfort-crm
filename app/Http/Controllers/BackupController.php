<?php

namespace App\Http\Controllers;

use Artisan;
use Exception;
use League\Flysystem\Adapter\Local;
use Log;
use Response;
use Storage;
use App\Models\permission;
use Request;


class BackupController extends Controller
{
    public function index()
    {
        $permissions = permission::where("user_id",session("user_id"))->first();

        $this->data['backups'] = [];

        foreach (config('backup.backup.destination.disks') as $disk_name) {
            $disk = Storage::disk($disk_name);
            $adapter = $disk->getDriver()->getAdapter();
            $files = $disk->allFiles();

            // make an array of backup files, with their filesize and creation date
            foreach ($files as $k => $f) {
                // only take the zip files into account
                if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                    $this->data['backups'][] = [
                        'file_path'     => $f,
                        'file_name'     => str_replace('backups/', '', $f),
                        'file_size'     => $disk->size($f),
                        'last_modified' => $disk->lastModified($f),
                        'disk'          => $disk_name,
                        'download'      => ($adapter instanceof Local) ? true : false,
                        ];
                }
            }
        }

        // reverse the backups, so the newest one would be on top
        $this->data['backups'] = array_reverse($this->data['backups']);
        $this->data['title'] = 'Backups';

        return view('backup', $this->data, compact('permissions'));
    }

    public function create()
    {
        try {
            ini_set('max_execution_time', 600);

            Log::info('Backpack\BackupManager -- Called backup:run from admin interface');

            Artisan::call('backup:run');

            Log::info("Backpack\BackupManager -- backup process has started");
        } catch (Exception $e) {
            Response::make($e->getMessage(), 500);
        }

        return back()->with("msg","<div class='alert alert-success'>Backup Created Successfully!</div>");
    }

    /**
     * Downloads a backup zip file.
     */
    public function download()
    {
        $disk = Storage::disk(Request::input('disk'));
        $file_name = Request::input('file_name');
        $adapter = $disk->getDriver()->getAdapter();

        if ($adapter instanceof Local) {
            $storage_path = $disk->getDriver()->getAdapter()->getPathPrefix();

            if ($disk->exists($file_name)) {
                return response()->download($storage_path.$file_name);
            } else {
                return back()->with("msg","<div class='alert alert-danger'>Backup not Found!</div>");
            }
        } else {
            return back()->with("msg","<div class='alert alert-danger'>Backup not Found!</div>");
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        $disk = Storage::disk(Request::input('disk'));

        if ($disk->exists($file_name)) {
            $disk->delete($file_name);
            return back()->with("msg","<div class='alert alert-success'>Backup Deleted Successfully!</div>");
        } else {
             return back()->with("msg","<div class='alert alert-danger'>Backup not Found!</div>");
        }
    }
}
