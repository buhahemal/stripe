<?php

namespace App\Service;
class FileService {
    public function addMedia($file,$path)
    {
        $fileName = time() . "." . $file->getClientOriginalExtension();
        $file->move($path, $fileName);
        return $fileName;
    }
}

?>