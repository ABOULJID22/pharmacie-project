<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $primaryKey = 'id_document';

    protected $fillable = [
        'nom_fichier', 'type', 'url_storage', 'file_path',
        'file_size', 'pages_count', 'status', 'date_upload', 'id_uploader'
    ];

    protected $casts = [
        'date_upload' => 'datetime',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'id_uploader');
    }

    public function partages()
    {
        return $this->hasMany(PartagesDocuments::class, 'id_document');
    }

    public function isFinished(): bool
{
    return $this->status === 'finished'; // adapte la condition à ton cas (par exemple, un champ `status`)
}

public function isValidated(): bool
{
    return $this->validated === true;
}

public function audits()
{
    return $this->hasMany(Audit::class, 'id_document', 'id_document');
}


}
