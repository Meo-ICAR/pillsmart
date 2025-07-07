<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MedicinesImport;

class ImportMedicinesFromCsv extends Command
{
    protected $signature = 'medicines:import {file}';
    protected $description = 'Import medicines from a CSV file using Laravel Excel';

    public function handle()
    {
        $file = $this->argument('file');
        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return 1;
        }
        Excel::import(new MedicinesImport, $file);
        $this->info('Medicines imported successfully!');
        return 0;
    }
}
