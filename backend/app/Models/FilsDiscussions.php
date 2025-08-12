<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilsDiscussions extends Model
{
    protected $primaryKey = 'id_fils';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'fils_discussions';

    

    protected $fillable = ['sujet', 'id_createur','id_participant','date_creation'];

    protected $casts = [
        'date_creation' => 'datetime',
    ];

    public function createur()
    {
        return $this->belongsTo(User::class, 'id_createur');
    }
public function participant()
{
    return $this->belongsTo(User::class, 'id_participant');
}
    public function messages()
    {
        return $this->hasMany(Message::class, 'id_fils');
    }

    public function markInProgress(): void
    {
        $this->status = 'in_progress';
        $this->save();
    }

    public function resolve($user, string $notes): void
    {
        $this->status = 'resolved';
        $this->resolution_notes = $notes;
        $this->resolved_by = $user->id;
        $this->resolved_at = now();
        $this->save();
    }

    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }


}