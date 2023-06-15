<?php

namespace App\Enums;

use TiagoF2\Enums\Core\Enum;

class BrazilianStates extends Enum
{
    public const AC = 1;
    public const AL = 2;
    public const AP = 3;
    public const AM = 4;
    public const BA = 5;
    public const CE = 6;
    public const DF = 7;
    public const ES = 8;
    public const GO = 9;
    public const MA = 10;
    public const MT = 11;
    public const MS = 12;
    public const MG = 13;
    public const PA = 14;
    public const PB = 15;
    public const PR = 16;
    public const PE = 17;
    public const PI = 18;
    public const RJ = 19;
    public const RN = 20;
    public const RS = 21;
    public const RO = 22;
    public const RR = 23;
    public const SC = 24;
    public const SP = 25;
    public const SE = 26;
    public const TO = 27;

    protected static array $enums = [
        self::AC => 'AC',
        self::AL => 'AL',
        self::AP => 'AP',
        self::AM => 'AM',
        self::BA => 'BA',
        self::CE => 'CE',
        self::DF => 'DF',
        self::ES => 'ES',
        self::GO => 'GO',
        self::MA => 'MA',
        self::MT => 'MT',
        self::MS => 'MS',
        self::MG => 'MG',
        self::PA => 'PA',
        self::PB => 'PB',
        self::PR => 'PR',
        self::PE => 'PE',
        self::PI => 'PI',
        self::RJ => 'RJ',
        self::RN => 'RN',
        self::RS => 'RS',
        self::RO => 'RO',
        self::RR => 'RR',
        self::SC => 'SC',
        self::SP => 'SP',
        self::SE => 'SE',
        self::TO => 'TO',
    ];

    public const UF = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins',
    ];
}
