<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DataTables;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response as CodeResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::pluck('rolename', 'id');
        return view('users')->with('roles', $roles);
    }

    public function getusers()
    {
        $query = User::with('roles');
        return DataTables::eloquent($query)
            ->limit(function ($query) {
                $query->where('id', '>', request('start'));
            })
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="javascript:void(0)" id="'.$row->id.'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $createUserRequest)
    {
        try {
            $file = $createUserRequest->profileimg->store('public');
            DB::beginTransaction();
            $user = User::create([
                'firstname' => $createUserRequest->firstName,
                'lastname' => $createUserRequest->lastName,
                'email' => $createUserRequest->email,
                'birthdate' => strtotime($createUserRequest->dateofbirth),
                'profileimg' => $file,
                'currentaddress' => $createUserRequest->currentaddress,
                'permenentaddress' => $createUserRequest->permenentaddress,
            ]);
            $roles = array_map(function ($role) use ($user) {
                return array(
                    'roleid' => $role[0],
                    'userid' => $user->id
                );
            }, $createUserRequest->roles);
            $roles = UserHasRole::insert($roles);
            DB::commit();
            return Response::json(['code' => CodeResponse::HTTP_CREATED, 'message' => 'Employee created successfully!']);
        } catch (Exception $th) {
            return Response::json(['code' => CodeResponse::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Oops Its Not you its us!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        try {
            $user = User::findorfail($userId);
            $user = $user->load('roles');
            return Response::json(['code' => CodeResponse::HTTP_OK, 'user' => $user]);
        } catch (ModelNotFoundException $th) {
            return Response::json(['code' => CodeResponse::HTTP_NOT_FOUND,'message' => 'Employee Record Not Found'],CodeResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId)
    {
        try {
            $user = User::findorfail($userId);
            $user = $user->load('roles');
            return Response::json(['code' => CodeResponse::HTTP_OK, 'user' => $user]);
        } catch (ModelNotFoundException $th) {
            return Response::json(['code' => CodeResponse::HTTP_NOT_FOUND,'message' => 'Employee Record Not Found'],CodeResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return Response::json(['code' => CodeResponse::HTTP_OK, 'user' => true]);
        } catch (ModelNotFoundException $th) {
            return Response::json(['code' => CodeResponse::HTTP_NOT_FOUND,'message' => 'Employee Record Not Found'],CodeResponse::HTTP_NOT_FOUND);
        }
    }
}
