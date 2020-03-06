<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;
use App\Role;
use App\Employe;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UtilisateurController extends Controller
{
    //

    public function getLoginPage()
     {
     	# code...

     	return view('pages.login');
     }
     public function getSignUpPage()
     {
     	# code...

          $idsession=session('ID');
        $role=session('ROLE');
        if ($idsession!=null && ($role=='ADMINISTRATEUR')) {

          $role=Role::all();
          $use=Utilisateur::all();

          return view('pages.signUp')->with("roles",$role)->with("users",$use);
        }else{
          
          return redirect()->route('log');
        }

     	
     } 

     public function enregistrerUserPost()
     {
     // 	# code...

          
          if (request('operation')=='ajouter') {
               # code...
          
          	$bon=false;
          	//print("DFFDD");
          	try {
          		$nom=request('nom');
          		$prenom=request('prenom');
          		$tel=request('tel');
          		$username=request('username');
          		$pass=request('password');
          		$adresse=request('adresse');
          		$role=request('role');
          		$user=new Utilisateur();
          		

          		$user->NOM=$nom;
          		$user->PRENOM=$prenom;
          		$user->ADRESSE=$adresse;
          		$user->TELEPHONE=$tel;

          		$user->ROLE_ID=$role;
          		$user->MOTDEPASSE=$pass;
          		$user->USERNAME=$username;
          		$user->save();

          		$bon=true;
          		$role=Role::all();
          		$use=Utilisateur::all();
          	    return view('pages.signUp')->with("roles",$role)->with("bon",$bon)->with('users',$use);
          	} catch (QueryException $e) {
          		$role=Role::all();
          		//print("dfdffd");
                    print($e);
          		$bon=false;
                    $use=Utilisateur::all();
          		return view('pages.signUp')->with("roles",$role)->with("bon",$bon)->with("users",$use);
          	}
          }


          if (request('operation2')=='delete') {
               # code...

               $role=session('ROLE');
               if ($role=='ADMINISTRATEUR') {
                    # code...
                    $bon=0;

                    $id=request('idasupprimer');

                   // print("GGGG");
                    try {
                         
                         $d=DB::table('utilisateurs')->where('ID',$id)->delete();
                         $bon=true;
                         $role=Role::all();
                         $use=Utilisateur::all();
                        return view('pages.signUp')->with("roles",$role)->with("bon",$bon)->with('users',$use);

                    } catch (QueryException $e) {

                        
                         $role=Role::all();
                         $use=Utilisateur::all();
                         //print("CATCH :".$bon);

                         //print($e);

                        return view('pages.signUp')->with("roles",$role)->with("bon",$bon)->with('users',$use);
                    }
                    

               }else{
                    return redirect()->route('log');
               }
          }

          if (request('operation')=='update') {
               # code...


               $bon=false;
               //print("DFFDD");
               try {
                    $nom=request('nom');
                    $prenom=request('prenom');
                    $tel=request('tel');
                    $username=request('username');
                    $pass=request('password');
                    $adresse=request('adresse');
                    $role=request('role');
                    $id=request('idUp');
                    //print($id."| ".$nom.' |'.$prenom.' |'.$tel.' |'.$username);

                    $user=new Utilisateur();
                    
                    $r=DB::table('utilisateurs')->where('ID',$id)->update(['NOM'=>$nom,'PRENOM'=>$prenom,'ADRESSE'=>$adresse,'TELEPHONE'=>$tel,'USERNAME'=>$username,'ROLE_ID'=>$role,'MOTDEPASSE'=>$pass]);
                    //$r=DB::table('utilisateurs')->where('ID',$id)->update(['PRENOM'=>$prenom],['ADRESSE'=>$adresse],['TELEPHONE'=>$tel],['USERNAME'=>$username]);

                    $bon=true;
                    $role=Role::all();
                    $use=Utilisateur::all();
                   return view('pages.signUp')->with("roles",$role)->with("bon",$bon)->with('users',$use);
               } catch (QueryException $e) {
                    $role=Role::all();
                    //print("dfdffd");
                    //print($e);
                    $bon=false;
                    $use=Utilisateur::all();
                    return view('pages.signUp')->with("roles",$role)->with("bon",$bon)->with("users",$use);
               }
          }

     }


     public function dd()
     {
          # code...
          return "DSDSDDSDS";
     }


     public function signIn()
     {
          # code...

          try {
               
               $username=request('username');
               $password=request('password');

               $user=DB::table('utilisateurs')->where('USERNAME',$username)->join('roles','roles.ID','=','utilisateurs.ROLE_ID')->select('utilisateurs.ID as ID','utilisateurs.USERNAME as USERNAME','roles.LIBELLE as LIBELLE','utilisateurs.MOTDEPASSE as MOTDEPASSE')->get()->first();

               
               if ($user->MOTDEPASSE==$password) {
                    # code...
                    //redirect()->route('home');
                    //print("pppp");

                    session(['USERNAME'=>$user->USERNAME]);
                    session(['ID'=>$user->ID]);
                    print(session('ID'));
                    session(['ROLE'=>$user->LIBELLE]);
                    print($user->LIBELLE);
                    
                    return view('pages.home');
               }else{
                    $bon=false;
               return view('pages.login')->with("bon",$bon);
               }

          } catch (QueryException $e) {
               $bon=false;
               return view('pages.login')->with("bon",$bon);
          }
     }
}
