<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
class UserControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//=======================fontion retounant la vue register========================//
    public function index()
    {
        return view('users.register');
    }

    public function login()
    {
        return view('users.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//========================fonction pour enregistrer un user=======================//
    public function create(User $users,Request $request)
    {
        //
        $users->name = $request->name;
        $users->prenom = $request->prenom;
        $users->email = $request->email;
        $users->telephone = $request->telephone;
        $users->adresse = $request->adresse;
        $users->password = Hash::make($request->password);
        $users->save();

        $users = $users->id;
        $pan=DB::insert('insert into paniers (user_id) values (?)', [$users]);
        

        return redirect()->Route('register')->with('success','Votre compte à été créé avec succés');
    }
//==================================fonction de conexion=================================//
    public function handleLogin(Request $request)
    {
       $credentials =  $request->validate([
            'email'=>['required','email'],
            'password'=> ['required'],
       ]);
       if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->role === 'admin'){
                return redirect('/adminGerant');
            }else{
                return redirect('/');
            }
        }else{
          return redirect()->back()->with('error','login ou mot de passe incorrecte');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //======================================deconnexion d'un utilisateur===========================//
    public function logout()
    {
       Session::flush();
       Auth::logout();
       return redirect('register')->with('error','Deconnexion reussit');
    }
}
