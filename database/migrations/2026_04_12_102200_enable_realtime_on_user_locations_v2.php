<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        // 1. Set replica identity to FULL so Supabase gets the complete row for every update
        DB::statement('ALTER TABLE user_locations REPLICA IDENTITY FULL;');
        
        // 2. Ensure user_locations is part of the realtime publication
        // This is the standard way Supabase listens to table changes
        DB::statement('ALTER PUBLICATION supabase_realtime ADD TABLE user_locations;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER PUBLICATION supabase_realtime DROP TABLE user_locations;');
    }
};
