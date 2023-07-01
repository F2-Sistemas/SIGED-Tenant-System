<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\IdeHelper\TenantContext;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\OrcamentoItem
 *
 * @property AsCollection $aditional_data
 * @property-read \App\Models\Orcamento|null $orcamento
 * @method static \Database\Factories\OrcamentoItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem query()
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $lei_tipo
 * @property string|null $lei_numero
 * @property string|null $lei_data
 * @property string|null $content
 * @property string $orcamento_id
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem whereAditionalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem whereLeiData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem whereLeiNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem whereLeiTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem whereOrcamentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrcamentoItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrcamentoItem extends Model
{
    use HasFactory;
    use HasUuids;
    use TenantContext;

    // protected $table = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'orcamento_id',
        'lei_tipo',
        'lei_numero',
        'lei_data',
        'content',
        'aditional_data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'aditional_data' => AsCollection::class,
    ];

    /**
     * Get the orcamento that owns the OrcamentoItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orcamento(): BelongsTo
    {
        return $this->belongsTo(Orcamento::class, 'orcamento_id', 'id');
    }
}
