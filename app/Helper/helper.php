<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function storeFile($file, $folderName){
    $filename = time() . "_" . $file->getclientoriginalname();
    $fileStore = $file->storeas($folderName, $filename);
    return $fileStore;
}

function storeBase64File($base64String,$folderName) {
    $array = explode(";",$base64String,2);
    $extension = explode('/',$array[0],2)[1];
    $file = explode(',',$array[1])[1];
    $file = base64_decode($file);
    $uniqueFileName = time().'_'.Str::random(10).'.'.$extension;
    Storage::disk('local')->put($folderName.'/'. $uniqueFileName, $file);
    return $folderName . '/' . $uniqueFileName;
}
