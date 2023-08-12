<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_part', function (Blueprint $table) {
            $table->foreignId('menu_id')->constrained('menus');
            $table->foreignId('part_id')->constrained('parts');
            $table->primary(['menu_id', 'part_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_part');
    }
};
