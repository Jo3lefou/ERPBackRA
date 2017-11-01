<?php 
namespace AppBundle\Services;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class FileRemove{

    private $targetDir;

    public function __construct($targetDir) {
        $this->targetDir = $targetDir;
    }
    
    public function removeFile($path) {
        $fs = new Filesystem();
        $file = $this->targetDir . '/' . $path;
        try{
            if($fs->exists($file)){
                $fs->remove($file);
                return true;
            }
            return false;
        } catch(IOExceptionInterface $e){
            //log error for $e->getPath();
        }
    }
}