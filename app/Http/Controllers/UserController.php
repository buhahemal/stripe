<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateuserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DataTables;
use Exception;
use GrahamCampbell\ResultType\Result;
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
                $actionBtn = '<a href="javascript:void(0)" id="' . $row->id . '" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
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
            $files = $createUserRequest->profileimg;
            $profileImage = time() . "." . $files->getClientOriginalExtension();
            $files->move(public_path('/profileimages/'), $profileImage);
            DB::beginTransaction();
            $user = User::create([
                'firstname' => $createUserRequest->firstName,
                'lastname' => $createUserRequest->lastName,
                'email' => $createUserRequest->email,
                'birthdate' => $createUserRequest->dateofbirth,
                'profileimg' => $profileImage,
                'currentaddress' => $createUserRequest->currentaddress,
                'permenentaddress' => $createUserRequest->permenentaddress,
            ]);
            $user->roles()->sync($createUserRequest->roles);
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
            return Response::json(['code' => CodeResponse::HTTP_NOT_FOUND, 'message' => 'Employee Record Not Found'], CodeResponse::HTTP_NOT_FOUND);
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
            return Response::json(['code' => CodeResponse::HTTP_NOT_FOUND, 'message' => 'Employee Record Not Found'], CodeResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateuserRequest $UpdateUserRequest, $userid)
    {
        try {
            $user =  User::findorfail($userid);
            if($UpdateUserRequest->hasFile('profileimg')) {
                $profileImg = $UpdateUserRequest->file('profileimg');
                $profileImage = time() . "." . $profileImg->getClientOriginalExtension();
                $profileImg->move(public_path('profileimages'), $profileImage);
                $user->profileimg = $profileImage;
            }
            DB::beginTransaction();
            $user->firstname = $UpdateUserRequest->firstName;
            $user->lastname = $UpdateUserRequest->lastName;
            $user->email  = $UpdateUserRequest->email;
            $user->birthdate = $UpdateUserRequest->dateofbirth;
            $user->currentaddress = $UpdateUserRequest->currentaddress;
            $user->permenentaddress = $UpdateUserRequest->permenentaddress;
            $user->update();
            $user->roles()->sync($UpdateUserRequest->Eroles);
            DB::commit();
            return Response::json($UpdateUserRequest->all());
        } catch (ModelNotFoundException $th) {
            return Response::json(['code' => CodeResponse::HTTP_NOT_FOUND, 'message' => 'Employee Record Not Found'], CodeResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userid)
    {
        try {
            $user = User::findorfail($userid);
            $user->roles()->detach();
            $user->delete();
            return Response::json(['code' => CodeResponse::HTTP_OK, 'message' => 'Employee Record Deleted Successfully!.']);
        } catch (ModelNotFoundException $th) {
            return Response::json(['code' => CodeResponse::HTTP_NOT_FOUND, 'message' => 'Employee Record Not Found'], CodeResponse::HTTP_NOT_FOUND);
        }
    }
}
