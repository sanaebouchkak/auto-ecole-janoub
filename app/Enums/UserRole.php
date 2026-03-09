<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case ASSISTANTE = 'assistante';
    case MONITEUR = 'moniteur';
    case CANDIDAT = 'candidat';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrateur',
            self::ASSISTANTE => 'Assistante',
            self::MONITEUR => 'Moniteur',
            self::CANDIDAT => 'Candidat',
        };
    }
}
