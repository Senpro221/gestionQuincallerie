<?php

namespace App\Http\Controllers;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class PanierControler extends Controller
{
//================================fontion pour lister le panier=================================/
    public function panier()
    {
        $user = Auth::user()->id;
        $panier = DB::select('select p.id from paniers p,users u where p.user_id=u.id and u.id=?',[$user]);
        $paniers = DB::select('select * from appartenirs a,produits p, paniers pa where a.id_prod=p.id and a.id_panier=pa.id and pa.id=?',[$panier[0]->id]);

        return view('paniers.listpan',compact('paniers'));
    }

//=====================================fomtion pour ajouter au panier===========================================================================//
    public function store(Request $request,$id)
    {
        $produits = DB::select('select quantite from produits where id = ?', [$request->id]);
       
        $user = Auth::user()->id;
        $panier = DB::select('select p.id from paniers p,users u where p.user_id=u.id and u.id=?',[$user]);
        $produits = DB::select('select * from produits where id = ?', [$request->id]);
        $app = DB::select('select id_prod from appartenirs a,produits p,paniers pa where a.id_prod=p.id and a.id_panier=pa.id and p.id=? and pa.id=?',[$request->id,$panier[0]->id]);

       if($produits[0]->quantite < $request->quantite ){
        return back()->with('error',"La quantité demandée n'est pas disponible");
       }elseif(!empty($app)){
        return Redirect()->Route("listpanier")->with('error',"La produit existe au panier");
       }else{
        DB::insert('insert into appartenirs (id_panier,id_prod,quantites) values (?, ?, ?)', [$panier[0]->id,$request->id,$request->quantite]);
        return back()->with('success',"La produit ajouter au panier");

       }
    }

//===================================retouner le formulaire de facturation=============================================//
    public function commande()
    {
        return view('order.commande');
    }

//==============================================details de facturation=========================================================//
    public function DetailsFacture(Request $request)
    {
        //on recuper l'id et le typeLivraison
        $user = Auth::user()->id;
        $livraison = $request->typeLivraison;
    
        //on recupere l'idpanier du user connecter
        $pane = DB::select('select id from paniers where user_id =?',[$user]);
    
        //on recuper tous les produits qui sont dans la table appartenir dont l'idpanier est l'idpanier du user connecter
        $produits=DB::select('select * from appartenirs,produits where produits.id = appartenirs.id_prod and id_panier=?',[$pane[0]->id]);
        
        //on insert dans la table commande id_user et le type de livraison
        DB::insert('insert into commandes (user_id,typeLivraison) values (?,?)', [$user,$livraison]);
       
        //on selection id commade de user connecter
        $pa = DB::select('select id from commandes where user_id =?',[$user]);
         
        // $pa =  Commande::orderBy('id', 'desc')->get();

        //ici on va boucler sur tous les produits qui sont dans la table appartenir(qui represant le panier dans notre interface)
            foreach($produits as $produits){
        //ici on recuper l'idproduit et la quantites qui est dans appartenir
                $id = $produits->id;
                $quantites  = $produits->quantites;

        //on appelle la fonction updateStock qui permet de faire la soustraction du (quantiterStock - quantiteCommander)
                $this->updateStock();
                DB::insert('insert into commande_pivos (id_commande,id_prod,quantiteCom) values (?,?,?)', [$pa[0]->id,$id,$quantites]);
        //=========================on vide le panier de l'utilisateurs=======================================
                DB::delete('delete from appartenirs where id_panier =?',[$pane[0]->id]);
 
        } 
        return  redirect('/Validecommande');
    }

//==================================permet de faire la soustraction du (quantiterStock - quantiteCommander)
    private function updateStock(){
        //dd($request->quantite);
        $app =  DB::select('select * from appartenirs,produits where appartenirs .id_prod=produits.id'); 
        foreach($app as $pa){
        //dd($pa->quantites);
        DB::update('update produits set quantite = '. $pa->quantite - $pa->quantites.' where id = ?', [$pa->id]);
   
        }
    }

//=======================================fonction pour lister les commande================================================//
    public function listerCommandes(Request $request){
        $user =  Auth::user()->id;
        $listeCommande =  DB::select('select * from commandes  where  user_id=?',[$user]);
        //$listeCommande =  Commande::orderBy('id', 'desc')->get();
        return view('order.listerCommandes',[
                    'listeCommande'=>$listeCommande,
          ]);   
    }

//===========================================fonction pour afficher les detail de chaque commande==============================//
    public function afficheDetails($id){
        $user = Auth::user()->id; 
        $detailsCom=DB::select('SELECT m.nom,m.prix_unitaire,o.quantiteCom,m.image FROM commande_pivos o,commandes c,produits m ,users u WHERE o.id_prod=m.id and o.id_commande = c.id and c.user_id= u.id and u.id=? and c.id=?',[$user,$id]); 
        return view('order.detailCommandes',[
            'detailsCom'=>$detailsCom,
        
        ]);
    
    }  
//===========================================retourne la vue validerCommande==========================================//
    public function Validecommande()
    {
       return view('order.validerCommande');
    }

//==========================fonction pour metre a jour la quantie au niveau du panier=======================//
    public function update(Request $request, $id)
    {
        DB::update('update appartenirs set quantites = ? where idApp = ?', [$request->quantite,$id]);
        return back()->with('success',"Quantité mise à jour avec succés");

    }

//==============================================suprimer au niveau du panier===================================//
    public function delete($id)
    {
        DB::delete('delete from appartenirs where idApp = ?', [$id]);
        return back()->with('error',"Produit supprimer  avec succés");

    }
}
