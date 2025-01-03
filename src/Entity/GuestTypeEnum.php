<?php

namespace App\Entity;


use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum GuestTypeEnum: string implements TranslatableInterface
{
    case MULTI = 'Mehrere Freunde/Mehrere Familienmitglieder';
    case SINGLE_MALE = 'Ein Freund/Ein männliches Familienmitglied';
    case SINGLE_FEMALE = 'Eine Freundin/Ein weibliches Familienmitglied';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::MULTI => $translator->trans('guest_type.multi.label', locale: $locale),
            self::SINGLE_MALE => $translator->trans('guest_type.single_male.label', locale: $locale),
            self::SINGLE_FEMALE => $translator->trans('guest_type.single_female.label', locale: $locale),
        };
    }
}