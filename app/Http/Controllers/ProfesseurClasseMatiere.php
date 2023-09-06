<?php

namespace App\Http\Controllers;
use App\Models\ProfesseurClasseMatiere as ModelsProfesseurClasseMatiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\inscription;



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
        ->get();

        $data = DB::table('professeur_classe_matieres')
        ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
        ->join('matiers', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')
        ->join('professeurs', 'professeur_classe_matieres.professeur_id', '=', 'professeurs.id')
        ->join('annee_scolaires', 'professeur_classe_matieres.annee_scolaire_id', '=', 'annee_scolaires.id')
        ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
        ->join('users', 'users.ecole_id', '=', 'ecoles.id')
        ->where('users.id', '=', $user_id)
        ->where('annee_scolaires.annee1',lastAneeScolaire())
        ->select('classes.nom as classe', 'matiers.nom as matiere', 'professeurs.nom as nom','professeurs.prenom as prenom','professeurs.matricule as matricule')
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
        ->orderBy("id","Desc")
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

     
         return view('admin.notes-etudiants.notes-etudiants',compact('anneeScolaires','professeurs','typeCompositions','typesTrimestreInfos'));
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
        
   
    $professorId = ProfId(); // récupérer l'ID du professeur connecté
    $classes = DB::table('professeur_classe_matieres')
    ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
    ->join('ecoles', 'classes.ecole_id', '=', 'ecoles.id')

    ->where('professeur_classe_matieres.professeur_id', $request->professeur)
    ->where('ecoles.id', $ecoleId) // Filtrez par l'ID de l'école connectée

    ->select('classes.nom', 'classes.id')
    ->distinct()
    ->get();

    $matieres = DB::table('professeur_classe_matieres')
    ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
    ->join('ecoles', 'classes.ecole_id', '=', 'ecoles.id')
    ->join('matiers', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')
    ->where('professeur_classe_matieres.professeur_id', $request->professeur)
    ->where('ecoles.id', $ecoleId)
    ->where('classes.id', $request->classe) // Filtrez par l'ID de la classe choisie
    ->select('matiers.nom', 'matiers.id')
    ->distinct()
    ->get();

    $userId = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
    $ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session

    // Récupérez les critères de filtrage depuis la requête
    $anneeScolaire = $request->input('annee_scolaire');
    $typeTrimestre = $request->input('type_trimestre');
    $typeComposition = $request->input('type_composition');
    $professeur = $request->input('professeur');
    $classe = $request->input('classe');
    $matiere = $request->input('matiere');

   $data = inscription::query() 
        ->join('an_ttri_prof_mat_tcomp_ins', 'inscriptions.id', '=', 'an_ttri_prof_mat_tcomp_ins.inscription_id')
        ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
        ->where('an_ttri_prof_mat_tcomp_ins.annee_scolaire_id', $anneeScolaire)
        ->where('an_ttri_prof_mat_tcomp_ins.type_trimestre_id', $typeTrimestre)
        ->where('an_ttri_prof_mat_tcomp_ins.type_compo_id', $typeComposition)
        ->where('an_ttri_prof_mat_tcomp_ins.professeur_id', $professeur)
        ->where('an_ttri_prof_mat_tcomp_ins.classe_id', $classe)
        ->where('an_ttri_prof_mat_tcomp_ins.matier_id', $matiere)
        ->select('etudiants.nom as nom_etudiant', 'etudiants.prenom as prenom_etudiant','etudiants.matricule as matricule','an_ttri_prof_mat_tcomp_ins.note')
        ->get();

    return response()->json([
        "Notes"=>$data,
        "matieres"=>$matieres,
        "classes"=>$classes,

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
