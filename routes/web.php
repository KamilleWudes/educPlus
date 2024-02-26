<?php

use App\Http\Livewire\Etudiants;
use App\Models\Matier;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

// use Symfony\Component\Console\Input\Input;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); ->middleware("auth.superAdmin") ->middleware("auth.admin")

// Route SuperAdmin

Route::get('/utilisateur', [App\Http\Controllers\superAdminController::class, 'index'])->name ('SuperAdmin')->middleware("auth.superAdmin");
Route::get('/addutilisateur', [App\Http\Controllers\superAdminController::class, 'create'])->name ('addSuperAdmin')->middleware("auth.superAdmin");
Route::post('/createutilisateur', [App\Http\Controllers\superAdminController::class, 'store'])->name ('createSuperAdmin')->middleware("auth.superAdmin");
Route::put('/update_utilisateur/{id}', [App\Http\Controllers\superAdminController::class, 'update'])->name ('update_superAdmin')->middleware("auth.superAdmin");
Route::get('/utilisateur={id}', [App\Http\Controllers\superAdminController::class, 'edit'])->name ('editsuperAdmin')->middleware("auth.superAdmin");
Route::get('/detail-utilisateur={id}', [App\Http\Controllers\superAdminController::class, 'detail'])->name ('detailsuperAdmin')->middleware("auth.superAdmin");

// Route Etudiant  

Route::get('/etudiant', [App\Http\Controllers\EtudiantController::class, 'index'])->name ('etudiant')->middleware("auth.admin");
Route::get('/addEtudiant', [App\Http\Controllers\EtudiantController::class, 'create'])->name ('addEtudiant')->middleware("auth.admin");
Route::post('/createEtudiant', [App\Http\Controllers\EtudiantController::class, 'store'])->name ('createEtudiant')->middleware("auth.admin");
Route::put('/update_etudiant/{id}', [App\Http\Controllers\EtudiantController::class, 'update'])->name ('update_etudiant')->middleware("auth.admin");
Route::get('/etudiant={id}', [App\Http\Controllers\EtudiantController::class, 'edit'])->name ('editEtudiant')->middleware("auth.admin");
Route::get('/detail-etudiant={id}', [App\Http\Controllers\EtudiantController::class, 'detail'])->name ('detailEtudiant')->middleware("auth.admin");
// Route::delete('/etudiant/{etudiant}', [App\Http\Controllers\EtudiantController::class, 'destroy'])->name ('delete_etudiant')->middleware("auth.admin");
Route::get('/etudiant-delete/{id}', [App\Http\Controllers\EtudiantController::class, 'destroy'])->name ('delete_etudiant')->middleware("auth.admin");
Route::get('/etudiant-delete-list', [App\Http\Controllers\EtudiantController::class, 'onlyTrashed'])->name ('etudiant-delete-list')->middleware("auth.admin");
Route::get('/etudiant-restore/{id}', [App\Http\Controllers\EtudiantController::class, 'restore'])->name ('etudiant-restore')->middleware("auth.admin");

Route::get('/Releve-de-notes', [App\Http\Controllers\EtudiantController::class, 'GetReleve'])->name ('Releve')->middleware("auth.admin");

//Route bulletin niveau admin
Route::get('/Releve-pdf={id}', [App\Http\Controllers\EtudiantController::class,'exportPdf'])->name('Releve-pdf')->middleware("auth.admin");



// Route Annee scolaire
Route::get('/anneeScolaire', [App\Http\Controllers\AnneeScolaireController::class, 'index'])->name ('anneeScolaire')->middleware("auth.admin");
Route::get('/addAnneeScolaire', [App\Http\Controllers\AnneeScolaireController::class, 'create'])->name ('addAnneeScolaire')->middleware("auth.admin");
Route::post('/createAnneeScolaire', [App\Http\Controllers\AnneeScolaireController::class, 'store'])->name ('createAnneeScolaire')->middleware("auth.admin");
Route::delete('/anneeScolaire/{anneeScolaire}', [App\Http\Controllers\AnneeScolaireController::class, 'destroy'])->name ('delete_anneeScolaire')->middleware("auth.admin");
Route::put('/anneeScolaire/{id}', [App\Http\Controllers\AnneeScolaireController::class, 'update'])->name ('update_anneeScolaire')->middleware("auth.admin");
Route::get('/anneeScolaire={id}', [App\Http\Controllers\AnneeScolaireController::class, 'edit'])->name ('edit_anneeScolaire')->middleware("auth.admin");

