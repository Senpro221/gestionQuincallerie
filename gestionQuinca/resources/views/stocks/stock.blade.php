
@extends('./layouts/app')


@section('page-content')
<div class="home-content" style="margin-left: 5rem;">
     @if (session()->has('success'))
              <div class="alert alert-success">
                {{session()->get('success')}}
              </div>
           @endif
    <div class="overview-boxes ms-5 mt-1">
        <div class="box">
            <table class="mtable" border="1">
                <tr>
                    <th>Nom Produits</th>
                    <th>Quantité en stock</th>
                    <th>Quantité minimum</th>

                    <th>Action</th>
                </tr>
                @foreach($stocks as $stock ) 
                   
                    @if ($stock->quantite < $stock->quantiteMin )
                        <tr class="alert alert-warning" style="background-color: rgba(249, 189, 92, 0.465); ">
                            <td>{{ $stock->nom }}</td>
                                
                            <td>{{ $stock->quantite }}</td>
                        
                            <td>{{ $stock->quantiteMin }}</td>
                            <td>
                                <a href="{{ route('updateQuantity',$stock->id) }}"  class="btn btn-success" >Ajouter</a>
                            </td> 
                              
                            {{-- <td> <a href="{{ route('statutmedicaments',$stock->id) }}" class="btn btn-danger">Suppimer</a> </td>              --}}
                                
                        </tr>
                    @else        
                    <tr class="">
                        <td>{{ $stock->nom }}</td>
                            
                        <td>{{ $stock->quantite }}</td>                     
                        <td>{{ $stock->quantiteMin }}</td>
                      
                    </tr>
                @endif            
                            
                    </tr>
                        
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection