<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CategorieController extends Controller
{
    //

    public function getCat()
    {
    	# code...
    	$cat=Categorie::all();
    	return view('pages.categorie')->with("categories",$cat);
    }

    public function enregistrerCat()
    {
    	# code...

    	if (request('operation')=='ajouter') {
    		# code...

    		try {
    			$ca=new Categorie();
    			$ca->LIBELLE=request('libelle');
    			$ca->save();
    			$bon=true;

    			$cat=Categorie::all();
    			return view('pages.categorie')->with("categories",$cat)->with("bon",$bon);

    		} catch (QueryException $e) {

    			$bon=false;
    			$cat=Categorie::all();
    			return view('pages.categorie')->with("categories",$cat)->with("bon",$bon);	
    		}
    	}


        if (request('operation')=='update') {
            # code...

            try {
                $id=request('id');
                $libelle=request('libelle');

                $res=DB::table('categories')->where('ID',$id)->update(['libelle'=>$libelle]);

                $cat=Categorie::all();
                $bon=true;
                return view('pages.categorie')->with("categories",$cat)->with("bon",$bon);

            } catch (QueryException $e) {

                $bon=false;
                $cat=Categorie::all();
                return view('pages.categorie')->with("categories",$cat)->with("bon",$bon);  
            }
        }

        if (request('operation2')=='delete') {
            # code...

            try {
                
            } catch (QueryException $e) {
                
            }
        }
    }
}
