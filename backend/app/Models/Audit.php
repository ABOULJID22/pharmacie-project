<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audits';
    protected $primaryKey = 'id_audit';
    public $timestamps = false;

    protected $fillable = [
        'id_demandeur',
         'id_document',
        'objet',
        'statut',
        'rapport',
        'date_demande',
        'date_realisation',
         'reponse',
        'date_reponse',
    ];

    protected $casts = [
        'date_demande' => 'datetime',
        'date_realisation' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur demandeur de l'audit
     */
    public function demandeur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_demandeur', 'id_user');
    }


    public function document(): BelongsTo
{
    return $this->belongsTo(Document::class, 'id_document', 'id_document');
}

}
