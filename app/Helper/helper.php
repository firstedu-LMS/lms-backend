<?php

namespace App\Helper;


function storeFile($file,$folderName){
    $filename = time() . "_" . $file->getclientoriginalname();
    $fileStore = $file->storeas($folderName, $filename);
    return $fileStore;
}
