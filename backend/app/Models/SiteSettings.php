<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $fillable = [
        'logo',
        'address',
        'telephone',
        'email',
        'facebook',
        'youtube',
        'instagram',
        'x',
        'whatsapp',
        'image_accueil',
        'text_propos',
        'title_propos',
        'img1_propos',
        'img2_propos',
        'img3_propos',
        'img4_propos',
        'video_service',
        'text_service',
        'title_service',
        'text_contact',
        'title_contact',
    ];

    protected $appends = [
        'logo_url',
        'image_accueil_url',
        'img1_propos_url',
        'img2_propos_url',
        'img3_propos_url',
        'img4_propos_url',
        'video_service_url',
    ];

    /**
     * Get the full URL for the logo.
     *
     * @return string|null
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }

    /**
     * Get the full URL for the image_accueil.
     *
     * @return string|null
     */
    public function getImageAccueilUrlAttribute(): ?string
    {
        return $this->image_accueil ? Storage::url($this->image_accueil) : null;
    }
    /**
     * Get the full URL for img1_propos.
     *
     * @return string|null
     */
    public function getImg1ProposUrlAttribute(): ?string
    {
        return $this->img1_propos ? Storage::url($this->img1_propos) : null;
    }
    /**
     * Get the full URL for img2_propos.
     *
     * @return string|null
     */
        public function getImg2ProposUrlAttribute(): ?string
    {
        return $this->img2_propos ? Storage::url($this->img2_propos) : null;
    }

    /**
     * Get the full URL for img2_propos.
     *
     * @return string|null
     */
        public function getImg3ProposUrlAttribute(): ?string
    {
        return $this->img3_propos ? Storage::url($this->img3_propos) : null;
    }
    /**
     * Get the full URL for img2_propos.
     *
     * @return string|null
     */
        public function getImg4ProposUrlAttribute(): ?string
    {
        return $this->img4_propos ? Storage::url($this->img4_propos) : null;
    }
    /**
     * Get the full URL for video_service.
     *
     * @return string|null
     */
    public function getVideoServiceUrlAttribute(): ?string
    {
        return $this->video_service ? Storage::url($this->video_service) : null;
    }
    
 
}


/* <?php


namespace App\Models;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $fillable = [
        'logo',
        'address',
        'telephone',
        'email',
        'facebook',
        'youtube',
        'instagram',
        'x',
        'whatsapp',
        'image_accueil',
        'text_propos',
        'title_propos',
        'img1_propos',
        'img2_propos',
        'img3_propos',
        'img4_propos',
        'video_service',
        'text_service',
        'title_service',
        'text_contact',
        'title_contact'
    ];

    protected $appends = [
        'logo_url',
        'image_accueil_url',
    ];

   public function getLogoUrlAttribute()
{
    if (!$this->logo) {
        return null;
    }
    if (str_starts_with($this->logo, 'http')) {
        return $this->logo;
    }
    return asset('storage/' . $this->logo);
}

public function getImageAccueilUrlAttribute()
{
    if (!$this->image_accueil) {
        return null;
    }
    if (str_starts_with($this->image_accueil, 'http')) {
        return $this->image_accueil;
    }
    return asset('storage/' . $this->image_accueil);
}
} */