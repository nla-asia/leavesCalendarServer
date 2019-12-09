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
        $leaves = Leave::join("employees","employees.id","=","leaves.employee_id")
        ->join("leave_types","leave_types.id","=","leaves.type")
        ->select("leaves.*", "employees.name as employee_name","leave_types.name as leave_name")
        ->orderBy("leaves.created_at","DESC")
        ->get();

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
        ->join("leave_types","leave_types.id","=","leaves.type")
        ->where("leaves.employee_id", $filters['employee_id'])
        ->select("leaves.*", "employees.name as employee_name","leave_types.name as leave_name")
        ->orderBy("leaves.created_at","DESC")
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

        return $this->sendResponse([],'Leave deleted successfully');
    }



    private static function getCsv($columnNames, $rows, $fileName = 'file.csv') {
     
        $headers = [
            "Content-Encoding"=> "UTF-8",
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $callback = function() use ($columnNames, $rows ) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }




    /**
     *  export Leave. in pdf
     * GET|HEAD /leaves/{id}
     *
     * @param Request
     *
     * @return Response
     */
    public function export_pdf(Request $request)
    {


        return $this->sendResponse($request->all(), 'Leave exported successfully');
    }



    public function export_excel(Request $request){
        $headers = ['ID','Employee Name', 'Leave Type', 'Start Date', 'End Date'];
        $rows = [];
        $start = $request->start_date;
        $end = $request->end_date;
        $employee_id = $request->employee_id;

        $leaves =  Leave::join("employees","employees.id","=","leaves.employee_id")
        ->join("leave_types","leave_types.id","=","leaves.type")
        ->select("leaves.*", "employees.name as employee_name","leave_types.name as leave_name")
        ->orderBy("leaves.created_at","ASC")
        ->get();

        foreach($leaves as $l){

             $rows[] = [$l->id, $l->employee_name, $l->leave_name, $l->start_date, $l->end_date];
        }

        return self::getCsv($headers, $rows, 'leaves_history.xls');
    }




}
