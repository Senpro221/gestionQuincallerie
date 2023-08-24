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
        $categories = DB::select("select categories.id from categories where categories.nom=?",[$request->categorie]);
        //dd($categories[0]->id);
        $produits->nom = $request->nom;
        $produits->image = $request->image;
        $produits->categorie = $request->categorie;
        $produits->quantite = $request->quantite;
        $produits->quantiteMin = $request->quantiteMin;
        $produits->prix_unitaire = $request->prix_unitaire;
        $produits->libelle = $request->libelle;
        $produits->id_cat = $categories[0]->id;
        $produits->save();
        return back()->with('success','Produit ajouté avec succés');
    }

//========================== fonction pour afficher le detaille d'un produit===========================
    public function detailleProduit($id) {
        $produits = DB::select('select * from produits where id = ?', [$id]);
        return view('produits.detaille',compact('produits'));
    }

//========================== fonction pour afficher la liste et le nombres de produit de chaque categorie===========================
    public function listeCategorie() {
        $categorie = DB::select('SELECT c.nom,c.id, COUNT(p.id) AS nombre_de_produits
        FROM Categories c
        LEFT JOIN Produits p ON c.id = p.id_cat
        GROUP BY c.nom,c.id;
        ');
        //dd($counte);
         //$categorie = DB::select('select * from categories');
        return view('categories.listeCategorie',compact('categorie'));
    }
//===========================fonction qui affiche les produits de chaque categorie==================================//
    public function produitDeChaqueCategorie($id) {
        $produits = DB::select('SELECT * from produits where id_cat=?',[$id]);
        
        return view('categories.produitDeChaqueCategorie',compact('produits'));
    }
}
