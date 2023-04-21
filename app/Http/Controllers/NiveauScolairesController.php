<?php

namespace App\Http\Controllers;
use App\Models\Ecole;
use App\Models\niveauScolaires;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class NiveauScolairesController extends Controller
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
        $NiveauScolaires = niveauScolaires::all();
        return view ('admin.NiveauScolaires.liste',compact('NiveauScolaires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ecoles = Ecole::orderBy("id","Desc")->get();
        return view ('admin.NiveauScolaires.create',compact('ecoles'));
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
       ]);
       niveauScolaires::create($request->all());
       return back()->with("success","Niveau Scolaire ajouté avec succè!");
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
        $NiveauScolaires=niveauScolaires::find($id);

        return view ('admin.NiveauScolaires.edite',compact('NiveauScolaires'));

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
       ]);
        $niveauScolaires = niveauScolaires::find($id);
         $niveauScolaires->nom = $request->nom;

         $niveauScolaires->update($request->all());
         return back()->with("success","Niveau scolaire mise à jour avec succè!");
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
