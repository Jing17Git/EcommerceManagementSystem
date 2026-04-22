<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seller_application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_application_id')->constrained()->onDelete('cascade');
            $table->enum('document_type', ['business_permit', 'id_card', 'other'])->default('other');
            $table->string('document_name');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();

            // Indexes for better performance
            $table->index('seller_application_id');
            $table->index('document_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_application_documents');
    }
};
