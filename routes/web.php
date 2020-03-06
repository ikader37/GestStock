<?php

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

Route::get('/','UtilisateurController@getLoginPage');
Route::post('/','UtilisateurController@signIn');

Route::get('/oo', function () {
    return view('mm');
});

Route::get('/accueil',function(){

	return view('pages.home');
});


Route::get('/log','UtilisateurController@getLoginPage')->name('log');
Route::post('log','UtilisateurController@signIn');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/enreg','UtilisateurController@getSignUpPage');

Route::post('/enreg','UtilisateurController@enregistrerUserPost');

Route::get('/article','ArticleController@getAjouterArticle');

Route::post('/article','ArticleController@enregistrerArticle');

Route::get('/stock','ArticleController@getSortieStock');


Route::post("/e",function(){
	
});

Route::get('/categories','CategorieController@getCat');

Route::post('/categories','CategorieController@enregistrerCat');

Route::get('/fournisseur','FournisseurController@getFour');
Route::post('/fournisseur','FournisseurController@enregistrerFournisseur');

Route::get('/etatstock','ArticleController@etatStock');
Route::post('/etatstock','ArticleController@renouvellerStock');

Route::get('/sortie','VendreCondroller@getSortieStock');

Route::post('/sortie','VendreCondroller@enregistrerSortieStock');

