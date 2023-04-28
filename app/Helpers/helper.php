<?php

use App\Models\anneeScolaire;
use App\Models\Professeur;
use App\Models\User;
use App\Models\userprincipal;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


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
        $data = array();
        if(Session::has('Professeur')){
            $data = Professeur::where('id','=', Session::get('Professeur'))->first()->ecole_id;

            $ecoles = DB::table('ecoles')->where('id','=', $data)->first()->nom;

            return 'Ecole : ' .$ecoles;

        }
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
    //Role superAdmin
     function fullRoleSuperAdmin(){
        $data = array();
        if(Session::has('userprincipal')){
            $data = userprincipal::where('id','=', Session::get('userprincipal'))->first()->role;
             return  $data ;
         }
     }

     function UserfullRoleProf(){
        $data = array();
        if(Session::has('Professeur')){
            $data = Professeur::where('id','=', Session::get('Professeur'))->first()->role;
             return  $data ;
         }
     }


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

     function UserEcoles(){
       // $eco = array();
        if(Session::has('user')){
         $data = User::where('id','=', Session::get('user'))->first()->ecole_id;

         $ecoles = DB::table('ecoles')->where('id','=', $data)->first()->nom;

        return 'Ecole : ' .$ecoles;
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
 

?>
