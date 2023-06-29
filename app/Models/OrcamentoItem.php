<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrcamentoItem extends Model
{
    use HasFactory;
    use HasUuids;

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
