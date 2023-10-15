<?php

namespace App\Helper;


function storeFile($file){
    $filename = time() . "_" . $file->getclientoriginalname();
    $fileStore = $file->storeas('videos', $filename);
    return $fileStore;
}
