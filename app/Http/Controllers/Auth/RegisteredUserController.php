<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\inventory\location;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users=User::leftJoin('locations','users.location','=', 'locations.id')
        ->select('*','users.id as uid')->get();
            
            $locations=location::all();
                       
            return view('admin.dashboard',compact('users','locations'));
        
    }
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeo(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->attachRole('user');
        event(new Registered($user));

        Auth::login($user);

        return redirect('inventory/select/location');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'title' => ['required', 'string', 'max:6'],
            'contact' => ['string', 'max:20'],
            'is_active' => ['required', 'integer', 'max:3'],
            'avatar' => ['image', 'mimes:jpg,png', 'max:200'],
        ]);
        
        

        $photoPath ='';
        $input = $request->all();
      if($request->hasFile('avatar'))
        { 
            $request->validate(['avatar'=>'image']);
            $photoName=date('YmdHis').$request->surname.'.'.$request->file('avatar')->extension();
            $photoPath = $request->file('avatar')->storeAs('photos',$photoName,'public');

        }else
        {
            $photoPath='';
        }
        

        $user = User::create([
            
            'full_name' =>  $request->input('full_name'),
            'name' =>  $request->input('name'),
            'email' =>  $request->input('email'),
            'password' => Hash::make($input['password']),
            'title' =>  $request->input('title'),
            'contact' =>  $request->input('contact'),
            'location' =>  $request->input('location_id'),
            'avatar' => $photoPath,
            'is_active' =>  $request->input('is_active'),
            
        ]);
        
        $insertedUser=User::findOrFail($user->id);
        return redirect()->back()->with('success', 'User Added Successfully and Password sent to '.$input['email']);
        
    }
}
