<?php

namespace App\Models;

use App\Mapping\FieldsMapping;
use App\Mapping\TablesMapping;
use App\Services\OptionService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionModel extends Model
{
    use HasFactory;
    use FieldsMapping;

    protected $table    = TablesMapping::TABLE2;
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $optionService = new OptionService();
        $this->fillable = $optionService->optionsFields;
    }

    public function profile()
    {
        return $this->belongsTo(ProfileModel::class, self::FIELD38);
    }
}
