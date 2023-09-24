<?php
namespace App\Utils\FormatJsonForResponseService;

interface JsonResponseInterface {
    public function format();
    public function getJson();
}