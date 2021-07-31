<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Response as CodeResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function all()
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

    public function create($userDetails)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'firstname' => $userDetails->firstName,
                'lastname' => $userDetails->lastName,
                'email' => $userDetails->email,
                'birthdate' => $userDetails->dateofbirth,
                'profileimg' => $userDetails->profileimg,
                'currentaddress' => $userDetails->currentaddress,
                'permenentaddress' => $userDetails->permenentaddress,
            ]);
            $user->roles()->sync($userDetails->roles);
            DB::commit();
            return Response::json(['code' => CodeResponse::HTTP_CREATED, 'message' => 'Employee created successfully!']);
        } catch (Exception $th) {
            return Response::json(['code' => CodeResponse::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Oops Its Not you its us!']);
        }
    }

    public function Update($userId, $userDetails)
    {
        try {
            $user =  User::findorfail($userId);
            DB::beginTransaction();
            $user->firstname = $userDetails->firstName;
            $user->lastname = $userDetails->lastName;
            $user->email  = $userDetails->email;
            $user->birthdate = $userDetails->dateofbirth;
            $user->currentaddress = $userDetails->currentaddress;
            $user->permenentaddress = $userDetails->permenentaddress;
            if(!empty($userDetails->profileimg)){
                $user->profileimg  = $userDetails->profileimg;
            } 
            $user->update();
            $user->roles()->sync($userDetails->Eroles);
            DB::commit();
            return Response::json($userDetails->all());
        } catch (ModelNotFoundException $th) {
            return Response::json(['code' => CodeResponse::HTTP_NOT_FOUND, 'message' => 'Employee Record Not Found'], CodeResponse::HTTP_NOT_FOUND);
        }
    }

    public function Delete($userId)
    {
        try {
            $user = User::findorfail($userId);
            $user->roles()->detach();
            $user->delete();
            return Response::json(['code' => CodeResponse::HTTP_OK, 'message' => 'Employee Record Deleted Successfully!.']);
        } catch (ModelNotFoundException $th) {
            return Response::json(['code' => CodeResponse::HTTP_NOT_FOUND, 'message' => 'Employee Record Not Found'], CodeResponse::HTTP_NOT_FOUND);
        }
    }
}
