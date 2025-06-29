<?php

namespace App\Services;

use App\Mapping\SchemeMapping;
use App\Schemes\PolicyScheme;

class PolicyService
{
    public array $policyScheme    = [];
    public array $policyFields    = [];
    public array $policyMigration = [];
    public array $policyValidate = [];

    public function __construct()
    {
        $this->setPolicyScheme();
        $this->setPolicyFields();
        $this->setPolicyMigration();
        $this->setPolicyValidate();
    }

    private function setPolicyScheme(): void
    {
        $policySchemeInstance = new PolicyScheme();
        $this->policyScheme   = $policySchemeInstance->getScheme();
    }

    private function setPolicyFields(): void
    {
        foreach ($this->policyScheme as $item) {
            $this->policyFields[] = $item[SchemeMapping::SCHEME0];
        }
    }

    private function setPolicyMigration(): void
    {
        foreach ($this->policyScheme as $item) {
            $this->policyMigration[] = [
                SchemeMapping::SCHEME1 => $item[SchemeMapping::SCHEME1],
                SchemeMapping::SCHEME0 => $item[SchemeMapping::SCHEME0],
                SchemeMapping::SCHEME4 => $item[SchemeMapping::SCHEME4],
                SchemeMapping::SCHEME3 => $item[SchemeMapping::SCHEME3],
            ];
        }
    }

    private function setPolicyValidate(): void
    {
        foreach ($this->policyScheme as $item) {
            $this->policyValidate[] = [
                $item[SchemeMapping::SCHEME0] => $item[SchemeMapping::SCHEME5],
            ];
        }

        $this->policyValidate = array_merge(...$this->policyValidate);
    }
}
