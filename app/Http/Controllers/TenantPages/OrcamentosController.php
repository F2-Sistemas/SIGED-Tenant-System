<?php

namespace App\Http\Controllers\TenantPages;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Enums\OrcamentoTipoEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Orcamento;
use Illuminate\Database\Schema\Builder;

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

        $allowedYears = range(2015, date('Y') + 4); // Aceita apenas ano de referência a partir de X.

        $orcamentoTipoEnums = OrcamentoTipoEnum::enums(false);
        if ($tipoOrcamento && !in_array($tipoOrcamento, array_values($orcamentoTipoEnums), true)) {
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

        // Orcamentos
        $orcamentos = Cache::remember(
            implode('-', [
                'orcamentos',
                'selectedYear',
                $selectedYear,
                'tipoOrcamento' => $tipoOrcamento,
            ]),
            (60 * 60 * 24) /*secs*/,
            function () use (
                $selectedYear,
                $tipoOrcamento,
                $orcamentoTipoEnums,
                $allowedYears,
            ) {
                $text = 'Check out this guide to learn how to <a href="/docs/getting-started/introduction/">get started</a> and start developing websites even faster with components on top of Tailwind <strong>CSS.</strong>';
                $stripedText = strip_tags($text, ['a']);

                if (!in_array($selectedYear, $allowedYears)) {
                    return [];
                }

                $query = Orcamento::anoVigencia($selectedYear)
                    ->with('items');

                $tipoOrcamento = array_flip($orcamentoTipoEnums)[$tipoOrcamento] ?? null;

                if ($tipoOrcamento) {
                    $query->where('tipo', $tipoOrcamento);
                }

                return $query->get();
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
                'latestYears' => range(date('Y'), (date('Y') - 6)),
            ]
        );
    }
}
