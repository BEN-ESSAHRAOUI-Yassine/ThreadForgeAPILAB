<?php

namespace App\Enums;

enum RawContentStatus: string
{
    case Pending = 'en_attente';
    case Processing = 'en_traitement';
    case Completed = 'traite';
    case Failed = 'echoue';
}
