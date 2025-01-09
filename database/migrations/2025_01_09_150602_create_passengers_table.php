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
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->string('nid_no')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('passport_expire_date')->nullable();
            $table->string('passport_info_upload')->nullable();
            $table->string('pcc_number')->nullable();
            $table->date('pcc_issue_date')->nullable();
            $table->string('pcc_upload')->nullable();
            $table->string('designated_country_name');
            $table->string('work_type')->nullable();
            $table->string('company_name')->nullable();
            $table->string('required_doc_name')->nullable();
            $table->string('application_status')->default('Pending');
            $table->decimal('contact_amount', 10, 2)->nullable();
            $table->decimal('deposit_amount', 10, 2)->nullable();
            $table->decimal('due_amount', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->string('image_upload')->nullable();
            $table->string('pdf_upload')->nullable();
            $table->string('payment_doc_upload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
