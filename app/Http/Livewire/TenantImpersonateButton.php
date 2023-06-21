<?php

namespace App\Http\Livewire;

use App\Models\Tenant;
use Livewire\Component;

class TenantImpersonateButton extends Component
{
    public function mount($tenantId = null)
    {
        \Log::info([
            'tenantId' => $tenantId,
            'line' => __FILE__ . ':' . __LINE__
        ]); // TODO: remove this before final version
    }

    public function boot($tenantId = null)
    {
        \Log::info([
            'tenantId' => $tenantId,
            'line' => __FILE__ . ':' . __LINE__
        ]); // TODO: remove this before final version
    }

    public function render()
    {
        return view('livewire.tenant-impersonate-button');
    }

    public function impersonate()
    {
        tenancy()->initialize(Tenant::find('cliente1'));
    }

    public function tenantGet(string $key = \null)
    {
        return tenant($key);
    }
}
