<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Mail\VeryfyUserByMail;
use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
                $this->middleware('guest');
               
  
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
    
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verifyToken' => str_random(20),
           
        ]);
        Mail::to($user->email)->send(new VeryfyUserByMail($user));
       return  $user;
    }
    public function verifyUser($email, $token){
        
        $user = User::where(['email'=>$email,'verifyToken'=>$token])->first();
        if($user){
            $user->verifyToken='';
            $user->status=1;
            if($user->save()){
                
                return redirect('login')->with('message','your account is verify sucessfully');
            } else {
            return redirect('login')->with('message', 'invalid email or token');    
            }
            
        } else {
         return redirect('login')->with('message','there is mismatch the token');    
        }
        
    }
}
