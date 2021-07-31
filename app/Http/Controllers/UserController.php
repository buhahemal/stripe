<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateuserRequest;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\FileService;

class UserController extends Controller
{
    private $user;
    private $role;
    public function __construct(UserRepositoryInterface $user,RoleRepositoryInterface $role)
    {
        $this->user = $user;
        $this->role = $role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->role->getRoleNameAndId();
        return view('users')->with('roles', $roles);
    }

    public function getUsers()
    {
      return $this->user->all();
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
        $profileImg = (new FileService())->addMedia($createUserRequest->profileimg,public_path('/profileimages/'));
        $createUserRequest->profileimg = $profileImg;
        return $this->user->create($createUserRequest); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        return $this->user->show($userId);    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId)
    {
        return $this->user->show($userId);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateuserRequest $UpdateUserRequest, $userId)
    {
        if($UpdateUserRequest->hasFile('profileimg')) {
            $UpdateUserRequest->profileimg = (new FileService())->addMedia($UpdateUserRequest->profileimg,public_path('/profileimages/'));;
        }
        return $this->user->Update($userId,$UpdateUserRequest);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        return $this->user->Delete($userId);
    }
}
