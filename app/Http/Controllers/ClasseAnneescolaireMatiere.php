<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\anneeScolaire;
use App\Models\classe;
use App\Models\ClasseAnneescolaireMatiere as ModelsClasseAnneescolaireMatiere;
use App\Models\Matier;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClasseAnneescolaireMatiere extends Controller
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
     $data = DB::table('classe_anneescolaire_matieres')
    ->join('classes', 'classes.id', '=', 'classe_anneescolaire_matieres.classe_id')
    ->join('matiers', 'matiers.id', '=', 'classe_anneescolaire_matieres.matier_id')
    ->join('annee_scolaires', 'annee_scolaires.id', '=', 'classe_anneescolaire_matieres.annee_scolaire_id')
    ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('users', 'users.ecole_id', '=', 'ecoles.id')
    ->where('users.id', '=', $user_id)
    ->where('classe_anneescolaire_matieres.annee_scolaire_id', AnneScolairesId())
    ->select('classes.nom as classe_nom', 'matiers.nom as matiere_nom', 'annee_scolaires.annee1 as anneescolaire_annee1', 'annee_scolaires.annee2 as anneescolaire_annee2', 'classe_anneescolaire_matieres.coefficient','classe_anneescolaire_matieres.id')
    ->orderBy('classe_anneescolaire_matieres.created_at', 'desc')
    ->get();

    $AnneeScolaires = DB::table('users')
    ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
    ->join('annee_scolaires', 'ecoles.id', '=', 'annee_scolaires.ecole_id')
    ->where('users.id', '=', $user_id)
    ->select('annee_scolaires.annee1 as annee1','annee_scolaires.id as id','annee_scolaires.annee2 as annee2')
    ->orderBy("id","Desc")
    ->get();

    return view ('admin.matiere_coefficient.liste', compact('data','AnneeScolaires'));

    }
 
    public function GetClasses(request $request){

        //dd($request->classe_id);
       $matieres = DB::table('matiers')
         ->join('professeur_classe_matieres', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')

         //->join('classe_anneescolaire_matieres', 'classe_anneescolaire_matieres.matier_id', '=', 'matiers.id')
         //  ->join('classe_anneescolaire_matieres', 'matiers.id', '=', 'classe_anneescolaire_matieres.matier_id')

         ->where('professeur_classe_matieres.classe_id', $request->classe_id)
         ->distinct()
         ->select(
             'matiers.id','matiers.nom'
         )
         ->get();

        //  return response()->json($matieres);
        // dd($matieres);
        return response()->json([
            "matieres"=>$matieres,
        ]);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $classes = DB::table('users')
        ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
        ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
        ->join('niveau_scolaires', 'classes.niveau_scolaires_id', '=', 'niveau_scolaires.id')
        ->where('users.id', '=', $user_id)
        ->select('ecoles.nom as ecole_nom', 'classes.id as id', 'classes.nom as nom','niveau_scolaires.nom as niveau_scolaire')
        ->orderBy("id","Desc")
        ->get();
        // $matieres = Matier::offset(0)->limit(1)->orderBy("id", "Desc")->get();
        $matieres = Matier::get();

        $AnneeScolaires = anneeScolaire::offset(0)->limit(1)->orderBy("id", "Desc")->get();
        // $classes = classe::orderBy("id", "Desc")->get();

        return view('admin.matiere_coefficient.create', compact('AnneeScolaires', 'classes', 'matieres'));
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
            // "nom" => 'required|unique:matiers,nom',

            'annee_scolaire_id'=>'required',
            'classe_id' => 'required',
            'coefficient'=>'required',
            'matier_id'=>'required',
            'ecole_id'=>'required'

        ]);

        $validator = Validator::make($request->all(), [
            'classe_id' => [
                'required',
                Rule::unique('classe_anneescolaire_matieres')->where(function ($query) use ($request) {
                     $query->where('ecole_id', $request->ecole_id)
                                 ->where('annee_scolaire_id', $request->annee_scolaire_id)
                                 ->where('matier_id', $request->matier_id);
                                
                })->ignore($request->id), // Ignorer la ligne actuelle lors de la vérification des doublons
            ],
                 ]);

      
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'La validation a échoué. Veuillez vérifier vos données.');
        }

        $ClassesCoefficients = new ModelsClasseAnneescolaireMatiere();
        $ClassesCoefficients->annee_scolaire_id = $request->annee_scolaire_id;
        $ClassesCoefficients->classe_id = $request->classe_id;
        $ClassesCoefficients->matier_id = $request->matier_id;
        $ClassesCoefficients->ecole_id = $request->ecole_id;
        $ClassesCoefficients->coefficient = $request->coefficient;

        $ClassesCoefficients->save();

        return back()->with("success", " Matiere et coefficient enregistrer avec succè!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ModelsClasseAnneescolaireMatiere::find($id);

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

     return view ('admin.matiere_coefficient.edite',compact('classes','matieres','data'));
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
            'coefficient'=>'required',
            'ecole_id' => 'required',

           
          ]);
          $validator = Validator::make($request->all(), [
            'classe_id' => [
                'required',
                Rule::unique('classe_anneescolaire_matieres')->where(function ($query) use ($request) {
                     $query->where('ecole_id', $request->ecole_id)
                                 ->where('annee_scolaire_id', $request->annee_scolaire_id)
                                 ->where('matier_id', $request->matier_id);
                                
                })->ignore($request->id), // Ignorer la ligne actuelle lors de la vérification des doublons
            ],
                 ]);

      
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'La validation a échoué. Veuillez vérifier vos données.');
        }

          $coef = ModelsClasseAnneescolaireMatiere::find($id);
          $coef->matier_id = $request->matier_id;
          $coef->classe_id = $request->classe_id;
          $coef->annee_scolaire_id = $request->annee_scolaire_id;
          $coef->coefficient = $request->coefficient;
        
          $coef->update();
 
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
    public function GetCoefAnnees(request $request){
        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté

        $data = DB::table('classe_anneescolaire_matieres')
       ->join('classes', 'classes.id', '=', 'classe_anneescolaire_matieres.classe_id')
       ->join('matiers', 'matiers.id', '=', 'classe_anneescolaire_matieres.matier_id')
       ->join('annee_scolaires', 'annee_scolaires.id', '=', 'classe_anneescolaire_matieres.annee_scolaire_id')
       ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
       ->join('users', 'users.ecole_id', '=', 'ecoles.id')
       ->where('users.id', '=', $user_id)
       ->where('classe_anneescolaire_matieres.annee_scolaire_id','=', $request->annee)
       ->select('classes.nom as classe_nom', 'matiers.nom as matiere_nom', 'annee_scolaires.annee1 as anneescolaire_annee1', 'annee_scolaires.annee2 as anneescolaire_annee2', 'classe_anneescolaire_matieres.coefficient','classe_anneescolaire_matieres.id')
       ->orderBy('classe_anneescolaire_matieres.created_at', 'desc')
       ->get();


    return response()->json([
        "coefAnnee"=>$data,


    ]);
    }
}
