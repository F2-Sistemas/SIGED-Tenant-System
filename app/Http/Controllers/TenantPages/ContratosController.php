<?php

namespace App\Http\Controllers\TenantPages;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Schema\Builder;

class ContratosController extends Controller
{
    /**
     * function index
     *
     * @param \Illuminate\Http\Request $request
     * @param ?string $selectedYear
     *
     * @return \Inertia\Response
     */
    public function index(Request $request, ?string $selectedYear = null): Response
    {
        $latestYears = range(date('Y'), (date('Y') - 6));

        $selectedYear = in_array($selectedYear, $latestYears) ? $selectedYear : $request->query('selectedYear', date('Y'));

        /**
         * @mock
         */
        $contracts = [
            '01' => [
                'label' => 'Janeiro',
                'year' => $selectedYear,
                'items' => [
                    [
                        // public Contratado $contratado_id; // [INDEX]
                        // public ?string $numero; // [INDEX]
                        // public ?string $ano_relacionado; // [INDEX]
                        // public ?string $vigencia_inicio; // [INDEX]
                        // public ?string $vigencia_fim; // [INDEX]
                        // public ?string $valor; // [INDEX]
                        // public ?AtoDeContrato $ato_de_contrato; // [INDEX]
                        // public ?RegistroDePreco $registro_de_preco; // [INDEX]
                        // public ?string $objeto; // (descrição)

                        'contratado_id' => 'Contratado XYZ',
                        'numero' => '1234/' . $selectedYear,
                        'ano_relacionado' => $selectedYear,
                        'vigencia_inicio' => $selectedYear,
                        'vigencia_fim' => ($selectedYear) + 2,
                        'valor' => rand($selectedYear, $selectedYear * 7),
                        'ato_de_contrato' => 'Pregão eletrônico',
                        'registro_de_preco' => null,
                        'objeto' => fake()->paragraph(),
                    ],
                    [
                        'contratado_id' => 'Contratado XYZ',
                        'numero' => '1235/' . $selectedYear,
                        'ano_relacionado' => $selectedYear,
                        'vigencia_inicio' => $selectedYear,
                        'vigencia_fim' => ($selectedYear) + 2,
                        'valor' => rand($selectedYear, $selectedYear * 7),
                        'ato_de_contrato' => 'Pregão eletrônico',
                        'registro_de_preco' => [
                            'ata' => 4546,
                            'ano' => $selectedYear,
                            'file' => [
                                'url' => url('#abcde'),
                            ],
                        ],
                        'objeto' => fake()->paragraph(),
                    ],
                ],
            ],
        ];

        return Inertia::render(
            'Tenants/Public/Contratos/Index',
            [
                'latestYears' => $latestYears,
                'selectedYear' => $selectedYear,
                'contracts' => $contracts,
            ]
        );
    }
}
