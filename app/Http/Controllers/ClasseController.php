<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\classe;
use App\Models\Ecole;
use App\Models\niveauScolaires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ClasseController extends Controller
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

     $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
    $classes = DB::table('users')
    ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
    ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('niveau_scolaires', 'classes.niveau_scolaires_id', '=', 'niveau_scolaires.id')
    ->where('users.id', '=', $user_id)
    ->select('ecoles.nom as ecole_nom', 'classes.id as classe_id', 'classes.nom as classe_nom','niveau_scolaires.nom as niveau_scolaire')
    ->orderby('classe_id','desc')
    ->get();
        return view ('admin.classes.liste',compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

         $ecoles = Ecole::orderBy("id","Desc")->get();
        $NiveauScolaires=niveauScolaires::orderBy("id","Desc")->get();
        return view ('admin.classes.create',compact('NiveauScolaires','ecoles'));
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
            'nom' => 'required|unique:classes,nom,NULL,id,ecole_id,'.$request->ecole_id.',niveau_scolaires_id,'.$request->niveau_scolaires_id,
            'niveau_scolaires_id' => 'required',
       ]);
       classe::create($request->all());
       return back()->with("success","Classe ajouté avec succè!");
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
        $classes = classe::find($id);
        $ecoles = Ecole::orderBy("id","Desc")->get();
        $NiveauScolaires=niveauScolaires::orderBy("id","Desc")->get();

        return view ('admin.classes.edite',compact('classes','NiveauScolaires','ecoles'));
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
            //'nom' => 'required:classes,nom,NULL,id,ecole_id,'.$request->ecole_id.',niveau_scolaires_id,'.$request->niveau_scolaires_id,
             'nom' => 'required|' . Rule::unique('classes')->ignore($id),
           // 'ecole_id' => 'required',
           'niveau_scolaires_id' => 'required',

       ]);
        $classes = classe::find($id);
         $classes->nom = $request->nom;
      //   $classes->ecole_id = $request->ecole_id;
         $classes->niveau_scolaires_id = $request->niveau_scolaires_id;

         $classes->update($request->all());
         return back()->with("success","Classe mise à jour avec succè!");
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
