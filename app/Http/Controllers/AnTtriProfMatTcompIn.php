<?php

namespace App\Http\Controllers;
use App\Models\Ecole;
use App\Models\inscription;
use Illuminate\Http\Request;
use App\Models\classe;
use App\Models\anneeScolaire;
use App\Models\Matier;
use App\Models\Etudiant;
use App\Models\Professeur;
use App\Models\typeTrimestre;
use App\Models\typeComposition;
use App\Models\an_ttri_prof_mat_tcomp_in;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use PDF;
use Dompdf\Dompdf;
use App\Notifications\SendNotesEtudiantNotification;
use App\Notifications\SendNotesNotification;
use Illuminate\Support\Facades\Hash;



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
        $this->validate($request, [
            'type_compo_id' => 'required',
            'professeur_id' => 'required',
            'classe_id' => 'required',
            'matier_id' => 'required',
            'annee_scolaire_id' => 'required',
            'inscription_id' => 'required',
            'type_trimestre_id' =>'required',

         ]);

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

], [
    'inscription_id.unique' => 'Le doublon de cette inscription existe déjà avec les mêmes critères.',
 ]);
if ($validator->fails()) {
    return redirect()->back()->with('error', 'La validation a échoué. Veuillez vérifier vos données.');
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
         // Récupérez l'étudiant associé à cette note
    $etudiant = Etudiant::find($t[$i]['etu']);

    // Envoyez la notification à l'étudiant
    $etudiant->notify(new SendNotesEtudiantNotification($noteModel));
    $etudiant->notify(new SendNotesNotification($noteModel));


    }
    
    
     //return response()->json(['success' => true, 'message' => 'Enregistrement réussi']);
     return redirect()->back()->with('success', "L'enregistrement a été effectué avec succès");


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
    ->join('classe_anneescolaire_matieres', function ($join) use ($ecoleId, $anneeScolaire, $classe, $matiere) {
        $join->on('classe_anneescolaire_matieres.classe_id', '=', 'an_ttri_prof_mat_tcomp_ins.classe_id')
            ->on('classe_anneescolaire_matieres.matier_id', '=', 'an_ttri_prof_mat_tcomp_ins.matier_id')
            ->on('classe_anneescolaire_matieres.annee_scolaire_id', '=', 'an_ttri_prof_mat_tcomp_ins.annee_scolaire_id')
            ->where('classe_anneescolaire_matieres.ecole_id', $ecoleId)
            ->where('classe_anneescolaire_matieres.annee_scolaire_id', $anneeScolaire)
            ->where('classe_anneescolaire_matieres.classe_id', $classe)
            ->where('classe_anneescolaire_matieres.matier_id', $matiere);
    })
    ->where('an_ttri_prof_mat_tcomp_ins.annee_scolaire_id', $anneeScolaire)
    ->where('an_ttri_prof_mat_tcomp_ins.type_trimestre_id', $typeTrimestre)
    ->where('an_ttri_prof_mat_tcomp_ins.type_compo_id', $typeComposition)
    ->where('an_ttri_prof_mat_tcomp_ins.classe_id', $classe)
    ->where('an_ttri_prof_mat_tcomp_ins.matier_id', $matiere)
    ->select(
        'etudiants.nom as nom_etudiant',
        'etudiants.prenom as prenom_etudiant',
        'etudiants.matricule as matricule',
        'classe_anneescolaire_matieres.coefficient as coefficient',
        'an_ttri_prof_mat_tcomp_ins.note as note',
        DB::raw('an_ttri_prof_mat_tcomp_ins.note * classe_anneescolaire_matieres.coefficient as note_coefficient'),
        DB::raw('CASE 
        WHEN (an_ttri_prof_mat_tcomp_ins.note) = 20 THEN "Excellent"
        WHEN (an_ttri_prof_mat_tcomp_ins.note) >= 17 THEN "Très bien"
        WHEN (an_ttri_prof_mat_tcomp_ins.note) >= 14 THEN "Bien"
        WHEN (an_ttri_prof_mat_tcomp_ins.note) >= 12 THEN "Assez bien"
        WHEN (an_ttri_prof_mat_tcomp_ins.note) >= 10 THEN "Passable"
        ELSE "Insuffisant"
    END AS appreciation')
    )
    ->get();


        // Récupérez le coefficient de la matière choisie
    $coefficientMatiere = DB::table('classe_anneescolaire_matieres')
    ->where('ecole_id', $ecoleId)
    ->where('annee_scolaire_id', $anneeScolaire)
    ->where('classe_id', $classe)
    ->where('matier_id', $matiere)
    ->value('coefficient');

        // Récupérez la matiere  choisie
    $matiereChoisie = Matier::where('id', $matiere)->value('nom');

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
    "coefficientMatiere"=>$coefficientMatiere,
    "matiereChoisie"=>$matiereChoisie,

]);
}

