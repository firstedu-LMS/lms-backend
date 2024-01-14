<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
function storeFile($file, $folderName){
    $filename = time() . "_" . $file->getclientoriginalname();
    $fileStore = $file->storeas($folderName, $filename);
    return $fileStore;
}

function storeBase64File($base64String,$folderName) {
    $file = base64_decode($base64String);
    $uniqueFileName = time().'_'.Str::random(10).'.png';
    Storage::disk('local')->put($folderName.'/'. $uniqueFileName, $file);
    return $folderName . '/' . $uniqueFileName;
}
