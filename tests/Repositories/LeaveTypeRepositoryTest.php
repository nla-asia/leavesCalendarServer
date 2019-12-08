<?php namespace Tests\Repositories;

use App\Models\LeaveType;
use App\Repositories\LeaveTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LeaveTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LeaveTypeRepository
     */
    protected $leaveTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->leaveTypeRepo = \App::make(LeaveTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_leave_type()
    {
        $leaveType = factory(LeaveType::class)->make()->toArray();

        $createdLeaveType = $this->leaveTypeRepo->create($leaveType);

        $createdLeaveType = $createdLeaveType->toArray();
        $this->assertArrayHasKey('id', $createdLeaveType);
        $this->assertNotNull($createdLeaveType['id'], 'Created LeaveType must have id specified');
        $this->assertNotNull(LeaveType::find($createdLeaveType['id']), 'LeaveType with given id must be in DB');
        $this->assertModelData($leaveType, $createdLeaveType);
    }

    /**
     * @test read
     */
    public function test_read_leave_type()
    {
        $leaveType = factory(LeaveType::class)->create();

        $dbLeaveType = $this->leaveTypeRepo->find($leaveType->id);

        $dbLeaveType = $dbLeaveType->toArray();
        $this->assertModelData($leaveType->toArray(), $dbLeaveType);
    }

    /**
     * @test update
     */
    public function test_update_leave_type()
    {
        $leaveType = factory(LeaveType::class)->create();
        $fakeLeaveType = factory(LeaveType::class)->make()->toArray();

        $updatedLeaveType = $this->leaveTypeRepo->update($fakeLeaveType, $leaveType->id);

        $this->assertModelData($fakeLeaveType, $updatedLeaveType->toArray());
        $dbLeaveType = $this->leaveTypeRepo->find($leaveType->id);
        $this->assertModelData($fakeLeaveType, $dbLeaveType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_leave_type()
    {
        $leaveType = factory(LeaveType::class)->create();

        $resp = $this->leaveTypeRepo->delete($leaveType->id);

        $this->assertTrue($resp);
        $this->assertNull(LeaveType::find($leaveType->id), 'LeaveType should not exist in DB');
    }
}
