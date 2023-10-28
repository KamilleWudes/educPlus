<?php
use App\Models\Matier;
use App\Models\anneeScolaire;
use App\Models\Professeur;
use App\Models\User;
use App\Models\userprincipal;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Etudiant;
use App\Models\inscription;
use App\Models\ProfesseurClasseMatiere;
use App\Models\Ecole;
use App\Models\classe;
use App\Models\typeComposition;
use App\Models\typeTrimestre;
use App\Models\niveauScolaires;


//Users
function UserfullName(){
    $data = array();
     if(Session::has('user')){
         $data1 = User::where('id','=', Session::get('user'))->first()->name;
         $data2 = User::where('id','=', Session::get('user'))->first()->prenom;

         $fulNames = $data1 .' '. $data2;
         return $fulNames ;
     }
 }

 function Userid(){
    $data = array();
     if(Session::has('user')){
         $data = User::where('id','=', Session::get('user'))->first()->id;
         return $data ;
     }
 }

function UserfullRole(){
       $data = array();
        if(Session::has('user')){
            $datas = User::where('id','=', Session::get('user'))->first()->role;

           // $datas = DB::table('roles')->where('id','=', $data)->first()->nom;

            return $datas ;
        }
    }

    //Profeseurs
    function UserfullNameProf(){
        $data = array();
        if(Session::has('Professeur')){
            $data3 = Professeur::where('id','=', Session::get('Professeur'))->first()->nom;
            $data4 = Professeur::where('id','=', Session::get('Professeur'))->first()->prenom;
            $fulNamesProf = $data3 .' '. $data4;
            return $fulNamesProf ;

        }
     }

     //Ecole professeur
     function fullEcoleProf(){
        // $data = array();
        // if(Session::has('Professeur')){
        //     $data = Professeur::where('id','=', Session::get('Professeur'))->first()->ecole_id;

        //     $ecoles = DB::table('ecoles')->where('id','=', $data)->first()->nom;

        //     return 'Ecole : ' .$ecoles;

        // }
     }

      //superadmin
    function FullNameSuperAdmin(){
        $data = array();
        if(Session::has('userprincipal')){
            $data3 = userprincipal::where('id','=', Session::get('userprincipal'))->first()->nom;
            $data4 = userprincipal::where('id','=', Session::get('userprincipal'))->first()->prenom;
            $fulNameSuperadmin = $data3 .' '. $data4;
            return $fulNameSuperadmin ;

        }
     }
     //id superAdmin
     function superAdminId(){
        $data = array();
         if(Session::has('userprincipal')){
             $data = userprincipal::where('id','=', Session::get('userprincipal'))->first()->id;
             return $data ;
         }
     }
    //Role superAdmin
     function fullRoleSuperAdmin(){
        $data = array();
        if(Session::has('userprincipal')){
            $data = userprincipal::where('id','=', Session::get('userprincipal'))->first()->role;
             return  $data ;
         }
     }

     // récupérer le Role du professeur connecté

     function UserfullRoleProf(){
        $data = array();
        if(Session::has('Professeur')){
            $data = Professeur::where('id','=', Session::get('Professeur'))->first()->role;
             return  $data ;
         }
     }

     // récupérer l'ID du professeur connecté

     function ProfId(){
        $data = array();
        if(Session::has('Professeur')){
            $professeurId = Professeur::where('id','=', Session::get('Professeur'))->first()->id;
             return  $professeurId ;
         }
     }


     function AnneScolaire(){
        $AnneeScolaire1 = anneeScolaire::offset(0)->limit(1)->orderBy("id","Desc")->get()->first()->annee1;

        $AnneeScolaire2 = anneeScolaire::offset(0)->limit(1)->orderBy("id","Desc")->get()->first()->annee2;

        $AnneeScolaire = 'Annee scolaire : '. $AnneeScolaire1.'-'. $AnneeScolaire2;

        return $AnneeScolaire;
     }

