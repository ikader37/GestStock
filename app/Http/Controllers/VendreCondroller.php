<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Vendre;
use App\Article;

class VendreCondroller extends Controller
{
    //

    public function getSortieStock()
    {
    	# code...

        $idsession=session('ID');
        $role=session('ROLE');
        if ($idsession!=null && ($role=='ADMINISTRATEUR' || $role=='EMPLOYE')) {


            $art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();

        $vendres=DB::table('vendres')->join('utilisateurs','utilisateurs.ID','=','vendres.UTILISATEUR_ID')->join('articles','articles.ID','=','vendres.ARTICLE_ID')->select('vendres.QUANTITE as QUANTITE','vendres.DATE_SORTIE as DATE_SORTIE','vendres.ID AS ID','articles.DESIGNATION as DESIGNATION')->get();

            return view('pages.sortiestock')->with("articles",$art)->with("vendres",$vendres);




        }else{

            return redirect()->route('log');
        }
        
    	//return view('pages.sortiestock');
    }


    public function enregistrerSortieStock()
    {
        # code...
        //print("ffff");
        //Recuperons les variables sessions
        $idsession=session("ID");
        $role=session("ROLE");
        $username=session("USERNAME");

        
        //Verifions que ces donnees sontr valides
        if (request('operation')=='ajouter') {
        	# code...
        	if ($idsession!=null && ($role=='ADMINISTRATEUR' || $role=='EMPLOYE')) {
        	# code...
        	$idarticle=request('id');
        	$newQuant=request('quantite');

        	$data=['quantite'=>$newQuant];
            //Verifier si la valeur de la quantite sa sup[erieure a 0]
            Validator::make($data,[

                    'quantite'=>'required | numeric | min:1',
                   
                ],['quantite.min'=>'La valeur du champ quantité doit être supérieure à 0.'])->validate();

            $oldQuant=Article::where('ID',$idarticle)->select('QUANTITE')->first();

            //Verifions que la quantite entree n'est pqs superieure  a celle existante
            if ($newQuant<=$oldQuant->QUANTITE) {
            	# code...
            	try {
            		$vendre=new Vendre();
	            	$vendre->QUANTITE=$newQuant;
	            	$vendre->ARTICLE_ID=$idarticle;
	            	$vendre->UTILISATEUR_ID=$idsession;
	            	$vendre->save();
	            	$res=Article::where('ID',$idarticle)->update(['QUANTITE'=>$oldQuant->QUANTITE-$newQuant]);

	            	$art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();

	            	$bon=true;

	            	$vendres=DB::table('vendres')->join('utilisateurs','utilisateurs.ID','=','vendres.UTILISATEUR_ID')->join('articles','articles.ID','=','vendres.ARTICLE_ID')->select('vendres.QUANTITE as QUANTITE','vendres.DATE_SORTIE as DATE_SORTIE','vendres.ID AS ID','articles.DESIGNATION as DESIGNATION')->get();

	            	//print("eeeeee ".$bon);
            		return view('pages.sortiestock')->with("articles",$art)->with("bon",$bon)->with("vendres",$vendres);;

            	} catch (QueryException $e) {
            		

            		$art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();
            		$bon=false;

            		$vendres=DB::table('vendres')->join('utilisateurs','utilisateurs.ID','=','vendres.UTILISATEUR_ID')->join('articles','articles.ID','=','vendres.ARTICLE_ID')->select('vendres.QUANTITE as QUANTITE','vendres.DATE_SORTIE as DATE_SORTIE','vendres.ID AS ID','articles.DESIGNATION as DESIGNATION')->get();

            		//print("eeeeee ".$bon);
            		return view('pages.sortiestock')->with("articles",$art)->with("bon",$bon)->with("vendres",$vendres);;
            	}
            	

            }else{

            	$art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();

            	$bol=0;
            	//print("SDDSDSDS");
            	print("SDFSDFSDF  ".$bol);
            	$vendres=DB::table('vendres')->join('utilisateurs','utilisateurs.ID','=','vendres.UTILISATEUR_ID')->join('articles','articles.ID','=','vendres.ARTICLE_ID')->select('vendres.QUANTITE as QUANTITE','vendres.DATE_SORTIE as DATE_SORTIE','vendres.ID AS ID','articles.DESIGNATION as DESIGNATION')->get();

            	return view('pages.sortiestock')->with("articles",$art)->with("bol",$bol)->with("vendres",$vendres);;


            }


	        }else{
	        	return redirect()->route('log');
	        }

        }

        if (request('operation2')=='delete') {
        	# code...
        	print("FFFF");
        	$id=request('idasupprimer');

        	try {
        		//print("FFFF %");
        		
        		$re=DB::table('vendres')->where('ID',$id)->delete();
        		print("FFFF ]]]");
        		$art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();

            	$bon=true;
            	//print("SDDSDSDS");
            	//print("SDFSDFSDF  ".$bol);
            	$vendres=DB::table('vendres')->join('utilisateurs','utilisateurs.ID','=','vendres.UTILISATEUR_ID')->join('articles','articles.ID','=','vendres.ARTICLE_ID')->select('vendres.QUANTITE as QUANTITE','vendres.DATE_SORTIE as DATE_SORTIE','vendres.ID AS ID','articles.DESIGNATION as DESIGNATION')->get();

            	return view('pages.sortiestock')->with("articles",$art)->with("bon",$bon)->with("vendres",$vendres);;

        	} catch (QueryException $e) {
        		
        		$art=DB::table('articles')->join('categories','categories.ID','=','articles.CATEGORIE_ID')->join('fournisseurs','fournisseurs.ID','=','articles.FOURNISSEUR_ID')->select('articles.ID as ID','articles.DESIGNATION as DESIGNATION','articles.QUANTITE as QUANTITE','articles.PRIX_UNITAIRE as PRIX_UNITAIRE','categories.LIBELLE as LIBELLE','fournisseurs.NOM as NOM','fournisseurs.PRENOM as PRENOM')->get();

            	$bon=false;
            	//print("SDDSDSDS");
            	//print("SDFSDFSDF  ".$bol);
            	$vendres=DB::table('vendres')->join('utilisateurs','utilisateurs.ID','=','vendres.UTILISATEUR_ID')->join('articles','articles.ID','=','vendres.ARTICLE_ID')->select('vendres.QUANTITE as QUANTITE','vendres.DATE_SORTIE as DATE_SORTIE','vendres.ID AS ID','articles.DESIGNATION as DESIGNATION')->get();

            	return view('pages.sortiestock')->with("articles",$art)->with("bon",$bon)->with("vendres",$vendres);;
        	}
        }
        

    }
}
