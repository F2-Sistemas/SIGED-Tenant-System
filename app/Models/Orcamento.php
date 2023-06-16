<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Orcamento
 *
 * @method static \Database\Factories\OrcamentoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento query()
 * @mixin \Eloquent
 */
class Orcamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'ano_vigencia_inicio',
        'ano_vigencia_fim',
        'ative',
    ];

    protected $casts = [
        'ative' => 'boolean',
    ];
}
