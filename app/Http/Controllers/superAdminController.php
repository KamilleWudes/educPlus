<?php

namespace App\Http\Controllers;
use App\Models\userprincipal;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;


class superAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('isLoggedSuperadmin');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SuperAdmins = userprincipal::all();
        return view ('admin.superAdmins.liste',compact('SuperAdmins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = userprincipal::orderBy("id","Desc")->get();

         return view('admin.superAdmins.create',compact('data'));
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
           'nom' => 'required',
           'prenom' => 'required',
           'telephone' => 'required|numeric|unique:userprincipals,telephone',
           'password' => ['required', 'string', 'min:8'],
           'email' => 'required|email|unique:userprincipals,email',
       ]);
       $userprincipals = new userprincipal();
       $userprincipals->nom = $request->nom;
       $userprincipals->prenom = $request->prenom;
       $userprincipals->telephone = $request->telephone;
       $userprincipals->email = $request->email;
       $userprincipals->password = hash::make($request->password);
       $userprincipals->role = $request->role;

       $userprincipals->save();

       return back()->with("success","Utilisateur ajouté avec succè!");

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
        $users = userprincipal::find($id);

        return view('admin.superAdmins.edite',compact('users'));
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
           'nom' => 'required',
           'prenom' => 'required',
           'telephone' => 'required|numeric|' . Rule::unique('userprincipals')->ignore($id),
           'email' => 'required|email|' . Rule::unique('userprincipals')->ignore($id),
           'password' => ['required', 'string', 'min:8'],

       ]);
       $userprincipals = userprincipal::find($id);
       $userprincipals->nom = $request->nom;
       $userprincipals->prenom = $request->prenom;
       $userprincipals->telephone = $request->telephone;
       $userprincipals->password = hash::make($request->password);
       $userprincipals->email = $request->email;

       $userprincipals->update();

       return back()->with("success","Utilisateur mise à jour avec succè!");
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
