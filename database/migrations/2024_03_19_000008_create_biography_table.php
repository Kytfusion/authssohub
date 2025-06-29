<?php

use App\Mapping\FieldsMapping;
use App\Mapping\SchemeMapping;
use App\Mapping\TablesMapping;
use App\Services\BiographyService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    use FieldsMapping;

    public function up()
    {
        $biographyService = app(BiographyService::class);

        Schema::create(TablesMapping::TABLE1, function (Blueprint $table) use ($biographyService) {
            $table->id();
            $table->foreignId(self::FIELD38)->constrained(TablesMapping::TABLE0)->onDelete('cascade');

            foreach ($biographyService->biographyMigration as $item) {
                $table->{$item[SchemeMapping::SCHEME1]}($item[SchemeMapping::SCHEME0])->{$item[SchemeMapping::SCHEME4]}($item[SchemeMapping::SCHEME3]);
            }

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TablesMapping::TABLE1);
    }
};
