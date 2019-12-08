<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Leave;

class LeaveApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_leave()
    {
        $leave = factory(Leave::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/leaves', $leave
        );

        $this->assertApiResponse($leave);
    }

    /**
     * @test
     */
    public function test_read_leave()
    {
        $leave = factory(Leave::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/leaves/'.$leave->id
        );

        $this->assertApiResponse($leave->toArray());
    }

    /**
     * @test
     */
    public function test_update_leave()
    {
        $leave = factory(Leave::class)->create();
        $editedLeave = factory(Leave::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/leaves/'.$leave->id,
            $editedLeave
        );

        $this->assertApiResponse($editedLeave);
    }

    /**
     * @test
     */
    public function test_delete_leave()
    {
        $leave = factory(Leave::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/leaves/'.$leave->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/leaves/'.$leave->id
        );

        $this->response->assertStatus(404);
    }
}
