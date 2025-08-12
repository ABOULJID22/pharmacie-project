<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    protected $fillable = [
        'name', 'role','phone','adress', 'photo_team', 'email', 'linkedin', 'description'
    ];

     protected $appends = [
        'photo_team_url'
    ];
    /**
     * Get the full URL for the photo_team.
     *
     * @return string|null
     */
    public function getPhotoTeamUrlAttribute(): ?string
    {
        return $this->photo_team ? asset('storage/' . $this->photo_team) : null;
    }

}
