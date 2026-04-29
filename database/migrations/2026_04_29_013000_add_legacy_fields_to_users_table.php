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
            if (! Schema::hasColumn('users', 'father_name')) {
                $table->string('father_name')->nullable()->after('last_name');
            }
            if (! Schema::hasColumn('users', 'nid')) {
                $table->string('nid')->nullable()->after('father_name');
            }
            if (! Schema::hasColumn('users', 'passport')) {
                $table->string('passport')->nullable()->after('nid');
            }
            if (! Schema::hasColumn('users', 'company')) {
                $table->string('company')->nullable()->after('passport');
            }
            if (! Schema::hasColumn('users', 'category')) {
                $table->string('category')->nullable()->after('company');
            }
            if (! Schema::hasColumn('users', 'rating')) {
                $table->string('rating')->nullable()->after('category');
            }
            if (! Schema::hasColumn('users', 'note')) {
                $table->text('note')->nullable()->after('rating');
            }
            if (! Schema::hasColumn('users', 'description')) {
                $table->text('description')->nullable()->after('note');
            }
            if (! Schema::hasColumn('users', 'access_token')) {
                $table->string('access_token')->nullable()->after('remember_token');
            }
            if (! Schema::hasColumn('users', 'otp')) {
                $table->string('otp')->nullable()->after('access_token');
            }
            if (! Schema::hasColumn('users', 'otp_expiry')) {
                $table->timestamp('otp_expiry')->nullable()->after('otp');
            }
            if (! Schema::hasColumn('users', 'email_verified')) {
                $table->unsignedTinyInteger('email_verified')->default(0)->after('otp_expiry');
            }
            if (! Schema::hasColumn('users', 'profile_image')) {
                $table->string('profile_image')->nullable()->after('email_verified');
            }
            if (! Schema::hasColumn('users', 'is_golden_guiter')) {
                $table->unsignedTinyInteger('is_golden_guiter')->default(0)->after('profile_image');
            }
            if (! Schema::hasColumn('users', 'social_media_links')) {
                $table->json('social_media_links')->nullable()->after('is_golden_guiter');
            }
            if (! Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('social_media_links');
            }
            if (! Schema::hasColumn('users', 'artist_type')) {
                $table->string('artist_type')->nullable()->after('address');
            }
            if (! Schema::hasColumn('users', 'ancestor_id')) {
                $table->unsignedBigInteger('ancestor_id')->nullable()->after('artist_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'ancestor_id',
                'artist_type',
                'address',
                'social_media_links',
                'is_golden_guiter',
                'profile_image',
                'email_verified',
                'otp_expiry',
                'otp',
                'access_token',
                'description',
                'note',
                'rating',
                'category',
                'company',
                'passport',
                'nid',
                'father_name',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