//Route utilisateur
Route::get('/responsable', [App\Http\Controllers\UtilisateursController::class, 'index'])->name ('utilisateur')->middleware("auth.superAdmin");
Route::get('/addresponsable', [App\Http\Controllers\UtilisateursController::class, 'create'])->name ('addutilisateur')->middleware("auth.superAdmin");
Route::post('/createResponsable', [App\Http\Controllers\UtilisateursController::class, 'store'])->name ('createutilisateur')->middleware("auth.superAdmin");
Route::get('/responsable={id}', [App\Http\Controllers\UtilisateursController::class, 'edit'])->name ('edit_utilisateur')->middleware("auth.superAdmin");
Route::put('/update_responsable/{id}', [App\Http\Controllers\UtilisateursController::class, 'update'])->name ('update_utilisateur')->middleware("auth.superAdmin");
Route::get('/detail-responsable={id}', [App\Http\Controllers\UtilisateursController::class, 'detail'])->name ('detail_utilisateur')->middleware("auth.superAdmin");


//Route professeurs
Route::get('/professeur', [App\Http\Controllers\professeurController::class, 'index'])->name ('professeur')->middleware("auth.admin");
Route::get('/addprofesseur', [App\Http\Controllers\professeurController::class, 'create'])->name ('addprofesseur')->middleware("auth.admin");
Route::post('/createprofesseur', [App\Http\Controllers\professeurController::class, 'store'])->name ('createprofesseur')->middleware("auth.admin");
Route::delete('/professeurs/{professeur}', [App\Http\Controllers\professeurController::class, 'destroy'])->name ('delete_professeur')->middleware("auth.admin");
Route::put('/update_professeur/{id}', [App\Http\Controllers\professeurController::class, 'update'])->name ('update_professeurs')->middleware("auth.admin");
Route::get('/professeur={id}', [App\Http\Controllers\professeurController::class, 'edit'])->name ('editprofesseur')->middleware("auth.admin");
Route::get('/detail={id}', [App\Http\Controllers\professeurController::class, 'detail'])->name ('detailprofesseur')->middleware("auth.admin");


// Route::get('/professeur-classe-matieres', [App\Http\Controllers\professeurController::class,'disposer'])->name('disposer')->middleware("auth.admin");



//Route inscriptions
Route::get('/inscription', [App\Http\Controllers\InscriptionController::class, 'index'])->name ('inscription')->middleware("auth.admin");
Route::get('/addinscription', [App\Http\Controllers\InscriptionController::class, 'create'])->name ('addinscription')->middleware("auth.admin");
Route::post('/createinscription', [App\Http\Controllers\InscriptionController::class, 'store'])->name ('createinscription')->middleware("auth.admin");
Route::get('/inscription={id}', [App\Http\Controllers\InscriptionController::class, 'edit'])->name ('edit_inscription')->middleware("auth.admin");
Route::put('/update_inscription/{id}', [App\Http\Controllers\InscriptionController::class, 'update'])->name ('update_inscription')->middleware("auth.admin");
Route::get('/inscription-detail={id}', [App\Http\Controllers\InscriptionController::class, 'detail'])->name ('detail_inscription')->middleware("auth.admin");


Route::get('/inscription-delete/{id}', [App\Http\Controllers\InscriptionController::class, 'destroy'])->name ('delete_inscription')->middleware("auth.admin");
Route::get('/inscription-delete-list', [App\Http\Controllers\InscriptionController::class, 'onlyTrashed'])->name ('inscription-delete-list')->middleware("auth.admin");
Route::get('/inscription-restore/{id}', [App\Http\Controllers\InscriptionController::class, 'restore'])->name ('inscription-restore')->middleware("auth.admin");

//Route bulletin


