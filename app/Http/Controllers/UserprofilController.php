<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserprofilController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit()
    {
        //
        $user = User::find(Auth()->user()->id);

        return view('editprofil', compact('user'));
    }

    public function update(Request $request)
    {

        //UPDATE TAB
        $update = [];

        //Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'photo' => '|mimes:jpg,png,jpeg|max:5048',
        ]);

        //VALIDATE PASSWORD = CONFIRM PASSWORD
        if($request->password){
            if($request->password !== $request->password_confirmation){
                return redirect()->route('editprofil')->withErrors('Les mots de passe ne correspondent pas');
            }
        }

        //VALIDATE EMAIL EXISTE DEJA OU PAS

        //SI PAS DE PHOTO
        if (!$request->photo)
        {
            $user = User::find($id);
            $user->update([
                'name' => $request->input('name'),
                'bio' => $request->input('bio'),
                'email' => $request->input('email'),
            ]);

            //
            User::where('id', Auth::user()->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('profil')->withMessage('Votre profil à été mis à jour');
        }

        $newImageName  = time() . '-' . $request->name . '.' .
            $request ->photo->extension();
        $request->photo->move(public_path('imgs'), $newImageName);

        $user = User::find($id);

        //Si Photo
        //Si password not changed
        if($request->password){
            $user->update([
                'name' => $request->input('name'),
                'bio' => $request->input('bio'),
                'email' => $request->input('email'),
                'photo' => $newImageName,
                'password' => $request->input('password')
            ]);
        }else{
            $user->update([
                'name' => $request->input('name'),
                'bio' => $request->input('bio'),
                'email' => $request->input('email'),
                'photo' => $newImageName,
            ]);
        }

        return redirect()->route('profil', $user)->withMessage('Votre profil à été mis à jour');
    }


    public function destroy($id)
    {
        //
    }
}
