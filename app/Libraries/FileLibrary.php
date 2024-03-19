<?php

namespace App\Libraries;




class FileLibrary
{

    var $fileClass;

    public function __construct()
    {
    }
    public function uploadFile($file, $path, $name)
    {
        $extension = $file->getClientExtension();
        $fullName = $name . "." . $extension;
        $result = $file->move($path, $fullName);
        $return ['uploaded'] = $result;
        $return ['name'] = $fullName;
        return $return;
    }
}
