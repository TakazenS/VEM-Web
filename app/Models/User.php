<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    const ROLE_DIRECTEUR = 'directeur';
    const ROLE_ADMIN = 'administrateur';
    const ROLE_CHEF_SITE = 'chefs de site';
    const ROLE_CHERCHEUR = 'chercheur';
    const ROLE_TECHNICIEN = 'technicien';
    const ROLE_LOGISTIQUE = 'logistique';
    const ROLE_UTILISATEUR = 'utilisateur';

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
        ];
    }

    public function isUtilisateur(): bool
    {
        return $this->role === self::ROLE_UTILISATEUR;
    }

    public function isDirecteur(): bool
    {
        return $this->role === self::ROLE_DIRECTEUR;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isChefDeSite(): bool
    {
        return $this->role === self::ROLE_CHEF_SITE;
    }

    public function isChercheur(): bool
    {
        return $this->role === self::ROLE_CHERCHEUR;
    }

    public function isTechnicien(): bool
    {
        return $this->role === self::ROLE_TECHNICIEN;
    }

    public function isLogistique(): bool
    {
        return $this->role === self::ROLE_LOGISTIQUE;
    }
}
