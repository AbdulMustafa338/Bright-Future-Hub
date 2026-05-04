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
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->string('registration_id')->nullable()->after('organization_name');
            $table->string('location')->nullable()->after('registration_id');
            $table->string('google_map_link')->nullable()->after('location');
            $table->text('rejection_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->dropColumn(['registration_id', 'location', 'google_map_link', 'rejection_reason']);
        });
    }
};