//annee bulettin
     function AnneScolaires(){
        $AnneeScolaire1 = anneeScolaire::offset(0)->limit(1)->orderBy("id","Desc")->get()->first()->annee1;

        $AnneeScolaire2 = anneeScolaire::offset(0)->limit(1)->orderBy("id","Desc")->get()->first()->annee2;

        $AnneeScolaire = $AnneeScolaire1.'-'. $AnneeScolaire2;

        return $AnneeScolaire;
     }

     function AnneScolairesId(){
        $AnneeScolaire1 = anneeScolaire::offset(0)->limit(1)->orderBy("id","Desc")->get()->first()->id;

        return $AnneeScolaire1;
     }


     function lastAneeScolaire(){
        $AnneeScolaire1 = anneeScolaire::offset(0)->limit(1)->orderBy("id","Desc")->get()->first()->annee1;
        $lastAnees = $AnneeScolaire1;
    // $date = new DateTime();
    // $currentYear = $date->format('Y');

        return $lastAnees;
     }

     function UserEcoles(){
       // $eco = array();
        if(Session::has('user')){
         $data = User::where('id','=', Session::get('user'))->first()->ecole_id;

         $ecoles = DB::table('ecoles')->where('id','=', $data)->first()->nom;

        return $ecoles;
    }}

    function disposer(){
        // $eco = array();
        if(Session::has('Professeur')){
            $data = Professeur::where('id','=', Session::get('Professeur'))->first()->id;

         $table = DB::table('professeur_classe_matieres')->where('classe_id','=',$data)->get();

        return $table;
     }
}


function Ecoles(){
    // $eco = array();
     if(Session::has('user')){
      $data = User::where('id','=', Session::get('user'))->first()->ecole_id;

      $ecoles = DB::table('ecoles')->where('id','=', $data)->first()->nom;

     return $ecoles;
 }}


function EcolesId(){
    // $eco = array();
     if(Session::has('user')){
      $data = User::where('id','=', Session::get('user'))->first()->ecole_id;

     return $data;
 }}


if (!function_exists('getConnectedEcoleId')) {
    function getConnectedEcoleId() {
        return session('ecole_id');

        // {{ getConnectedEcoleId() }}
        
    }
}

if (!function_exists('getConnectedEcoleName')) {
    function getConnectedEcoleName() {
        return session('ecole_nom'); 
    }
}

    // récupérer le Role du professeur connecté
 function RoleEtudiant(){
    $data = array();
    if(Session::has('Etudiant')){
        $data = Etudiant::where('id','=', Session::get('Etudiant'))->first()->role;
         return  $data ;
     }
 }

 //Etudiant non connecté      
 function fullNameEtudiant(){
    $data = array();
     if(Session::has('Etudiant')){
         $data1 = Etudiant::where('id','=', Session::get('Etudiant'))->first()->nom;
         $data2 = Etudiant::where('id','=', Session::get('Etudiant'))->first()->prenom;

         $fulNames = $data1 .' '. $data2;
         return $fulNames ;
     }
 }

 //Recuperation de l'id de l'etudiant
 function EtudiantId(){
    $data = array();
     if(Session::has('Etudiant')){
         $data = Etudiant::where('id','=', Session::get('Etudiant'))->first()->id;
         return $data ;
     }
 }

 function getEcoleDeLEtudiantConnecte()
{
    // Récupérez l'ID de l'étudiant connecté à partir de la session
    $etudiantId = EtudiantId(); 

    if ($etudiantId) {
        // Utilisez une requête pour récupérer l'école de l'étudiant connecté
        $ecole = DB::table('inscriptions')
            ->join('ecoles', 'inscriptions.ecole_id', '=', 'ecoles.id')
            ->where('inscriptions.etudiant_id', $etudiantId)
            ->select('ecoles.nom as ecole_nom')
            ->first();

        if ($ecole) {
            return $ecole->ecole_nom;
        }
    }

    return null; // Retournez null si aucune école n'est trouvée
}

