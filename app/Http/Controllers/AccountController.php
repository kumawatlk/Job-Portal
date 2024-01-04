<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    public function regitration(){
        return view("front.account.registration");
    }

    public function proccessregisration(Request $request){
        // echo 1111;die();    
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:3',
            'confirm_password'=>'required|same:password',
        ], [
            'confirm_password.same' => 'The password and confirmation must match.',
        ]);
        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            Session::flash('message', 'You have registered successfully');
            return response()->json([
                'status'=>true,
                'error'=>[],
                'msg'=>'User Register SuccessFully'
            ]);
        }else {
            return response()->json([
                'status'=>false,
                'error'=>$validator->errors()
            ]);
        }
    }
    public function login(){
        return view('front.account.login');
    }
    public function authenticate(Request $request){
        // print_r($request->all());
        // die();
        $validator = validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
                // return redirect()
                Session::flash('success','You have logged in SuccessFullly');
                return redirect()->route('profile');
            }else {
                return redirect()->route('account.login')->with('error','Either Email/Password is incorrect');
            }
        }else {
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
            // return response()->json([
            //     'status'=>false,
            //     'error'=>$validator->error
            // ]);
        }

    }
    public function profile(){
        $auth_user_id = Auth::user()->id;

        $user_data = User::find($auth_user_id);
        // echo "<pre>";
        // print_r($user_data);
        // die();
        return view('front.account.profile',compact('user_data'));
    }
public function profile_update(Request $request){
    // echo "<pre>";
    // print_r($request->all());
    // die();
    $user_id = Auth::user()->id;
    $validator = Validator::make($request->all(),[
        'name'=>'required|min:5|max:20',
        // 'email'=>'required|email',
        'email'=>'required|email|unique:users,email,'.$user_id.',id',
        'designation'=>'required',
        'mobile'=>'required|min:10|max:11',

    ]);


    if ($validator->passes()) {
        
        $update_profile = User:: find($user_id);
        $update_profile->name = $request->name;
        $update_profile->email = $request->email;
        $update_profile->designation = $request->designation;
        $update_profile->mobile = $request->mobile;
        $update_profile->save();
        Session::flash('success','Your Profile Has Been Updated Succcessfully');
        return response()->json([
            'status'=>true,
            // 'msg'=>
        ]);
    }else {
        // echo 1111;
        // die();
        return response()->json([
            'status'=>false,
            'error'=>$validator->errors()
        ]);
    }
}

public function profilepic(Request $request){
    // echo 11;
    // dd($request->all());
    $validator = Validator::make($request->all(),[
        'image'=>'required|image'
    ]);

    if ($validator->passes()) {
        $folderPath = public_path('/upload/profile'); // Adjust the path as needed
        if (File::isDirectory($folderPath)) {

        File::deleteDirectory($folderPath);
        $image = $request->file('image');
        $imagename =time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path("/upload/profile"),$imagename);
        // create new image instance
        $source_path = public_path("/upload/profile/".$imagename);
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($source_path); // 800 x 600
        // $image = $image->brightness(70);
        // $image = $image->blur(3);
        // mirror image
        // $image = $image->setLoops(3);
        $image = $image->fill('#b53717', 10, 10);


        // $image = $image->flip();
        // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
        $image->cover(150, 150);
        // print_r($image);
        // die();
        $image->toPng()->save(public_path(('upload/thumb/'.$imagename)));

        $user_id = Auth::user()->id;
        $update_profile_pic =User:: find($user_id);
        $update_profile_pic->image = $imagename;
        $update_profile_pic->save();
        if ($update_profile_pic == true) {
            Session::Flash('success','Profile Pic Updated uccessfully');
            return response()->json([
                'status'=>true
            ]);   
        }
        }
    }else {
        return response()->json([
            'status'=>false,
            'error'=>$validator->errors()
        ]);
    }
}
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');

    }
}
