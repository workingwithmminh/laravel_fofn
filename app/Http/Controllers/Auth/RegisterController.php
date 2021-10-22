<?php

namespace App\Http\Controllers\Auth;

use App\Agent;
use App\Events\RegisterEvent;
use App\User;
use App\UserProfiles;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('adminlte::auth.register');
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

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
            'name'     => 'required|max:255',
            'username' => 'required|numeric|digits_between:7,13|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'terms'    => 'required',

            'role' => [
	            'required',
	            Rule::in([config('settings.roles.customer'),config('settings.roles.agent_admin')]),
            ],
            'profile.birthday' => 'nullable|date_format:Y-m-d',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $fields = [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ];
        if (config('auth.providers.users.field','email') === 'username' && isset($data['username'])) {
            $fields['username'] = $data['username'];
        }
	    $user = new User();
	    \DB::transaction(function () use($fields, $data, &$user) {
	        //data agent
	        $agentFields = [
	            'name' => $data['name'],
                'phone' => $data['username'],
                'email' => $data['email']
            ];

	    	//prepare
		    $role = $data['role'];
		    $profile = $data['profile'];
		    $profile['phone'] = $fields['username'];//ten dang nhap la sdt
		    //neu là đăng ký đại lý, thì active = false, cần admin tự active
		    if($role === config('settings.roles.agent_admin')){
			    $fields['active'] = config("settings.inactive");
                //create agent
                $agent = Agent::create($agentFields);
                if ($agent){
                    $fields['agent_id'] = $agent->id;
                }
		    }
		    //add user
		    $user = User::create($fields);
		    //add profile
		    $user->profile()->save(new UserProfiles($profile));
		    //role
		    $user->assignRole($role);
	    });

	    return $user;
    }
	public function register(Request $request)
	{
		$this->validator($request->all())->validate();
        $user = $this->create($request->all());

		event(new Registered($user));

		//nếu user đã kích hoạt: đại lý
		if($request->role === config('settings.roles.agent_admin')) {
			$message = __('message.user.agent_account_success');
			if($request->wantsJson()){
				return response()->json([
					'success' => 'OK',
					'message' => $message
				]);
			}
			//dại lý
			\Session::flash('flash_info', $message);

			event(new RegisterEvent($user));

			return back();
		}else{
			$message = __('message.user.account_success');
			if($request->wantsJson()){
				return response()->json([
					'success' => 'OK',
					'message' => $message
				]);
			}

			\Session::flash('flash_message', $message);

			$this->guard()->login( $user );

			return $this->registered($request, $user)
				?: redirect($this->redirectPath());
		}
	}
}
