@extends('../layouts/entete')

@section('page-content')
<div class="row ">
    <div class="col-md-12">
        <form action="" class="card card-sm">
            <div class="card-body row no-gutters align-items-center me-1">
               <div class="col">
                    <input type="search" placeholder="Rechercher un produit" class="form-control form-control-borderless" name="item-name">
               </div>
               <div class="col-auto ">
                    <button type="submit" class="btn btn-success ">Recherche</button>
               </div>
            </div>

        </form>
    </div>
</div>

<div class="row">
    @forelse($produits as $produit)
    <div class="col-md-3 mt-1">
       
        <div class="card">
            <img src="/image/{{ $produit->image }}" style="height: 300px;"  class="card-img-top " alt="vous">  
            <div class="card-body">
                <div class="card-title" >{{$produit->nom}}</div>
                <div class="card-text" style="color: orange; font-family: popper;">{{$produit->prix_unitaire}} FCFA</div>
                <a href="{{ route('detailleProduit',$produit->id) }}" class="btn btn-info mt-2">Détails</a>
                <a href="{{ route('detailleProduit',$produit->id) }}" class="btn btn-success mt-2">+Ajouter</a>
            </div>
        </div>
        
    </div>
    @endforeach
    
</div>

@endsection