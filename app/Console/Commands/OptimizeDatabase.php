<?php
// app/Console/Commands/OptimizeDatabase.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OptimizeDatabase extends Command
{
    protected $signature = 'db:optimize';
    protected $description = 'Optimize database tables';

    public function handle()
    {
        $this->info('Optimizing database tables...');
        
        $tables = DB::select('SHOW TABLES');
        $databaseName = config('database.connections.mysql.database');
        $tableKey = "Tables_in_{$databaseName}";
        
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            DB::statement("OPTIMIZE TABLE {$tableName}");
            $this->info("Optimized table: {$tableName}");
        }
        
        $this->info('Database optimization completed!');
        
        return 0;
    }
}