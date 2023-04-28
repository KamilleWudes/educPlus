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

    public function GetTuteurs(request $request){
        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté

        //dd($request->etudiant);
       $data = DB::table('users')

       ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
       ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
       ->join('inscriptions', 'classes.id', '=', 'inscriptions.classe_id')
       ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
       ->join('tuteurs', 'inscriptions.tuteur_id', '=', 'tuteurs.id')
       ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
       ->select('inscriptions.id', 'inscriptions.date_insription','classes.nom as classe_nom','tuteurs.noms as tuteur_nom','etudiants.id as etudiant_id','etudiants.nom as etudiant_nom','tuteurs.prenoms as tuteur_prenoms','tuteurs.telephone1 as tuteur_telephone1','tuteurs.telephone2 as tuteur_telephone2','etudiants.prenom as etudiant_prenom','etudiants.sexe as etudiant_sexe','etudiants.matricule as matricule','annee_scolaires.annee1', 'annee_scolaires.annee2', 'ecoles.nom as ecole_nom','etudiants.adresse as etudiant_adresse')
       ->where('users.id', '=', $user_id)
       ->where('inscriptions.annee_scolaire_id','=', $request->tuteur)
       ->orderBy('tuteur_id','desc')
       ->get();

      // dd($data);

    return response()->json([
        "tuteurs"=>$data,


    ]);


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


          $anneeScolaires = DB::table('users')
          ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
          ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
          ->join('inscriptions', 'classes.id', '=', 'inscriptions.classe_id')
          ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
          ->join('tuteurs', 'inscriptions.tuteur_id', '=', 'tuteurs.id')
          ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
          ->select('annee_scolaires.annee1 as annee1','annee_scolaires.annee2 as annee2','annee_scolaires.id as id')
          ->where('users.id', '=', $user_id)
          ->distinct()
          ->get();
        return view ('admin.tuteurs.liste',compact('tuteurs','anneeScolaires'));
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
