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
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Drop existing morphs columns
            $table->dropColumn(['tokenable_type', 'tokenable_id']);
            
            // Add new morphs columns with UUID support
            $table->string('tokenable_type');
            $table->uuid('tokenable_id');
            
            // Add index for performance
            $table->index(['tokenable_type', 'tokenable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Drop the custom columns
            $table->dropIndex(['tokenable_type', 'tokenable_id']);
            $table->dropColumn(['tokenable_type', 'tokenable_id']);
            
            // Re-add original morphs columns (BIGINT)
            $table->morphs('tokenable');
        });
    }
};
