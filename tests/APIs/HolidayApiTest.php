<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Holiday;

class HolidayApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_holiday()
    {
        $holiday = factory(Holiday::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/holidays', $holiday
        );

        $this->assertApiResponse($holiday);
    }

    /**
     * @test
     */
    public function test_read_holiday()
    {
        $holiday = factory(Holiday::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/holidays/'.$holiday->id
        );

        $this->assertApiResponse($holiday->toArray());
    }

    /**
     * @test
     */
    public function test_update_holiday()
    {
        $holiday = factory(Holiday::class)->create();
        $editedHoliday = factory(Holiday::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/holidays/'.$holiday->id,
            $editedHoliday
        );

        $this->assertApiResponse($editedHoliday);
    }

    /**
     * @test
     */
    public function test_delete_holiday()
    {
        $holiday = factory(Holiday::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/holidays/'.$holiday->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/holidays/'.$holiday->id
        );

        $this->response->assertStatus(404);
    }
}
