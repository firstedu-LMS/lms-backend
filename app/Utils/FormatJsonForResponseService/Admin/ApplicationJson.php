<?php

namespace App\Utils\FormatJsonForResponseService\Admin;
use App\Utils\FormatJsonForResponseService\JsonResponseInterface;

class ApplicationJson implements JsonResponseInterface {
    protected $datas;
    public function __construct($datas) {
        $this->datas = $datas;
    }
    public function format()
    {
        $formatData = [];
        foreach($this->datas as $data) {
            $formatItem = [
               "id" => $data->id,
               "email" => $data->email,
               "career" => $data->career,
               "cv" => $data->cv->cv,
               "created_at" => $data->created_at
            ];
            $formatData[]= $formatItem;
        }
        return $formatData;
    }
    public function getJson()
    {
        return $this->format();
    }
}
