<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    const ROLE_ADMIN = 'admin';
    const ROLE_PHARMACIEN = 'pharmacien';
    const ROLE_CONSEILLER = 'conseiller';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'id_user';
    public $timestamps = false;
    protected $table = 'users';
    public $incrementing = true; // ou false selon ton cas
    protected $keyType = 'int'; 
    
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'phone_2',
        'address',
        'city',
        'postal_code',
        'country',
        'job_title',
        'is_active',
        'avatar_url',
        'last_login_at',
        'role', 
        'email_verified_at',
    ];

    /** 
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

 public function getFullNameAttribute(): string
    {
        return $this->first_name && $this->last_name
            ? "{$this->first_name} {$this->last_name}"
            : $this->name;
    }
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->attributes['avatar_url']
            ? asset('storage/' . $this->attributes['avatar_url'])
            : $this->getDefaultAvatarUrl();
    }

 protected function getDefaultAvatarUrl(): string
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

       public function isAdmin(): bool { return $this->hasRole(self::ROLE_ADMIN); }
    public function isPharmacien(): bool { return $this->hasRole(self::ROLE_PHARMACIEN); }
    public function isConseiller(): bool { return $this->hasRole(self::ROLE_CONSEILLER); }


     public function scopeOnlyAdmins($query) {
        return $query->whereHas('roles', fn($q) => $q->where('name', self::ROLE_ADMIN));
    }

    public function scopeOnlyPharmaciens($query) {
        return $query->whereHas('roles', fn($q) => $q->where('name', self::ROLE_PHARMACIEN));
    }

    public function scopeOnlyConseillers($query) {
        return $query->whereHas('roles', fn($q) => $q->where('name', self::ROLE_CONSEILLER));
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'id_uploader');
    }

    public function partages()
    {
        return $this->hasMany(PartagesDocuments::class, 'id_user');
    }

    public function filsDiscussions()
    {
        return $this->hasMany(FilsDiscussions::class, 'id_createur');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_auteur');
    }
    public function messagesEnvoyes()
    {
        return $this->hasMany(Message::class, 'id_auteur');
    }


   
    
}
