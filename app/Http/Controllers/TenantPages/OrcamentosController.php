<?php

namespace App\Http\Controllers\TenantPages;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Enums\OrcamentoTipoEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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
        $selectedYear = $request->query('selectedYear') ?? $anoVigencia ?? date('c');

        if ($tipoOrcamento && !in_array($tipoOrcamento, array_values(OrcamentoTipoEnum::enums(false)), true)) {
            abort(404);
        }

        $orcamentoTipos = Cache::remember(
            'orcamentoTipos',
            (60 * 60 * 24) /*secs*/,
            function () {
                foreach (OrcamentoTipoEnum::enums(false) as $enum => $key) {
                    $enums[] = [
                        'enum' => $enum,
                        'key' => $key,
                        'label' => OrcamentoTipoEnum::get($enum)
                    ];
                };

                return $enums ?? [];
            }
        );

        // Orcamento
        $orcamentos= Cache::remember(
            implode('-', ['orcamentos', $selectedYear]),
            (60 * 60 * 24) /*secs*/,
            function () {
                foreach (OrcamentoTipoEnum::enums(false) as $enum => $key) {
                    $enums[] = [
                        'enum' => $enum,
                        'key' => $key,
                        'label' => OrcamentoTipoEnum::get($enum)
                    ];
                };

                return $enums ?? [];
            }
        );

        return Inertia::render(
            'Tenants/Public/Orcamentos/Index',
            [ // resources/js/Pages/Tenants/Public/Orcamentos/Index.vue
                'selectedYear' => $selectedYear,
                'tipoOrcamento' => $tipoOrcamento,
                'pageTitle' => __('pages/orcamentos.index.title'),
                'orcamentoTipos' => $orcamentoTipos,
                'orcamentos' => $orcamentos,
            ]
        );
    }
}
