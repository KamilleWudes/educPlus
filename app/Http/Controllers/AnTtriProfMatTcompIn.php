<?php

namespace App\Http\Controllers;
use App\Models\Ecole;
use App\Models\inscription;
use Illuminate\Http\Request;
use App\Models\classe;
use App\Models\anneeScolaire;
use App\Models\Matier;
use App\Models\Professeur;
use App\Models\typeTrimestre;
use App\Models\typeComposition;
use App\Models\an_ttri_prof_mat_tcomp_in;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use PDF;



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
        $professeurId = ProfId(); // ID du professeur connecté
        $ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session
       
        $typeCompositions = DB::table('type_compositions')
        ->select('type_compositions.nom','type_compositions.id')
        ->where('type_compositions.ecole_id', '=', $ecoleId)
        ->distinct()
        ->get();

        $typesTrimestres = DB::table('type_trimestres')
        ->select('type_trimestres.nom','type_trimestres.id')
        ->where('type_trimestres.ecole_id', '=', $ecoleId)
        ->distinct()
        ->get();

        $anneeScolaires = DB::table('annee_scolaires')
        ->select('annee_scolaires.*')
        ->where('annee_scolaires.ecole_id', '=', $ecoleId)
        ->distinct()
        ->get();

         // Obtenez les classes de l'école du professeur pour la dernière année scolaire
         $classes = DB::table('professeur_classe_matieres')
         ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
         ->join('ecoles', 'classes.ecole_id', '=', 'ecoles.id')
         ->join('annee_scolaires', 'professeur_classe_matieres.annee_scolaire_id', '=', 'annee_scolaires.id')
         ->where('professeur_classe_matieres.professeur_id', $professeurId)
         ->where('ecoles.id', session('ecole_id')) // ID de l'école connectée depuis la session
         ->where('annee_scolaires.annee1', lastAneeScolaire())
         ->select('classes.nom as nom', 'classes.id as id')
         ->distinct()
         ->get();

        return view ('admin.Saisie-notes.liste',compact('typesTrimestres','typeCompositions','classes','anneeScolaires'));
    
    }
   

    public function GetClasseMatiere(request $request){
        $professorId = ProfId(); // récupérer l'ID du professeur connecté

       // dd($request->classe_id." ".$professorId);
       $matieres = DB::table('matiers')
        ->join('professeur_classe_matieres', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')
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
                $professeurId = ProfId(); // ID du professeur connecté
                $ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session

                $etudiantsInscrits = DB::table('inscriptions')
                ->join('etudiants', 'etudiants.id', '=', 'inscriptions.etudiant_id')
                ->select('inscriptions.*','etudiants.nom', 'etudiants.prenom','etudiants.matricule')
                ->get();

                // Obtenez les étudiants en fonction de l'école, de la classe, de l'année scolaire et du professeur
                $etudiantsClasses = DB::table('etudiants')
                ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
                ->join('classes', 'classes.id', '=', 'inscriptions.classe_id')
                ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
                ->join('professeur_classe_matieres', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
                ->join('annee_scolaires', 'annee_scolaires.id', '=', 'inscriptions.annee_scolaire_id')
                ->select('etudiants.*', 'classes.nom as nom_classe', 'ecoles.nom as nom_ecole')
                ->where('professeur_classe_matieres.classe_id', $request->classe_id)
                ->where('professeur_classe_matieres.matier_id', $request->matieres)
                ->where('professeur_classe_matieres.professeur_id', '=', $professeurId)
                ->where('ecoles.id', $ecoleId)
                ->where('annee_scolaires.annee1',lastAneeScolaire())
                ->get();


                // $etudiantsClasses = DB::table('etudiants')
                // ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
                // ->join('classes', 'classes.id', '=', 'inscriptions.classe_id')
                // ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
                // ->join('professeur_classe_matieres', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
                // ->select('etudiants.*', 'classes.nom as nom_classe', 'ecoles.nom as nom_ecole')
                // ->where('professeur_classe_matieres.classe_id', $request->classe_id)
                // ->where('professeur_classe_matieres.matier_id',  $request->matieres)
                // ->where('professeur_classe_matieres.professeur_id', '=', $professorId)
                // ->get();

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
        $professeurId = ProfId(); // ID du professeur connecté
        $ecole_id = session('ecole_id'); // ID de l'école connectée depuis la session
        $ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session

        // $ecoleId = getConnectedProfesseurEcoleId();
        $professeurs = Professeur::orderBy("id", "Desc")->get();
        // $typeCompositions = typeComposition::orderBy("id", "asc")->get();
        $matieres = Matier::orderBy("id", "Desc")->get();
       
        $typeCompositions = DB::table('type_compositions')
        ->select('type_compositions.nom','type_compositions.id')
        ->where('type_compositions.ecole_id', '=', $ecoleId)
        ->distinct()
        ->get();

        $typesTrimestreInfos = DB::table('type_trimestres')
        ->select('type_trimestres.nom','type_trimestres.id')
        ->where('type_trimestres.ecole_id', '=', $ecoleId)
        ->distinct()
        ->get();

        $anneeScolaires = DB::table('annee_scolaires')
        ->select('annee_scolaires.*')
        ->where('annee_scolaires.ecole_id', '=', $ecoleId)
        ->distinct()
        ->get();


        // Obtenez les classes de l'école du professeur pour la dernière année scolaire
        $classes = DB::table('professeur_classe_matieres')
        ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
        ->join('ecoles', 'classes.ecole_id', '=', 'ecoles.id')
        ->join('annee_scolaires', 'professeur_classe_matieres.annee_scolaire_id', '=', 'annee_scolaires.id')
        ->where('professeur_classe_matieres.professeur_id', $professeurId)
        ->where('ecoles.id', session('ecole_id')) // ID de l'école connectée depuis la session
        ->where('annee_scolaires.annee1', lastAneeScolaire())
        ->select('classes.nom as nom', 'classes.id as id')
        ->distinct()
        ->get();
    

        //   $professorId = ProfId(); // récupérer l'ID du professeur connecté

        //     $classes = DB::table('classes')
        //     ->join('professeur_classe_matieres', 'classes.id', '=', 'professeur_classe_matieres.classe_id')
        //     ->where('professeur_classe_matieres.professeur_id', $professorId)
        //     ->distinct()
        //     ->get(['classes.id', 'classes.nom']);

        return view('admin.Saisie-notes.create', compact('professeurs','typesTrimestreInfos','matieres','typeCompositions','classes','anneeScolaires'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session
        //dd($request->all());
        // $this->validate($request, [
        //     'type_compo_id' => 'required',
        //     'professeur_id' => 'required',
        //     'classe_id' => 'required',
        //     'matier_id' => 'required',
        //     'annee_scolaire_id' => 'required',
        //     'inscription_id' => 'required',
        //     'type_trimestre_id' =>'required',

        //  ]);

//Validez les données avec la règle de validation unique
$validator = Validator::make($request->all(), [
    'inscription_id' => [
        'required',
        Rule::unique('an_ttri_prof_mat_tcomp_ins')->where(function ($query) use ($request) {
             $query->where('type_compo_id', $request->input('type_compo_id'))
                         ->where('annee_scolaire_id', $request->input('annee_scolaire_id'))
                         ->where('type_trimestre_id', $request->input('type_trimestre_id'))
                         ->where('classe_id', $request->input('classe_id'))
                         ->where('matier_id', $request->input('matier_id'));
        })->ignore($request->id), // Ignorer la ligne actuelle lors de la vérification des doublons
    ],
    'type_compo_id' => 'required',
    'annee_scolaire_id' => 'required',
    'type_trimestre_id' => 'required',
    'professeur_id' => 'required',
    'classe_id' => 'required',
    'matier_id' => 'required',
], [
    'inscription_id.unique' => 'Le doublon de cette inscription existe déjà avec les mêmes critères.',
 ]);
if ($validator->fails()) {
    return redirect()->back()->with('error', 'La validation a échoué. Veuillez vérifier vos données.');
} else {
    return redirect()->back()->with('success', 'L\'enregistrement a été effectué avec succès');
}

    $t = array();
    $t = json_decode($request->etudiant_et_notes, true);
    

    for ($i=0; $i < count($t); $i++) { 
        $noteModel = new an_ttri_prof_mat_tcomp_in();
        $noteModel->annee_scolaire_id =  $request->annee_scolaire_id;
        $noteModel->professeur_id = $request->professeur_id;
        $noteModel->type_trimestre_id = $request->type_trimestre_id;
        $noteModel->type_compo_id = $request->type_compo_id;
        $noteModel->classe_id = $request->classe_id;
        $noteModel->matier_id = $request->matier_id;
        $noteModel->inscription_id = $t[$i]['etu'];
        $noteModel->note = $t[$i]['note'];

        $noteModel->save();
    }
    
     //return response()->json(['success' => true, 'message' => 'Enregistrement réussi']);
     return redirect()->back()->with('success', 'L\'enregistrement a été effectué avec succès');


}

public function GetNotesEtudes(request $request){
    $userId = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
    $ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session

    // Récupérez les critères de filtrage depuis la requête
    $anneeScolaire = $request->input('annee_scolaire');
    $typeTrimestre = $request->input('type_trimestre');
    $typeComposition = $request->input('type_composition');
    $classe = $request->input('classe');
    $matiere = $request->input('matiere');

   $data = Inscription::query() 
        ->join('an_ttri_prof_mat_tcomp_ins', 'inscriptions.id', '=', 'an_ttri_prof_mat_tcomp_ins.inscription_id')
        ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
        ->where('an_ttri_prof_mat_tcomp_ins.annee_scolaire_id', $anneeScolaire)
        ->where('an_ttri_prof_mat_tcomp_ins.type_trimestre_id', $typeTrimestre)
        ->where('an_ttri_prof_mat_tcomp_ins.type_compo_id', $typeComposition)
        ->where('an_ttri_prof_mat_tcomp_ins.classe_id', $classe)
        ->where('an_ttri_prof_mat_tcomp_ins.matier_id', $matiere)
        ->select('etudiants.nom as nom_etudiant', 'etudiants.prenom as prenom_etudiant','etudiants.matricule as matricule','an_ttri_prof_mat_tcomp_ins.note')
        ->get();

   //classe-matier
   $professorId = ProfId(); // récupérer l'ID du professeur connecté
   $matieres = DB::table('matiers')
    ->join('professeur_classe_matieres', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')
    ->where('professeur_classe_matieres.classe_id', $request->classe)
    ->where('professeur_classe_matieres.professeur_id', $professorId)
    ->distinct()
    ->select(
        'matiers.id','matiers.nom',
    )
    ->get();

return response()->json([
    "Notes"=>$data,
    "matieres"=>$matieres,

]);
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
