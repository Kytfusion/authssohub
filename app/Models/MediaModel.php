<?php

namespace App\Models;

use App\Mapping\FieldsMapping;
use App\Mapping\TablesMapping;
use App\Services\MediaService;
use App\Services\ProfileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaModel extends Model
{
    use HasFactory;
    use FieldsMapping;

    protected $table    = TablesMapping::TABLE3;
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $mediaService = new MediaService();
        $this->fillable = $mediaService->mediaFields;
    }
}
