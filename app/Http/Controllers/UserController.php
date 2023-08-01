<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function include(){
        if(!auth()->user())
        {
           return  0;
        }
        else{
          return Cart::where('user_id',auth()->user()->id)->where('is_ordered',false)->count();
        }
   
   
         }
    public function userregister()
    {
       
        $itemsincart= $this->include();
        $categories = Category::orderBy('priority')->get();
        return view('userregister',compact('categories','itemsincart'));
    }

    public function userstore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\password::defaults()],
        ]);
    
        $data['password'] = Hash::make($data['password']);
    

        // dd(auth()->user()->role);
        // Check if the current user is authenticated (logged in)
        if (auth()->user()->role=='admin') {
            // Check if the authenticated user has the role 'admin'
           
                $data['role'] = 'admin';

        
                User::create($data);
                return redirect(route('user.userdetails'));
            
        } else {
            // If the user is not authenticated, or has a different role than 'admin'
            $data['role'] = 'users';
            User::create($data);
            return redirect(route('userlogin'));
        }
    }
        

    public function userdetails(){

       
        $users = User::all();
        return view('user.userdetails',compact('users'));    

     }

    public function userprofile() {
        $carts = Cart::all();
        $itemsincart = $this->include();
        $orders = Order::where('user_id',auth()->user()->id)->get();
        return view('userprofile', compact('carts', 'itemsincart', 'orders'));
    }


  
   
    public function editprofile(Request $id){
        $carts = Cart::all();
        $categories=Category::all();
        $itemsincart= $this->include();
        $users=User::find($id);
        return view('editprofile',compact('users','categories','carts','itemsincart'));
    }

    public function userupdate(Request $request){
        $user = User::find(auth()->user()->id);
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required | email',
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        // if ($request->has('password')) {
        //     $data['password'] = Hash::make($data['password']);
        // }
        if(auth()->user()){
            if(auth()->user()->role=='admin'){
            $data['role']='admin';
            $user->update($data);
            return redirect(route('adminprofile.index'));
        }
        else{
            $data['role']='user';
            $user->update($data);
            return redirect()->route('userprofile',$user->id);
            } 
    }
}

     public function createadmin(){
        return view('user.createadmin');
     }


     public function destroy(string $id){
        $user=User::find($id);
       if( $user->delete()){
        return redirect(route('user.userdetails'))->with('success',' Deleted Sucessfully!');
       }
       else
        return redirect(route('user.userdetails'))->with('success',' Cannot Deleted!');
        }

     
        // public function adminprofile() {
           
        //     return view('user.adminprofile');
        // }

       
        // public function adminupdate(Request $request){
        //     $user = User::find(auth()->user()->id);
        //     $data = $request->validate([
        //         'name' => 'required',
        //         'phone' => 'required',
        //         'address' => 'required',
        //         'email' => 'required | email',
        //         // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        //     ]);
        //     // if ($request->has('password')) {
        //     //     $data['password'] = Hash::make($data['password']);
        //     // }
        //     $user->update($data);
        
        //     return redirect()->route('adminprofile.update',$user->id)->with('success','Admin Profile updated successfully!');
        // }


        // public function adminedit(){
        //     if(auth()->user()){
        //         if(auth()->user()->role=='admin'){
        //     return view('adminprofile.edit');
        //         }
        // }
        // }

        public function adminprofile(){
            if(auth()->user()){
                if(auth()->user()->role=='admin'){
            return view('adminprofile.index');
                }
        }
        
        }
        public function adminedit(){
            if(auth()->user()){
                if(auth()->user()->role=='admin'){
            return view('adminprofile.edit');
                }
        }
        }







}