if (!function_exists('getTotalProfesseurs')) {
    function getTotalProfesseurs()
    {
        // Obtenez le nom de l'école connectée
        $ecoleNom  = Ecoles();

        // Obtenez le nom de la dernière année scolaire
       // $derniereAnneeScolaireNom  = lastAneeScolaire();

       // Utilisez Eloquent pour obtenir le total des professeurs inscrits pour l'école et l'année scolaire spécifiées
       $totalProfesseurs = ProfesseurClasseMatiere::join('ecoles', 'professeur_classe_matieres.ecole_id', '=', 'ecoles.id')
       ->join('annee_scolaires', 'professeur_classe_matieres.annee_scolaire_id', '=', 'annee_scolaires.id')
       ->where('ecoles.nom', $ecoleNom)
      // ->where('annee_scolaires.annee1', $derniereAnneeScolaireNom)
       ->count();

        return $totalProfesseurs;
    }
}
//Total des etudiants

function getTotalEtudiants(){
    $user_id = Userid(); // l'id de l'utilisateur connecté

    $totalInscriptions = DB::table('users')
    ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
    ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('inscriptions', 'classes.id', '=', 'inscriptions.classe_id')
    ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
    ->join('tuteurs', 'inscriptions.tuteur_id', '=', 'tuteurs.id')
    ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
    ->select('inscriptions.id', 'inscriptions.date_insription', 'ecoles.nom as ecole_nom','classes.nom as classe_nom','tuteurs.noms as tuteur_nom','tuteurs.prenoms as tuteur_prenoms','tuteurs.telephone1 as tuteur_telephone1','tuteurs.telephone2 as tuteur_telephone2', 'etudiants.nom as etudiant_nom','etudiants.prenom as etudiant_prenom','etudiants.matricule as matricule','annee_scolaires.annee1', 'annee_scolaires.annee2')
    ->where('users.id', '=', $user_id)
    //->where('annee_scolaires.annee1',lastAneeScolaire()) 
    ->count();

    return $totalInscriptions;

}
 
//Total des classes
function getTotalClasses() {
    $ecoleNom  = Ecoles();
    // Comptez le nombre de classes pour l'école spécifiée
    $totalClasses = classe::whereHas('ecole', function ($query) use ($ecoleNom) {
        $query->where('nom', $ecoleNom);
    })->count();

    return $totalClasses;
}

//Total de Tuteurs
function getTotalTuteurs(){
   
    $user_id = Userid(); // l'id de l'utilisateur connecté

    $totalInscriptions = DB::table('users')
    ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
    ->join('classes', 'ecoles.id', '=', 'classes.ecole_id')
    ->join('inscriptions', 'classes.id', '=', 'inscriptions.classe_id')
    ->join('annee_scolaires', 'inscriptions.annee_scolaire_id', '=', 'annee_scolaires.id')
    ->join('tuteurs', 'inscriptions.tuteur_id', '=', 'tuteurs.id')
    ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
    ->select('inscriptions.id', 'inscriptions.date_insription', 'ecoles.nom as ecole_nom','classes.nom as classe_nom','tuteurs.noms as tuteur_nom','tuteurs.prenoms as tuteur_prenoms','tuteurs.telephone1 as tuteur_telephone1','tuteurs.telephone2 as tuteur_telephone2', 'etudiants.nom as etudiant_nom','etudiants.prenom as etudiant_prenom','etudiants.matricule as matricule','annee_scolaires.annee1', 'annee_scolaires.annee2')
    ->where('users.id', '=', $user_id)
   // ->where('annee_scolaires.annee1',lastAneeScolaire())
    ->count();

    return $totalInscriptions;
}

//Total des Ecoles inscrit
function getTotalEcoles(){

$ecolesInscris= Ecole::all()->count();

   return $ecolesInscris;

}
//Total des Responsables 
function getTotalResponsables(){

$ResponsableInscris= User::all()->count();
    
   return $ResponsableInscris;
    
 }
    //Total des Utilisateurs 
function getTotalUtilisateurs(){

    $usersInscris= userprincipal::all()->count();
        
       return $usersInscris;
        
}
//Total de Niveau scolaire
   function getTotalNiveauScolaire(){

     $NiveauScolaires = niveauScolaires::all()->count();
      return $NiveauScolaires;
                
        }
?>
