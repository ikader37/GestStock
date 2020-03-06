<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Categorie;
use App\Fournisseur;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    //

    public function getAjouterArticle()
    {
    	# code...
        //print("FFFF");
    	$idsession=session('ID');
        $role=session('ROLE');
        $username=session('USERNAME');

        if ($idsession!=null && ($role=='ADMINISTRATEUR' || $role=='EMPLOYE')) {


            $articles=Article::all();
            $cat=Categorie::all();
            $fournisseurs=Fournisseur::all();
            //print($cat);
            //$four=Fournisseur::all();
            return view('pages.articles')->with('articles',$articles)->with("categorie",$cat)->with("fournisseurs",$fournisseurs);
            # code...
        }else{
            return redirect()->route('log');
    		//->with("fournisseur",$four);
        }
    	   	

    	
    }


    





    public function enregistrerArticle()
    {
        # code...
       /// print("FFFFF");

        $idsession=session('ID');
        $role=session('ROLE');
        if ($idsession!=null && ($role=='ADMINISTRATEUR' || $role=='EMPLOYE')) {


                if (request('operation')=='ajouter') {
            # code...
            $bon=false;
            try {
                
                $ar=new Article();
                $ar->DESIGNATION=request('designation');
                $ar->PRIX_UNITAIRE=request('prix_unit');
                $ar->QUANTITE=request('quantite');
                $ar->CATEGORIE_ID=request('categorie');
                $ar->FOURNISSEUR_ID=request('fournisseur');
                $ar->CREATED_BY=$idsession;



                $data=['quantite'=>$ar->QUANTITE,'prix_unit'=>$ar->PRIX_UNITAIRE];
            //Verifier si la valeur de la quantite sa sup[erieure a 0]

                $message=['required'=>'Le :attribute est un champ obligatoire.','min'=>'Le champ :attribute doit être supérieur à 1.'];
                //Validator::make($data,[                    'quantite'=>'required | numeric | min:1','prix_unit'=>'required | numeric | min:1',$message])->validate();

                Validator::make($data,['quantite'=>'required | numeric | min:1','prix_unit'=>'required | numeric | min:1'],['quantite.min'=>'La valeur du champ quantité doit être supérieure à 0.','prix_unit.min'=>'La valeur du champ prix unitaire doit être supérieure à 0.'])->validate();

                
                //print("FFFFF");
                $ar->save();
                //print("FFFFF");
                $bon=true;
                $articles=Article::all();
                //print("FFFFF");
                $cat=Categorie::all();
                 $fournisseurs=Fournisseur::all();
                return view('pages.articles')->with("bon",$bon)->with("articles",$articles)->with("categorie",$cat)->with("fournisseurs",$fournisseurs);
                //print("FFFFF");

            } catch (QueryException $e) {
                $bon=false;
                $articles=Article::all();
                $cat=Categorie::all();
                 $fournisseurs=Fournisseur::all();
                return view('pages.articles')->with("bon",$bon)->with("articles",$articles)->with("categorie",$cat)->with("fournisseurs",$fournisseurs);
            }
        }



        //La mise a jour




        if (request('operation2')=='delete') {
            # code...

            try {

                $id=request('idasupprimer');
                $res=DB::table('articles')->where('ID',$id)->delete();
                $bon=true;
                $articles=Article::all();
                $cat=Categorie::all();
                 $fournisseurs=Fournisseur::all();
                return view('pages.articles')->with("bon",$bon)->with("articles",$articles)->with("categorie",$cat)->with("fournisseurs",$fournisseurs);
            } catch (QueryException $e) {
                $bon=false;
                $articles=Article::all();
                $cat=Categorie::all();
                 $fournisseurs=Fournisseur::all();
                return view('pages.articles')->with("bon",$bon)->with("articles",$articles)->with("categorie",$cat)->with("fournisseurs",$fournisseurs);
            }
        }

        if (request('operation')=='update') {
            # code...
                $desi=request('designation');
                $prix=request('prix_unit');
                $quantite=request('quantite');
                $cat=request('categorie');
                $four=request('fournisseur');
                $idUp=request('idUp');
                try {

                    $data=['quantite'=>$quantite,'prix_unit'=>$prix];
            //Verifier si la valeur de la quantite sa sup[erieure a 0]

                Validator::make($data,['quantite'=>'required | numeric | min:1','prix_unit'=>'required | numeric | min:1'],['quantite.min'=>'La valeur du champ quantité doit être supérieure à 0.','prix_unit.min'=>'La valeur du champ prix unitaire doit être supérieure à 0.'])->validate();

                    $r=DB::table('articles')->where('ID',$idUp)->update(['DESIGNATION'=>$desi,'PRIX_UNITAIRE'=>$prix,'QUANTITE'=>$quantite,'CATEGORIE_ID'=>$cat,'FOURNISSEUR_ID'=>$four]);
                    
                    $bon=true;
                $articles=Article::all();
                //print("FFFFF");
                $cat=Categorie::all();
                 $fournisseurs=Fournisseur::all();
                return view('pages.articles')->with("bon",$bon)->with("articles",$articles)->with("categorie",$cat)->with("fournisseurs",$fournisseurs);


                } catch (QueryException $e) {
                    
                    $bon=false;
                $articles=Article::all();
                //print("FFFFF");
                $cat=Categorie::all();
                 $fournisseurs=Fournisseur::all();
                return view('pages.articles')->with("bon",$bon)->with("articles",$articles)->with("categorie",$cat)->with("fournisseurs",$fournisseurs);
                }
        }


            # code...
        }else{
            return redirect()->route('login');
        }

        
    }

    public function etatStock()
    {
        # code...

        //print("FFFF");
        try {
            $art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();

            return view('pages.etatStock')->with('articles',$art);
        } catch (QueryException $e) {
            $art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();
             return view('pages.etatStock')->with('articles',$art);
        }
    }


    public function renouvellerStock(Request $req)
    {
        # code...

        //print("FFFF");
        if (request('operation')=='renouveller') {
            # code...
            //print("FFFF");
            try {
                //print(" | FFFF");
                $id=request('id');
                $newQuantity=request('quantite');
               // print(" | FFFF");

                
                $oldQuantity=Article::where('ID',$id)->select('QUANTITE')->first();
                //print("| FFFF");

                //print($oldQuantity);
                $finalQuantity=$newQuantity+$oldQuantity->QUANTITE;
                
            
           // print("| FFFF %");
            $data=['quantite'=>$newQuantity];
            //Verifier si la valeur de la quantite sa sup[erieure a 0]
            Validator::make($data,[

                    'quantite'=>'required | numeric | min:1'],['quantite.min'=>'La valeur du champ quantité doit être supérieure à 0.'])->validate();
                // if ($v->fails()) {
                //    print("FAILS");
                //    $art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();
                // //print(" | FFFF");
                //    $erreur=false;

                // return view('pages.etatStock')->with('articles',$art)->with("bon",$erreur);
                // }else{

                    
                // }

                $finish=Article::where('ID',$id)->update(['QUANTITE'=>$finalQuantity]);

                    $art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();
                //print(" | FFFF");
                    $bon=true;

                return view('pages.etatStock')->with('articles',$art)->with('bon',$bon);
                

                
            } catch (QueryException $e) {
                $bon=false;

                $art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();

                 return view('pages.etatStock')->with('articles',$art)->with('bon',$bon);;
            }
        }
    }


}
