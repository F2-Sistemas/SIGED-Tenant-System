<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\IdeHelper\TenantContext;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Orcamento
 *
 * @method static \Database\Factories\OrcamentoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento query()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrcamentoItem> $items
 * @property-read int|null $items_count
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $tipo
 * @property int $ano_vigencia_inicio
 * @property int|null $ano_vigencia_fim
 * @property bool|null $active
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrcamentoItem> $items
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento whereAnoVigenciaFim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento whereAnoVigenciaInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento whereAtive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orcamento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Orcamento extends Model
{
    use HasFactory;
    use HasUuids;
    use TenantContext;

    protected $fillable = [
        'tipo',
        'ano_vigencia_inicio',
        'ano_vigencia_fim',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $appends = [
        'tipoValue',
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

    public function getTipoValueAttribute()
    {
        return \App\Enums\OrcamentoTipoEnum::get($this->tipo) ?? null;
    }

    public function scopeAnoVigencia(Builder $query, int $anoInicio, ?int $anoFim = null)
    {
        $query->where('ano_vigencia_inicio', $anoInicio);

        if ($anoFim && $anoFim >= $anoInicio) {
            $query->where('ano_vigencia_fim', $anoFim);
        }

        return $query;
    }
}
