<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartagesDocuments extends Model
{
    protected $primaryKey = 'id_partage';
    public $timestamps = false;
    protected $table = 'partages_documents';

    protected $fillable = [
        'id_document', 'id_user', 'date_partage', 'statut_lecture'
    ];

    protected $casts = [
        'date_partage' => 'datetime',
        'statut_lecture' => 'boolean',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'id_document');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
