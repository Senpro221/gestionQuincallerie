
@extends('./../layouts/app')


@section('page-content')


   <div class="home-content ">
     @if (session()->has('success'))
              <div class="alert alert-success">
                {{session()->get('success')}}
              </div>
           @endif
      <div class="overview-boxes">
      
          <div class="box">
     <div style="max-width: 410px"> 
            <form action="{{ route('insererProduit') }}" method="POST">
             <h2 class="text-success">Ajouter un produit</h2>
             <hr>
            @csrf
            @method('post')
              <label for="nom_medoc">Nom Produit</label>
              <input type="text" name="nom" id="nom" placeholder="Nom du médicament" value="{{ old('nom')}}">

              @error('nom')
            <div class="text text-danger">
              {{$message}}
            </div>
            @enderror

            <label for="nom_medoc">Image</label>
            <input type="file" name="image" id="iamge">

            @error('image')
            <div class="text text-danger">
              {{$message}}
            </div>
            @enderror
            
          
            <label for="nom_medoc">Catégorie</label>
              <select id="categorie"  name="categorie" >
                @foreach ($categories as $categorie )
                    <option value="{{$categorie->nom }}"> {{ $categorie->nom}} </option>     
                @endforeach
              </select>

             <label for="nom_medoc">Quantité</label>
              <input type="number" min="1" name="quantite" id="quantite" placeholder="Quantité du médicament" value="{{ old('quantite')}}">

              @error('quantite')
                <div class="text text-danger">
                {{$message}}
                </div>
              @enderror
              
             <label for="nom_medoc">Quantité Minimum</label>
              <input type="number" min="1" name="quantiteMin" id="quantiteMin" placeholder="Quantité minimun de stock du médicament" value="{{ old('quantiteMin')}}">

              @error('quantiteMin')
                <div class="text text-danger">
                {{$message}}
                </div>
              @enderror

              <label for="nom_medoc">Prix unitaire</label>
              <input type="number" min="1" name="prix_unitaire" id="prix_unitaire" placeholder="prix du médicament" value="{{ old('prix_unitaire')}}">

              @error('prix_unitaire')
                <div class="text text-danger">
                {{$message}}
                </div>
              @enderror
              
              

               <label for="nom_medoc">Libellé</label>
              <textarea name="libelle" id="libelle" placeholder="libelle du medicament">{{ old('libelle')}}</textarea>

              @error('libelle')
                <div class="text text-danger">
                {{$message}}
                </div>
              @enderror

              <button type="submit" class="btn btn-success mt-1">Ajouter et publié le médicaments</button>

            </form>
          </div>
          </div>
     
      <!-- tables -->  

        <div class="box">
          <table class="mtable" border="1">
            <tr>
              <th>Nom</th>
              <th>Quantité</th>
              <th>Prix_Unitaire</th>
              <th>Catégorie</th>
              {{-- <th>DLC</th> --}}
              <th>Action</th>

            </tr>
             @forelse($produits as $produit) 
               {{-- @if(Auth::user()->id===$medicament->user_id)  --}}
            <tr>
            
                <td>{{$produit->nom}}</td>
                <td>{{$produit->quantite}}</td>
                <td>{{$produit->prix_unitaire}} FCFA</td>
                <td>{{$produit->categorie}}</td>

         
                <td> 
                <form action="#" method="POST">
                  @csrf
                  @method('post')
                  <a href="#" type="submit" class="btn btn-success mt-1">Editer</a>

                 <button type="submit" class="btn btn-danger mt-1">Supprimer</button>
                </form>
               </td>
            </tr>
                {{-- @else 
              @endif --}}
      
            @empty

        @endforelse

        </table>
        </div>
  </div>    
  </body>
  @endsection
</html>