<?php

namespace App\Http\Controllers;
use App\Models\userprincipal;
use App\Notifications\SendSuperAdminRegistrationNotification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;


class superAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('isLoggedSuperadmin');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SuperAdmins = userprincipal::where('id', '=', superAdminId())->get();
     //   $SuperAdmins = userprincipal::all();
        return view ('admin.superAdmins.liste',compact('SuperAdmins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = userprincipal::orderBy("id","Desc")->get();

         return view('admin.superAdmins.create',compact('data'));
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
           'telephone' => 'required|numeric|unique:userprincipals,telephone',
           'email' => 'required|email|unique:userprincipals,email',
       ]);
       // Générer un mot de passe aléatoire de 8 caractères
   $password = Str::random(8);

       $userprincipals = new userprincipal();
       $userprincipals->nom = $request->nom;
       $userprincipals->prenom = $request->prenom;
       $userprincipals->telephone = $request->telephone;
       $userprincipals->email = $request->email;
    //    $userprincipals->password = hash::make($request->password);
    $userprincipals->password = Hash::make($password); // Hasher le mot de passe aléatoire

       $userprincipals->role = $request->role;

       $userprincipals->save();
        if($userprincipals){

            // Notifiez l'école nouvellement créée
            $userprincipals->notify(new SendSuperAdminRegistrationNotification($password));
        }

       return back()->with("success","Utilisateur ajouté avec succè!");

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
        $users = userprincipal::find($id);

        return view('admin.superAdmins.edite',compact('users'));
    }

    public function detail($id)
    {
        $utilisateurs = userprincipal::find($id);

        return view('admin.superAdmins.detail',compact('utilisateurs'));
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
           'telephone' => 'required|numeric|' . Rule::unique('userprincipals')->ignore($id),
           'email' => 'required|email|' . Rule::unique('userprincipals')->ignore($id),
          // 'password' => ['required', 'string', 'min:8'],

       ]);
       $userprincipals = userprincipal::find($id);
       $userprincipals->nom = $request->nom;
       $userprincipals->prenom = $request->prenom;
       $userprincipals->telephone = $request->telephone;
       //$userprincipals->password = hash::make($request->password);
       $userprincipals->email = $request->email;

       $userprincipals->update();

       return back()->with("success","Utilisateur mise à jour avec succè!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function reset($id)
     {
         return view('admin.password.reset-user');

         
         
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
      $userId = superAdminId();
      // Récupérez l'utilisateur à partir de l'ID
      $user = userprincipal::find($userId);
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

  //Profile utilisateur
  public function profil($id)
  {
    $utilisateurs = userprincipal::find($id);

      return view('admin.profil.superAdmin',compact('utilisateurs'));
      
  } 
    public function destroy($id)
    {
        //
    }
}
