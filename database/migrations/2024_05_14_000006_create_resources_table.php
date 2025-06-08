<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // public function up(): void
    // {
    //     Schema::create('resources', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('project_id')->constrained()->onDelete('cascade');
    //         $table->string('name');
    //         $table->enum('type', ['tool', 'software', 'material']);
    //         $table->integer('quantity');
    //         $table->decimal('cost', 10, 2);
    //         $table->timestamps();
    //     });
    // }
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_url')->nullable(); // For file storage or external links
            $table->enum('resource_type', ['document', 'video', 'link', 'template', 'guide'])->default('document');
            $table->json('visible_to_roles')->nullable(); // e.g., ["client", "staff"]
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};