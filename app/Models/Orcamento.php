<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    use HasUuids;

    protected $fillable = [
        'tipo',
        'ano_vigencia_inicio',
        'ano_vigencia_fim',
        'ative',
    ];

    protected $casts = [
        'ative' => 'boolean',
    ];

    /**
     * Get all of the items for the Orcamento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrcamentoItem::class, 'orcamento_id', 'id');
    }
}
