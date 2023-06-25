<?php

use App\Models\User;
use App\Models\Tenant;
use App\Helpers\TenantHelpers;
use Illuminate\Support\Collection;
use App\Helpers\ImpersonateTenantHelpers;

if (!function_exists('getTenancy')) {
    /**
     * getTenancy function
     *
     * @return ?\Stancl\Tenancy\Tenancy
     */
    function getTenancy(): ?Stancl\Tenancy\Tenancy
    {
        return TenantHelpers::getTenancy();
    }
}

if (!function_exists('hasInitializedTenant')) {
    /**
     * hasInitializedTenant function
     *
     * @return boolean
     */
    function hasInitializedTenant(): bool
    {
        return TenantHelpers::hasInitializedTenant();
    }
}

if (!function_exists('getTenant')) {
    /**
     * Get a key from the current tenant's storage.
     *
     * @param string|null $key
     * @return Tenant|null|mixed
     */
    function getTenant($key = null): ?Tenant
    {
        return TenantHelpers::getTenant($key);
    }
}

if (!function_exists('tenantInit')) {
    /**
     * function tenantInit
     *
     * @param mixed $tenantId
     * @param bool $throwException
     *
     * @return bool
     */
    function tenantInit(mixed $tenantId, bool $throwException = false): bool
    {
        return TenantHelpers::tenantInit($tenantId, $throwException);
    }
}

if (!function_exists('tenantEnd')) {
    /**
     * function tenantEnd
     *
     * @param bool $throwException
     *
     * @return bool
     */
    function tenantEnd(?bool $throwException = null): bool
    {
        return TenantHelpers::tenantEnd($throwException);
    }
}

if (!function_exists('initializeTenant')) {
    /**
     * function initializeTenant
     *
     * @param mixed $tenantId
     * @param bool $throwException
     *
     * @return bool
     */
    function initializeTenant(mixed $tenantId, bool $throwException = false): bool
    {
        return TenantHelpers::tenantInit($tenantId, $throwException);
    }
}

if (!function_exists('hasTenantOnSession')) {
    /**
     * function hasTenantOnSession
     *
     * @param null|User $user
     * @return bool
     */
    function hasTenantOnSession(null|User $user): bool
    {
        return ImpersonateTenantHelpers::hasTenantOnSession($user);
    }
}

if (!function_exists('canImpersonateATenant')) {
    /**
     * function canImpersonateATenant
     *
     * @param null|User $user
     * @return bool
     */
    function canImpersonateATenant(null|User $user): bool
    {
        return ImpersonateTenantHelpers::canImpersonateATenant($user);
    }
}

if (!function_exists('objectify')) {
    /**
     * function objectify
     *
     * @param mixed $content
     *
     * @return object
     */
    function objectify(mixed $content): object
    {
        return new class($content)
        {
            protected Collection $content;

            public function __construct(
                mixed $content
            ) {
                $content = in_array(gettype($content), ['integer', 'double', 'NULL']) ? ['data' => $content] : $content;
                $this->content = collect($content);
            }

            public function __get(string $key)
            {
                return $this->get($key, null);
            }

            public function get(?string $key = null, mixed $defaultValue = null): mixed
            {
                if (!$key) {
                    return $this->collect();
                }

                return $this->collect()->get($key, $defaultValue);
            }

            public function set(?string $key = null, mixed $value = null): static
            {
                $this->put($key, $value);

                return $this;
            }

            public function forget(?string $key = null): static
            {
                if (!$key) {
                    return $this;
                }

                $this->collect()->forget($key);

                return $this;
            }

            public function put(?string $key = null, mixed $value = null): static
            {
                if (!$key) {
                    return $this;
                }

                $this->collect()->put($key, $value);

                return $this;
            }

            public function collect(): Collection
            {
                return $this->content;
            }

            public function content(): Collection
            {
                return $this->collect();
            }

            public function typeIs(string $key, string $type, bool $checkInstance = false): bool
            {
                $value = $this->get($key);

                if ($checkInstance) {
                    return is_a($value, $type);
                }

                return strtolower(gettype($value)) === strtolower($type);
            }

            public function getIfTypeIs(
                string $key,
                string $type,
                mixed $defaultValue = null,
                bool $checkInstance = false
            ): mixed {
                return $this->typeIs($key, $type, $checkInstance) ? $this->get($key, $defaultValue) : $defaultValue;
            }

            public function truly(string $key, mixed $defaultValue = null, mixed $trulyIfIs = null): mixed
            {
                $value = $this->get($key, '__NOT_FOUND__');

                if ($value === '__NOT_FOUND__') {
                    return $defaultValue;
                }

                if ($trulyIfIs !== null) {
                    if (is_array($trulyIfIs)) {
                        return in_array($value, $trulyIfIs, true) ? $value : $defaultValue;
                    }

                    return $trulyIfIs === $value ? $value : $defaultValue;
                }

                return $value ?: $defaultValue;
            }

            public function elvis(string $key, mixed $defaultValue = null): mixed
            {
                return $this->truly($key, $defaultValue);
            }

            public function call(string $key, ?Closure $defaultCallable = null, ...$params): mixed
            {
                $defaultCallable ??= fn() => null;

                return call_user_func($this->getIfTypeIs($key, 'Closure', $defaultCallable, true), $params);
            }

            public function __call($name, $arguments): mixed
            {
                if (in_array($name, get_class_methods(__CLASS__), true)) {
                    return call_user_func($this->{$name}, $arguments);
                }

                return $this->call($name, params: $arguments);
            }
        };
    }
}

