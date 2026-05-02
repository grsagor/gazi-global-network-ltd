<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE `required_data` MODIFY `submitted_text` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `required_data` MODIFY `submitted_files` VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('UPDATE `required_data` SET `submitted_text` = \'\' WHERE `submitted_text` IS NULL');
        DB::statement('UPDATE `required_data` SET `submitted_files` = \'\' WHERE `submitted_files` IS NULL');

        DB::statement('ALTER TABLE `required_data` MODIFY `submitted_text` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `required_data` MODIFY `submitted_files` VARCHAR(255) NOT NULL');
    }
};
