<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;


class Message extends Model
{
    protected $primaryKey = 'id_message';

    protected $fillable = ['message', 'user_id','id_fils', 'id_auteur', 'contenu', 'date_envoi', 'statut_lecture', 'image_path'];

    protected $casts = [
        'date_envoi' => 'datetime',
        'statut_lecture' => 'boolean',
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'id_auteur');
    }

    public function fils()
    {
        return $this->belongsTo(FilsDiscussions::class, 'id_fils');
    }

     public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id_user');
}

}
