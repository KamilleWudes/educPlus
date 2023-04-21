<?php

namespace App\Http\Controllers;

use App\Models\Tuteur;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class TuteurController extends Controller
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
        carbon::setLocale("fr");
        // $tuteurs= Tuteur::all();
        $user_id = Userid(); // l'id de l'utilisateur connecté

        $tuteurs = DB::table('users')
          ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
          ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
          ->join('inscriptions', 'classes.id', '=', 'inscriptions.classe_id')
          ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
          ->join('tuteurs', 'inscriptions.tuteur_id', '=', 'tuteurs.id')
          ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
          ->select('inscriptions.id', 'inscriptions.date_insription','tuteurs.noms as noms','tuteurs.prenoms as prenoms','tuteurs.telephone1 as telephone1','tuteurs.telephone2 as telephone2', 'etudiants.nom as etudiant_nom', 'etudiants.prenom as etudiant_prenom','tuteurs.sex as sex','tuteurs.id as id','tuteurs.adresses as adresses','tuteurs.id as tuteurs_id','tuteurs.created_at as created_at')
          ->where('users.id', '=', $user_id)
          ->orderBy("tuteurs_id","Desc")
          ->get();
        return view ('admin.tuteurs.liste',compact('tuteurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
