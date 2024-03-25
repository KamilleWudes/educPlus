<?php

namespace App\Http\Controllers;
use PDF;
use Session;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Ecole;
use App\Models\classe;
use App\Models\Etudiant;
use App\Models\Professeur;
use App\Models\inscription;
use Illuminate\Http\Request;
use App\Models\anneescolaire;
use App\Models\typeTrimestre;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


use App\Models\an_ttri_prof_mat_tcomp_in;
use Illuminate\Contracts\Session\Session as SessionSession;

class EtudiantController extends Controller
{
    public function __construct()
    {
        // $this->middleware('isLoggedProf');
       $this->middleware('isLoggedIn');

    }

    public function Getetudes(request $request){
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
       ->where('inscriptions.annee_scolaire_id','=', $request->etudiant)
       ->orderBy('id','desc')
       ->get();

      // dd($data);

    return response()->json([
        "etudiants"=>$data,

    ]);


    }


    /**
     * Display a listing of the resource.
     *  isLoggedProf $this->middleware('isLoggedIn');

     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        carbon::setLocale("fr");
        // $etudiants= Etudiant::all();
        $user_id = Userid(); // l'id de l'utilisateur connecté

        $etudiants = DB::table('users')
          ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
          ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
          ->join('inscriptions', 'classes.id', '=', 'inscriptions.classe_id')
          ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
          ->join('tuteurs', 'inscriptions.tuteur_id', '=', 'tuteurs.id')
          ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
          ->select('inscriptions.id', 'inscriptions.date_insription','etudiants.matricule as matricule','ecoles.nom as ecole_nom','classes.nom as classe_nom','tuteurs.noms as tuteur_nom','tuteurs.prenoms as tuteur_prenoms','tuteurs.telephone1 as tuteur_telephone1','tuteurs.telephone2 as tuteur_telephone2', 'etudiants.nom as etudiant_nom', 'etudiants.prenom as etudiant_prenom','annee_scolaires.annee1 as annee1', 'annee_scolaires.annee2 as annee2','etudiants.adresse as etudiant_adresse', 'etudiants.sexe as sexe','etudiants.id as id','etudiants.created_at as created_at')
          ->where('users.id', '=', $user_id)
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
          ->orderBy("id","Desc")
          ->distinct()
          ->get();

        return view ('admin.etudiants.liste',compact('etudiants','anneeScolaires'));
    }

    public function GetReleve(){

        $userId = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $ecoleId = DB::table('users')
        ->where('id', $userId)
        ->value('ecole_id');

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

        return view ('admin.etudiants.releveNotes',compact('anneeScolaires','typesTrimestreInfos'));
    }

    public function GetReleves(request $request){
    // Récupérez les critères de filtrage depuis la requête
    $anneeScolaire = $request->input('annee_scolaire');
    $typeTrimestre = $request->input('type_trimestre');
    $classe = $request->input('classe');
    $userId = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
    $ecoleId = DB::table('users')
    ->where('id', $userId)
    ->value('ecole_id');

    $data = DB::table('etudiants')
    ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
    ->join('classes', 'classes.id', '=', 'inscriptions.classe_id')
    ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('annee_scolaires', 'annee_scolaires.id', '=', 'inscriptions.annee_scolaire_id')
    ->join('type_trimestres', 'type_trimestres.ecole_id', '=', 'ecoles.id') // Jointure sur l'école_id
    ->select('etudiants.*','inscriptions.*')
    ->where('ecoles.id', $ecoleId)
    ->where('classes.id', $classe)
    ->where('annee_scolaires.id', $anneeScolaire)
    ->where('type_trimestres.id', $typeTrimestre) // Filtre sur le type de trimestre
    ->orderBy('etudiants.nom', 'asc')
    ->get();

    $classes = DB::table('inscriptions')
    ->join('classes', 'inscriptions.classe_id', '=', 'classes.id')
    ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
    //->where('annee_scolaires.annee1', lastAneeScolaire())
    ->where('inscriptions.ecole_id', $ecoleId)
    ->select('classes.nom as nom','classes.id as id')
    ->distinct()
    ->get();

 // Récupérez la matiere  choisie
 $typeTrimestreChoisie = typeTrimestre::where('id', $typeTrimestre)->value('nom');

 $classeChoisie = classe::where('id', $classe)->value('nom');


    return response()->json([
        "Notes"=>$data,
        "classes"=> $classes,
        "typeTrimestreChoisie"=>$typeTrimestreChoisie,
        "classeChoisie"=>$classeChoisie,


    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.etudiants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
             'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'LieuNaissance'=>'required',
            'dateNaissance'=>'required',
            'telephone' => 'nullable|numeric|unique:etudiants,telephone',
            'adresse' => 'required',
            'email' => 'nullable|email|unique:etudiants,email',
            'image' => 'image|nullable|max:1999'
        ]);
        if ($request->hasFile('image')) {
            //1 : get File with ext
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //2 : get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // 3 : GET JUSTE FILE EXTENSION
                $extension = $request->file('image')->getClientOriginalExtension();
            //4 : file name to store
            $fileNameTotore = $fileName.'_'.time().'.'.$extension;

            //uploader l'image
            $path = $request->file('image')->storeAs('public/images', $fileNameTotore);
        } else {
            $fileNameTotore = 'user.png';
        }
    //  User::create($request->all());
        $etudiants = new Etudiant();
        $etudiants->nom = $request->nom;
        $etudiants->prenom = $request->prenom;
        $etudiants->sexe = $request->sexe;
        $etudiants->telephone = $request->telephone;
        $etudiants->adresse = $request->adresse;
        $etudiants->LieuNaissance = $request->LieuNaissance;
        $etudiants->dateNaissance = $request->dateNaissance;
        $etudiants->email = $request->email;
        $etudiants->image = $fileNameTotore;

        $etudiants->save();
        return back()->with("success","Etudiant ajouté avec succè!");

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
  
    public function exportPdf($id, Request $request)
    {
        $ecoleId = session('ecole_id'); // ID de l'école connectée depuis la session
        $anneeScolaireId = $request->input('anneeScolaire'); 


        $responsables = DB::table('users')
        ->select('users.*')
        ->where('users.ecole_id', '=', $ecoleId)
        ->distinct()
        ->get();
        $typeTrimestreId = $request->input('trimestre');

        //bibliothèque  dompdf
       //$pdf = PDF::loadView('admin.Releve-notes.export-pdf');

        // Téléchargez le PDF ou affichez-le dans le navigateur
        //return $pdf->download('jude.pdf');
        $entry = an_ttri_prof_mat_tcomp_in::where('inscription_id', $id)
        ->where('type_trimestre_id', $typeTrimestreId) 
        ->where('annee_scolaire_id', $anneeScolaireId)
        ->first();

        if (!$entry) {
            $message = 'Le bulletin est actuellement indisponible. Merci de réessayer plus tard.';
            return redirect()->back()->with('error', ($message));
        }
        // dd($entry->inscription_id);

        // Exemple : Récupérez le type de composition associé
        $typeComposition = $entry->typeComposition;

        // Exemple : Récupérez le professeur associé
        $professeur = $entry->professeur;

        // Exemple : Récupérez la classe associée
        $classe = $entry->classe;
        //dd($classe);

        // Exemple : Récupérez la matière associée
        $matiere = $entry->matiere;

        // Exemple : Récupérez l'année scolaire associée
        $anneeScolaire = $entry->anneeScolaire;

        $typeTrimestre = $entry->typeTrimestre;

        $inscription =  $entry->inscription;

        $classeId =  $classe->id; // l'ID de la classe connecté

           // Récupérez les ID des compositions
        $compositions = DB::table('an_ttri_prof_mat_tcomp_ins')
        ->where('type_trimestre_id', $entry->type_trimestre_id)
        ->where('inscription_id', $entry->inscription_id)
        ->where('annee_scolaire_id', $entry->anneeScolaire->id)
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
            $message = 'Le bulletin est actuellement indisponible. Merci de réessayer plus tard.';
            return redirect()->back()->with('error', ($message));
        }

        // Utilisez le Query Builder pour compter le nombre d'étudiants dans la classe
        $effectifTotal = DB::table('etudiants')
            ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
            ->where('inscriptions.classe_id', $classeId)
            ->where('inscriptions.annee_scolaire_id', $entry->anneeScolaire->id)
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
            ->where('devoir1.annee_scolaire_id', $entry->anneeScolaire->id)
            ->orderBy('devoir1.created_at') // Triez pour obtenir le premier devoir
            ->take(1); // Prenez seulement le premier devoir

    })
    
    ->leftJoin('an_ttri_prof_mat_tcomp_ins as devoir2', function ($join) use ($entry,$deuxiemeCompositionId) {
        $join->on('matiers.id', '=', 'devoir2.matier_id')
            ->where('devoir2.inscription_id', $entry->inscription_id)
            ->where('devoir2.type_trimestre_id', $entry->type_trimestre_id)
            ->where('devoir2.type_compo_id', $deuxiemeCompositionId) // Utilisez l'ID de la deuxième composition
            ->where('devoir2.annee_scolaire_id', $entry->anneeScolaire->id)
            ->orderBy('devoir2.created_at', 'desc') // Triez pour obtenir le deuxième devoir
            ->take(1); // Prenez seulement le deuxième devoir
    })
    ->leftJoin('an_ttri_prof_mat_tcomp_ins as composition', function ($join) use ($entry,$troisiemeCompositionId) {
        $join->on('matiers.id', '=', 'composition.matier_id')
            ->where('composition.inscription_id', $entry->inscription_id)
            ->where('composition.type_trimestre_id', $entry->type_trimestre_id)
            ->where('composition.annee_scolaire_id', $entry->anneeScolaire->id)
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


        
$pdfContent = view ('admin.pdf-Releve-notes-admin.releve-pdf',compact('moyenneMaxClasseArrondie','moyenneMinClasseArrondie','moyenneGlobaleArrondie','NewmoyenneDeLaClasse','moyenneMinClasse','moyenneMaxClasse','rangEtudiant','moyenneDeLaClasse','plusFaibleMoyenne','maxMoyenneDeLaClasse','maxMoyenneClasse','appreciation','moyenneGlobale','sommeProduits','sommeCoefficients','responsables','entry','effectifTotal','matieres','typeComposition','professeur','classe','matiere','anneeScolaire','typeTrimestre','inscription'))->render();;

     // Chargez le contenu PDF dans Dompdf
$dompdf->loadHtml($pdfContent);

// (Optionnel) Configurez des options de mise en page si nécessaire
$dompdf->setPaper('A3', 'portrait');

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
        $etudiants = Etudiant::find($id);

        return view ('admin.etudiants.edite',compact('etudiants'));
    }


    public function detail($id)
     {
        // $etudiants = Etudiant::find($id);
        // return view ('admin.etudiants.detail',compact('etudiants'));
        $inscriptions = inscription::find($id);
        $classes = classe::orderBy("id","Desc")->get();
        $AnneeScolaires = anneeScolaire::orderBy("id","Desc")->get();
        return view ('admin.etudiants.detail',compact('inscriptions','AnneeScolaires','classes'));
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
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'LieuNaissance'=>'required',
            'dateNaissance'=>'required',
            'telephone' => 'nullable|numeric|' . Rule::unique('etudiants')->ignore($id),
            'adresse' => 'required',
            'email' => 'nullable|email|' . Rule::unique('etudiants')->ignore($id),
            'image' => 'image|nullable|max:1999'
        ]);
        $etudiants = Etudiant::find($id);
        $etudiants->nom = $request->nom;
        $etudiants->prenom = $request->prenom;
        $etudiants->sexe = $request->sexe;
        $etudiants->telephone = $request->telephone;
        $etudiants->adresse = $request->adresse;
        $etudiants->LieuNaissance = $request->LieuNaissance;
        $etudiants->dateNaissance = $request->dateNaissance;
        $etudiants->email = $request->email;
        if ($request->hasFile('image'))
         {
           $destination = 'public/images/'.$etudiants->image;
           if(File::exists($destination))
           {
               File::delete($destination);
           }
           $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();

           $fileName = time().'.'.$extension;

           $file =  $request->file('image')->storeAs('public/images/',$fileName);
           $etudiants->image = $fileName;
         }
         $etudiants->update();

       return back()->with("success","Etudiant mise à jour avec succè!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Etudiant::find($id)->delete();
        return back()->with("success","Etudiant supprimer avec succè!");
    }

    public function onlyTrashed()
    {
        $etudiants = Etudiant::onlyTrashed()->get();
        return view('admin.etudiants.Alldelete',compact('etudiants'));

    }

    public function restore($id)
    {
        $etudiants = Etudiant::onlyTrashed()->findOrFail($id);
        $etudiants->restore();
        return back()->with("success","Etudiant Restaurer avec succè!");

    }

    public function reset($id)
    {
        return view('admin.password.reset-responsable');


    }   
    public function modifierMotDePasse(Request $request, $id)
   {
       $request->validate([
           'old_password' => ['required', 'string', 'min:8'],
           'new_password' => ['required', 'string', 'min:8'],
       ]);
   
       // Récupérez l'utilisateur connecté
       //$user = Userid();
   
      // Utilisez votre fonction helper pour obtenir l'ID de l'utilisateur connecté
    $userId = Userid();
    // Récupérez l'utilisateur à partir de l'ID
    $user = User::find($userId);
    //dd($user->password);
    if (!$user) {
        return back()->with('error', 'Utilisateur non trouvé.');
    }

    if (Hash::check($request->old_password, $user->password)) {
        // Le mot de passe actuel est correct
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return back()->with('success', 'Mot de passe changé avec succès!');
    } else {
        // Le mot de passe actuel est incorrect
        return back()->with('error', 'Le mot de passe actuel est incorrect.');
    }
}
//Profil admin
public function profil($id)
{
    $responsables = User::find($id);
    $ecoles = Ecole::orderBy("id","Desc")->get();

    return view('admin.profil.admin', compact('responsables','ecoles'));

} 


}
?>
