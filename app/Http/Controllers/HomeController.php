<?php
/**
 * Created by PhpStorm.
 * User: gifary
 * Date: 6/30/18
 * Time: 8:45 AM
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function index()
    {
        $user  =User::all();
        return view('welcome',compact("user"));
    }

    public function checkEmail(Request $request)
    {
        $user = User::where('email',$request->input("email"))->first();
        if($user instanceof User){
            return response()->json([
                'status' => true
            ]);
        }else{
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function saveData(Request $request){
        $this->validate($request, [
            'name'   => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email'  => 'required|email|unique:users,email',
            'foto'  => 'required'
        ]);

        $pathFoto='';
        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')->store('logo','public');
        }

        $data = $request->except(['foto']);
        $data['foto'] = $pathFoto;
        $data['password']= bcrypt(123456); //default password

        $user = User::create($data);
        return response()->json(
            $user
        );
    }
}