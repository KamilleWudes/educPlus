<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classe;

use App\Models\Matier;
use App\Models\Professeur;
use App\Models\typeTrimestre;
use App\Models\typeComposition;
use App\Models\an_ttri_prof_mat_tcomp_in;
use Session;
use Illuminate\Support\Facades\DB;

class AnTtriProfMatTcompIn extends Controller
{

    public function __construct()
    {
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
        return view ('admin.Saisie-notes.liste');

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
                ->select('inscriptions.*','etudiants.nom', 'etudiants.prenom','etudiants.matricule')
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
       // $bulletins= bulletin::all();

        $typesTrimestreInfos = typeTrimestre::distinct()
        ->orderby('id','asc')
        ->get(['id', 'nom']);



        $professorId = ProfId(); // récupérer l'ID du professeur connecté

            $classes = DB::table('classes')
            ->join('professeur_classe_matieres', 'classes.id', '=', 'professeur_classe_matieres.classe_id')
            ->where('professeur_classe_matieres.professeur_id', $professorId)
            ->distinct()
            ->get(['classes.id', 'classes.nom']);

        return view('admin.Saisie-notes.create', compact('professeurs','typesTrimestreInfos','matieres','typeCompositions','classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'type_compo_id' => 'required',
            'professeur_id' => 'required',
            'classe_id' => 'required',
            'matier_id' => 'required',
            'annee_scolaire_id' => 'required',
            'inscription_id' => 'required',
            'type_trimestre_id' =>'required',

        ]);

    $t = array();
    $t = json_decode($request->etudiant_et_notes, true);
    

    for ($i=0; $i < count($t); $i++) { 
        $noteModel = new an_ttri_prof_mat_tcomp_in();
        $noteModel->annee_scolaire_id = 1;
        $noteModel->professeur_id = 1;
        $noteModel->type_trimestre_id = 1;
        $noteModel->type_compo_id = 1;
        $noteModel->classe_id = 1;
        $noteModel->matier_id = 1;
        $noteModel->inscription_id = $t[$i]['etu'];
        $noteModel->note = $t[$i]['note'];

        $noteModel->save();
    }
    return response()->json(['success' => true, 'message' => 'Enregistrement réussi']);
    
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
