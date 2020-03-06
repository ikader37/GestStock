<nav class="navbar navbar-success" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex2-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>
    <div class="collapse navbar-collapse navbar-ex2-collapse">
      <ul class="nav navbar-nav">
        <li><a href="#">Accueil</a></li>
        <li><a href="{{url('article')}}">Articles</a></li>
        <li><a href="{{url('etatstock')}}">Etat stock</a></li>
        <li><a href="{{url('sortie')}}">Sorties du stock</a></li>
        


        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon icon-user"></i>
            {{Session::get('USERNAME')}} <b class="caret"></b>
          </a>
          <ul class="dropdown-menu dropdown-menu-success">
            <li><a href="{{url('enreg')}}">Tableau de bord</a></li>
            <li><a href="{{url('categories')}}">Deconnecter</a></li>
           
          </ul>
        </li>


      </ul>
      
      
    </div>
  </div>
</nav>