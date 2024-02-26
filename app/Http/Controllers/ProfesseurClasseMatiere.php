<?php

namespace App\Http\Controllers;
use App\Models\ProfesseurClasseMatiere as ModelsProfesseurClasseMatiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\inscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Matier;


class ProfesseurClasseMatiere extends Controller
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
        //$data = ModelsProfesseurClasseMatiere::all();
        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $anneesScolairesEcole = DB::table('annee_scolaires')
        ->join('professeur_classe_matieres', 'annee_scolaires.id', '=', 'professeur_classe_matieres.annee_scolaire_id')
        ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
        ->join('ecoles', 'classes.ecole_id', '=', 'ecoles.id')
        ->select('annee_scolaires.*')
        ->where('ecoles.id', $user_id)
        ->distinct()
        ->orderby('annee_scolaires.id','desc')
        ->get();

        $data = DB::table('professeur_classe_matieres')
        ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
        ->join('matiers', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')
        ->join('professeurs', 'professeur_classe_matieres.professeur_id', '=', 'professeurs.id')
        ->join('annee_scolaires', 'professeur_classe_matieres.annee_scolaire_id', '=', 'annee_scolaires.id')
        ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
        ->join('users', 'users.ecole_id', '=', 'ecoles.id')
        ->where('users.id', '=', $user_id)
        //->where('annee_scolaires.annee1',lastAneeScolaire())
        ->select('classes.nom as classe', 'matiers.nom as matiere', 'professeurs.nom as nom','professeurs.prenom as prenom','professeurs.matricule as matricule','professeur_classe_matieres.id as id')
        ->orderBy('professeur_classe_matieres.created_at', 'desc')
        ->get();

    return view('admin.professeur-classe-matieres.disposer', compact('data','anneesScolairesEcole'));

    }

    public function GetProfesseurClasseEcole(request $request){
        $userId = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $ecoleId = DB::table('users')
        ->where('id', $userId)
        ->value('ecole_id');

        $anneeScolaire = $request->input('professeurEcole'); // Récupération de l'id de l'annee scolaire depuis le ajax
        $data = DB::table('professeur_classe_matieres')
        ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
        ->join('matiers', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')
        ->join('professeurs', 'professeur_classe_matieres.professeur_id', '=', 'professeurs.id')
        ->join('annee_scolaires', 'professeur_classe_matieres.annee_scolaire_id', '=', 'annee_scolaires.id')
        ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
        ->join('users', 'users.ecole_id', '=', 'ecoles.id')
        ->where('users.id', '=', $userId)
        ->where('annee_scolaires.id','=', $request->professeurEcole)
        ->select('classes.nom as classe', 'matiers.nom as matiere', 'professeurs.nom as nom','professeurs.prenom as prenom','professeurs.matricule as matricule')
        ->orderBy("professeur_classe_matieres.id", "Desc")
        ->get();

    return response()->json([
        "professeursEcole"=>$data,

    ]);
}

    /**
     * Show the form for creating a new resource.     notesEtudiants
     *
     * @return \Illuminate\Http\Response 
     */
    public function notesEtudiants()
    {
        $userId = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $ecoleId = DB::table('users')
        ->where('id', $userId)
        ->value('ecole_id');
      
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
        ->orderBy('annee_scolaires.id', 'desc') // Tri par ordre décroissant d'ID
        ->get();

        // $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        // $classes = DB::table('users')
        // ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
        // ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
        // ->join('niveau_scolaires', 'classes.niveau_scolaires_id', '=', 'niveau_scolaires.id')
        // ->where('users.id', '=', $user_id)
        // ->select('ecoles.nom as ecole_nom', 'classes.id as classe_id', 'classes.nom as classe_nom','niveau_scolaires.nom as niveau_scolaire')
        // ->orderBy("classe_id","Desc")
        // ->get(); Important

        $classes = DB::table('inscriptions')
        ->join('classes', 'inscriptions.classe_id', '=', 'classes.id')
        ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
       // ->where('annee_scolaires.annee1', lastAneeScolaire())
        ->where('inscriptions.ecole_id', $ecoleId)
         ->select('classes.id as classe_id', 'classes.nom as classe_nom')
        ->distinct()
        ->get();

     
         return view('admin.notes-etudiants.notes-etudiants',compact('classes','anneeScolaires','typeCompositions','typesTrimestreInfos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function GetClassprofs(request $request){
        $userId = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $ecoleId = DB::table('users')
        ->where('id', $userId)
        ->value('ecole_id');
        
   

    $matieres = DB::table('professeur_classe_matieres')
    ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
    ->join('ecoles', 'classes.ecole_id', '=', 'ecoles.id')
    ->join('matiers', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')
    ->where('ecoles.id', $ecoleId)
    ->where('classes.id', $request->classe) // Filtrez par l'ID de la classe choisie
    ->select('matiers.nom', 'matiers.id')
    ->distinct()
    ->get();


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
    END AS appreciation'),
    )    ->orderBy('etudiants.nom', 'asc')

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
 

    return response()->json([
        "Notes"=>$data,
        "matieres"=>$matieres,
        "coefficientMatiere"=>$coefficientMatiere,
        "matiereChoisie"=>$matiereChoisie,

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
        $data = ModelsProfesseurClasseMatiere::find($id);
        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté

        $ecoleId = DB::table('users')
        ->where('id', $user_id)
        ->value('ecole_id');

        $classes = DB::table('users')
        ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
        ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
        ->join('niveau_scolaires', 'classes.niveau_scolaires_id', '=', 'niveau_scolaires.id')
        ->where('users.id', '=', $user_id)
        ->select('ecoles.nom as ecole_nom', 'classes.id as id', 'classes.nom as nom','niveau_scolaires.nom as niveau_scolaire')
        ->orderBy("id","Desc")
        ->get();

        $matieres = DB::table('matiers')
        ->select('matiers.*')
        ->where('matiers.ecole_id', '=', $ecoleId)
        ->distinct()
        ->get();

        $professeurs = DB::table('professeurs')
        ->join('professeur_classe_matieres', 'professeurs.id', '=', 'professeur_classe_matieres.professeur_id')
        ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
        ->join('ecoles', 'classes.ecole_id', '=', 'ecoles.id')
        ->join('annee_scolaires', 'professeur_classe_matieres.annee_scolaire_id', '=', 'annee_scolaires.id')
        ->select('professeurs.*')
        ->where('ecoles.id', $ecoleId)
        ->where('annee_scolaires.annee1',lastAneeScolaire())
        ->distinct()
        ->get();

        return view('admin.professeur-classe-matieres.edite', compact('data','matieres','classes','professeurs'));
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
            'matier_id' => 'required',
            'classe_id' => 'required',
            'annee_scolaire_id' => 'required',
            'professeur_id'=>'required',
            'ecole_id' => 'required',
           
          ]);
          $validator = Validator::make($request->all(), [
            'matier_id' => [
                'required',
                'array',
                Rule::unique('professeur_classe_matieres', 'matier_id')->where(function ($query) use ($request) {
                     $query->where('ecole_id', $request->ecole_id)
                        ->whereIn('classe_id', $request->classe_id)
                        ->where('professeur_id', $request->professeur_id)
                        ->where('annee_scolaire_id', $request->annee_scolaire_id);

                }),], ]);

      
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'La validation a échoué. Veuillez vérifier vos données.');
        }

          $donnes = ModelsProfesseurClasseMatiere::find($id);
          $donnes->matier_id = $request->matier_id;
          $donnes->classe_id = $request->classe_id;
          $donnes->annee_scolaire_id = $request->annee_scolaire_id;
          $donnes->professeur_id = $request->professeur_id;
          $donnes->ecole_id = $request->ecole_id;

        
          $donnes->update();
 
          return back()->with("success","Coefficient mise à jour avec succè!");
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
