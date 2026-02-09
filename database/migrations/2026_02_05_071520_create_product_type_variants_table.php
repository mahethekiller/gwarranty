<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_type_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_type_id')->constrained()->onDelete('cascade');
            $table->string('variant_name');
            $table->string('warranty_period');
            $table->string('usage_type')->nullable()->comment('Residential/Commercial');
            $table->json('additional_data')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('product_type_id');
        });

        // Get product type IDs
        $mikasaPlyId = DB::table('product_types')->where('slug', 'mikasa-ply')->value('id');
        $mikasaFloorsId = DB::table('product_types')->where('slug', 'mikasa-floors')->value('id');

        // Insert Mikasa Floor variants
        DB::table('product_type_variants')->insert([
            [
                'product_type_id' => $mikasaFloorsId,
                'variant_name' => 'Atmos (10 mm)',
                'warranty_period' => '10 yrs',
                'usage_type' => 'Residential'
            ],
            [
                'product_type_id' => $mikasaFloorsId,
                'variant_name' => 'Pristine (15 mm)',
                'warranty_period' => '30 yrs',
                'usage_type' => 'Residential'
            ],
            [
                'product_type_id' => $mikasaFloorsId,
                'variant_name' => 'Atmos (10 mm)',
                'warranty_period' => '3 yrs',
                'usage_type' => 'Commercial'
            ],
            [
                'product_type_id' => $mikasaFloorsId,
                'variant_name' => 'Pristine (15 mm)',
                'warranty_period' => '5 yrs',
                'usage_type' => 'Commercial'
            ],
        ]);

        // Insert Mikasa Ply variants
        DB::table('product_type_variants')->insert([
            [
                'product_type_id' => $mikasaPlyId,
                'variant_name' => 'Fire Guardian',
                'warranty_period' => '30 yrs',
                'usage_type' => null
            ],
            [
                'product_type_id' => $mikasaPlyId,
                'variant_name' => 'Marine Blue Blockboard',
                'warranty_period' => '25 yrs',
                'usage_type' => null
            ],
            [
                'product_type_id' => $mikasaPlyId,
                'variant_name' => 'Marine Blue',
                'warranty_period' => '30 yrs',
                'usage_type' => null
            ],
            [
                'product_type_id' => $mikasaPlyId,
                'variant_name' => 'Marine',
                'warranty_period' => '25 yrs',
                'usage_type' => null
            ],
            [
                'product_type_id' => $mikasaPlyId,
                'variant_name' => 'MR+ Blockboard',
                'warranty_period' => '15 yrs',
                'usage_type' => null
            ],
            [
                'product_type_id' => $mikasaPlyId,
                'variant_name' => 'MR+',
                'warranty_period' => '15 yrs',
                'usage_type' => null
            ],
            [
                'product_type_id' => $mikasaPlyId,
                'variant_name' => 'Sapphire',
                'warranty_period' => 'Lifetime',
                'usage_type' => null
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('product_type_variants');
    }
};