Route::get('/bulletin', [App\Http\Controllers\BulletinController::class, 'index'])->name('bulletin')->middleware("auth.professeur");
Route::get('/addbulletin', [App\Http\Controllers\BulletinController::class, 'create'])->name ('addbulletin')->middleware("auth.professeur");
Route::post('/createbulletin', [App\Http\Controllers\BulletinController::class, 'store'])->name ('createbulletin')->middleware("auth.professeur");

// Route::post('/createbulletin', [App\Http\Controllers\BulletinController::class, 'store'])->name ('createbulletin')->middleware("auth.professeur");

//Route ecole
Route::get('/ecole', [App\Http\Controllers\EcoleController::class, 'index'])->name ('ecole')->middleware("auth.superAdmin");

// Route::get('/ecole', [App\Http\Controllers\EcoleController::class, 'index'])->name ('ecole');
Route::get('/addecole', [App\Http\Controllers\EcoleController::class, 'create'])->name ('addecole')->middleware("auth.superAdmin");
Route::post('/createEcole', [App\Http\Controllers\EcoleController::class, 'store'])->name ('createecole')->middleware("auth.superAdmin");
Route::get('/ecole={id}', [App\Http\Controllers\EcoleController::class, 'edit'])->name ('edit_ecole')->middleware("auth.superAdmin");
Route::put('/update_ecole/{id}', [App\Http\Controllers\EcoleController::class, 'update'])->name ('update_ecole')->middleware("auth.superAdmin");
Route::delete('/ecoles/{ecole}', [App\Http\Controllers\EcoleController::class, 'destroy'])->name ('delete_ecole')->middleware("auth.superAdmin");
Route::get('/detail-ecole={id}', [App\Http\Controllers\EcoleController::class, 'detail'])->name ('detail_ecole')->middleware("auth.superAdmin");



//Route classe
Route::get('/classe', [App\Http\Controllers\ClasseController::class, 'index'])->name ('classe')->middleware("auth.admin");
Route::get('/addclasse', [App\Http\Controllers\ClasseController::class, 'create'])->name ('addclasse')->middleware("auth.admin");
Route::post('/createclasse', [App\Http\Controllers\ClasseController::class, 'store'])->name ('createclasse')->middleware("auth.admin");
Route::get('/classes={id}', [App\Http\Controllers\ClasseController::class, 'edit'])->name ('edit_ecole')->middleware("auth.admin");
Route::put('/update_classe/{id}', [App\Http\Controllers\ClasseController::class, 'update'])->name ('update_classe')->middleware("auth.admin");
Route::delete('/classes/{ecole}', [App\Http\Controllers\ClasseController::class, 'destroy'])->name ('delete_classe')->middleware("auth.admin");

//Route matiere
Route::get('/matiere', [App\Http\Controllers\MatiereController::class, 'index'])->name('matier')->middleware("auth.admin");
Route::get('/addmatiere', [App\Http\Controllers\MatiereController::class, 'create'])->name ('addmatier')->middleware("auth.admin");
Route::post('/creatematiere', [App\Http\Controllers\MatiereController::class, 'store'])->name ('creatematier')->middleware("auth.admin");
Route::put('/update_matiere/{id}', [App\Http\Controllers\MatiereController::class, 'update'])->name ('update_matiere')->middleware("auth.admin");
Route::get('/matiere={id}', [App\Http\Controllers\MatiereController::class, 'edit'])->name ('edit_matiere')->middleware("auth.admin");
Route::delete('/ecoles/{ecole}', [App\Http\Controllers\MatiereController::class, 'destroy'])->name ('delete_matiere')->middleware("auth.admin");



//Route trimestre
Route::get('/Typetrimestre', [App\Http\Controllers\TypeTrimestreController::class, 'index'])->name('trimestre')->middleware("auth.admin");
Route::get('/addTypetrimestre', [App\Http\Controllers\TypeTrimestreController::class, 'create'])->name ('addtrimestre')->middleware("auth.admin");
Route::post('/createTypetrimestre', [App\Http\Controllers\TypeTrimestreController::class, 'store'])->name ('createtrimestre')->middleware("auth.admin");
Route::get('/TypeTrimestres={id}', [App\Http\Controllers\TypeTrimestreController::class, 'edit'])->name ('edit_trimestres')->middleware("auth.admin");
Route::put('/update_Typetrimestres/{id}', [App\Http\Controllers\TypeTrimestreController::class, 'update'])->name ('update_trimestres')->middleware("auth.admin");

