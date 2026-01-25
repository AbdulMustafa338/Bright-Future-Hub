<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First delete all records with type 'job'
        DB::table('opportunities')->where('type', 'job')->delete();

        // Then modify the enum column to remove 'job'
        Schema::table('opportunities', function (Blueprint $table) {
            // We use raw statement because modification of ENUMs is platform specific
            // and Doctrine DBAL has some limitations with ENUMs.
            // Assuming MySQL/MariaDB for this environment.
            DB::statement("ALTER TABLE opportunities MODIFY COLUMN type ENUM('internship', 'scholarship', 'admission') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            DB::statement("ALTER TABLE opportunities MODIFY COLUMN type ENUM('internship', 'scholarship', 'admission', 'job') NOT NULL");
        });
    }
};
