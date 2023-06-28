<?php

namespace App\Filament\Resources;

use App\Helpers\TenantHelpers;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
// use App\Traits\TenancyEasyHelpers;
use Illuminate\Database\Eloquent\Model;

abstract class TenancyBaseResource extends Resource
{
    // use TenancyEasyHelpers;

    protected static bool $shouldAuthorizeWithGate = true;
    protected static bool $shouldIgnorePolicies = false;

    protected static ?bool $tenantIsRequired = true;
    protected static ?bool $toAbortIfHasNoTenantAndIsRequired = true;
    protected static ?int $errorCodeIfHasNoTenantAndIsRequired = 404;
    protected static ?string $errorMessageIfHasNoTenantAndIsRequired = 'Not Found';

    public static function can(string $action, ?Model $record = null): bool
    {
        $user = Filament::auth()->user();
        $model = static::getModel();

        if (static::toAbortIfHasNoTenant()) {
            static::abortIfHasNoTenantAndIsRequired();
        }

        $can = static::canFalseHasNoTenantAndIsRequired() ?? parent::can($action, $record);

        return (bool) $can;
    }

    public static function shouldAuthorizeWithGate(): bool
    {
        return static::$shouldAuthorizeWithGate;
    }

    public static function tenantIsRequired(): bool
    {
        return (bool) static::$tenantIsRequired;
    }

    public static function toAbortIfHasNoTenant(): bool
    {
        return (bool) static::$toAbortIfHasNoTenantAndIsRequired;
    }

    public static function getErrorCodeIfHasNoTenantAndIsRequired(): int
    {
        return static::$errorCodeIfHasNoTenantAndIsRequired ?? 404;
    }

    public static function getErrorMessageIfHasNoTenantAndIsRequired(): string
    {
        return __(static::$errorMessageIfHasNoTenantAndIsRequired ?? 'Not Found');
    }

    public static function abortIfHasNoTenantAndIsRequired(): void
    {
        if (!static::tenantIsRequired()) {
            return;
        }

        if (!TenantHelpers::hasInitializedTenant()) {
            \abort(
                static::getErrorCodeIfHasNoTenantAndIsRequired(),
                static::getErrorMessageIfHasNoTenantAndIsRequired(),
            );
        }
    }

    public static function canFalseHasNoTenantAndIsRequired(): ?bool
    {
        if (static::tenantIsRequired() && !TenantHelpers::hasInitializedTenant()) {
            return false;
        }

        return null;
    }

    public static function registerNavigationItems(): void
    {
        if (static::tenantIsRequired() && !TenantHelpers::hasInitializedTenant()) {
            return;
        }

        parent::registerNavigationItems();
    }

    public static function getNavigationItems(): array
    {
        if (static::tenantIsRequired() && !TenantHelpers::hasInitializedTenant()) {
            return [];
        }

        return parent::getNavigationItems();
    }
}
