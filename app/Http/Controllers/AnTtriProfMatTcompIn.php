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
<<<<<<< HEAD
      // dd($request->all());
        $request->validate([
=======
        //dd($request->all());
        $this->validate($request, [
>>>>>>> origin/zeus
            'type_compo_id' => 'required',
            'professeur_id' => 'required',
            'classe_id' => 'required',
            'matier_id' => 'required',
            'annee_scolaire_id' => 'required',
            'inscription_id' => 'required',
<<<<<<< HEAD
            'type_trimestre_id' => 'required',
            'note_etudiants.*.note' => 'required|numeric|min:0|max:20',
        ], [
            'note_etudiants.*.note.required' => 'La note est obligatoire.',
            'note_etudiants.*.note.numeric' => 'La note doit être numérique.',
            'note_etudiants.*.note.min' => 'La note doit être supérieure ou égale à 0.',
            'note_etudiants.*.note.max' => 'La note ne peut pas être supérieure à 20.',
        ]);
    

        // $this->validate($request, [
        //     'type_compo_id' => 'required',
        //     'professeur_id' => 'required',
        //     'classe_id' => 'required',
        //     'matier_id' => 'required',
        //     'annee_scolaire_id' => 'required',
        //     'inscription_id' => 'required',
        //     'type_trimestre_id' =>'required',
        //     'note' => 'required|array|numeric|min:0|max:20',
        //     //'note' => 'required|array'

        // ]);


    //principal
    // foreach ($data['note_etudiants'] as $note) {
    //     $noteModel = new an_ttri_prof_mat_tcomp_in();
    //     $noteModel->annee_scolaire_id = $data['annee_scolaire_id'];
    //     $noteModel->professeur_id = $data['professeur_id'];
    //     $noteModel->type_trimestre_id = $data['type_trimestre_id'];
    //     $noteModel->type_compo_id = $data['type_compo_id'];
    //     $noteModel->classe_id = $data['classe_id'];
    //     $noteModel->matier_id = $note['matier_id'];
    //     $noteModel->inscription_id = $note['inscription_id'];
    //     $noteModel->note = $note['note'];

    //     $noteModel->save();
    // }     return response()->json(['success' => true, 'message' => 'Enregistrement réussi']);

    try {
        // $data = $request->all();
        // $notes = $data['note_etudiants'];
        $data = $request->json()->all();
        $notes = $data['note_etudiants'];

        foreach ($notes as $note) {
            $noteModel = new an_ttri_prof_mat_tcomp_in();
            $noteModel->annee_scolaire_id = $note['annee_scolaire_id'];
            $noteModel->professeur_id = $note['professeur_id'];
            $noteModel->type_trimestre_id = $note['type_trimestre_id'];
            $noteModel->type_compo_id = $note['type_compo_id'];
            $noteModel->classe_id = $note['classe_id'];
            $noteModel->matier_id = $note['matier_id'];
            $noteModel->inscription_id = $note['inscription_id'];
            $noteModel->note = $note['note'];

            $noteModel->save();
        }

        return response()->json(['success' => true, 'message' => 'Enregistrement réussi']);
} catch (\Exception $e) {
    return response()->json(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}

=======
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
    
>>>>>>> origin/zeus
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
