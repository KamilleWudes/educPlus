<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Models\Etudiant;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;


use Carbon\Carbon;

class EtudiantController extends Controller
{
    public function __construct()
    {
        // $this->middleware('isLoggedProf');
       $this->middleware('isLoggedIn');

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
          ->select('inscriptions.id', 'inscriptions.date_insription','etudiants.matricule as matricule','ecoles.nom as ecole_nom','classes.nom as classe_nom','tuteurs.noms as tuteur_nom','tuteurs.prenoms as tuteur_prenoms','tuteurs.telephone1 as tuteur_telephone1','tuteurs.telephone2 as tuteur_telephone2', 'etudiants.nom as etudiant_nom', 'etudiants.prenom as etudiant_prenom','annee_scolaires.annee1', 'annee_scolaires.annee2','etudiants.adresse as etudiant_adresse', 'etudiants.sexe as sexe','etudiants.id as id','etudiants.created_at as created_at')
          ->where('users.id', '=', $user_id)
          ->get();


        return view ('admin.etudiants.liste',compact('etudiants'));
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
        $etudiants = Etudiant::find($id);

        return view ('admin.etudiants.detail',compact('etudiants'));
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

       return back()->with("success","professeurs mise à jour avec succè!");
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
}
?>
