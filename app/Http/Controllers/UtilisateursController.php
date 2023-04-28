<?php

namespace App\Http\Controllers;

use App\Models\Ecole;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class UtilisateursController extends Controller
{
    public function __construct()
    {
        // $this->middleware('isLoggedIn');
        $this->middleware('isLoggedSuperadmin');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        carbon::setLocale("fr");
        $users= User::all();
        return view ('admin.utilisateurs.liste',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ecoles = Ecole::orderBy("id","Desc")->get();
       // $roles = role::orderBy("id","Desc")->get();

        return view('admin.utilisateurs.create',compact('ecoles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required',
           'prenom' => 'required',
           'sexe' => 'required',
           'telephone' => 'required|numeric|unique:users,telephone',
           'adresse' => 'required',
           'email' => 'required|email|unique:users,email',
           'role' => 'required',
           'ecole_id' => 'required',
           'password' => ['required', 'string', 'min:8'],
        ]);
       $users = new User();
        $users->name = $request->name;
        $users->prenom = $request->prenom;
        $users->sexe = $request->sexe;
        $users->telephone = $request->telephone;
        $users->adresse = $request->adresse;
        $users->role = $request->role;
        $users->ecole_id = $request->ecole_id;
        $users->email = $request->email;
        $users->password = hash::make($request->password);

        $users->save();
        return back()->with("success","Responsable ajouté avec succè!");
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
        $ecoles = Ecole::orderBy("id","Desc")->get();
        $roles = role::orderBy("id","Desc")->get();
        $users = User::find($id);
        return view('admin.utilisateurs.edite',compact('users','ecoles','roles'));
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
        $this->validate($request, [
           'name' => 'required',
           'prenom' => 'required',
           'sexe' => 'required',
           'telephone' => 'nullable|numeric|' . Rule::unique('users')->ignore($id),
           'adresse' => 'required',
           'email' => 'required|email|' . Rule::unique('users')->ignore($id),
           //'role' => 'required',
           'ecole_id' => 'required',
           'password' => ['required', 'string', 'min:8']
         ]);

         $users = User::find($id);
         $users->name = $request->name;
         $users->prenom = $request->prenom;
         $users->sexe = $request->sexe;
         $users->telephone = $request->telephone;
         $users->adresse = $request->adresse;
       //  $users->role = $request->role;
         $users->ecole_id = $request->ecole_id;
         $users->email = $request->email;
         $users->password = $request->password;

         $users->update();

         return back()->with("success","Responsable mise à jour avec succè!");
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
}



?>
