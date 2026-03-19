<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;

class UserController extends Controller
{
    use ApiResponser;
    
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    //Old code
    /*public function getUsers()
    {
        $users = User::all();
        return response()->json($users,200);
    }*/
    
    //Get all users
    public function index()
    {
        $users = User::all();
        return $this->successResponse($users);
    }

    /**
     * Create a new user
     */
    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender'   => 'required|in:Male,Female',
        ];

        $this->validate($request, $rules);
        
        $user = User::create($request->all());
        
        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Obtain and show one user
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        //Optional
        /*if(!$user){
            return response()->json(['message' => 'User not Found'])
        }*/
        return $this->successResponse($user);
    }

    /**
     * Update an existing user
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender'   => 'in:Male,Female',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($id);
        $user->fill($request->all());

        if ($user->isClean()) {
            return $this->errorResponse(
                'At least one value must change', 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $user->save();
        return $this->successResponse($user);
    }

    /**
     * Remove an existing user
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->successResponse($user);
    }
}