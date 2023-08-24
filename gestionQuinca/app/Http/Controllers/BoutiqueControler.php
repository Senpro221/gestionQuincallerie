<?php

namespace App\Http\Controllers;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class BoutiqueControler extends Controller
{
//==========================fontion affichant la page d'accueil du visiteur====//
    public function index() {
        $produits = DB::select('select * from produits');
        $produits = Produit::orderBy('id', 'desc')->get();
        $produits = Produit::paginate(8);
        return view('index',compact('produits'));
    }
//=============================liste des produit===============================//
    public function listeProduit() {
        $produits = DB::select('select * from produits');
        $produits = Produit::paginate(8);
        return view('produits.listeProduit',compact('produits'));
    }
//==========================fontion affichant la page d'accueil du gerant====//
    public function indexAdmin() {
        return view('adminGerant');
    }
//===============================Ajouter une categorie=========================//
    public function ajoutCategorie() {
        $categories = DB::select('select * from categories');
        return view('categories.ajoutCategorie',compact('categories'));
    }
    public function insererCategorie(Categorie $categories,Request $request) {
        $categories->nom = $request->nom;
        $categories->save();
        return back()->with('success','Catégorie ajoutée avec succés');
    }

//=============================fontion pour Ajouter un produit=========================//
    public function ajoutProduit() {
        $produits = DB::select('select * from produits');
        $categories = DB::select('select * from categories');
        return view('produits.produit',[
            'produits'=>$produits,
            'categories'=>$categories
        ]);
    }
    public function insererProduit(Produit $produits,Request $request) {
        $produits->nom = $request->nom;
        $produits->image = $request->image;
        $produits->categorie = $request->categorie;
        $produits->quantite = $request->quantite;
        $produits->quantiteMin = $request->quantiteMin;
        $produits->prix_unitaire = $request->prix_unitaire;
        $produits->libelle = $request->libelle;
        $produits->save();
        return back()->with('success','Produit ajouté avec succés');
    }

//========================== fonction pour afficher le detaille d'un produit===========================
    public function detailleProduit($id) {
        $produits = DB::select('select * from produits where id = ?', [$id]);
        return view('produits.detaille',compact('produits'));
    }

}
