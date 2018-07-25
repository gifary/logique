<?php
/**
 * Created by PhpStorm.
 * User: gifary
 * Date: 6/30/18
 * Time: 8:45 AM
 */

namespace App\Http\Controllers;


use App\Address;
use App\CreditCard;
use App\Membership;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
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

    public function getMemberShip(Request $request){
        if ($request->has('q')) {
            $membership = Membership::where("name",'like','%'.$request->input('q').'%')->get();
            return response()->json($membership);
        }
    }

    public function saveData(Request $request){

        $this->validate($request, [
            'first_name'   => 'string|max:255',
            'last_name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email',
            'password'=>'required',
            'date_of_birth'=>'required',
            'card_number'=>'required',
            'expiry_month'=> 'required',
            'expiry_year'=>'required',
            'card_type'=>'required',
            'membership_id'=>'required|exists:memberships,id'
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        $list_address= $request->addresses;
        for($i=0; $i<sizeof($list_address);$i++){
            if(!empty($list_address[$i])){
                $address = new Address(['address'=>$list_address[$i]]);

                $user->addresses()->save($address);
            }
        }

        //input credit card
        $creditCard = new CreditCard($request->only(['card_number','expiry_month','expiry_year','card_type']));
        $user->creditCards()->save($creditCard);

        //input many to many memberships
//        $memberShips = Membership::find($request->membership_id);
        $user->memberships()->attach($request->membership_id);

        return redirect('login')->with('message', 'Success register, You can login now');

    }
    public function showLogin()
    {
        // show the form
        return view('login');
    }

    public function doLogin(Request$request){
        $this->validate($request, [
            'email'  => 'required|email',
            'password'=>'required'
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            echo "sukses login";
        }else{
            return redirect('login')->with("message","Wrong email or password");
        }

    }
}