public function GetprofReleve(){

    $ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session

    $anneeScolaires = DB::table('annee_scolaires')
    ->select('annee_scolaires.*')
    ->where('annee_scolaires.ecole_id', '=', $ecoleId)
    ->distinct()
    ->get();

    $typesTrimestreInfos = DB::table('type_trimestres')
    ->select('type_trimestres.nom','type_trimestres.id')
    ->where('type_trimestres.ecole_id', '=', $ecoleId)
    ->distinct()
    ->get();

    // $classes = DB::table('classes')
    // ->select('classes.*')
    // ->where('classes.ecole_id', '=', $ecoleId)
    // ->distinct()
    // ->get();

    return view ('admin.Saisie-notes.releveNotes',compact('anneeScolaires','typesTrimestreInfos'));
}

public function GetProfReleves(request $request){
// Récupérez les critères de filtrage depuis la requête
$anneeScolaire = $request->input('annee_scolaire');
$typeTrimestre = $request->input('type_trimestre');
$classe = $request->input('classe');
$ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session


$data = DB::table('etudiants')
    ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
    ->join('classes', 'classes.id', '=', 'inscriptions.classe_id')
    ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('annee_scolaires', 'annee_scolaires.id', '=', 'inscriptions.annee_scolaire_id')
    ->join('type_trimestres', 'type_trimestres.ecole_id', '=', 'ecoles.id') // Jointure sur l'école_id
    ->select('etudiants.*')
    ->where('ecoles.id', $ecoleId)
    ->where('classes.id', $classe)
    ->where('annee_scolaires.id', $anneeScolaire)
    ->where('type_trimestres.id', $typeTrimestre) // Filtre sur le type de trimestre
    ->orderBy('etudiants.nom', 'asc')
    ->get();

    
        // Obtenez les classes de l'école du professeur pour la dernière année scolaire
        $professeurId = ProfId(); // ID du professeur connecté

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

        // Récupérez la matiere  choisie
 $typeTrimestreChoisie = typeTrimestre::where('id', $typeTrimestre)->value('nom');

return response()->json([
  "Notes"=>$data,
  "classes"=>$classes,
  "typeTrimestreChoisie"=>$typeTrimestreChoisie,

]);
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function exportPdf()
   
    public function exportPdf($id)
    {
        $ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session

        $responsables = DB::table('users')
        ->select('users.*')
        ->where('users.ecole_id', '=', $ecoleId)
        ->distinct()
        ->get();
        //bibliothèque  dompdf
       //$pdf = PDF::loadView('admin.Releve-notes.export-pdf');

        // Téléchargez le PDF ou affichez-le dans le navigateur
        // $entry = Etudiant::find($id);
        //return $pdf->download('jude.pdf'); etudiants
        $entry = an_ttri_prof_mat_tcomp_in::where('inscription_id',$id)->first();

        // dd($entry->inscription_id);

        // Exemple : Récupérez le type de composition associé
        $typeComposition = $entry->typeComposition;
        // dd($entry->type_compo_id);

        // Exemple : Récupérez le professeur associé
        $professeur = $entry->professeur;

        // Exemple : Récupérez la classe associée
        $classe = $entry->classe;

        // Exemple : Récupérez la matière associée
        $matiere = $entry->matiere;

        // Exemple : Récupérez l'année scolaire associée
        $anneeScolaire = $entry->anneeScolaire;

        $typeTrimestre = $entry->typeTrimestre;

       // dd($entry->type_trimestre_id);


        $inscription =  $entry->inscription;

        $classeId =  $classe->id; // l'ID de la classe connecté

        $premiereCompositionId = null;

        // Récupérez les ID des compositions
        $compositions = DB::table('an_ttri_prof_mat_tcomp_ins')
            ->where('type_trimestre_id', $entry->type_trimestre_id)
            ->where('inscription_id', $entry->inscription_id)
            //->whereIn('type_compo_id', [1, 2, 3]) // Assurez-vous que ces valeurs correspondent aux types de composition souhaités
            ->orderBy('type_compo_id') // Triez par type_compo_id pour obtenir les compositions dans l'ordre 1, 2, 3
            ->distinct()
            ->pluck('type_compo_id');
            //dd($compositions);

            // Assurez-vous que vous avez les ID des compositions dans le bon ordre
        if (count($compositions) >= 3) {
            $premiereCompositionId = $compositions[0]; // ID de la première composition
            $deuxiemeCompositionId = $compositions[1]; // ID de la deuxième composition
            $troisiemeCompositionId = $compositions[2]; // ID de la troisième composition
        } else {
            // Gérez la situation où vous n'avez pas suffisamment de compositions
            $deuxiemeCompositionId = null;
            $troisiemeCompositionId = null;
        }
       // dd($troisiemeCompositionId);


        // Utilisez le Query Builder pour compter le nombre d'étudiants dans la classe
        $effectifTotal = DB::table('etudiants')
            ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
            ->where('inscriptions.classe_id', $classeId)
            ->count();

            $matieres = DB::table('matiers')
    ->join('classe_anneescolaire_matieres', function ($join) use ($classeId, $anneeScolaire, $typeTrimestre) {
        $join->on('matiers.id', '=', 'classe_anneescolaire_matieres.matier_id')
            ->where('classe_anneescolaire_matieres.classe_id', $classeId)
            ->where('classe_anneescolaire_matieres.annee_scolaire_id', $anneeScolaire->id);

    })
    ->leftJoin('an_ttri_prof_mat_tcomp_ins as devoir1', function ($join) use ($entry,$premiereCompositionId){
        $join->on('matiers.id', '=', 'devoir1.matier_id')
            ->where('devoir1.inscription_id', $entry->inscription_id)
            ->where('devoir1.type_trimestre_id',  $entry->type_trimestre_id)
            ->where('devoir1.type_compo_id', $premiereCompositionId) // Utilisez l'ID de la première composition
            ->orderBy('devoir1.created_at') // Triez pour obtenir le premier devoir
            ->take(1); // Prenez seulement le premier devoir

    })
       
    ->leftJoin('an_ttri_prof_mat_tcomp_ins as devoir2', function ($join) use ($entry,$deuxiemeCompositionId) {
        $join->on('matiers.id', '=', 'devoir2.matier_id')
            ->where('devoir2.inscription_id', $entry->inscription_id)
           ->where('devoir2.type_trimestre_id', $entry->type_trimestre_id)
            ->where('devoir2.type_compo_id', $deuxiemeCompositionId) // Utilisez l'ID de la deuxième composition
            ->orderBy('devoir2.created_at', 'desc') // Triez pour obtenir le deuxième devoir
            ->take(1); // Prenez seulement le deuxième devoir
    })
    ->leftJoin('an_ttri_prof_mat_tcomp_ins as composition', function ($join) use ($entry,$troisiemeCompositionId) {
        $join->on('matiers.id', '=', 'composition.matier_id')
            ->where('composition.inscription_id', $entry->inscription_id)
            ->where('composition.type_trimestre_id', $entry->type_trimestre_id)
            ->where('composition.type_compo_id', $troisiemeCompositionId); // Utilisez l'ID de la troisième composition
    })
    

    ->leftJoin('professeur_classe_matieres', function ($join) use ($classeId, $anneeScolaire) {
        $join->on('matiers.id', '=', 'professeur_classe_matieres.matier_id')
            ->where('professeur_classe_matieres.classe_id', $classeId)
            ->where('professeur_classe_matieres.annee_scolaire_id', $anneeScolaire->id);
    })
    ->leftJoin('professeurs', 'professeur_classe_matieres.professeur_id', '=', 'professeurs.id') // Joignez la table des professeurs
    ->select(
        'matiers.id',
        'matiers.nom',
        'professeurs.nom as nom_professeur','professeurs.prenom as prenom_professeur', // Sélectionnez le nom du professeur
        DB::raw('COALESCE(devoir1.note, 0) as note1'),
        DB::raw('COALESCE(devoir2.note, 0) as note2'),
        DB::raw('ROUND((COALESCE(devoir1.note, 0) + COALESCE(devoir2.note, 0)) / 2, 2) as moyenne_devoirs'), // Arrondir à 2 décimales
        DB::raw('COALESCE(composition.note, 0) as note_composition'),
        'classe_anneescolaire_matieres.coefficient as coef',
        DB::raw('ROUND(((COALESCE(devoir1.note, 0) + COALESCE(devoir2.note, 0)) / 2 + COALESCE(composition.note, 0)) / 2, 2) as moyenne_compo_classe'), // Arrondir à 2 décimales
        DB::raw('ROUND((((COALESCE(devoir1.note, 0) + COALESCE(devoir2.note, 0)) / 2 + COALESCE(composition.note, 0)) / 2) * classe_anneescolaire_matieres.coefficient, 2) as produit'), // Arrondir à 2 décimales
    
        DB::raw('
            CASE
                WHEN ((COALESCE(composition.note, 0) + (COALESCE(devoir1.note, 0) + COALESCE(devoir2.note, 0)) / 2) / 2) = 20 THEN "Excellent"
                WHEN ((COALESCE(composition.note, 0) + (COALESCE(devoir1.note, 0) + COALESCE(devoir2.note, 0)) / 2) / 2) >= 17 THEN "Très bien"
                WHEN ((COALESCE(composition.note, 0) + (COALESCE(devoir1.note, 0) + COALESCE(devoir2.note, 0)) / 2) / 2) >= 14 THEN "Bien"
                WHEN ((COALESCE(composition.note, 0) + (COALESCE(devoir1.note, 0) + COALESCE(devoir2.note, 0)) / 2) / 2) >= 12 THEN "Assez bien"
                WHEN ((COALESCE(composition.note, 0) + (COALESCE(devoir1.note, 0) + COALESCE(devoir2.note, 0)) / 2) / 2) >= 10 THEN "Passable"
                ELSE "Insuffisant"
            END as appreciation'
        )
    
    )
    //->groupBy('matiers.id', 'matiers.nom', 'classe_anneescolaire_matieres.coefficient')
    ->get();
    // Calcul de la somme totale des coefficients
$sommeCoefficients = $matieres->sum('coef');

// Calcul de la somme totale des produits
$sommeProduits = $matieres->sum('produit');
// Calcul de la MOYENNE GLOBALE
if ($sommeCoefficients != 0) {
    $moyenneGlobale = $sommeProduits / $sommeCoefficients;
} else {
    $moyenneGlobale = 0; // Pour éviter une division par zéro
}
// Utilisez number_format pour obtenir les deux derniers chiffres après la virgule
$moyenneGlobaleArrondie = number_format($moyenneGlobale, 2);
      
    if ($moyenneGlobale == 20) {
        $appreciation = 'Excellent';
    } elseif ($moyenneGlobale >= 17) {
        $appreciation = 'Très bien';
    } elseif ($moyenneGlobale >= 14) {
        $appreciation = 'Bien';
    } elseif ($moyenneGlobale >= 12) {
        $appreciation = 'Assez bien';
    } elseif ($moyenneGlobale >= 10) {
        $appreciation = 'Passable';
    } else {
        $appreciation = 'Insuffisant';
    }

// Calculez la plus forte moyenne de la classe en utilisant une sous-requête
$maxMoyenneClasse = DB::table('an_ttri_prof_mat_tcomp_ins')
    ->join('classe_anneescolaire_matieres', function ($join) use ($classeId, $anneeScolaire, $typeTrimestre) {
        $join->on('an_ttri_prof_mat_tcomp_ins.matier_id', '=', 'classe_anneescolaire_matieres.matier_id')
            ->where('an_ttri_prof_mat_tcomp_ins.classe_id', $classeId)
            ->where('an_ttri_prof_mat_tcomp_ins.annee_scolaire_id', $anneeScolaire->id)
            ->where('an_ttri_prof_mat_tcomp_ins.type_trimestre_id', $typeTrimestre->id);
    })
    ->select(DB::raw('SUM(an_ttri_prof_mat_tcomp_ins.note * classe_anneescolaire_matieres.coefficient) / SUM(classe_anneescolaire_matieres.coefficient) as moyenne_classe'))
    ->groupBy('an_ttri_prof_mat_tcomp_ins.inscription_id')
    ->orderByDesc('moyenne_classe')
    ->limit(1)
    ->first();

    // Utilisez la variable $maxMoyenneClasse pour obtenir la plus forte moyenne de la classe
$maxMoyenneDeLaClasse = $maxMoyenneClasse->moyenne_classe;
$classeId = $classe->id;
$ecoleId =  session('ecole_id');
$anneeScolaireId =  $anneeScolaire->id;
$typeTrimestreId = $typeTrimestre->id;

$plusFaibleMoyenne = DB::table('an_ttri_prof_mat_tcomp_ins')
    ->join('classes', 'an_ttri_prof_mat_tcomp_ins.classe_id', '=', 'classes.id')
    ->join('matiers', 'an_ttri_prof_mat_tcomp_ins.matier_id', '=', 'matiers.id')
    ->join('classe_anneescolaire_matieres', function ($join) use ($anneeScolaireId) {
        $join->on('an_ttri_prof_mat_tcomp_ins.matier_id', '=', 'classe_anneescolaire_matieres.matier_id')
            ->where('classe_anneescolaire_matieres.annee_scolaire_id', $anneeScolaireId);
    })
    ->where('classes.ecole_id', $ecoleId)
    ->where('classes.id', $classeId)
    ->where('an_ttri_prof_mat_tcomp_ins.type_trimestre_id', $typeTrimestreId)
    ->groupBy('an_ttri_prof_mat_tcomp_ins.classe_id')
    ->select(DB::raw('SUM(an_ttri_prof_mat_tcomp_ins.note * classe_anneescolaire_matieres.coefficient) / SUM(classe_anneescolaire_matieres.coefficient) as moyenne'))
    ->orderBy('moyenne', 'asc')
    ->value('moyenne');
  // Calcul de la moyenne de la classe
$moyenneDeLaClasse = ($plusFaibleMoyenne + $maxMoyenneDeLaClasse) / 2;
//////jude

// Obtenez la moyenne globale de l'étudiant
$moyenneEtudiant = DB::table('an_ttri_prof_mat_tcomp_ins')
    ->join('classe_anneescolaire_matieres', function ($join) {
        $join->on('classe_anneescolaire_matieres.classe_id', '=', 'an_ttri_prof_mat_tcomp_ins.classe_id')
            ->on('classe_anneescolaire_matieres.annee_scolaire_id', '=', 'an_ttri_prof_mat_tcomp_ins.annee_scolaire_id');
    })
    ->where('an_ttri_prof_mat_tcomp_ins.inscription_id', $entry->inscription_id) // Filtrez par l'ID de l'étudiant
    ->select(DB::raw('SUM(an_ttri_prof_mat_tcomp_ins.note * classe_anneescolaire_matieres.coefficient) / SUM(classe_anneescolaire_matieres.coefficient) as moyenne_globale'))
    ->first();

// Obtenez toutes les moyennes globales des étudiants de la même classe pour la même année scolaire
$moyennesClasse = DB::table('an_ttri_prof_mat_tcomp_ins')
    ->join('classe_anneescolaire_matieres', function ($join) {
        $join->on('classe_anneescolaire_matieres.classe_id', '=', 'an_ttri_prof_mat_tcomp_ins.classe_id')
            ->on('classe_anneescolaire_matieres.annee_scolaire_id', '=', 'an_ttri_prof_mat_tcomp_ins.annee_scolaire_id');
    })
    ->where('an_ttri_prof_mat_tcomp_ins.classe_id', $classeId) // Filtrez par l'ID de la classe
    ->where('an_ttri_prof_mat_tcomp_ins.annee_scolaire_id', $anneeScolaire->id) // Filtrez par l'ID de l'année scolaire
    ->where('an_ttri_prof_mat_tcomp_ins.type_trimestre_id', $typeTrimestre->id)
    ->select(DB::raw('SUM(an_ttri_prof_mat_tcomp_ins.note * classe_anneescolaire_matieres.coefficient) / SUM(classe_anneescolaire_matieres.coefficient) as moyenne_globale'))
    ->groupBy('an_ttri_prof_mat_tcomp_ins.inscription_id') // Groupez par ID d'inscription pour obtenir une moyenne par étudiant
    ->orderByDesc('moyenne_globale') // Triez par moyenne globale en ordre décroissant
    ->get();

// Déterminez le rang de l'étudiant en comparant sa moyenne globale avec celles des autres étudiants
$rangEtudiant = $moyennesClasse->search(function ($item) use ($moyenneEtudiant) {
    return $item->moyenne_globale === $moyenneEtudiant->moyenne_globale;
}) + 1; // Ajoutez 1 car les tableaux sont indexés à partir de zéro, le rang commence à 1.

// Maintenant, $rangEtudiant contient le rang de l'étudiant dans sa classe pour cette année scolaire.
// Obtenez la moyenne globale de l'étudiant
$moyenneEtudiant = DB::table('an_ttri_prof_mat_tcomp_ins')
    ->join('classe_anneescolaire_matieres', function ($join) {
        $join->on('classe_anneescolaire_matieres.classe_id', '=', 'an_ttri_prof_mat_tcomp_ins.classe_id')
            ->on('classe_anneescolaire_matieres.annee_scolaire_id', '=', 'an_ttri_prof_mat_tcomp_ins.annee_scolaire_id');
    })
    ->where('an_ttri_prof_mat_tcomp_ins.inscription_id', $entry->inscription_id) // Filtrez par l'ID de l'étudiant
    ->select(DB::raw('SUM(an_ttri_prof_mat_tcomp_ins.note * classe_anneescolaire_matieres.coefficient) / SUM(classe_anneescolaire_matieres.coefficient) as moyenne_globale'))
    ->first();

// Obtenez toutes les moyennes globales des étudiants de la même classe pour la même année scolaire
$moyennesClasse = DB::table('an_ttri_prof_mat_tcomp_ins')
    ->join('classe_anneescolaire_matieres', function ($join) {
        $join->on('classe_anneescolaire_matieres.classe_id', '=', 'an_ttri_prof_mat_tcomp_ins.classe_id')
            ->on('classe_anneescolaire_matieres.annee_scolaire_id', '=', 'an_ttri_prof_mat_tcomp_ins.annee_scolaire_id');
    })
    ->where('an_ttri_prof_mat_tcomp_ins.classe_id', $classeId) // Filtrez par l'ID de la classe
    ->where('an_ttri_prof_mat_tcomp_ins.annee_scolaire_id', $anneeScolaire->id) // Filtrez par l'ID de l'année scolaire
    ->select(DB::raw('SUM(an_ttri_prof_mat_tcomp_ins.note * classe_anneescolaire_matieres.coefficient) / SUM(classe_anneescolaire_matieres.coefficient) as moyenne_globale'))
    ->groupBy('an_ttri_prof_mat_tcomp_ins.inscription_id') // Groupez par ID d'inscription pour obtenir une moyenne par étudiant
    ->orderByDesc('moyenne_globale') // Triez par moyenne globale en ordre décroissant
    ->get();

// Obtenez la moyenne la plus élevée de la classe
$moyenneMaxClasse = $moyennesClasse->first()->moyenne_globale;

$moyenneMaxClasseArrondie = number_format($moyenneMaxClasse, 2);


// Maintenant, $moyenneMaxClasse contient la moyenne la plus élevée de la classe pour cette année scolaire.
// Obtenez la moyenne globale de l'étudiant
$moyenneEtudiant = DB::table('an_ttri_prof_mat_tcomp_ins')
    ->join('classe_anneescolaire_matieres', function ($join) {
        $join->on('classe_anneescolaire_matieres.classe_id', '=', 'an_ttri_prof_mat_tcomp_ins.classe_id')
            ->on('classe_anneescolaire_matieres.annee_scolaire_id', '=', 'an_ttri_prof_mat_tcomp_ins.annee_scolaire_id');
    })
    ->where('an_ttri_prof_mat_tcomp_ins.inscription_id', $entry->inscription_id) // Filtrez par l'ID de l'étudiant
    ->select(DB::raw('SUM(an_ttri_prof_mat_tcomp_ins.note * classe_anneescolaire_matieres.coefficient) / SUM(classe_anneescolaire_matieres.coefficient) as moyenne_globale'))
    ->first();

// Obtenez toutes les moyennes globales des étudiants de la même classe pour la même année scolaire
$moyennesClasse = DB::table('an_ttri_prof_mat_tcomp_ins')
    ->join('classe_anneescolaire_matieres', function ($join) {
        $join->on('classe_anneescolaire_matieres.classe_id', '=', 'an_ttri_prof_mat_tcomp_ins.classe_id')
            ->on('classe_anneescolaire_matieres.annee_scolaire_id', '=', 'an_ttri_prof_mat_tcomp_ins.annee_scolaire_id');
    })
    ->where('an_ttri_prof_mat_tcomp_ins.classe_id', $classeId) // Filtrez par l'ID de la classe
    ->where('an_ttri_prof_mat_tcomp_ins.annee_scolaire_id', $anneeScolaire->id) // Filtrez par l'ID de l'année scolaire
    ->select(DB::raw('SUM(an_ttri_prof_mat_tcomp_ins.note * classe_anneescolaire_matieres.coefficient) / SUM(classe_anneescolaire_matieres.coefficient) as moyenne_globale'))
    ->groupBy('an_ttri_prof_mat_tcomp_ins.inscription_id') // Groupez par ID d'inscription pour obtenir une moyenne par étudiant
    ->orderByDesc('moyenne_globale') // Triez par moyenne globale en ordre décroissant
    ->get();

// Obtenez la moyenne la plus faible de la classe
$moyenneMinClasse = $moyennesClasse->last()->moyenne_globale;
$moyenneMinClasseArrondie = number_format($moyenneMinClasse, 2);


// Maintenant, $moyenneMinClasse contient la moyenne la plus faible de la classe pour cette année scolaire.

// Calcul de la moyenne de la classe
$NewmoyenneDeLaClasse = ($moyenneMaxClasse + $moyenneMinClasse) / 2;

$dompdf = new Dompdf();


        
$pdfContent = view  ('admin.pdf-Releve-notes-professeur.export-pdf',compact('moyenneMaxClasseArrondie','moyenneMinClasseArrondie','moyenneGlobaleArrondie','NewmoyenneDeLaClasse','moyenneMinClasse','moyenneMaxClasse','rangEtudiant','moyenneDeLaClasse','plusFaibleMoyenne','maxMoyenneDeLaClasse','maxMoyenneClasse','appreciation','moyenneGlobale','sommeProduits','sommeCoefficients','responsables','entry','effectifTotal','matieres','typeComposition','professeur','classe','matiere','anneeScolaire','typeTrimestre','inscription'))->render();;

     // Chargez le contenu PDF dans Dompdf
$dompdf->loadHtml($pdfContent);

// (Optionnel) Configurez des options de mise en page si nécessaire
$dompdf->setPaper('A3', 'paysage');

// Rendu du PDF
$dompdf->render();

// Téléchargez le PDF
$dompdf->stream('releve-notes.pdf');
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
    public function reset($id)
    {
        return view('admin.password.reset-professeur');
        
    } 
    public function modifierMotDePasse(Request $request, $id)
    {
        $request->validate([
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8'],
        ]);
    
        // Utilisez votre fonction helper pour obtenir l'ID de l'utilisateur connecté
        $userId = ProfId();
        
        // Récupérez l'utilisateur à partir de l'ID
        $user = Professeur::find($userId);
    
        if (!$user) {
            return back()->with('error', 'Utilisateur non trouvé.');
        }
    
        if (Hash::check($request->old_password, $user->password)) {
            // Le mot de passe actuel est correct
            $user->update([
                'password' => bcrypt($request->new_password),
            ]);
         // dd($user);
            return back()->with('success', 'Mot de passe changé avec succès!');
        } else {
            // Le mot de passe actuel est incorrect
            return back()->with('error', 'Le mot de passe actuel est incorrect.');
        }
    }
}    