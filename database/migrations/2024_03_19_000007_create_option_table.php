<?php

use App\Mapping\FieldsMapping;
use App\Mapping\SchemeMapping;
use App\Mapping\TablesMapping;
use App\Services\OptionService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    use FieldsMapping;

    public function up()
    {
        $optionsService = app(OptionService::class);

        Schema::create(TablesMapping::TABLE2, function (Blueprint $table) use ($optionsService) {
            $table->id();
            $table->foreignId(self::FIELD38)->constrained(TablesMapping::TABLE0)->onDelete('cascade');

            foreach ($optionsService->optionsMigration as $item) {
                $table->{$item[SchemeMapping::SCHEME1]}($item[SchemeMapping::SCHEME0])->{$item[SchemeMapping::SCHEME4]}($item[SchemeMapping::SCHEME3]);
            }

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TablesMapping::TABLE2);
    }
};
