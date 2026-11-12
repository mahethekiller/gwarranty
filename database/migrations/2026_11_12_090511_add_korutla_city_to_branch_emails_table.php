<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $exists = DB::table('branch_emails')
            ->where('state', 'Telangana')
            ->where('city', 'Korutla')
            ->where('branch_name', 'Hyderabad')
            ->exists();

        if (!$exists) {
            DB::table('branch_emails')->insert([
                'zone_name'        => 'South',
                'state'            => 'Telangana',
                'city'             => 'Korutla',
                'branch_name'      => 'Hyderabad',
                'commercial_email' => 'hyderabad@greenlam.com',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('branch_emails')
            ->where('state', 'Telangana')
            ->where('city', 'Korutla')
            ->where('branch_name', 'Hyderabad')
            ->delete();
    }
};
