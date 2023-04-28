<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Matier;
use App\Models\Professeur;
use Illuminate\Contracts\Session\Session as SessionSession;

use App\Models\ProfesseurClasseMatiere;
use App\Models\User;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Commands\MoveCommand;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class ProfesseurController extends Controller
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
        $professeurs = DB::table('users')
        ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
        ->join('professeurs', 'ecoles.id', '=', 'professeurs.ecole_id')
        ->where('users.id', '=', $user_id)
        ->select('professeurs.nom as nom','professeurs.id as id', 'professeurs.matricule as matricule', 'professeurs.prenom as prenom','professeurs.sexe as sexe','professeurs.telephone1 as telephone1')
        ->orderBy("id","Desc")
        ->get();

        return view('admin.professeurs.liste', compact('professeurs'));
    }

    public function disposer()
    {
        $professeurs = Professeur::orderBy("id", "Desc")->get();
        $data = Professeur::all();

        return view('admin.professeur-classe-matieres.disposer', compact('professeurs'));
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
        ->where('users.id', '=', $user_id)
        ->select('classes.id as id', 'classes.nom as nom')
        ->orderBy("id","Desc")
        ->get();
        // $classes = classe::orderBy("id", "Desc")->get();
       // $matieres = Matier::orderBy("id", "Desc")->get();

        $professeurss = Professeur::offset(0)->limit(1)->orderBy("id", "Desc")->get();
        $professeurs = Professeur::orderBy("id","Desc")->get();

        $matieres = DB::table('users')
        ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
        ->join('matiers', 'ecoles.id', '=', 'matiers.ecole_id')
        ->where('users.id', '=', $user_id)
        ->select('matiers.nom as nom','matiers.id as id')
        ->orderBy("id","Desc")
        ->get();

        return view('admin.professeurs.create', compact('professeurs', 'classes', 'matieres', 'professeurss'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->na == 'nouveau') {

            $this->validate($request, [
                'nom' => 'required',
                'prenom' => 'required',
                'sexe' => 'required',
                'telephone1' => 'required|numeric|unique:professeurs,telephone1',
                'adresse' => 'required',
                'email' => 'required|email|unique:professeurs,email',
                'password' => ['required', 'string', 'min:8'],
                'classe_id' => 'required|array',
                'classe_id.*' => 'integer',
                'matier_id' => 'required|array',
                'matier_id.*' => 'integer',
                'role' => 'required',
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
                $fileNameTotore = $fileName . '_' . time() . '.' . $extension;

                //uploader l'image
                $path = $request->file('image')->storeAs('public/images', $fileNameTotore);
            } else {
                $fileNameTotore = 'user.png';
            }

            $professeurs = new Professeur();
            $professeurs->nom = $request->nom;
            $professeurs->prenom = $request->prenom;
            $professeurs->sexe = $request->sexe;
            $professeurs->telephone1 = $request->telephone1;
            $professeurs->adresse = $request->adresse;
            $professeurs->email = $request->email;
            $professeurs->image = $fileNameTotore;
            $professeurs->password = hash::make($request->password);
            $professeurs->role = $request->role;
            $professeurs->ecole_id = $request->ecole_id;


            $professeurs->save();
            //$professeurs->id;

             $matiere_ids = $request->input('matier_id');
             $classe_ids = $request->input('classe_id');

                foreach ($classe_ids as $classe_id) {
                    foreach ($matiere_ids as $matier_id){
                        $ProfesseurClasseMatiere = new ProfesseurClasseMatiere();
                        $ProfesseurClasseMatiere->professeur_id =$professeurs->id;
                        $ProfesseurClasseMatiere->classe_id = $classe_id;
                        $ProfesseurClasseMatiere->matier_id = $matier_id;
                        $ProfesseurClasseMatiere->save();

                    }

                }

                $annes = substr(AnneScolaires(), 7, 2);
                $matricule = substr($professeurs->nom, 0, 3) . substr($professeurs->prenom, 0, 1).$annes;
                $professeurs->matricule = $matricule;

                $professeurs->save();
           return back()->with("success", "Professeur ajouté avec succè!");

           } else {
            $this->validate($request, [
                'matier_id' => 'required|array',
                'professeur_id' => 'required',
                'matier_id.*' => 'integer',
                'classe_id' => 'required|array',
                'classe_id.*' => 'integer',


            ]);

            // $ProfesseurClasseMatieres = new ProfesseurClasseMatiere();
            // $ProfesseurClasseMatieres->professeur_id = $request->professeur_id;
            // $ProfesseurClasseMatieres->classe_id = $request->classe_id;
            // $ProfesseurClasseMatieres->matier_id = $request->matier_id;

            // $ProfesseurClasseMatieres->save();
             $matiere_ids = $request->input('matier_id');
             $classe_ids = $request->input('classe_id');

             foreach ($classe_ids as $classe_id) {
                foreach ($matiere_ids as $matier_id){
                        $ProfesseurClasseMatiere = new ProfesseurClasseMatiere();
                        $ProfesseurClasseMatiere->professeur_id =$request->professeur_id;
                        $ProfesseurClasseMatiere->classe_id = $classe_id;
                        $ProfesseurClasseMatiere->matier_id = $matier_id;
                        $ProfesseurClasseMatiere->save();

                    }

                }
            return back()->with("success", "Professeur ajouté avec succè!");
        }
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
        $professeurs = professeur::find($id);

        return view('admin.professeurs.edite', compact('professeurs'));
    }


    public function detail($id)
    {
        $professeurs = professeur::find($id);

        return view('admin.professeurs.detail', compact('professeurs'));
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
            'telephone1' => 'required|numeric|' . Rule::unique('professeurs')->ignore($id),
            'adresse' => 'required',
            'email' => 'required|email|' . Rule::unique('professeurs')->ignore($id),
            'image' => 'image|nullable|max:1999'

        ]);
        $professeurs = professeur::find($id);
        $professeurs->nom = $request->input('nom');
        $professeurs->prenom = $request->input('prenom');
        $professeurs->sexe = $request->input('sexe');
        $professeurs->telephone1 = $request->input('telephone1');
        $professeurs->adresse = $request->input('adresse');
        $professeurs->email = $request->input('email');

        if ($request->hasFile('image')) {
            $destination = 'public/images/' . $professeurs->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();

            $fileName = time() . '.' . $extension;

            $file =  $request->file('image')->storeAs('public/images/', $fileName);
            $professeurs->image = $fileName;
        }
        $professeurs->update();

        return back()->with("success", "professeurs mise à jour avec succè!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $professeurs =  Professeur::find($id);

        if ($professeurs->image != 'user.png') {
            Storage::delete('public/images/' . $professeurs->image);
        }
        $professeurs->delete();
        return back();
    }
}
