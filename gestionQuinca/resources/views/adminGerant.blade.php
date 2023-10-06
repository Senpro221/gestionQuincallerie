
@extends('./layouts/app')


@section('page-content')

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
    
      <div class="home-content">
        <div class="overview-boxes">
          <div class="box">
            <div class="right-side">
              
              <div class="box-topic" style="text-transform: uppercase">Produits</div>
              <div class="number">{{ $medoc }}</div>
              <div class="indicator">
                <i class="bx bx-down-arrow-alt down"></i>
                <span class="text">en stock</span>
              </div>
            </div>
            <i class="bx bxs-cart-add cart two"></i>
          </div>
          <div class="box">
            <div class="right-side">
           
              <div class="box-topic" style="text-transform: uppercase">Ventes</div>
              <div class="number">{{ $ventes }}</div>             
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text">vendus</span>
              </div>
            </div>
            <i class="bx bx-cart cart three"></i>
          </div>
         
          <div class="box">
           
            <div class="right-side">
              <div class="box-topic" style="text-transform: uppercase">Commandes</div>
              <div class="number">{{ $commandes }}</div>
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text">Enregistrer</span>
              </div>
            </div>
            <i class="bx bx-cart-alt cart"></i>
          </div> 
       
          <div class="box">
            <div class="right-side">
            
              <div class="box-topic" style="text-transform: uppercase">Utilisateurs</div>
              <div class="number">{{ $users }}</div>
              <div class="indicator">
                <i class="bx bx-down-arrow-alt down"></i>
                <span class="text">Enregistrer</span>
              </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor" class="w-6 h-6 ms-5  text-success" style="width:60px ;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
            </svg>
            
          </div>
        </div>
        
       
          <div class="sales-boxes" style="width:120rem;">
            <div class="recent-sales box">
              <div class="title">Commandes recentes</div>
              
              
              <div class="sales-details">
                <ul class="details">
                  <li class="topic">Date</li>
                  @foreach ($recentComm as $recent)
                  <li><a href="#">{{ $recent->dateCommande }}</a></li>
                 @endforeach
                </ul>        
                <ul class="details">
                  <li class="topic">Client</li>
                  @foreach ($recentComm as $recent)
                  <li><a href="#">{{ $recent->prenom }} {{ $recent->name }}</a></li>
                  @endforeach
                </ul>
                <ul class="details">
                  <li class="topic">Produits</li>
                  @foreach ($recentComm as $recent)
                  <li><a href="#">{{ $recent->nom }}</a></li>
                  @endforeach
                </ul>
                <ul class="details">
                  <li class="topic">Prix du Produit</li>
                  @foreach ($recentComm as $recent)
                  <li><a href="#"></a>{{ $recent->prix_unitaire }}</li>
                  @endforeach
                 
                </ul>
              </div>
                
             
              <div class="button" >
                <a href="#" type="button" class="btn-success" >Voir Tout</a>
              </div>
            </div>
            
        </div>
 

    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
    </script>
  </body>
</html>



  @endsection
