<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;
    public function __construct(UserInterface $userRepository){
    	$this->user = $userRepository;
    }

    public function showAllUsers()
    {
        return response()->json($this->user->showAllUsers(),200);
    }

    public function show($id)
    {
        return response()->json($this->user->show($id),200);
    }




    public function update($id, Request $request)
    {
        if($id  != \Auth::id()){
            return  response()->json(['failed','You can not edit other users'], 401);
        }

        return response()->json($this->user->update($id,$request->all()), 200);
    }

    public function delete($id)
    {
        if($id  != \Auth::id()){
            return  response()->json(['failed','You can not edit other users'], 401);
        }
        $this->user->destroy($id);
        return response('Deleted Successfully', 200);
    }
    //
}
