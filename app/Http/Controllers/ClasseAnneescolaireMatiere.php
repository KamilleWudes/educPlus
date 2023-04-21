<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Session\Session as SessionSession;

use Illuminate\Http\Request;
use App\Models\anneeScolaire;
use App\Models\classe;
use App\Models\ClasseAnneescolaireMatiere as ModelsClasseAnneescolaireMatiere;
use App\Models\Matier;
use Illuminate\Support\Facades\DB;


class ClasseAnneescolaireMatiere extends Controller
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
       // $data = ModelsClasseAnneescolaireMatiere::all();
     $data = DB::table('classe_anneescolaire_matieres')
    ->join('classes', 'classes.id', '=', 'classe_anneescolaire_matieres.classe_id')
    ->join('matiers', 'matiers.id', '=', 'classe_anneescolaire_matieres.matier_id')
    ->join('annee_scolaires', 'annee_scolaires.id', '=', 'classe_anneescolaire_matieres.annee_scolaire_id')
    ->select('classes.nom as classe_nom', 'matiers.nom as matiere_nom', 'annee_scolaires.annee1 as anneescolaire_annee1', 'annee_scolaires.annee2 as anneescolaire_annee2', 'classe_anneescolaire_matieres.coefficient')
    ->orderBy('classe_anneescolaire_matieres.created_at', 'desc')
    ->get();
    return view ('admin.matiere_coefficient.liste', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $classes = DB::table('users')
        ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
        ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
        ->join('niveau_scolaires', 'classes.niveau_scolaires_id', '=', 'niveau_scolaires.id')
        ->where('users.id', '=', $user_id)
        ->select('ecoles.nom as ecole_nom', 'classes.id as id', 'classes.nom as nom','niveau_scolaires.nom as niveau_scolaire')
        ->orderBy("id","Desc")
        ->get();
        // $matieres = Matier::offset(0)->limit(1)->orderBy("id", "Desc")->get();
        $matieres = Matier::get();

        $AnneeScolaires = anneeScolaire::offset(0)->limit(1)->orderBy("id", "Desc")->get();
        // $classes = classe::orderBy("id", "Desc")->get();

        return view('admin.matiere_coefficient.create', compact('AnneeScolaires', 'classes', 'matieres'));
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
            // "nom" => 'required|unique:matiers,nom',

            'annee_scolaire_id'=>'required',
            'classe_id' => 'required',
            'coefficient'=>'required',
            'matier_id'=>'required'
        ]);

        // $matieres = new Matier();
        // $matieres->nom = $request->nom;
        // $matieres->save();


        $ClassesCoefficients = new ModelsClasseAnneescolaireMatiere();
        $ClassesCoefficients->annee_scolaire_id = $request->annee_scolaire_id;
        $ClassesCoefficients->classe_id = $request->classe_id;
        $ClassesCoefficients->matier_id = $request->matier_id;
        $ClassesCoefficients->coefficient = $request->coefficient;

        $ClassesCoefficients->save();

        return back()->with("success", " Matiere et coefficient enregistrer avec succè!");
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
