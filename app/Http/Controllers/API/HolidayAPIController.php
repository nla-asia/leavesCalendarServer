<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateHolidayAPIRequest;
use App\Http\Requests\API\UpdateHolidayAPIRequest;
use App\Models\Holiday;
use App\Repositories\HolidayRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class HolidayController
 * @package App\Http\Controllers\API
 */

class HolidayAPIController extends AppBaseController
{
    /** @var  HolidayRepository */
    private $holidayRepository;

    public function __construct(HolidayRepository $holidayRepo)
    {
        $this->holidayRepository = $holidayRepo;
    }

    /**
     * Display a listing of the Holiday.
     * GET|HEAD /holidays
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $holidays = $this->holidayRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($holidays->toArray(), 'Holidays retrieved successfully');
    }

    /**
     * Store a newly created Holiday in storage.
     * POST /holidays
     *
     * @param CreateHolidayAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateHolidayAPIRequest $request)
    {
        $input = $request->all();

        $holiday = $this->holidayRepository->create($input);

        return $this->sendResponse($holiday->toArray(), 'Holiday saved successfully');
    }

    /**
     * Display the specified Holiday.
     * GET|HEAD /holidays/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Holiday $holiday */
        $holiday = $this->holidayRepository->find($id);

        if (empty($holiday)) {
            return $this->sendError('Holiday not found');
        }

        return $this->sendResponse($holiday->toArray(), 'Holiday retrieved successfully');
    }

    /**
     * Update the specified Holiday in storage.
     * PUT/PATCH /holidays/{id}
     *
     * @param int $id
     * @param UpdateHolidayAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHolidayAPIRequest $request)
    {
        $input = $request->all();

        /** @var Holiday $holiday */
        $holiday = $this->holidayRepository->find($id);

        if (empty($holiday)) {
            return $this->sendError('Holiday not found');
        }

        $holiday = $this->holidayRepository->update($input, $id);

        return $this->sendResponse($holiday->toArray(), 'Holiday updated successfully');
    }

    /**
     * Remove the specified Holiday from storage.
     * DELETE /holidays/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Holiday $holiday */
        $holiday = $this->holidayRepository->find($id);

        if (empty($holiday)) {
            return $this->sendError('Holiday not found');
        }

        $holiday->delete();

        return $this->sendResponse([],'Holiday deleted successfully');
    }
}
