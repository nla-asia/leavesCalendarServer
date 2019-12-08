<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLeaveTypeAPIRequest;
use App\Http\Requests\API\UpdateLeaveTypeAPIRequest;
use App\Models\LeaveType;
use App\Repositories\LeaveTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LeaveTypeController
 * @package App\Http\Controllers\API
 */

class LeaveTypeAPIController extends AppBaseController
{
    /** @var  LeaveTypeRepository */
    private $leaveTypeRepository;

    public function __construct(LeaveTypeRepository $leaveTypeRepo)
    {
        $this->leaveTypeRepository = $leaveTypeRepo;
    }

    /**
     * Display a listing of the LeaveType.
     * GET|HEAD /leaveTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $leaveTypes = $this->leaveTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($leaveTypes->toArray(), 'Leave Types retrieved successfully');
    }

    /**
     * Store a newly created LeaveType in storage.
     * POST /leaveTypes
     *
     * @param CreateLeaveTypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLeaveTypeAPIRequest $request)
    {
        $input = $request->all();

        $leaveType = $this->leaveTypeRepository->create($input);

        return $this->sendResponse($leaveType->toArray(), 'Leave Type saved successfully');
    }

    /**
     * Display the specified LeaveType.
     * GET|HEAD /leaveTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LeaveType $leaveType */
        $leaveType = $this->leaveTypeRepository->find($id);

        if (empty($leaveType)) {
            return $this->sendError('Leave Type not found');
        }

        return $this->sendResponse($leaveType->toArray(), 'Leave Type retrieved successfully');
    }

    /**
     * Update the specified LeaveType in storage.
     * PUT/PATCH /leaveTypes/{id}
     *
     * @param int $id
     * @param UpdateLeaveTypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeaveTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var LeaveType $leaveType */
        $leaveType = $this->leaveTypeRepository->find($id);

        if (empty($leaveType)) {
            return $this->sendError('Leave Type not found');
        }

        $leaveType = $this->leaveTypeRepository->update($input, $id);

        return $this->sendResponse($leaveType->toArray(), 'LeaveType updated successfully');
    }

    /**
     * Remove the specified LeaveType from storage.
     * DELETE /leaveTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var LeaveType $leaveType */
        $leaveType = $this->leaveTypeRepository->find($id);

        if (empty($leaveType)) {
            return $this->sendError('Leave Type not found');
        }

        $leaveType->delete();

        return $this->sendResponse([],'Leave Type deleted successfully');
    }
}
