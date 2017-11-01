<?php
namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUpload{

    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        // ORIGINAL FILE
        //$file_name = empty($file->getClientOriginalName()) ? md5(uniqid()).'.'.$file->guessExtension() : $file->getClientOriginalName();
        $file_name = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->targetDir, $file_name);
        return $file_name;
    }
}