<?php

namespace App\Http\Controllers;

use App\Models\anneeScolaire;
use App\Models\User;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Session;

use Illuminate\Validation\Rule;
class AnneeScolaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLoggedIn');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anneeScolaires= anneeScolaire::all();

        return view ('admin.annee-scolaires.liste',compact('anneeScolaires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.annee-scolaires.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           // "anneeScolaire" =>'required|unique:annee_scolaires,anneeScolaire',
            "annee1" =>'required|numeric|unique:annee_scolaires,annee1',
            "annee2" =>'required|numeric|unique:annee_scolaires,annee2',

            "annee1"=>['required','min:4','max:4'],
            "annee2"=>['required','min:4','max:4'],
        ]);
        $anneeScolaires = new anneeScolaire();
        $anneeScolaires->annee1 = $request->annee1;
        $anneeScolaires->annee2 = $request->annee2;

        $anneeScolaires->save();

         return back()->with("success","Année scolaire ajouté avec succè!");
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
        $anneeScolaire = anneeScolaire::find($id);

         return view ('admin.annee-scolaires.edite',compact('anneeScolaire'));
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
        // $request->validate([
        //     "anneeScolaire" =>'required',
        //     "annee1" =>'required|numeric'. Rule::unique('annee_scolaires')->ignore($id),
        //     "annee2" =>'required|numeric'. Rule::unique('annee_scolaires')->ignore($id)
        //  ]);

        //  $anneeScolaires = anneeScolaire::find($id);
        //  $anneeScolaires->annee1 = $request->annee1;
        //  $anneeScolaires->annee2 = $request->annee2;


        //  $anneeScolaires->update();
        //  return back()->with("success","Année scolaire mise à jour avec succè!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($anneeScolaire)
    {
        anneeScolaire::find($anneeScolaire)->delete();
        return back()->with("success","Année scolaire supprimer avec succè!");
    }

}
