<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Fournisseur;

class FournisseurController extends Controller
{
    //

    public function getFour()
    {
    	# code...

    	$fou=Fournisseur::all();
    	return view('pages.fournisseur')->with("fournisseurs",$fou);
    }

    public function enregistrerFournisseur()
    {
    	# code...
    	if (request('operation')=='ajouter') {
    		# code...

    		try {
    			$fo=new Fournisseur();
    			$fo->NOM=request('nom');
    			$fo->PRENOM=request('prenom');
    			$fo->ADRESSE=request('adresse');
    			$fo->TELEPHONE=request('tel');
    			$fo->save();

    			$fou=Fournisseur::all();
    			$bon=true;
    			return view('pages.fournisseur')->with("fournisseurs",$fou)->with("bon",$bon);
    		} catch (QueryException $e) {
    			$fou=Fournisseur::all();
    			$bon=false;
    			return view('pages.fournisseur')->with("fournisseurs",$fou)->with("bon",$bon);;
    		}
    	}



        if (request('operation')=='update') {
            # code...

            try {
                $fo=new Fournisseur();
                $nom=request('nom');
                $prenom=request('prenom');
                $adresse=request('adresse');
                $tel=request('tel');
                $id=request('idUp');
                

                $fo=DB::table('fournisseurs')->where('ID',$id)->update(['NOM'=>$nom,'PRENOM'=>$prenom,'ADRESSE'=>$adresse,'TELEPHONE'=>$tel]);

                $fou=Fournisseur::all();
                $bon=true;
                //print($id);
                return view('pages.fournisseur')->with("fournisseurs",$fou)->with("bon",$bon);
            } catch (QueryException $e) {
                $fou=Fournisseur::all();
                $bon=false;
                //print($e);

                return view('pages.fournisseur')->with("fournisseurs",$fou)->with("bon",$bon);;
            }
        }

        if (request('operation2')=='delete') {
            # code...

            try {

                $id=request('idasupprimer');

                $res=DB::table('fournisseurs')->where('id',$id)->delete();
                print("DELE");
                $fou=Fournisseur::all();
                $bon=true;
                //print($id);
                return view('pages.fournisseur')->with("fournisseurs",$fou)->with("bon",$bon);
            } catch (QueryException $e) {
                $fou=Fournisseur::all();
                $bon=false;
                return view('pages.fournisseur')->with("fournisseurs",$fou)->with("bon",$bon);;
            }
        }


    }
}
