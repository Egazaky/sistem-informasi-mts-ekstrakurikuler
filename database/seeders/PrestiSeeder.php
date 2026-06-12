<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PrestiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = 'e:\\Pemrograman Web\\Laravel\\ALDIS\\absensi.sql';
        if (!File::exists($sqlPath)) {
            $this->command->error("Source SQL file not found at: {$sqlPath}");
            return;
        }

        $this->command->info("Reading and seeding data from {$sqlPath}...");

        $content = File::get($sqlPath);
        
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Explode by lines
        $lines = explode("\n", $content);
        $statement = "";
        $count = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '--') || str_starts_with($line, '/*')) {
                continue;
            }
            
            $statement .= " " . $line;
            
            if (str_ends_with($line, ';')) {
                $stmt = trim($statement);
                if (stripos($stmt, 'INSERT INTO') === 0) {
                    // Replace table names with presti_ prefixed ones
                    $tables = ['absensi', 'admin', 'guru', 'ortu', 'siswa', 'tagihan'];
                    foreach ($tables as $table) {
                        $stmt = str_ireplace("`$table`", "`presti_$table`", $stmt);
                    }
                    try {
                        DB::statement($stmt);
                        $count++;
                    } catch (\Exception $e) {
                        $this->command->error("Failed to execute statement: " . substr($stmt, 0, 100) . "... Error: " . $e->getMessage());
                    }
                }
                $statement = "";
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info("Seeding completed successfully! Total statements executed: {$count}");
    }
}
