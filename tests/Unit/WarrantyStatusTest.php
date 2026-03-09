<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\WarrantyRegistrationNew;
use App\Models\ProductDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WarrantyStatusTest extends TestCase
{
    /**
     * Test that mixed status (approved and rejected) results in approved overall status.
     * Note: This test assumes you have a testing database configured or can mock the model.
     * Since I cannot easily set up a full DB state in this environment,
     * I will mock the productDetails relation.
     */
    public function test_mixed_approved_and_rejected_is_approved()
    {
        $warranty = new WarrantyRegistrationNew();

        // We need to simulate the productDetails collection
        $product1 = new ProductDetail(['status' => 'approved']);
        $product2 = new ProductDetail(['status' => 'rejected']);

        // Manually setting the relation for testing purposes without DB
        $warranty->setRelation('productDetails', collect([$product1, $product2]));

        $this->assertEquals('approved', $warranty->overall_status);
    }

    public function test_all_rejected_is_rejected()
    {
        $warranty = new WarrantyRegistrationNew();

        $product1 = new ProductDetail(['status' => 'rejected']);
        $product2 = new ProductDetail(['status' => 'rejected']);

        $warranty->setRelation('productDetails', collect([$product1, $product2]));

        $this->assertEquals('rejected', $warranty->overall_status);
    }

    public function test_all_approved_is_approved()
    {
        $warranty = new WarrantyRegistrationNew();

        $product1 = new ProductDetail(['status' => 'approved']);
        $product2 = new ProductDetail(['status' => 'approved']);

        $warranty->setRelation('productDetails', collect([$product1, $product2]));

        $this->assertEquals('approved', $warranty->overall_status);
    }

    public function test_pending_takes_precedence_over_approved()
    {
        $warranty = new WarrantyRegistrationNew();

        $product1 = new ProductDetail(['status' => 'approved']);
        $product2 = new ProductDetail(['status' => 'pending']);

        $warranty->setRelation('productDetails', collect([$product1, $product2]));

        $this->assertEquals('pending', $warranty->overall_status);
    }
}
