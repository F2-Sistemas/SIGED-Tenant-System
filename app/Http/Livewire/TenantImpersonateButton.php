<?php

namespace App\Http\Livewire;

use App\Models\Tenant;
use Livewire\Component;

class TenantImpersonateButton extends Component
{
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