//Route composition
Route::get('/TypeComposition', [App\Http\Controllers\TypeCompositionController::class, 'index'])->name('TypeComposition')->middleware("auth.admin");
Route::get('/addTypeComposition', [App\Http\Controllers\TypeCompositionController::class, 'create'])->name ('addTypeComposition')->middleware("auth.admin");
Route::post('/createTypeComposition', [App\Http\Controllers\TypeCompositionController::class, 'store'])->name ('createTypeComposition')->middleware("auth.admin");
Route::get('/typeCompositions={id}', [App\Http\Controllers\TypeCompositionController::class, 'edit'])->name ('edit_TypeComposition')->middleware("auth.admin");
Route::put('/update_TypeComposition/{id}', [App\Http\Controllers\TypeCompositionController::class, 'update'])->name ('update_TypeComposition')->middleware("auth.admin");


//Route Niveaux scolaires
Route::get('/NiveauScolaires', [App\Http\Controllers\NiveauScolairesController::class, 'index'])->name('NiveauScolaires')->middleware("auth.superAdmin");
Route::get('/addNiveauScolaires', [App\Http\Controllers\NiveauScolairesController::class, 'create'])->name ('addNiveauScolaires')->middleware("auth.superAdmin");
Route::post('/createNiveauScolaire', [App\Http\Controllers\NiveauScolairesController::class, 'store'])->name ('createNiveauScolaire')->middleware("auth.superAdmin");
Route::get('/NiveauScolaires={id}', [App\Http\Controllers\NiveauScolairesController::class, 'edit'])->name ('edit_NiveauScolaires')->middleware("auth.superAdmin");
Route::put('/update_NiveauScolaires/{id}', [App\Http\Controllers\NiveauScolairesController::class, 'update'])->name ('update_NiveauScolaires')->middleware("auth.superAdmin");
Route::delete('/NiveauScolaires/{NiveauScolaires}', [App\Http\Controllers\NiveauScolairesController::class, 'destroy'])->name ('delete_NiveauScolaires')->middleware("auth.superAdmin");

//Route tuteur
Route::get('/tuteur', [App\Http\Controllers\TuteurController::class, 'index'])->name('tuteur')->middleware("auth.admin");
Route::put('/update_tuteur/{id}', [App\Http\Controllers\TuteurController::class, 'update'])->name ('update_tuteur')->middleware("auth.admin");
Route::get('/tuteur={id}', [App\Http\Controllers\TuteurController::class, 'edit'])->name ('edittuteur')->middleware("auth.admin");
Route::get('/detail-tuteur={id}', [App\Http\Controllers\TuteurController::class, 'detail'])->name ('detailtuteur')->middleware("auth.admin");
//
//Route matiere et coefficient
Route::get('/matiere_coefficient', [App\Http\Controllers\ClasseAnneescolaireMatiere::class,'index'])->name('matiere_coefficient')->middleware("auth.admin");
Route::get('/addmatiere_coefficient', [App\Http\Controllers\ClasseAnneescolaireMatiere::class,'create'])->name ('addMatiere_coefficient')->middleware("auth.admin");
Route::post('/creatematiere_coefficient', [App\Http\Controllers\ClasseAnneescolaireMatiere::class,'store'])->name ('createMatiere_coefficient')->middleware("auth.admin");
Route::get('/matiere_coefficient={id}', [App\Http\Controllers\ClasseAnneescolaireMatiere::class,'edit'])->name('edit-matiere-coefficient')->middleware("auth.admin");
Route::put('/matiere_coefficient/{id}', [App\Http\Controllers\ClasseAnneescolaireMatiere::class,'update'])->name('update-matiere-coefficient')->middleware("auth.admin");


