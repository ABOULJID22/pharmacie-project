<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
    protected $primaryKey = 'id_question';

    protected $fillable = ['question', 'reponse', 'cible', 'visible', 'date_creation'];

    protected $casts = [
        'visible' => 'boolean',
        'date_creation' => 'datetime',
    ];
}
