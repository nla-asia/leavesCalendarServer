<?php namespace Tests\Repositories;

use App\Models\Leave;
use App\Repositories\LeaveRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LeaveRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LeaveRepository
     */
    protected $leaveRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->leaveRepo = \App::make(LeaveRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_leave()
    {
        $leave = factory(Leave::class)->make()->toArray();

        $createdLeave = $this->leaveRepo->create($leave);

        $createdLeave = $createdLeave->toArray();
        $this->assertArrayHasKey('id', $createdLeave);
        $this->assertNotNull($createdLeave['id'], 'Created Leave must have id specified');
        $this->assertNotNull(Leave::find($createdLeave['id']), 'Leave with given id must be in DB');
        $this->assertModelData($leave, $createdLeave);
    }

    /**
     * @test read
     */
    public function test_read_leave()
    {
        $leave = factory(Leave::class)->create();

        $dbLeave = $this->leaveRepo->find($leave->id);

        $dbLeave = $dbLeave->toArray();
        $this->assertModelData($leave->toArray(), $dbLeave);
    }

    /**
     * @test update
     */
    public function test_update_leave()
    {
        $leave = factory(Leave::class)->create();
        $fakeLeave = factory(Leave::class)->make()->toArray();

        $updatedLeave = $this->leaveRepo->update($fakeLeave, $leave->id);

        $this->assertModelData($fakeLeave, $updatedLeave->toArray());
        $dbLeave = $this->leaveRepo->find($leave->id);
        $this->assertModelData($fakeLeave, $dbLeave->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_leave()
    {
        $leave = factory(Leave::class)->create();

        $resp = $this->leaveRepo->delete($leave->id);

        $this->assertTrue($resp);
        $this->assertNull(Leave::find($leave->id), 'Leave should not exist in DB');
    }
}
