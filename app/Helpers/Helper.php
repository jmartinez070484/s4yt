<?php 

namespace App\Helpers;

class Helper {

	/*

        Return script

    */
    static function fileVersion($file = null){
        $fileVersion = null;

        if($file){
            $scriptPath = public_path().$file;
            
            if(file_exists($scriptPath)){
                $fileVersion = $file.'?v='.filemtime($scriptPath);
            }
        }

        return $fileVersion;
    }
}