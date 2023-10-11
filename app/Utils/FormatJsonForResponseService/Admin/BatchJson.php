<?php

namespace App\Utils\FormatJsonForResponseService\Admin;

use App\Utils\FormatJsonForResponseService\JsonResponseInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchJson  extends JsonResource implements JsonResponseInterface {
    protected $data = [];
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function format()
    {
        $formatDatas = [];
        $isCollection = is_a($this->data,'Illuminate\Database\Eloquent\Collection');
        logger($isCollection);
        if ($isCollection) {
            foreach($this->datas as $data) {
               $formatDatas[] =  $this->preFormat($data);
            }
            logger('co');
            logger($formatDatas);
            return $formatDatas;
        }else {
            logger('obj');
            logger($this->preFormat($this->data));
            return $this->preFormat($this->data);
        }
    }

    public function preFormat ($data){
        return  [
            "id" => $data->id,
            "name" => $data->name,
            "course" => $data->name,
            "instructor" => $data->instructor->user->name,
            "start_date" => $data->start_date,
            "end_date" => $data->end_date,
            "stutus" => $data->status,
            "created_at" => $data->created_at,
        ];
    }

    public function getJson()
    {
        return $this->format();
    }
}