<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoutiqueControler;
use App\Http\Controllers\UserControler;
use App\Http\Controllers\PanierControler;
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

//===============route pour afficher la page d'accueil du visisteurs===========//
Route::get('/',[BoutiqueControler::class, 'index'])->name('index');

//===================route pour afficher la page d'accueil du gerant===========================================//
Route::get('/adminGerant',[BoutiqueControler::class, 'indexAdmin'])->name('adminGerant');

//============================routes pour ajouter des categories=================================================//
Route::get('/ajoutCategorie',[BoutiqueControler::class, 'ajoutCategorie'])->name('ajoutCategorie');
Route::post('/insererCategorie',[BoutiqueControler::class, 'insererCategorie'])->name('insererCategorie');

//==========================routes pour ajouter des Produits===================================================//
Route::get('/ajoutProduit',[BoutiqueControler::class, 'ajoutProduit'])->name('ajoutProduit');
Route::post('/insererProduit',[BoutiqueControler::class, 'insererProduit'])->name('insererProduit');
Route::get('/detailleProduit/{id}',[BoutiqueControler::class, 'detailleProduit'])->name('detailleProduit');
Route::get('/listeProduit',[BoutiqueControler::class, 'listeProduit'])->name('listeProduit');


//==============route pour s'inscrire et se connecter et se deconnecter users==================//
Route::get('/register',[UserControler::class, 'index'])->name('register');
Route::post('/registration',[UserControler::class, 'create'])->name('registration');
Route::post('/login',[UserControler::class, 'handleLogin'])->name('login');
Route::get('/logout',[UserControler::class, 'logout'])->name('logout');

//=====================route pour ajouter au panier et lister le panier=======================//
Route::post('/addPanier/{id}',[PanierControler::class, 'store'])->name('addPanier');
Route::get('/listpanier',[PanierControler::class, 'panier'])->name('listpanier');
Route::post('/updatePanier/{id}',[PanierControler::class, 'update'])->name('updatePanier');
Route::get('/deletePanier/{id}',[PanierControler::class, 'delete'])->name('deletePanier');

//=======================================commander produit==============================================//
Route::get('/commande',[PanierControler::class, 'commande'])->name('commande');
Route::post('/DetailsFacture',[PanierControler::class,'DetailsFacture'])->name('DetailsFacture');
Route::get('/Validecommande',[PanierControler::class, 'Validecommande'])->name('Validecommande');
Route::get('/listerCommandes',[PanierControler::class, 'listerCommandes'])->name('listerCommandes');
Route::get('/afficheDetails/{id}',[PanierControler::class, 'afficheDetails'])->name('afficheDetails');
