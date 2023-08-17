<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Backup extends Command
{
    protected $signature = 'backup {dbName}';

    protected $description = 'model name to backup as .sql file';

    protected function filterNull($data)
    {
        $values = [];
        foreach ($data as $value) {
            if ($value === null) {
                $values[] = "NULL";
            } else {
                $values[] = "'" . $value . "'";
            }
        }
        return $values;
    }

    protected function createDir($path): void
    {
        mkdir($path, 0777, true);
    }


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //This code is to resolve import model issue
        $modelName = 'App\\Models\\' . Str::studly($this->argument('dbName'));
        $filePath =  base_path('app') . DIRECTORY_SEPARATOR . "backup" . DIRECTORY_SEPARATOR . Str::studly($this->argument('dbName')) . "Backup.sql";
        $dirPath =  base_path('app') . DIRECTORY_SEPARATOR . "backup";
        $tableName = Str::snake($this->argument('dbName')) . "s";
        $collection = $modelName::all();

        //This $i is used to track the index of $collection
        $i = 0;
        $arryLength = count($collection);

        foreach ($collection as $index => $object) {
            $i = $index;
            $data = json_decode($object, true);
            $columns = "`" . implode("`, `", array_keys($data)) . "`";

            $valuesString = implode(", ", $this->filterNull($data));

            if (!is_dir($dirPath)) {
                $this->createDir($dirPath);
            }

            if (!file_exists($filePath)) {
                $header  = "INSERT INTO `$tableName` ($columns) VALUES\n";
                file_put_contents($filePath, $header, FILE_APPEND);
            }

            if ($i == $arryLength - 1) {
                $sql = "  ($valuesString);" . "\n";
            } else {
                $sql = "  ($valuesString)," . "\n";
            }

            file_put_contents($filePath, $sql, FILE_APPEND);
        }
    }
}
