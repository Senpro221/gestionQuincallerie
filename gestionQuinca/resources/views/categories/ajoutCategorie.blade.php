

@extends('../layouts/app')


@section('page-content')


   <div class="home-content ">

        @if (session()->has('success'))
        <div class="alert alert-success">
          {{session()->get('success')}}
        </div>
      @endif
      
      <div class="overview-boxes">
          <div class="box">
            
            <form action="{{ route('insererCategorie') }}" method="POST">
              <h2 class="text-success">Ajouter une catégorie </h2>
              <hr>
             @csrf
             @method('post')
             
             <label for="nom_medoc">Nom</label>
               <input type="text"  name="nom" required placeholder="saisir le nom de la catégorie">
               <button type="submit" class="btn btn-success mt-1">Ajouter</button>
 
             </form>
             
          </div>  
          
     
      <!-- tables -->  
      <div class="box">
        <table class="mtable" border="1">
          <tr>
            <th>Numero</th>
            <th>Nom de la catégorie</th>
            
            {{-- <th>DLC</th> --}}
            <th>Action</th>

          </tr>
           @forelse($categories as $categorie) 
             {{-- @if(Auth::user()->id===$medicament->user_id)  --}}
          <tr>
          
              <td>{{ $categorie->id }}</td>
              <td>{{ $categorie->nom }}</td>
    
              <td> 
              <form action="#" method="POST">
                @csrf
                @method('post')
                <a href="{{ route('editCategorie',$categorie->id) }}" type="submit" class="btn btn-success mt-1">Editer</a>

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