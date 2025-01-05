<?php

namespace App\Enums;

enum OrganizationType: string
{
    case LEGAL = 'LEGAL';

    case INDIVIDUAL = 'INDIVIDUAL';

    public function translate(): string
    {
        return match ($this) {
            self::LEGAL => 'Юридическое лицо',
            self::INDIVIDUAL => 'Индивидуальный предприниматель',
        };
    }
}
