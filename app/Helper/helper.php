<?php
use Illuminate\Support\Facades\Storage;

function storeFile($file, $folderName){
    $filename = time() . "_" . $file->getclientoriginalname();
    $fileStore = $file->storeas($folderName, $filename);
    return $fileStore;
}


function storeBase64File($base64String,$fileName,$folderName) {
    $file = base64_decode($base64String);
    $uniqueFileName = time() . "_" . $fileName;
    $fileStore = Storage::disk('local')->put($folderName.'/'. $uniqueFileName, $file);
    return $folderName . '/' . $uniqueFileName;
}
