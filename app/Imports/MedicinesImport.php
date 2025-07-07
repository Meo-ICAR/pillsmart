<?php

namespace App\Imports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;

class MedicinesImport implements ToModel, WithHeadingRow, WithChunkReading, WithValidation
{
    public function model(array $row)
    {
        return new Medicine([
            'codice_aic' => $row['codice_aic'],
            'cod_farmaco' => $row['cod_farmaco'] ?? null,
            'cod_confezione' => $row['cod_confezione'] ?? null,
            'denominazione' => $row['denominazione'] ?? null,
            'descrizione' => $row['descrizione'] ?? null,
            'codice_ditta' => $row['codice_ditta'] ?? null,
            'ragione_sociale' => $row['ragione_sociale'] ?? null,
            'stato_amministrativo' => $row['stato_amministrativo'] ?? null,
            'tipo_procedura' => $row['tipo_procedura'] ?? null,
            'forma' => $row['forma'] ?? null,
            'codice_atc' => $row['codice_atc'] ?? null,
            'pa_associati' => $row['pa_associati'] ?? null,
            'link' => $row['link'] ?? null,
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'codice_aic' => 'required',
        ];
    }
}
