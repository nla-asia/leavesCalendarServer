<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LeaveType;

class LeaveTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_leave_type()
    {
        $leaveType = factory(LeaveType::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/leave_types', $leaveType
        );

        $this->assertApiResponse($leaveType);
    }

    /**
     * @test
     */
    public function test_read_leave_type()
    {
        $leaveType = factory(LeaveType::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/leave_types/'.$leaveType->id
        );

        $this->assertApiResponse($leaveType->toArray());
    }

    /**
     * @test
     */
    public function test_update_leave_type()
    {
        $leaveType = factory(LeaveType::class)->create();
        $editedLeaveType = factory(LeaveType::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/leave_types/'.$leaveType->id,
            $editedLeaveType
        );

        $this->assertApiResponse($editedLeaveType);
    }

    /**
     * @test
     */
    public function test_delete_leave_type()
    {
        $leaveType = factory(LeaveType::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/leave_types/'.$leaveType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/leave_types/'.$leaveType->id
        );

        $this->response->assertStatus(404);
    }
}
