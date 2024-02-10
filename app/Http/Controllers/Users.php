<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Req_User;
use App\Http\Requests\Req_EditUser;

use Illuminate\Support\Facades\DB;


class Users extends Controller
{
    public function AddNewUser(Req_User $request){
        $newUser = $request->validated();
        $newUser['newPassword'] = bcrypt($newUser['newPassword']);
        $photo = $request->file('newPhoto');
        if($request->hasFile('newPhoto') && $photo->isValid() && in_array($photo->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif','webp']));
        $file_name = time().$newUser['newName'];
        $folder = 'data_file';

        if($photo->move($folder, $file_name)){
            $newUser['newPhoto'] = $file_name;
            $saveUser = User::create([
                'name' => $request->newName,
                'username' =>$request->newUsername,
                'password' =>$request->newPassword,
                'access' =>$request->newAccess,
                'image' =>$file_name
            ]);

            return redirect()->back()->with('success','Add new user Success');
        }else{
            return redirect()->back()->with('error','Add new user Failed');

        }

    }

    public function login(Request $request){
        $loginUser = $request->validate([
            'loginUsername' =>'required',
            'loginPassword' =>'required',
        ], [
            'loginUsername.required' => 'Username must be filled',
            'loginPassword.required' => 'Password must be filled',
        ]);
        if(auth()->attempt(['username' =>$loginUser['loginUsername'],'password' =>$loginUser['loginPassword']])){
            $request->session()->regenerate();
            $user = auth()->user();
            session(['name' => $user->name,'username' => $user->username, 'photo' => $user->image,]);    
        return redirect('/dashboard')->with('success','Login Success');
        }else{
        return redirect()->back()->with('error','Login Failed');
        }
    }

    public function logOut(){
        auth()->logout();
        return redirect('/')->with('success', 'Logout Success');
            }

    public function editUserForm(User $dataUser){
              if(!auth()->user()->id ){
                return redirect('/');
                }
           return view('editUserForm',['dataUser'=>$dataUser]);
            }

            // ! penting
            public function editUser(User $dataUser, Req_EditUser $request){
                if(auth()->check()){
                    $newEdit = $request->validated();
                    if(!empty($newEdit['editPassword'])){
                        $newEdit['editPassword'] = bcrypt($newEdit['editPassword']);
                    } 
                    $file_name = time().$newEdit['editName'].'_edited';
                    $editedUser = [
                        'name' => $request->editName,
                        'username' =>$request->editUsername,
                        'password' => $newEdit['editPassword'] ?: null,
                        'access' =>$request->editAccess,
                        'image' =>$file_name ?: null
                    ];
                    if(empty($newEdit['editName'])){
                        unset($editedUser['name']);
                    }
                    if(empty($newEdit['editUsername'])){
                        unset($editedUser['username']);
                    }
                    if(empty($newEdit['editPassword'])){
                        unset($editedUser['password']);
                    }
                    if (!$request->hasFile('editPhoto')) {
                        unset($editedUser['image']);
                    } else {
                        $editPhoto = $request->file('editPhoto');
                        if ($editPhoto->isValid() && in_array($editPhoto->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif','webp'])) {
                            $editPhoto->move('data_file', $file_name);
                            $newEdit['editPhoto'] = $file_name.$file->getClientOriginalName();
                        }
                    }
                    $dataUser->update($editedUser);
                    return redirect()->back()->with('success', 'update user success');
                
                } else {
                    return view('loginpage');
                }
            }

            public function deleteUser($dataUser){
                $UserToDelete = User::findOrFail($dataUser);
                $UserToDelete->delete();
                return redirect()->back()->with('success', 'update user success');
            }
            
            public function listUsers(){
                if(auth()->check()){
                    $user = auth()->id(); //menampilkan data user kecuali yang sedang login    
                    $dataUsers = DB::table('users')->whereNotIn('id',[$user])->get();
                    return view('listUsers',compact('dataUsers'));    
                }else{
                    return redirect('/');
                }
            }
        
            
        }
