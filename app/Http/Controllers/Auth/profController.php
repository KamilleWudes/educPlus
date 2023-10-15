<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as FacadesSession;
use App\Models\Ecole;
use Illuminate\Support\Facades\DB;




class profController extends Controller
{
    public function __construct()
    {
        //$this->middleware('isLoggedIn');
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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


    public function loginProf(Request $request)
    {
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            if ($request->na == 'admin') {
                $user = User::where("email", $request->email)->first();
                if ($user && Hash::check($request->password, $user->password)) {
                    $request->session()->put('user', $user->id);
                    return redirect('dashbord');
                }
            } else {
                $request->validate([
                    'ecole_id' => 'required',
                ]);
    
                $prof = Professeur::where("email", $request->email)->first();

                if ($prof && Hash::check($request->password, $prof->password)) {
                    // Vérification de l'école du professeur ici
                    $chosen_ecole_id = $request->input('ecole_id');
                        $chosen_ecole = Ecole::find($chosen_ecole_id);
                        if ($chosen_ecole) {
                            $prof = Professeur::with(['ecoles' => function ($query) use ($chosen_ecole_id) {
                                $query->where('ecole_id', $chosen_ecole_id);
                            }])->where("email", $request->email)->first();
                        
                            if ($prof && Hash::check($request->password, $prof->password) && $prof->ecoles->count() > 0) {
                                $request->session()->put('ecole_id', $chosen_ecole_id);
                                $request->session()->put('ecole_nom', $chosen_ecole->nom);
                                $request->session()->put('Professeur', $prof->id);
                                return redirect('liste-note');
                            }}
                }
            }
    
            return redirect()->back()->with("error", "Authentification incorrecte");
        }
}

public function dashbord()
    {
        $user_id = Userid(); // l'id de l'utilisateur connecté

    $inscriptions = DB::table('users')
    ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
    ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('inscriptions', 'classes.id', '=', 'inscriptions.classe_id')
    ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
    ->join('tuteurs', 'inscriptions.tuteur_id', '=', 'tuteurs.id')
    ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
    ->select('inscriptions.id', 'inscriptions.date_insription', 'ecoles.nom as ecole_nom','classes.nom as classe_nom','tuteurs.noms as tuteur_nom','tuteurs.prenoms as tuteur_prenoms','tuteurs.telephone1 as tuteur_telephone1','tuteurs.telephone2 as tuteur_telephone2', 'etudiants.nom as etudiant_nom','etudiants.prenom as etudiant_prenom','etudiants.matricule as matricule')
    ->where('users.id', '=', $user_id)
   // ->where('annee_scolaires.annee1',lastAneeScolaire())
    ->orderBy('inscriptions.id', 'desc') // Trie par ID d'inscription décroissante
    ->take(7) // Limiter à 7 résultats
    ->get();

    $data = DB::table('professeur_classe_matieres')
    ->join('classes', 'professeur_classe_matieres.classe_id', '=', 'classes.id')
    ->join('matiers', 'professeur_classe_matieres.matier_id', '=', 'matiers.id')
    ->join('professeurs', 'professeur_classe_matieres.professeur_id', '=', 'professeurs.id')
    ->join('annee_scolaires', 'professeur_classe_matieres.annee_scolaire_id', '=', 'annee_scolaires.id')
    ->join('ecoles', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('users', 'users.ecole_id', '=', 'ecoles.id')
    ->where('users.id', '=', $user_id)
   // ->where('annee_scolaires.annee1',lastAneeScolaire())
    ->select('classes.nom as classe', 'matiers.nom as matiere', 'professeurs.nom as nom','professeurs.prenom as prenom','professeurs.matricule as matricule','professeurs.created_at as created_at','professeurs.image as image','professeur_classe_matieres.id as id')
    ->orderBy('professeur_classe_matieres.created_at', 'desc')
    ->take(7) // Limiter à 7 résultats
    ->orderBy('professeur_classe_matieres.id', 'desc') // Trie par ID d'inscription décroissante
    ->get();
    
        return view('dashbord',compact('inscriptions','data'));
    }    

}
