<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEmployeeAPIRequest;
use App\Http\Requests\API\UpdateEmployeeAPIRequest;
use App\Http\Requests\API\EmployeeLoginRequest;
use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;


/**
 * Class EmployeeController
 * @package App\Http\Controllers\API
 */

class EmployeeAPIController extends AppBaseController
{
    /** @var  EmployeeRepository */
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepository = $employeeRepo;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(EmployeeLoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Username or password is incorrect!'], 401);
        }

        return $this->respondWithToken($token);
    }


        /**
     * Display the authenticated Employee.
     * GET|HEAD /employees/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show()
    {
        return response()->json(auth()->user());
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    /**
     * Display a listing of the Employee.
     * GET|HEAD /employees
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $employees = $this->employeeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($employees->toArray(), 'Employees retrieved successfully');
    }

    /**
     * Store a newly created Employee in storage.
     * POST /employees
     *
     * @param CreateEmployeeAPIRequest $request
     *
     * @return Response
     */
    public function register(CreateEmployeeAPIRequest $request)
    {
        $input = $request->all();

        $input['password'] = Hash::make($request->password);

        $employee = $this->employeeRepository->create($input);


        return $this->sendResponse($employee->toArray(), 'Employee saved successfully');
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = Auth::user();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user'=> $user
        ]);
    }

}
