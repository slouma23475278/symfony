<?php

namespace App\Enum;

enum EventType: string
{
    case CONFERENCE = 'Conference';
    case WORKSHOP = 'Workshop';
    case SEMINAR = 'Seminar';
    case MEETING = 'Meeting';
    case PARTY = 'Party';

    public static function getChoices(): array
    {
        return array_map(
            fn(EventType $case) => $case->value,
            EventType::cases()
        );
    }
}
