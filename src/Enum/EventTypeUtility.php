<?php

namespace App\Enum;

class EventTypeUtility
{
    public static function getChoices(): array
    {
        return array_map(
            fn(EventType $case) => $case->value,
            EventType::cases()
        );
    }
}

