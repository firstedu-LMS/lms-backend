<?php
namespace App\Utils\FormatJsonForResponseService\Admin;
use App\Utils\FormatJsonForResponseService\JsonResponseInterface;

class AssignmentJson implements JsonResponseInterface{
    protected $datas;
    public function __construct($datas)
    {
        $this->datas = $datas;
    }
    public function format()
    {
        $formatDatas = [] ;
        foreach($this->datas as $data) {
            $formatItem = [
                "id" => $data->id,
                "title" => $data->title,
                "course" => $data->course->name,
                "batch" => $data->batch->name,
                "test_date" => $data->test_date,
                "test_time" => $data->test_time,
                "agenda" => $data->agenda,
                "file" => $data->file->file,
                "created_at" => $data->created_at
            ];
            $formatDatas[] = $formatItem;
        }
        return $formatDatas;
    }
    public function getJson()
    {
        return $this->format();
    }
}