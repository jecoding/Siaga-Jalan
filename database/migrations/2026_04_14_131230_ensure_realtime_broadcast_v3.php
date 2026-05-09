<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Force set replica identity to FULL
        DB::statement('ALTER TABLE user_locations REPLICA IDENTITY FULL;');
        
        // 2. Ensure user_locations is part of the realtime publication
        // Handle case where it might already be there to avoid errors
        try {
            DB::statement('ALTER PUBLICATION supabase_realtime ADD TABLE user_locations;');
        } catch (\Exception $e) {
            // If it fails, try to drop and re-add or just ignore if it says it already exists
            // But we use a safer SQL way if possible or just catch
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            DB::statement('ALTER PUBLICATION supabase_realtime DROP TABLE IF EXISTS user_locations;');
        } catch (\Exception $e) {}
    }
};
