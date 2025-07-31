<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('product_types')->nullable()->after('name');
        });

        // Mikasa Ply types and warranties
        DB::table('products')->where('name', 'Mikasa Ply')->update([
            'product_types' => json_encode([
                ['type' => 'Fire Guaardian', 'warranty' => '30 yrs'],
                ['type' => 'Marine Blue Blockboard', 'warranty' => '25 yrs'],
                ['type' => 'Marine Blue', 'warranty' => '30 yrs'],
                ['type' => 'Marine', 'warranty' => '25 yrs'],
                ['type' => 'MR+ Blockboard', 'warranty' => '15 yrs'],
                ['type' => 'MR+', 'warranty' => '15 yrs'],
                ['type' => 'Sapphire', 'warranty' => 'Lifetime'],
            ]),
        ]);

        // Mikasa Floors types and warranties
        DB::table('products')->where('name', 'Mikasa Floors')->update([
            'product_types' => json_encode([
                ['type' => 'Atmos (10 mm)', 'warranty' => '10 yrs'],
                ['type' => 'Pristine (15 mm)', 'warranty' => '30 yrs'],
                ['type' => 'Atmos (10 mm)', 'warranty' => '3 yrs'],
                ['type' => 'Pristine (15 mm)', 'warranty' => '5 yrs'],
            ]),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_types');
        });
    }
};
