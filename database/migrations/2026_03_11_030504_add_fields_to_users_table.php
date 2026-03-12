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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->text('address')->nullable()->after('avatar');
            // Note: wilayah_id will be added when wilayahs table is created
            // $table->unsignedBigInteger('wilayah_id')->nullable()->after('address');
            // $table->foreign('wilayah_id')->references('id')->on('wilayahs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'avatar', 'address']);
        });
    }
};
