<?php
namespace App\Enum;

enum TypeEvenement: string
{
    case Nettoyage = 'Nettoyage';
    case Plantation = 'Plantation';
    case Sensibilisation = 'Sensibilisation';
    case Recyclage = 'Recyclage';
    case Formation = 'Formation';
}