//Route professeur-classe-matieres
Route::get('/professeur-classe-matieres', [App\Http\Controllers\ProfesseurClasseMatiere::class,'index'])->name('disposer')->middleware("auth.admin");
Route::get('/adddisposer', [App\Http\Controllers\ProfesseurClasseMatiere::class,'create'])->name('adddisposer')->middleware("auth.admin");
Route::post('/createdisposer', [App\Http\Controllers\ProfesseurClasseMatiere::class,'store'])->name ('createdisposer')->middleware("auth.admin");
Route::get('/edition={id}', [App\Http\Controllers\ProfesseurClasseMatiere::class,'edit'])->name ('edition')->middleware("auth.admin");
Route::put('/edition-professeur/{id}', [App\Http\Controllers\ProfesseurClasseMatiere::class,'update'])->name ('update')->middleware("auth.admin");
Route::get('/detail-professeur-classe-matier={id}', [App\Http\Controllers\ProfesseurClasseMatiere::class, 'detail'])->name('getdetail')->middleware("auth.admin");


Route::get('/notes-etudiants', [App\Http\Controllers\ProfesseurClasseMatiere::class, 'notesEtudiants'])->name ('notes-etudiants')->middleware("auth.admin");


//Route anneescolaire-classe-matieres
Route::get('/anneescolaire-classe-matieres', [App\Http\Controllers\ClasseAnneescolaireMatiere::class, 'index'])->name('anneescolaire-classe-matieres')->middleware("auth.admin");


Auth::routes();

// Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware("auth.admin");

Route::post('/', [App\Http\Controllers\Auth\profController::class,'loginProf'])->name('verification');

// Route::get('/dashbord', [App\Http\Controllers\Auth\profController::class,'dashbord'])->name('dashboard')->middleware(["auth.admin", "auth.superAdmin"]);

Route::get('/dashbord', [App\Http\Controllers\Auth\profController::class, 'dashbord'])
    ->name('dashboard')
    ->middleware(["auth.admin"]);
    
Route::get('/home', [App\Http\Controllers\UserPrincipalController::class, 'dashbord'])
->name('getHome')
->middleware(["auth.superAdmin"]);

Route::get('/', [App\Http\Controllers\HomeController::class,'index'])->name('home');

Route::post('/superadmin', [App\Http\Controllers\UserPrincipalController::class,'loginSuperAdmin'])->name('superadmin');

Route::get('/acceuil', [App\Http\Controllers\UserPrincipalController::class,'index'])->name('users'); 


//Route saisi de note
Route::get('/liste-note', [App\Http\Controllers\AnTtriProfMatTcompIn::class,'index'])->name('saisi-note')->middleware("auth.professeur");

Route::get('/add-saisi-note', [App\Http\Controllers\AnTtriProfMatTcompIn::class,'create'])->name('add-saisi-note')->middleware("auth.professeur");

Route::post('/create-saisi-note', [App\Http\Controllers\AnTtriProfMatTcompIn::class,'store'])->name('create-saisi-note')->middleware("auth.professeur");

Route::get('/Releve-de-note', [App\Http\Controllers\AnTtriProfMatTcompIn::class, 'GetprofReleve'])->name ('Releves')->middleware("auth.professeur");

Route::get('/bulletin-pdf={id}', [App\Http\Controllers\AnTtriProfMatTcompIn::class,'exportPdf'])->name('bulletin-pdf')->middleware("auth.professeur");

Route::put('/update_note/{id}', [App\Http\Controllers\AnTtriProfMatTcompIn::class, 'update'])->name ('update_bulletin')->middleware("auth.professeur");

Route::get('/edit_note={id}', [App\Http\Controllers\AnTtriProfMatTcompIn::class, 'edit'])->name ('edit_note')->middleware("auth.professeur");

//Route Recuperation dans le select

 Route::get('/GetClasseMatiere', [App\Http\Controllers\AnTtriProfMatTcompIn::class,'GetClasseMatiere'])->name('GetClasseMatiere');

//Route::get('/matieres', [App\Http\Controllers\BulletinProfesseurTypecompositonMatier::class,'GetClasseMatiere'])->name('GetClasseMatiere');

Route::get('/classes_mat', [App\Http\Controllers\ClasseAnneescolaireMatiere::class, 'GetClasses'])->name('GetClasses');

Route::get('/GetAnnee', [App\Http\Controllers\InscriptionController::class, 'GetAnnees'])->name('GetAnnee');

Route::get('/GetTuteur', [App\Http\Controllers\TuteurController::class, 'GetTuteurs'])->name('GetTuteur');

Route::get('/Getetude', [App\Http\Controllers\EtudiantController::class, 'Getetudes'])->name('Getetude');

