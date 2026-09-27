<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('couriers', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 120);
            $table->string('phone', 30)->unique();
            $table->string('email', 120)->nullable()->unique();
            $table->unsignedTinyInteger('level');
            $table->string('status', 20)->default('active');
            $table->string('vehicle_type', 30)->nullable();
            $table->string('vehicle_plate_number', 20)->nullable()->unique();
            $table->string('service_area', 120)->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['level', 'name']);
            $table->index('registered_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
