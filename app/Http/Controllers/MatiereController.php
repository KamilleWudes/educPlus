<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\Matier;
use Illuminate\Http\Request;
use App\Models\ClasseAnneescolaireMatiere as ModelsClasseAnneescolaireMatiere;
use Illuminate\Support\Facades\DB;



class MatiereController extends Controller
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
        // $matieres= Matier::all();
        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $matieres = DB::table('users')
        ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
        ->join('matiers', 'ecoles.id', '=', 'matiers.ecole_id')
        ->where('users.id', '=', $user_id)
        ->select('matiers.nom as nom','matiers.id as id')
        ->orderBy("id","Desc")
        ->get();

        return view ('admin.matieres.liste',compact('matieres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.matieres.create');
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
            "nom" =>'required|unique:matiers,nom',
         ]);

        $mat = new Matier();
        $mat->nom = $request->nom;
        $mat->ecole_id = $request->ecole_id;

        $mat->save();
         return back()->with("success","Matière ajouté avec succè!");
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
        $matieres = Matier::find($id);

        return view ('admin.matieres.edite',compact('matieres'));
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
        $request->validate([
            'nom' => 'required|'. Rule::unique('matiers')->ignore($id),

         ]);
         $matieres = Matier::find($id);
         $matieres->nom = $request->nom;

         $matieres->update($request->all());

         return back()->with("success","Matiere mise à jour avec succè!");
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
