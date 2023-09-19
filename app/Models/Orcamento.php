<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\IdeHelper\TenantContext;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\OrcamentoTipoEnum;

/**
 * App\Models\Orcamento
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $tipo
 * @property int $ano_vigencia_inicio
 * @property int|null $ano_vigencia_fim
 * @property bool|null $active
 * @property-read mixed $exercicio
 * @property-read mixed $tipo_translated_value
 * @property-read mixed $tipo_value
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrcamentoItem> $items
 * @property-read int|null $items_count
 * @method static Builder|Orcamento anoVigencia(int $anoInicio, ?int $anoFim = null)
 * @method static \Database\Factories\OrcamentoFactory factory($count = null, $state = [])
 * @method static Builder|Orcamento newModelQuery()
 * @method static Builder|Orcamento newQuery()
 * @method static Builder|Orcamento query()
 * @method static Builder|Orcamento whereActive($value)
 * @method static Builder|Orcamento whereAnoVigenciaFim($value)
 * @method static Builder|Orcamento whereAnoVigenciaInicio($value)
 * @method static Builder|Orcamento whereCreatedAt($value)
 * @method static Builder|Orcamento whereId($value)
 * @method static Builder|Orcamento whereTipo($value)
 * @method static Builder|Orcamento whereUpdatedAt($value)
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
        'tipoTranslatedValue',
        'exercicio',
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
        return static::tipoEnum(false);
    }

    public function getTipoTranslatedValueAttribute()
    {
        return static::tipoEnum(true);
    }

    public function scopeAnoVigencia(Builder $query, int $anoInicio, ?int $anoFim = null)
    {
        $query->where('ano_vigencia_inicio', $anoInicio);

        if ($anoFim && $anoFim >= $anoInicio) {
            $query->where('ano_vigencia_fim', $anoFim);
        }

        return $query;
    }

    public function tipoEnum(
        bool $tranlate = true,
        ?string $locale = null,
    ) {
        if (!$this->tipo) {
            return null;
        }

        return OrcamentoTipoEnum::getValue(
            $this->tipo,
            $tranlate,
            $locale,
        ) ?? null;
    }

    public function getExercicioAttribute()
    {
        if (!$this->tipo) {
            return null;
        }

        return match ($this->tipo) {
            OrcamentoTipoEnum::PPA => implode('/', array_filter([
                $this->ano_vigencia_inicio,
                $this->ano_vigencia_fim,
            ])),
            default => $this->ano_vigencia_inicio,
        };
    }
}
