<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\LoanController;
use Tests\TestCase;
use App\Models\{User, Loan};
use Laravel\Sanctum\Sanctum;

class LoanTest extends TestCase
{
    /**
     * customer loan request
     *
     * @return void
     */
    public function test_loan_request()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $loan = Loan::factory()->make();
        $this->postJson(action([LoanController::class, 'create']), $loan->toArray())
                         ->assertStatus(201)
                         ->assertJsonStructure([
                            'id',
                            'amount',
                            'duration',
                            'interest_rate',
                            'arrangement_fee',
                            'user_id'
                        ]);

        $this->assertTrue(true);
    }

    /**
     * customer loan request with invalid request
     *
     * @return void
     */
    public function test_loan_invalid_request()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->postJson(action([LoanController::class, 'create']), [])
                         ->assertStatus(422)
                         ->assertJson(['message' => 'The given data was invalid.']);

        $this->assertTrue(true);
    }

    /**
     * get loan details for loan status
     *
     * @return void
     */
    public function test_loan_details()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $loan = Loan::first();
        $this->get(action([LoanController::class, 'get'], $loan->id))
                         ->assertStatus(200)
                         ->assertJsonStructure([
                            'id',
                            'amount',
                            'duration',
                            'interest_rate',
                            'arrangement_fee',
                            'user_id'
                        ]);

        $this->assertTrue(true);
    }

    /**
     * loan details not found test
     *
     * @return void
     */
    public function test_loan_details_not_found()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $loan = Loan::first();
        $response = $this->get(action([LoanController::class, 'get'], 'abc'))
                         ->assertStatus(404);

        $this->assertTrue(true);
    }

    /**
     * loan approve by customer access deined
     *
     * @return void
     */
    public function test_loan_approve_by_customer()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $loan = Loan::where("status", "pending")->first();
        $this->postJson(action([LoanController::class, 'approve']), ["loanId" => $loan->id])
                         ->assertStatus(403)
                         ->assertJson(['message' => 'Access denied']);

        $this->assertTrue(true);
    }

    /**
     * loan approve
     *
     * @return void
     */
    public function test_loan_approve()
    {
        Sanctum::actingAs(
            User::factory()->admin()->create(),
            ['*']
        );

        $loan = Loan::where("status", "pending")->first();
        $this->postJson(action([LoanController::class, 'approve']), ["loanId" => $loan->id])
                         ->assertStatus(200)
                         ->assertJsonStructure([
                            'id',
                            'amount',
                            'duration',
                            'interest_rate',
                            'arrangement_fee',
                            'user_id'
                        ]);

        $this->assertTrue(true);
    }

    /**
     * loan repayment by customer
     *
     * @return void
     */
    public function test_loan_repayment()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $loan = Loan::where("status", "approve")->first();
        $response = $this->postJson(action([LoanController::class, 'repayment']), ["loanId" => $loan->id, "amount" => 3000, "transactionDetails" => "first payment"])
                         ->assertStatus(201)
                         ->assertJsonStructure([
                            'id',
                            'loan_id',
                            'amount',
                            'transaction_details'
                        ]);

        $this->assertTrue(true);
    }
}
