<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'role' => \App\Enums\UserRole::class,
        ];
    }

    public function candidat() {
        return $this->hasOne(Candidat::class);
    }

    public function moniteur() {
        return $this->hasOne(Moniteur::class);
    }

    public function isAdmin() {
        return $this->role === \App\Enums\UserRole::ADMIN;
    }

    public function isAssistante() {
        return $this->role === \App\Enums\UserRole::ASSISTANTE;
    }

    public function isMoniteur() {
        return $this->role === \App\Enums\UserRole::MONITEUR;
    }

    public function isCandidat() {
        return $this->role === \App\Enums\UserRole::CANDIDAT;
    }
}
