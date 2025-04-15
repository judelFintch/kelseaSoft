<?php

namespace App\Enums;

enum DossierType: string
{
    case SANS = 'sans';
    case AVEC = 'avec';

    public function label(): string
    {
        return match($this) {
            self::SANS => 'Sans licence',
            self::AVEC => 'Avec licence',
        };
    }

    public static function options(): array
    {
        return [
            ['label' => self::SANS->label(), 'value' => self::SANS->value],
            ['label' => self::AVEC->label(), 'value' => self::AVEC->value],
        ];
    }
}