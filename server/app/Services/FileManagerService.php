<?php

namespace App\Services;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Storage;

class FileManagerService {
    protected $disk;

    public function __construct(){
        $this->disk = Storage::disk(config("filesystems.default"));
    }

    public function putFile($path, $request)
    {
        return $this->disk->putFile("$path",$request);
    }

    public function delete($path)
    {
        return $this->disk->delete($path);
    }
}




