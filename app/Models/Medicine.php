<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'codice_aic',
        'cod_farmaco',
        'cod_confezione',
        'denominazione',
        'descrizione',
        'codice_ditta',
        'ragione_sociale',
        'stato_amministrativo',
        'tipo_procedura',
        'forma',
        'codice_atc',
        'pa_associati',
        'link',
    ];
}
