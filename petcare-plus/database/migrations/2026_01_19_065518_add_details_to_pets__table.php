<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::table('pets', function (Blueprint $table) {

            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade')->after('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('type');
            $table->integer('age');
            $table->decimal('weight', 8, 2);
            $table->unique(['owner_id', 'name', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
        public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['owner_id','code','name','type','age','weight']);
        });
    }
};