if (!function_exists('processLinkData')) {
    /**
     * function processLinkData
     *
     * @param null|array|Collection $linkData
     *
     * @return object
     */
    function processLinkData(null|array|Collection $linkData): object
    {
        $linkData = objectify($linkData);
        $class = (array) $linkData->getIfTypeIs('class', 'array', []);
        $route = $linkData->get('route');
        $label = (string) $linkData->getIfTypeIs('label', 'string', '');
        $url = ($linkData->get('url') ?: ($route && is_string($route) ? route($route) : null)) ?: '#!';
        $target = $linkData->truly('target', '_self', [
            '_self',
            '_blank',
        ]);

        $linkData->put('url', $url);
        $linkData->put('class', $class);
        $linkData->put('target', $target);
        $linkData->put('label', $label);
        $linkData->put(
            'html',
            fn() => \Spatie\Html\Facades\Html::a($linkData->url, $linkData->label)
                ->class($linkData->class)
                ->attribute('target', $linkData->target)
        );

        return $linkData;
    }
}

if (!function_exists('isOdd')) {
    /**
     * function isOdd
     *
     * @param mixed $value
     * @param bool $evaluatePrecision   if FALSE, will convert to integer and ignore mod
     *
     * @return bool
     */
    function isOdd(mixed $value, bool $evaluatePrecision = true): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        if (!$evaluatePrecision) {
            return (((int) $value) % 2) !== 0;
        }

        $values = explode('.', fmod($value, 1.0));

        return (($values[1] ?? $value ?? 0) % 2) !== 0;
    }
}

if (!function_exists('isEven')) {
    /**
     * function isEven
     *
     * @param mixed $value
     * @param bool $evaluatePrecision   if FALSE, will convert to integer and ignore mod
     *
     * @return bool
     */
    function isEven(mixed $value, bool $evaluatePrecision = true): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        if (!$evaluatePrecision) {
            return (((int) $value) % 2) === 0;
        }

        $values = explode('.', fmod($value, 1.0));

        return (($values[1] ?? $value ?? 0) % 2) === 0;
    }
}

if (!function_exists('getIf')) {
    /**
     * function getIf
     *
     * @param mixed $value
     * @param callable $condition
     *
     * @return mixed
     */
    function getIf(mixed $value, callable $condition): mixed
    {
        return call_user_func($condition, $value) ? $value : null;
    }
}

if (!function_exists('getIfOr')) {
    /**
     * function getIfOr
     *
     * @param mixed $value
     * @param callable $condition
     * @param mixed $optionalValue
     *
     * @return mixed
     */
    function getIfOr(mixed $value, callable $condition, mixed $optionalValue = null): mixed
    {
        return call_user_func($condition, $value) ? $value : (
            is_a($optionalValue, 'Closure') ? $optionalValue($value) : $optionalValue
        );
    }
}
