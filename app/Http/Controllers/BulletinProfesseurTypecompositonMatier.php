<?php

namespace App\Http\Controllers;

use App\Models\bulletin;
use Illuminate\Contracts\Session\Session as SessionSession;
use App\Models\classe;

use App\Models\Matier;
use App\Models\Professeur;
use App\Models\typeTrimestre;
use App\Models\typeComposition;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;



class BulletinProfesseurTypecompositonMatier extends Controller
{
    public function __construct()
    {
        // $this->middleware('isLoggedIn');
        $this->middleware('isLoggedProf');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function GetClasseMatiere(request $request){
        $professorId = ProfId(); // récupérer l'ID du professeur connecté

       // dd($request->classe_id." ".$professorId);
       $matieres = DB::table('matiers')
        ->join('professeur_classe_matieres', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')

        //->join('classe_anneescolaire_matieres', 'classe_anneescolaire_matieres.matier_id', '=', 'matiers.id')

        //  ->join('classe_anneescolaire_matieres', 'matiers.id', '=', 'classe_anneescolaire_matieres.matier_id')

        ->where('professeur_classe_matieres.classe_id', $request->classe_id)
        ->where('professeur_classe_matieres.professeur_id', $professorId)
        ->distinct()
        ->select(
            'matiers.id','matiers.nom',
        )
        ->get();

        $mat= DB::table('classe_anneescolaire_matieres')
         ->whereClasseId($request->classe_id)
        ->select(
            'classe_anneescolaire_matieres.*'
        )
        ->get();
        // dump(($mat));

                $etudiantsInscrits = DB::table('inscriptions')
                ->join('etudiants', 'etudiants.id', '=', 'inscriptions.etudiant_id')

                ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
                //->join('ecoles', 'annee_scolaires.ecole_id', '=', 'ecoles.id')

                ->select('inscriptions.*','etudiants.nom', 'etudiants.prenom','etudiants.matricule')
                ->where('inscriptions.annee_scolaire_id','=', AnneScolairesId())
              //  ->where('annee_scolaires.ecole_id','=', EcolesId())

                ->get();


                $etudiantsClasses = DB::table('etudiants')
                ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
                ->join('classes', 'classes.id', '=', 'inscriptions.classe_id')
                ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
                ->join('professeur_classe_matieres', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
                ->select('etudiants.*', 'classes.nom as nom_classe', 'ecoles.nom as nom_ecole')

                ->where('professeur_classe_matieres.classe_id', $request->classe_id)
                ->where('professeur_classe_matieres.matier_id',  $request->matieres)
                ->where('professeur_classe_matieres.professeur_id', '=', $professorId)

                ->get();

    return response()->json([
        "matieres"=>$matieres,
        "etudiantsClasses"=>$etudiantsClasses,
        "etudiantsInscrits"=>$etudiantsInscrits,
        "coefficient"=>$mat,


    ]);

    //return response()->json($matieres);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $professeurs = Professeur::orderBy("id", "Desc")->get();
        $typeCompositions = typeComposition::orderBy("id", "asc")->get();
        $matieres = Matier::orderBy("id", "Desc")->get();
        $bulletins= bulletin::all();

        $typesTrimestreInfos = typeTrimestre::distinct()
        ->orderby('id','asc')
        ->get(['id', 'nom']);

        $data = array();
        if(Session::has('Professeur')){
            $data = Professeur::where('id','=', Session::get('Professeur'))->first();
        }

        $professorId = ProfId(); // récupérer l'ID du professeur connecté

            $classes = DB::table('classes')
            ->join('professeur_classe_matieres', 'classes.id', '=', 'professeur_classe_matieres.classe_id')
            ->where('professeur_classe_matieres.professeur_id', $professorId)
            ->distinct()
            ->get(['classes.id', 'classes.nom']);

        return view('admin.Operations.create', compact('professeurs','typesTrimestreInfos','matieres','bulletins','typeCompositions','data','classes'));
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
