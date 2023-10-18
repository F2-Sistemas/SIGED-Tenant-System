<?php

/**
 * Usage:
 *
 * By enum:
 * \App\Enums\PlaceTypeEnum::getValue(1, true, 'pt_BR');
 *
 * By key:
 * \App\Enums\PlaceTypeEnum::trans('some_here', 'pt_BR');
 */

return [
    'CNPJ' => 'CNPJ',
    'CPF' => 'CPF',
    'PASSPORT' => 'Passaporte',
    'OTHER' => 'Outro',
    'NO_ONE' => 'Nenhum',
];
