<?php

namespace App\Http\Controllers;
use App\Models\ProfesseurClasseMatiere as ModelsProfesseurClasseMatiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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


    $data = DB::table('professeur_classe_matieres')
    ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
    ->join('matiers', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')
    ->join('professeurs', 'professeur_classe_matieres.professeur_id', '=', 'professeurs.id')

    ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('users', 'users.ecole_id', '=', 'ecoles.id')

    ->where('users.id', '=', $user_id)

    ->select('classes.nom as classe', 'matiers.nom as matiere', 'professeurs.nom as professeur','professeurs.prenom as prenom','professeurs.matricule as matricule')
    ->orderBy('professeur_classe_matieres.created_at', 'desc')
    ->get();

    return view('admin.professeur-classe-matieres.disposer', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $professeurs = Professeur::orderBy("id", "Desc")->get();

        // return view('admin.professeur-classe-matieres.disposer', compact('professeurs'));
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
