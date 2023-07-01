<?php

namespace App\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;

class ExtendModelsCommand extends ModelsCommand
{
    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    /**
     * Generate factory method from "HasFactory" trait.
     *
     * A way to set tenant context
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    protected function getFactoryMethods($model)
    {
        $tenantContext = in_array(\App\Support\IdeHelper\TenantContext::class, class_uses_recursive($model));

        if ($tenantContext) {
            $tenantId = $this->option('tenant_id') ?: config('ide-helper.tenant_context.tenant_id_on_migration');

            if (!$tenantId) {
                throw new \Exception(
                    "For tenant context, tenantId is required. [ide-helper.tenant_context.tenant_id_on_migration]",
                    1
                );
            }

            tenantInit($tenantId);

            $modelName = get_class($model);
            $model = new $modelName();
        }

        return parent::getFactoryMethods($model);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ...parent::getOptions(),
            ['tenant_id', 'T', InputOption::VALUE_OPTIONAL, 'A tenant ID when tenant context'],
        ];
    }
}
