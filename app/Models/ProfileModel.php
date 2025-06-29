<?php

namespace App\Models;

use App\Mapping\FieldsMapping;
use App\Mapping\SchemeMapping;
use App\Mapping\TablesMapping;
use App\Services\BiographyService;
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $profileService = new ProfileService();
        $this->fillable = $profileService->profileFields;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // nu e clar, probabil tre sters
    public function bio()
    {
        return $this->hasOne(BiographyModel::class, self::FIELD38);
    }

    public function biography()
    {
        return $this->hasOne(BiographyModel::class, self::FIELD38);
    }

    public function options()
    {
        return $this->hasOne(OptionModel::class, self::FIELD38);
    }
}
