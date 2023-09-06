<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

use App\Models\anneeScolaire;
use App\Models\classe;
use App\Models\Etudiant;
use App\Models\inscription;
use App\Models\Tuteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLoggedIn');
    }

    public $nouveau = "";
    public $ancien = "";

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */       //-where('professeur_classe_matieres.classe_id', $request->classe_id)

    public function GetAnnees(request $request){
        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté

       // dd($request->annee);
       $data = DB::table('users')

       ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
       ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
       ->join('inscriptions', 'classes.id', '=', 'inscriptions.classe_id')
       ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
       ->join('tuteurs', 'inscriptions.tuteur_id', '=', 'tuteurs.id')
       ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
       ->select('inscriptions.id', 'inscriptions.date_insription','classes.nom as classe_nom','tuteurs.noms as tuteur_nom','etudiants.nom as etudiant_nom','tuteurs.prenoms as tuteur_prenoms','tuteurs.telephone1 as tuteur_telephone1','tuteurs.telephone2 as tuteur_telephone2','etudiants.prenom as etudiant_prenom','etudiants.matricule as matricule','annee_scolaires.annee1', 'annee_scolaires.annee2', 'ecoles.nom as ecole_nom')
       ->where('users.id', '=', $user_id)
       ->orderBy("id","Desc")
       ->where('inscriptions.annee_scolaire_id','=', $request->annee)
       ->get();

      // dd($data);

    return response()->json([
        "inscriptions"=>$data,


    ]);


    }
    public function index()
    {
        // $inscriptions= inscription::all();
     $user_id = Userid(); // l'id de l'utilisateur connecté
     $anneeScolaireEnCours = AnneeScolaire::orderBy('id', 'desc')->first(); // récupération de l'année scolaire en cours

  $inscriptions = DB::table('users')
    ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
    ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('inscriptions', 'classes.id', '=', 'inscriptions.classe_id')
    ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
    ->join('tuteurs', 'inscriptions.tuteur_id', '=', 'tuteurs.id')
    ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
    ->select('inscriptions.id', 'inscriptions.date_insription', 'ecoles.nom as ecole_nom','classes.nom as classe_nom','tuteurs.noms as tuteur_nom','tuteurs.prenoms as tuteur_prenoms','tuteurs.telephone1 as tuteur_telephone1','tuteurs.telephone2 as tuteur_telephone2', 'etudiants.nom as etudiant_nom','etudiants.prenom as etudiant_prenom','etudiants.matricule as matricule','annee_scolaires.annee1', 'annee_scolaires.annee2')
    ->where('users.id', '=', $user_id)
    ->where('annee_scolaires.annee1',lastAneeScolaire())
    ->get();

    $AnneeScolaires = DB::table('users')
    ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
    ->join('annee_scolaires', 'ecoles.id', '=', 'annee_scolaires.ecole_id')
    ->where('users.id', '=', $user_id)
    ->select('annee_scolaires.annee1 as annee1','annee_scolaires.id as id','annee_scolaires.annee2 as annee2')
    ->orderBy("id","Desc")
    ->get();


    return view ('admin.inscriptions.liste',compact('inscriptions','AnneeScolaires'));
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
        ->select('ecoles.nom as ecole_nom', 'classes.id as classe_id', 'classes.nom as classe_nom','niveau_scolaires.nom as niveau_scolaire')
        ->orderBy("classe_id","Desc")
        ->get();
        $etudiantss = Etudiant::offset(0)->limit(1)->orderBy("id","Desc")->get();
        $tuteurs = Tuteur::offset(0)->limit(1)->orderBy("id","Desc")->get();

        $AnneeScolaires = anneeScolaire::offset(0)->limit(1)->orderBy("id","Desc")->get();
        $etudiants = Etudiant::orderBy("id","Desc")->get();
        $Tuteurss = Tuteur::orderBy("id","Desc")->get();

        return view ('admin.inscriptions.create',compact('etudiants','classes','AnneeScolaires','etudiantss','tuteurs','Tuteurss'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if($request->na == 'nouveau' and $request->nw == 'new'){

        //dd($request->nouveau);
        $this->validate($request, [
           'nom' => 'required',
           'prenom' => 'required',
           'sexe' => 'required',
           'LieuNaissance'=>'required',
           'dateNaissance'=>'required',
           'telephone' => 'nullable|numeric|unique:etudiants,telephone',
           'adresse' => 'required',
           'email' => 'nullable|email|unique:etudiants,email',
           'image' => 'image|nullable|max:1999',

           'noms' => 'required',
           'prenoms' => 'required',
           'sex' => 'required',
           'telephone1'=>'required|numeric|unique:tuteurs,telephone1',
           'telephone2' => 'nullable|numeric|unique:tuteurs,telephone2',
           'adresses' => 'required',
           'emails' => 'required|email|unique:tuteurs,emails',

           'annee_scolaire_id'=>'required',
           'classe_id' => 'required',
           'date_insription' => 'required',

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
   //save Etudiant
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

     //save tuteurs
       $tuteurs = new Tuteur();
       $tuteurs->noms = $request->noms;
       $tuteurs->prenoms = $request->prenoms;
       $tuteurs->sex = $request->sex;
       $tuteurs->telephone1 = $request->telephone1;
       $tuteurs->telephone2 = $request->telephone2;
       $tuteurs->adresses = $request->adresses;
       $tuteurs->emails = $request->emails;

       $tuteurs->save();

       //save inscriptions
       $inscriptions = new inscription();
       $inscriptions->annee_scolaire_id = $request->annee_scolaire_id;
       $inscriptions->date_insription = $request->date_insription;
       $inscriptions->classe_id = $request->classe_id;
       $inscriptions->etudiant_id = $etudiants->id;
       $inscriptions->tuteur_id = $tuteurs->id;

       $inscriptions->save();

       $annes = substr(AnneScolaires(), 7, 2);
       $matricule = substr($etudiants->nom, 0, 3) . substr($etudiants->prenom, 0, 1).substr($etudiants->dateNaissance, 2, 2).$annes;
       $etudiants->matricule = $matricule;

       $etudiants->save();

       return back()->with("success"," inscription realiser avec succè!");

    } else if($request->na == 'ancien' and $request->nw == 'new'){

        $this->validate($request, [

           'noms' => 'required',
           'prenoms' => 'required',
           'sex' => 'required',
           'telephone1'=>'required|numeric|unique:tuteurs,telephone1',
           'telephone2' => 'nullable|numeric|unique:tuteurs,telephone2',
           'adresses' => 'required',
           'emails' => 'required|email|unique:tuteurs,emails',

           'annee_scolaire_id'=>'required',
           'classe_id' => 'required',
           'date_insription' => 'required',
           'etudiant_id' => 'required',


       ]);

        //save tuteurs
      $tuteurs = new Tuteur();
      $tuteurs->noms = $request->noms;
      $tuteurs->prenoms = $request->prenoms;
      $tuteurs->sex = $request->sex;
      $tuteurs->telephone1 = $request->telephone1;
      $tuteurs->telephone2 = $request->telephone2;
      $tuteurs->adresses = $request->adresses;
      $tuteurs->emails = $request->emails;

      $tuteurs->save();

       //save inscriptions
       $inscriptions = new inscription();
       $inscriptions->annee_scolaire_id = $request->annee_scolaire_id;
       $inscriptions->date_insription = $request->date_insription;
       $inscriptions->classe_id = $request->classe_id;
       $inscriptions->etudiant_id = $request->etudiant_id;
       $inscriptions->tuteur_id = $tuteurs->id;

       $inscriptions->save();


       return back()->with("success"," inscription realiser avec succè!");

    }elseif($request->na == 'nouveau' and $request->nw == 'old'){

        //dd($request->nouveau);
        $this->validate($request, [
           'nom' => 'required',
           'prenom' => 'required',
           'sexe' => 'required',
           'LieuNaissance'=>'required',
           'dateNaissance'=>'required',
           'telephone' => 'nullable|numeric|unique:etudiants,telephone',
           'adresse' => 'required',
           'email' => 'nullable|email|unique:etudiants,email',
           'image' => 'image|nullable|max:1999',

           'annee_scolaire_id'=>'required',
           'classe_id' => 'required',
           'date_insription' => 'required',
           'tuteur_id' => 'required',


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
   //save Etudiant
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

       //save inscriptions
       $inscriptions = new inscription();
       $inscriptions->annee_scolaire_id = $request->annee_scolaire_id;
       $inscriptions->date_insription = $request->date_insription;
       $inscriptions->classe_id = $request->classe_id;
       $inscriptions->tuteur_id = $request->tuteur_id;
       $inscriptions->etudiant_id = $etudiants->id;

       $inscriptions->save();

       $annes = substr(AnneScolaires(), 7, 2);
       $matricule = substr($etudiants->nom, 0, 3) . substr($etudiants->prenom, 0, 1).substr($etudiants->dateNaissance, 2, 2).$annes;
       $etudiants->matricule = $matricule;

       $etudiants->save();

       return back()->with("success"," inscription realiser avec succè!");
  } else {

    // dd($request->nouveau);
    $this->validate($request, [

        'annee_scolaire_id'=>'required',
        'classe_id' => 'required',
        'date_insription' => 'required',
        'tuteur_id' => 'required',
        'etudiant_id' => 'required',

    ]);

     //save inscriptions
     $inscriptions = new inscription();
     $inscriptions->annee_scolaire_id = $request->annee_scolaire_id;
     $inscriptions->date_insription = $request->date_insription;
     $inscriptions->classe_id = $request->classe_id;
     $inscriptions->tuteur_id = $request->tuteur_id;
     $inscriptions->etudiant_id = $request->etudiant_id;

     $inscriptions->save();

     return back()->with("success"," inscription realiser avec succè!");


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
        $inscriptions = inscription::find($id);
        $classes = classe::orderBy("id","Desc")->get();
        $AnneeScolaires = anneeScolaire::orderBy("id","Desc")->get();


        return view ('admin.inscriptions.edite',compact('inscriptions','AnneeScolaires','classes'));
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
            'image' => 'image|nullable|max:1999',

            'noms' => 'required',
            'prenoms' => 'required',
            'sex' => 'required',
            'telephone1'=>'required|numeric|'. Rule::unique('tuteurs')->ignore($id),
            'telephone2' => 'nullable|numeric|'. Rule::unique('tuteurs')->ignore($id),
            'adresses' => 'required',
            'emails' => 'required|email|'. Rule::unique('tuteurs')->ignore($id),

            'annee_scolaire_id'=>'required',
            'classe_id' => 'required',
            'date_insription' => 'required',
            'etudiant_id' => 'required',
            'tuteur_id' => 'required'

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


     //update tuteurs
       $tuteurs = Tuteur::find($id);
       $tuteurs->noms = $request->noms;
       $tuteurs->prenoms = $request->prenoms;
       $tuteurs->sex = $request->sex;
       $tuteurs->telephone1 = $request->telephone1;
       $tuteurs->telephone2 = $request->telephone2;
       $tuteurs->adresses = $request->adresses;
       $tuteurs->emails = $request->emails;

       $tuteurs->update();


       //update inscriptions
       $inscriptions = inscription::find($id);
       $inscriptions->annee_scolaire_id = $request->annee_scolaire_id;
       $inscriptions->date_insription = $request->date_insription;
       $inscriptions->classe_id = $request->classe_id;
       $inscriptions->tuteur_id = $request->tuteur_id;
       $inscriptions->etudiant_id = $request->etudiant_id;

       $inscriptions->update();


       return back()->with("success"," inscription Mise à jour avec succè!");
       
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function detail($id)
     {
        $inscriptions = inscription::find($id);
        $classes = classe::orderBy("id","Desc")->get();
        $AnneeScolaires = anneeScolaire::orderBy("id","Desc")->get();


        return view ('admin.inscriptions.detail',compact('inscriptions','AnneeScolaires','classes'));
    }

    public function destroy($id)
    {
        inscription::find($id)->delete();
        return back()->with("success","Etudiant supprimer avec succè!");
    }

    public function onlyTrashed()
    {
        $inscriptions = inscription::onlyTrashed()->get();
        return view('admin.inscriptions.Alldelete',compact('inscriptions'));

    }

    public function restore($id)
    {
        $inscriptions = inscription::onlyTrashed()->findOrFail($id);
        $inscriptions->restore();
        return back()->with("success","Etudiant Restaurer avec succè!");

    }

}
