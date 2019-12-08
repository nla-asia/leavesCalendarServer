<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLeaveAPIRequest;
use App\Http\Requests\API\UpdateLeaveAPIRequest;
use App\Models\Leave;
use App\Repositories\LeaveRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;

/**
 * Class LeaveController
 * @package App\Http\Controllers\API
 */

class LeaveAPIController extends AppBaseController
{
    /** @var  LeaveRepository */
    private $leaveRepository;

    public function __construct(LeaveRepository $leaveRepo)
    {
        $this->leaveRepository = $leaveRepo;
    }

    /**
     * Display a listing of the Leave.
     * GET|HEAD /leaves
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $leaves = $this->leaveRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($leaves->toArray(), 'Leaves retrieved successfully');
    }

    /**
     * Display a listing of the Leave.
     * GET|HEAD /leaves
     *
     * @param Request $request
     * @return Response
     */
    public function my_index(Request $request)
    {
        $filters = $request->except(['skip', 'limit']);
        $filters['employee_id'] = Auth::id();
        $leaves = Leave::join("employees","employees.id","=","leaves.employee_id")
        ->where("leaves.employee_id", $filters['employee_id'])
        ->select("leaves.*", "employees.name as employee_name")
        ->get();

        return $this->sendResponse($leaves->toArray(), 'Leaves retrieved successfully');
    }

    /**
     * Store a newly created Leave in storage.
     * POST /leaves
     *
     * @param CreateLeaveAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLeaveAPIRequest $request)
    {
        $input = $request->all();
        $input['employee_id'] = Auth::id();
        $leave = $this->leaveRepository->create($input);

        return $this->sendResponse($leave->toArray(), 'Leave saved successfully');
    }

    /**
     * Display the specified Leave.
     * GET|HEAD /leaves/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Leave $leave */
        $leave = $this->leaveRepository->find($id);

        if (empty($leave)) {
            return $this->sendError('Leave not found');
        }

        return $this->sendResponse($leave->toArray(), 'Leave retrieved successfully');
    }

    /**
     * Update the specified Leave in storage.
     * PUT/PATCH /leaves/{id}
     *
     * @param int $id
     * @param UpdateLeaveAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeaveAPIRequest $request)
    {
        $input = $request->all();

        /** @var Leave $leave */
        $leave = $this->leaveRepository->find($id);

        if (empty($leave)) {
            return $this->sendError('Leave not found');
        }

        $leave = $this->leaveRepository->update($input, $id);

        return $this->sendResponse($leave->toArray(), 'Leave updated successfully');
    }

    /**
     * Remove the specified Leave from storage.
     * DELETE /leaves/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Leave $leave */
        $leave = $this->leaveRepository->find($id);

        if (empty($leave)) {
            return $this->sendError('Leave not found');
        }

        $leave->delete();

        return $this->sendSuccess('Leave deleted successfully');
    }
}
