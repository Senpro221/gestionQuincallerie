<?php

namespace App\Http\Controllers;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Commande;
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
        if(Auth::user()->role== 'admin'){
                $ventes = DB::table('ventes')->count();
                //dd($ventes);
                $medoc = DB::table('produits')->count();

                $users = DB::table('users')->count();

                $commandes = DB::table('commandes')->count();

                $recentComm = DB::select("SELECT c.dateCommande,u.prenom,u.name,m.nom,m.prix_unitaire FROM commande_pivos o,commandes c,users u, produits m WHERE c.user_id=u.id and o.id_prod = m.id and o.id_commande=c.id ORDER BY dateCommande DESC");

            // dd($recentComm);
            return view('adminGerant',[
                'ventes'=>$ventes,
                'medoc'=>$medoc,
                'users'=>$users,
                'commandes'=>$commandes,
                'recentComm'=>$recentComm
                ]);
        }else{
            return back();
        }
    }
//===============================Ajouter une categorie=========================//
    public function ajoutCategorie() {
        if(Auth::user()->role== 'admin'){
            $categories = DB::select('select * from categories');
            return view('categories.ajoutCategorie',compact('categories'));
        }else{
            return back();
        }
    }
    public function insererCategorie(Categorie $categories,Request $request) {
        if(Auth::user()->role== 'admin'){
            $categories->nom = $request->nom;
            $categories->save();
            return back()->with('success','Catégorie ajoutée avec succés');
        }else{
            return back();
        }
    }

//=============================fontion pour Ajouter un produit=========================//
    public function ajoutProduit() {
        if(Auth::user()->role== 'admin'){
            $produits = DB::select('select * from produits');
            $categories = DB::select('select * from categories');
            return view('produits.produit',[
                'produits'=>$produits,
                'categories'=>$categories
            ]);
        }else{
            return back();
        }
    }
    public function insererProduit(Produit $produits,Request $request) {
        if(Auth::user()->role== 'admin'){
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
        }else{
            return back();
        }
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
//==============================================editer un produit=========================================
    public function edit($id) {
        if(Auth::user()->role== 'admin'){
            $produits = DB::select('select * from produits where id=?',[$id]);
            $categories = DB::select('select * from categories ');
            return view('produits.edit',[
                'produits'=>$produits,
                'categories'=>$categories
            ]);
        }else{
            return back();
        }
    }

    public function update($id,Request $request)
    {
        if(Auth::user()->role== 'admin'){
            $nom = $request->nom;
            $image = $request->image;
            $categorie = $request->categorie;
            $quantite = $request->quantite;
            $quantiteMin = $request->quantiteMin;
            $prix_unitaire = $request->prix_unitaire;
            $libelle = $request->libelle;
            
            DB::update('update produits set nom = ?, image=?,categorie =?, quantite=? ,quantiteMin=?,prix_unitaire=?,libelle=? where id = ?', [$nom,$image,$categorie,$quantite,$quantiteMin,$prix_unitaire,$libelle,$id]);
            
            return redirect()->Route('ajoutProduit')->with('success','Produit mise à jour');
        }else{
            return back();
        }
    }

//======================fonction pour supprimer un produit au niveau de admin==================================
    public function delete($id)
    {
        if(Auth::user()->role== 'admin'){
            DB::delete('delete from produits where id = ?', [$id]);
            return redirect()->Route('ajoutProduit')->with('success','Produit mise à jour');
        }else{
            return back();
        }
    }

//==============================================editer une categorie=========================================
    public function editCategorie(Categorie $categories) {
        if(Auth::user()->role== 'admin'){
            return view('categories.edit',[
                'categories'=>$categories
            ]);
        }else{
            return back();
        }
    }

    //==============================================modifier une categorie=========================================
    public function updateCategorie(Categorie $categories,Request $request) {
        if(Auth::user()->role== 'admin'){
            
            $categories->nom = $request->nom;
            $categories->save();
            
            return redirect()->Route('ajoutCategorie')->with('success','Catégorie mise à jour');
        }else{
            return back();
        }
    }

//=======================fonction pour lister les produit a vendre au niveau de admin
    public function listProdAdmin()
    {
        if(Auth::user()->role== 'admin'){
            $produits = Produit::all();

            return view('ventes.listing',compact('produits'));
        }else{
            return back();
        }
    }

//===========================fonction pour affichant le formulaire de vente niveau admin
    public function vendreProduit($id)
    {
        if(Auth::user()->role== 'admin'){
            $produits = DB::select('select * from produits  where id=?',[$id]);
            return view('ventes.vente',compact('produits'));
        }else{
            return back();
        }
    }

//==================fonction pour mettre a jour le stock apres vente===========================//
    public function stockupdate(Request $request,$id){
        if(Auth::user()->role== 'admin'){
            $quantiteVendue  = $request->quantite;
        
            $app =  DB::select('select * from produits where  produits.id=?',[$id]);
            
            foreach($app as $pa){
            
                if($quantiteVendue > $pa->quantite){
                    return back()->with('error','la quantité saisie n\'est pas disponible');
                }else{         
                    DB::update('update produits set quantite = '.$pa->quantite - $request->quantite.' where id = ?', [$pa->id]);
                    DB::insert('insert into ventes (user_id, id_prod, quantiteVendue) values (?, ?, ?)', [Auth::user()->id,$id,$request->quantite]);
                    return redirect()->Route('listProdAdmin')->with('success','Produit vendu avec succés');
                }
                break;
            }
        }else{
            return back();
        }
    }

//===========================fonction retournant la liste de toutes commande au niveau e l'admin================================//
    public function listeCommandeAll(Request $request)
    {
        if(Auth::user()->role== 'admin'){
           $listeCommande = DB::select('select c.id, c.dateCommande,c.statut,c.typeLivraison,u.prenom,u.name,u.telephone from commandes c,users u where c.user_id=u.id ');
           //$listeCommande = Commande::orderBy('id', 'desc')->get();
           return view('order.listesCommandesAll',compact('listeCommande'));
        }else{
            return back();
        }
    }

//============================fonction retournant les deatilles de chaque commande au niveau de l'admin==================================================//
    public function DetailsCommandesGerant(Request $request,$id)
    {
        if(Auth::user()->role== 'admin'){
           $data = Commande::find($id);
           //dd($data);
           $idcom = DB::select('select id from commande_pivos where id_commande = ?', [$id]);
           $detailsCom =  DB::select('select * from commande_pivos,produits,commandes where produits.id=commande_pivos.id_prod and commandes.id=commande_pivos.id_commande and id_commande=?',[$data->id]);
       
           return view('order.DetailsCommandesAll',[
               'detailsCom'=>$detailsCom,         
           ]);

        }else{
            return back();
        }
    }

//===============================fonction permetant de changer le statut d'une commande=====================================//
       public function statutCommandes(Request $request, string $id)
       {
            if(Auth::user()->role== 'admin'){
               $data = Commande::find($id);
               if($data->statut==1){
                   $data->statut=2;
               }else{
                   $data->statut=1;
               }
               $data->save();
               return back()->with('success','Commande livré avec succés.');
            }else{
                return back();
            }
           
       }

//================================fonction pour rechercher un produit cote client==================================//
    public function search()
	{   
        if(Auth::user()->role== Null){
			$q = request()->input('q');
			// dd($q);
			$produits = Produit::where('nom', 'like', "%$q%")
			->orWhere('categorie', 'like', "%$q%")
			->paginate(6);
			return view('produits.search')->with('produits',$produits);
        }else{
            return back();
        }
	}

   
}
