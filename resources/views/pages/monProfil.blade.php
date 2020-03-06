@extends('layout/applicationLayout')
@section('menu')

  @if(Session::get('ROLE')=='EMPLOYE')
    @include('menus.menusimple')
  @endif

  @if(Session::get('ROLE')=='ADMINISTRATEUR')
    @include('menus.menuadmin')
  @endif
  
@endsection
@section('content')

	<div class="row">
    <div class="col-lg-20 col-lg-offset-3">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><center>ENREGISTRER UN EMPLOYE</center></h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal " method="POST">

                    {{csrf_field()}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="operation" value="ajouter" id="operation" name="operation">
                    <input type="hidden" name="idUp" id="idUp">
                    @if(!empty($bon))
                            @if($bon)
                                <div class="form-group">
                                   <div class="alert alert-success alert-dismissable fade in">
                                        <i class="icon icon_check_alt icon-lg"></i>
                                        <strong>Reussit:</strong> Opération reussit.
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                   <div class="alert alert-danger alert-dismissable fade in">
                                        <i class="icon icon_check_alt icon-lg"></i>
                                        <strong>Echec !</strong> Opération echouée.
                                    </div>
                                </div>
                            @endif

                        @endif


                  <div class="form-group">
                        <label class="col-sm-6 control-label">Nom:</label>
                        <div class="col-sm-10">
                          <input type="text" id="nom" class="form-control" name="nom" required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Prenom(s):</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="prenom" name="prenom" required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Adresse:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="adresse" name="adresse" required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Telephone:</label>
                        <div class="col-sm-10">
                          <input type="tel" class="form-control"  name="tel" required="true" id ="tel">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Nom d'utilisateur:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="username" name="username" required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Mot de passe:</label>
                        <div class="col-sm-10">
                          <input type="password"  id="password" class="form-control" name="password" required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="col-sm-10 btn btn-primary col-sm-offset-2 icon icon-check-circle" type="submit" id="submit" />
                        <input class="col-sm-10 btn btn-danger col-sm-offset-2 icon icon-repeat" type="reset" id="reset"/>
                    </div>
                </form>

@endsection