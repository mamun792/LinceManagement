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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('license_key')->unique();
            $table->string('domain');
            $table->enum('status', ['active', 'suspended', 'revoked'])->default('active');
            $table->timestamp('created_time');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_lifetime')->default(false);
            $table->integer('max_domains')->default(1);
            $table->text('meta_data');
            $table->timestamp('last_verified_at')->nullable();
            $table->integer('verification_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Add indexes for better performance
            $table->index('status');
            $table->index('expires_at');
            $table->index(['status', 'expires_at']);
            $table->index('is_lifetime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
