<?php

namespace App\Models;

use App\Mapping\FieldsMapping;
use App\Mapping\SchemeMapping;
use App\Mapping\TablesMapping;
use App\Services\BiographyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiographyModel extends Model
{
    use HasFactory;
    use FieldsMapping;

    protected $table = TablesMapping::TABLE1;

    protected $fillable = [];

    protected $casts = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $biographyService = new BiographyService();
        foreach ($biographyService->biographyScheme as $scheme) {
            $propertyName = $scheme[SchemeMapping::SCHEME0];
            $dataType     = $scheme[SchemeMapping::SCHEME1];

            if (!in_array($propertyName, $this->fillable)) {
                $this->fillable[] = $propertyName;
            }

            switch ($dataType) {
                case 'string':
                    $this->casts[$propertyName] = 'string';
                    break;
                case 'integer':
                    $this->casts[$propertyName] = 'integer';
                    break;
                case 'boolean':
                    $this->casts[$propertyName] = 'boolean';
                    break;
                case 'json':
                    $this->casts[$propertyName] = 'array';
                    break;
                case 'date':
                    $this->casts[$propertyName] = 'date';
                    break;
                case 'datetime':
                    $this->casts[$propertyName] = 'datetime';
                    break;
                case 'float':
                    $this->casts[$propertyName] = 'float';
                    break;

            }
        }
    }
}
