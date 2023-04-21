<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Carbon\Carbon;


class EcoleController extends Controller
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
        carbon::setLocale("fr");
        $ecoles= Ecole::all();
        return view ('admin.ecoles.liste',compact('ecoles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.ecoles.create');
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
            'nom' => 'required|unique:ecoles,nom',
            'telephone1' => 'required|numeric|unique:ecoles,telephone1',
            'telephone2' => 'nullable|numeric|unique:ecoles,telephone2',
            'adresse' => 'required',
            'email' => 'required|email|unique:ecoles,email',
        ]);
        Ecole::create($request->all());
        return back()->with("success","Ecole ajouté avec succè!");
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
        $ecoles = Ecole::find($id);

         return view ('admin.ecoles.edite',compact('ecoles'));
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
        $this->validate($request,[
            'nom' => 'required|' . Rule::unique('ecoles')->ignore($id),
            'telephone1' => 'required|numeric|' . Rule::unique('ecoles')->ignore($id),
            'telephone2' => 'nullable|numeric|' . Rule::unique('ecoles')->ignore($id),
            'adresse' => 'required',
            'email' => 'required|email|' . Rule::unique('ecoles')->ignore($id),

         ]);
         $ecoles = Ecole::find($id);
         $ecoles->nom = $request->nom;
         $ecoles->telephone1 = $request->telephone1;
         $ecoles->telephone2 = $request->telephone2;
         $ecoles->adresse = $request->adresse;
         $ecoles->email = $request->email;

         $ecoles->update($request->all());
         return back()->with("success","Ecole modifié avec succè!");
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
