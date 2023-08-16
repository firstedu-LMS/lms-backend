<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup {dbName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'model name to backup as .sql file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $modelName = 'App\\Models\\' . Str::studly($this->argument('dbName'));
        $collection = $modelName::all();
        $i = 0;
        $arryLength = count($collection);
        foreach ($collection as $index => $object) {
            $i = $index;
            $data = json_decode($object, true);
            $tableName = Str::snake($this->argument('dbName')) . "s";
            $columns = "`" . implode("`, `", array_keys($data)) . "`";
            $values = [];

            foreach ($data as $value) {
                if ($value === null) {
                    $values[] = "NULL";
                } else {
                    $values[] = "'" . $value . "'";
                }
            }

            $valuesString = implode(", ", $values);
            $filePath =  base_path('app') . DIRECTORY_SEPARATOR . "backup" . DIRECTORY_SEPARATOR . Str::studly($this->argument('dbName')) . "Backup.sql";
            $dir =  base_path('app') . DIRECTORY_SEPARATOR . "backup";

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
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
