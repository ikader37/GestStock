@extends('layout/applicationLayout')
@section('menu')

  @if(Session::get('ROLE')=='EMPLOYE')
    @include('menus.menusimple')
  @endif

  @if(Session::get('ROLE')=='ADMINISTRATEUR')
    @include('menus.menuadmin')
  @endif
  
@endsection
@section('content')@extends('layout/applicationLayout')
@section('menu')
  @include('menus.menuadmin')
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
                        <label class="col-sm-6 control-label">Role:</label>
                        <div class="col-sm-10">
                          <select name="role" id="role">
                              @foreach($roles as $rol)
                                <option value="{{$rol->ID}}"> 
                                    {{$rol->LIBELLE}}
                                </option>
                              @endforeach
                          </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <input class="col-sm-10 btn btn-primary col-sm-offset-2 icon icon-check-circle" type="submit" id="submit" />
                        <input class="col-sm-10 btn btn-danger col-sm-offset-2 icon icon-repeat" type="reset" id="reset"/>
                    </div>

                </form>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-20 col-lg-offset-3">
        <div class="panel panel-success">
            <div class="panel panel-heading">
                <h2><center>LISTE DES EMPLOYES</center></h2>
            </div>
            <div class="panel panel-body">
                <table class="table table-striped table-advance table-hover">
                    <tbody>
                        <thead>
                            
                            <tr>
                                <th><i class="icon_profile"></i>#</th>
                                <th><i class="icon_adress"></i> Nom</th>
                                <th><i class="icon_mail_alt"></i> Prénom(s)</th>
                                <th><i class="icon_mail_alt"></i> Adresse</th>
                                <th><i class="icon_mail_alt"></i> Telephone</th>
                                <th><i class="icon_mail_alt"></i> Nom d'utilisateur</th>
                                <th>Opérations</th>
                            </tr>
                        </thead>


                        @if(!empty($users))
                      @foreach($users as $user)
                        <tr id="{{$user->ID}}">

                            <td>{{$loop->index +1}}</td>
                            <td data-role="nom" data-target="nom">{{$user->NOM}}</td>
                            <td data-role="prenom" data-target="prenom">{{$user->PRENOM}}</td>
                            <td data-role="adresse" data-target="adresse">{{$user->ADRESSE}}</td>
                            <td data-role="telephone" data-target="telephone">{{$user->TELEPHONE}}</td>
                            <td data-role="username" data-target="username">{{$user->USERNAME}}</td>
                            

                            <td>
                                <div class="btn btn-group">
                                    <a class="btn btn-success edit" href="#" value="{{$user->ID}}" id="editer {{$user->ID}}"  data-id="{{$user->ID}}" data-role="editer"><i class="icon icon-edit"></i></a>

                                    <a class="btn btn-danger delete"  value="{{$user->ID}}" id="delete {{$user->ID}}"  data-role="delete" data-id="{{$user->ID}}" data-toggle="modal" href="#modalSupprimer" ><i class="icon icon-times-circle"></i></a>
                                    <!--<a class="btn btn-primary infos"  value="{{$user->ID}}" id="detail {{$user->ID}}"  data-role="detail" data-id="{{$user->ID}}" ><i class="icon icon-info-circle"></i></a>
                                    -->
                                </div>
                            </td>

                           

                        </tr>

                        @endforeach
                        @endif

                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
</div>
   


<!--Boite de dialogue pour l'operation de suppression d'un employer-->

<div class="modal fade" id="modalSupprimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Suppression</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="operation2" id="operation2" value="delete">
                    <input type="hidden" name="idasupprimer" id="idasupprimer">
                    <p id="messageSupprimer" >Voulez-vous supprimer </p>
                    <button type="submit" class="bn btn-primary"><i class="icon_trash_alt"></i> Supprimer</button>
                    <button type="reset" class="btn btn-inverse" data-dismiss="modal"><i class="icon icon-times icon-lg"></i> Fermer</button>
                </form>
                
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    //Le clickk sur le boutton supprimer

    $('#pass').hide();

    $(document).on('click','a[data-role=delete]',function(){
        var id=$(this).data('id');
        console.log('ID A SUPPRIMER'+id);
        $('#idasupprimer').val(id);
        //alert(idheureDepart);

        $('#operation2').val('delete');
        var nom=$('#'+id).children('td[data-target=nom]').text();
        var prenom=$('#'+id).children('td[data-target=prenom]').text();
        //var tra=$('#'+idheureDepart).children('td[data-target=intituletrajet]').text();

        $('#messageSupprimer').value="";
        $('#messageSupprimer').append("l\'employé "+nom+" "+prenom+"?");
    });

    $(document).on('click','a[data-role=editer]',function(){

                var id=$(this).data('id');//Recuperer le id du trajet qui se trouve dans le button qui declanche l'action
                
                var nom=$('#'+id).children('td[data-target=nom]').text();
                var prenom=$('#'+id).children('td[data-target=prenom]').text();
                var adresse=$('#'+id).children('td[data-target=adresse]').text();
                var telephone=$('#'+id).children('td[data-target=telephone]').text();
                var username=$('#'+id).children('td[data-target=username]').text();
                //alert(heuredepart);
                $('#nom').val(nom);
                $('#prenom').val(prenom);
                $('#adresse').val(adresse);
                $('#tel').val(telephone);
                $('#username').val(username);
                $('#operation').val('update');
                $('#idUp').val(id);

                //$('#role').hide();
               
            });




</script>


@endsection