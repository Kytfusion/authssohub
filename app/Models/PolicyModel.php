<?php

namespace App\Models;

use App\Mapping\FieldsMapping;
use App\Mapping\TablesMapping;
use App\Services\PolicyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyModel extends Model
{
    use HasFactory;
    use FieldsMapping;

    protected $table    = TablesMapping::TABLE4;
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $policyService = new PolicyService();
        $this->fillable = $policyService->policyFields;
    }
}
