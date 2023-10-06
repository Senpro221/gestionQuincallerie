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
   
//=====================routes consernant les categories cote client =======================//
   Route::get('/listeCategorie',[BoutiqueControler::class, 'listeCategorie'])->name('listeCategorie');
   Route::get('/produitDeChaqueCategorie/{id}',[BoutiqueControler::class, 'produitDeChaqueCategorie'])->name('produitDeChaqueCategorie');
   Route::get('/detailleProduit/{id}',[BoutiqueControler::class, 'detailleProduit'])->name('detailleProduit');
   Route::get('/listeProduit',[BoutiqueControler::class, 'listeProduit'])->name('listeProduit');

//==========================================Groupes des routes qui necessites pas une authentification
Route::middleware(['guest'])->group(function(){
    //==============route pour s'inscrire et se connecter et se deconnecter users==================//
    Route::get('/register',[UserControler::class, 'index'])->name('register');
    Route::post('/registration',[UserControler::class, 'create'])->name('registration');
    Route::get('/login',[UserControler::class, 'login'])->name('login');
    Route::post('/login',[UserControler::class, 'handleLogin'])->name('handleLogin');

});
 
//==================Groupes des routes qui necessites une authentification//=================================================//
Route::middleware('auth')->group(function(){

    //===================route pour afficher la page d'accueil du gerant===========================================//
    Route::get('/adminGerant',[BoutiqueControler::class, 'indexAdmin'])->name('adminGerant');
    //================================Route pour le stock dans la page admin=========================================//
    Route::get('/stock', [PanierControler::class,'stock'])->name('stock');
    Route::get('/updateQuantity/{id}', [PanierControler::class,'updateQuantity'])->name('updateQuantity');
    Route::post('/mettreAjourStock/{id}',[PanierControler::class,'mettreAjourStock'])->name('mettreAjourStock');

    //============================routes pour ajouter des categories=================================================//
    Route::get('/ajoutCategorie',[BoutiqueControler::class, 'ajoutCategorie'])->name('ajoutCategorie');
    Route::post('/insererCategorie',[BoutiqueControler::class, 'insererCategorie'])->name('insererCategorie');
    Route::get('/editCategorie/{categories}',[BoutiqueControler::class, 'editCategorie'])->name('editCategorie');
    Route::post('/updateCategorie/{categories}',[BoutiqueControler::class, 'updateCategorie'])->name('updateCategorie');


    //==========================routes pour ajouter des Produits===================================================//
    Route::get('/ajoutProduit',[BoutiqueControler::class, 'ajoutProduit'])->name('ajoutProduit');
    Route::post('/insererProduit',[BoutiqueControler::class, 'insererProduit'])->name('insererProduit');
    Route::get('/editProduit/{id}',[BoutiqueControler::class, 'edit'])->name('editProduit');
    Route::put('/updateProduit/{id}',[BoutiqueControler::class, 'update'])->name('produit.update');
    Route::delete('/deleteProduit/{id}',[BoutiqueControler::class, 'delete'])->name('produit.delete');
    //====================================Route pour la vente sur place========================================================//
    Route::get('/listProdAdmin',[BoutiqueControler::class, 'listProdAdmin'])->name('listProdAdmin');
    Route::get('/vendre/{id}',[BoutiqueControler::class, 'vendreProduit'])->name('vendre');
    Route::post('/stockupdate/{id}',[BoutiqueControler::class, 'stockupdate'])->name('stockupdate');

    //====================================les routes concernant les commandes dans l'admin=================================================================//
    Route::get('/listeCommandeAll',[BoutiqueControler::class, 'listeCommandeAll'])->name('listeCommandeAll');
    Route::get('/DetailsCommandesGerant/{id}',[BoutiqueControler::class, 'DetailsCommandesGerant'])->name('DetailsCommandesGerant');
    Route::get('/statutCommandes/{id}',[BoutiqueControler::class, 'statutCommandes'])->name('statutCommandes');

    //Routes pour Rechercher un produits
    Route::post('/search',[BoutiqueControler::class, 'search'])->name('shearch');

    //=====================================les Routes concernant le panier de user=============================//
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

    //========================================route pour la deconnexion======================================//
    Route::get('/logout',[UserControler::class, 'logout'])->name('logout');

});
