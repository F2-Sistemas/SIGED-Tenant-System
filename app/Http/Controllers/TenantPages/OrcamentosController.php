<?php

namespace App\Http\Controllers\TenantPages;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Enums\OrcamentoTipoEnum;
use App\Http\Controllers\Controller;

class OrcamentosController extends Controller
{
    /**
     * function index
     *
     * @param \Illuminate\Http\Request request
     *
     * @return \Inertia\Response
     */
    public function index(
        Request $request,
        ?string $anoVigencia = null,
        ?string $tipoOrcamento = null,
    ): Response {
        $tipoOrcamento ??= $request->query('tipoOrcamento');

        $tipoOrcamento = in_array($tipoOrcamento, array_values(OrcamentoTipoEnum::enums(false)), true)
            ? $tipoOrcamento : null;

        return Inertia::render(
            'Tenants/Public/Orcamentos/Index',
            [ // resources/js/Pages/Profile/Edit.vue
                'selectedYear' => $request->query('selectedYear') ?? $anoVigencia,
                'tipoOrcamento' => $tipoOrcamento ,
            ]
        );
    }
}
