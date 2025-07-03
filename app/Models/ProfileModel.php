<?php

namespace App\Models;

use App\Mapping\FieldsMapping;
use App\Mapping\TablesMapping;
use App\Services\ProfileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class ProfileModel extends Model implements JWTSubject, AuthenticatableContract
{
    use HasFactory;
    use Authenticatable;
    use FieldsMapping;

    protected $table    = TablesMapping::TABLE0;
    protected $fillable = [];

    public function __construct(
        array $attributes = []
    ) {
        parent::__construct($attributes);
        $service        = app(ProfileService::class);
        $this->fillable = $service->fields;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
