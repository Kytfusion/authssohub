<?php

use App\Mapping\FieldsMapping;
use App\Mapping\SchemeMapping;
use App\Mapping\TablesMapping;
use App\Services\PolicyService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    use FieldsMapping;

    public function up()
    {
        $policyService = app(PolicyService::class);

        Schema::create(TablesMapping::TABLE4, function (Blueprint $table) use ($policyService) {
            $table->id();

            foreach ($policyService->policyMigration as $item) {
                $table->{$item[SchemeMapping::SCHEME1]}($item[SchemeMapping::SCHEME0])->{$item[SchemeMapping::SCHEME4]}($item[SchemeMapping::SCHEME3]);
            }

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TablesMapping::TABLE4);
    }
};