Route::get('/GetProf', [App\Http\Controllers\professeurController::class, 'GetProfesseur'])->name('GetProf'); 

Route::get('/GetProfesseurClasse', [App\Http\Controllers\ProfesseurClasseMatiere::class, 'GetProfesseurClasseEcole'])->name('GetProfesseurClasse'); 

Route::get('/GetNotesEtude', [App\Http\Controllers\AnTtriProfMatTcompIn::class, 'GetNotesEtudes'])->name('GetNotesEtude'); 

Route::get('/GetClassprof', [App\Http\Controllers\ProfesseurClasseMatiere::class, 'GetClassprofs'])->name ('GetClassprof');

Route::get('/GetReleve', [App\Http\Controllers\EtudiantController::class, 'GetReleves'])->name ('GetReleve');

Route::get('/GetProfReleve', [App\Http\Controllers\AnTtriProfMatTcompIn::class, 'GetProfReleves'])->name ('GetProfReleve');

Route::get('/GetCoefAnnee', [App\Http\Controllers\ClasseAnneescolaireMatiere::class, 'GetCoefAnnees'])->name('GetCoefAnnee');


//Route Zone Etudiant
Route::get('/space-etudiant', [App\Http\Controllers\UserPrincipalController::class,'zoneEtude'])->name('zoneEtude');

Route::post('/NoteLogin', [App\Http\Controllers\UserPrincipalController::class,'NoteLogins'])->name('NoteLogin');

Route::get('/Note-etudiant', [App\Http\Controllers\EtudiantReleveController::class,'NoteEtudiants'])->name('Note-etudiant');

Route::get('/bulettin-etudiant', [App\Http\Controllers\EtudiantReleveController::class,'bulettinEtudiants'])->name('bulettin-etudiant');

Route::get('/GetNotesEtudiant', [App\Http\Controllers\EtudiantReleveController::class, 'GetNotesEtudiants'])->name('GetNotesEtudiant');

Route::get('/GetBulettin', [App\Http\Controllers\EtudiantReleveController::class, 'GetBulettins'])->name ('GetBulettin');

//Route bulletin niveau Etudiant
Route::get('/bulettin-pdf={id}', [App\Http\Controllers\EtudiantReleveController::class,'bulettinPdf'])->name('bulettin-pdf');


//Mise à jour des mot de passe

//Reset password SuperAdmin
Route::get('/reset-password-utilisateur={id}', [App\Http\Controllers\superAdminController::class, 'reset'])->name('reset')->middleware("auth.superAdmin");
Route::put('/update-password-utilisateur/{id}', [App\Http\Controllers\superAdminController::class, 'modifierMotDePasse'])->name('update_password')->middleware("auth.superAdmin");

//Reset password Admin
Route::get('/reset-password={id}', [App\Http\Controllers\EtudiantController::class, 'reset'])->name('reset')->middleware("auth.admin");
Route::put('/update_password/{id}', [App\Http\Controllers\EtudiantController::class, 'modifierMotDePasse'])->name ('update_password')->middleware("auth.admin");

//Reset password professeur
Route::get('/reset-password-professeur={id}', [App\Http\Controllers\AnTtriProfMatTcompIn::class, 'reset'])->name('reset')->middleware("auth.professeur");
Route::put('/update-password-professeur/{id}', [App\Http\Controllers\AnTtriProfMatTcompIn::class, 'modifierMotDePasse'])->name('update_password')->middleware("auth.professeur");

//Profil Admin
Route::get('/profil-admin={id}', [App\Http\Controllers\EtudiantController::class, 'profil'])->name('profil')->middleware("auth.admin");

//Profil Professeur
Route::get('/profil-professeur={id}', [App\Http\Controllers\AnTtriProfMatTcompIn::class, 'profil'])->name('profil')->middleware("auth.professeur");

//Profil SuperAdmin
Route::get('/profil-utilisateur={id}', [App\Http\Controllers\superAdminController::class, 'profil'])->name('profil')->middleware("auth.superAdmin");

//Profil Etudiant
Route::get('/profil-etudiant={id}', [App\Http\Controllers\EtudiantReleveController::class, 'profil'])->name('profil');
