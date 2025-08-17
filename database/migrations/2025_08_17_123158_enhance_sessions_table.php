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
        Schema::table('sessions', function (Blueprint $table) {
            // Check and add columns only if they don't exist
            if (!Schema::hasColumn('sessions', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('payload');
            }
            
            if (!Schema::hasColumn('sessions', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('user_agent');
            }
            
            if (!Schema::hasColumn('sessions', 'login_at')) {
                $table->timestamp('login_at')->nullable()->after('ip_address');
            }
            
            if (!Schema::hasColumn('sessions', 'last_activity_at')) {
                $table->timestamp('last_activity_at')->nullable()->after('login_at');
            }
            
            if (!Schema::hasColumn('sessions', 'metadata')) {
                $table->json('metadata')->nullable()->after('last_activity_at');
            }
            
            if (!Schema::hasColumn('sessions', 'status')) {
                $table->enum('status', ['active', 'expired', 'terminated'])->default('active')->after('metadata');
            }
        });
        
        // Add indexes after all columns are created
        Schema::table('sessions', function (Blueprint $table) {
            // Check if indexes exist before creating them
            if (!$this->indexExists('sessions', 'sessions_user_id_status_index')) {
                $table->index(['user_id', 'status']);
            }
            
            if (!$this->indexExists('sessions', 'sessions_ip_address_last_activity_index')) {
                $table->index(['ip_address', 'last_activity']);
            }
            
            if (!$this->indexExists('sessions', 'sessions_login_at_index')) {
                $table->index('login_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Drop indexes first
            if ($this->indexExists('sessions', 'sessions_user_id_status_index')) {
                $table->dropIndex(['user_id', 'status']);
            }
            
            if ($this->indexExists('sessions', 'sessions_ip_address_last_activity_index')) {
                $table->dropIndex(['ip_address', 'last_activity']);
            }
            
            if ($this->indexExists('sessions', 'sessions_login_at_index')) {
                $table->dropIndex(['login_at']);
            }
        });
        
        Schema::table('sessions', function (Blueprint $table) {
            $columnsToCheck = [
                'user_agent',
                'ip_address', 
                'login_at',
                'last_activity_at',
                'metadata',
                'status'
            ];
            
            $columnsToDelete = [];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('sessions', $column)) {
                    $columnsToDelete[] = $column;
                }
            }
            
            if (!empty($columnsToDelete)) {
                $table->dropColumn($columnsToDelete);
            }
        });
    }
    
    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $index): bool
    {
        $indexes = Schema::getConnection()
            ->getSchemaBuilder()
            ->getDoctrineSchemaManager()
            ->listTableIndexes($table);
            
        return array_key_exists($index, $indexes);
    }
};
