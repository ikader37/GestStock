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
                <h3 class="panel-title"><center>GESTION DES ARTICLES</center></h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal " method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="operation" value="ajouter" id="operation">
                    <input type="hidden" name="idUp"  id="idUp">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="icon icon-minus-circle">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!empty($bon))
                            @if($bon)
                                <div class="form-group">
                                   <div class="alert alert-success alert-dismissable fade in">
                                        <i class="icon icon-check"></i>
                                        <strong>Reussit:</strong> Enregistrement reussit.
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                   <div class="alert alert-danger alert-dismissable fade in">
                                        <i class="icon icon-info"></i>
                                        <strong>Echec !</strong> Enregistrement echoué.
                                    </div>
                                </div>
                            @endif
                        @endif



                  <div class="form-group">
                        <label class="col-sm-6 control-label">Designation:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control"  name="designation" id="designation" value="{{old('designation')}}" required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Prix unitaire:</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="prix_unit" id="prix_unit" required="true" value="{{old('prix_unit')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Quantité:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="quantite" name="quantite" required="true" value="{{old('quantite')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label">Categorie:</label>
                        <div class="col-sm-10">
                          <select value="{{old('categorie')}}" name="categorie" id="categorie">
                              @foreach($categorie as $a) 
                                <option value="{{$a->ID}}">
                                   {{$a->LIBELLE}} 
                                </option>
                              @endforeach
                          </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label">Fournisseur:</label>
                        <div class="col-sm-10">
                          <select name="fournisseur" id="fournisseur">
                              @foreach($fournisseurs as $four)
                                <option value="{{$four->ID}}">{{$four->NOM  }} {{$four->PRENOM}} {{$four->ADRESSE}}  {{$four->TELEPHONE}}</option>
                                @endforeach
                          </select>
                        </div>
                    </div>

                    <div class="form-group ">
                        <button class="col-sm-5 btn btn-primary col-sm-offset-5" type="submit"><i class="icon icon-check-circle"></i>Enregistrer</button>
                        <button class="col-sm-5 btn btn-danger col-sm-offset-2" type="reset"><i class="icon icon-times-circle"></i>Annuler</button>
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
                <h3><center>LISTE DES ARTICLES</center></h3>
            </div>
            <div class="panel panel-body">
                <table class="table table-striped table-advance table-hover">
                    <tbody>
                        <thead>
                            
                            <tr>
                                <th>#Numero</th>
                                <th><i class="icon_profile"></i>Désignation</th>
                                <th><i class="icon_adress"></i> Prix unitaire</th>
                                <th><i class="icon_mail_alt"></i> Quantité</th>
                                <th><i class="icon_mail_alt"></i> Opérations</th>
                            </tr>
                        </thead>


                        @if(!empty($articles))
                      @foreach($articles as $ar)
                        <tr id="{{$ar->ID}}">

                            <td>{{$loop->index +1}}</td>
                            <td data-role="designation" data-target="designation">{{$ar->DESIGNATION}}</td>
                            <td data-role="prix_unit" data-target="prix_unit">{{$ar->PRIX_UNITAIRE}}</td>
                            <td data-role="quantite" data-target="quantite">{{$ar->QUANTITE}}</td>

                            <td>
                                <div class="btn btn-group">
                                    <a class="btn btn-success editer" value="{{$ar->ID}}" id="editer {{$ar->ID}}"  data-id="{{$ar->ID}}" data-role="editer"><i class="icon icon-edit"></i></a>

                                    <a class="btn btn-danger delete"  value="{{$ar->ID}}" id="delete {{$ar->ID}}"  data-role="delete" data-id="{{$ar->ID}}" data-toggle="modal" href="#modalSupprimer" ><i class="icon icon-times-circle"></i></a>
                                    <!--<a class="btn btn-primary infos"  value="{{$ar->ID}}" id="detail {{$ar->ID}}"  data-role="detail" data-id="{{$ar->ID}}" ><i class="icon icon-info-circle"></i></a>
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
                    <button type="submit" class="bn btn-primary"><i class="icon icon-trash-o"></i> Supprimer</button>
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

   

    $(document).on('click','a[data-role=delete]',function(){
        var id=$(this).data('id');
        console.log('ID A SUPPRIMER'+id);
        $('#idasupprimer').val(id);
        //alert(idheureDepart);

        $('#operation2').val('delete');
        var designation=$('#'+id).children('td[data-target=designation]').text();
        //var prenom=$('#'+id).children('td[data-target=prenom]').text();
        //var tra=$('#'+idheureDepart).children('td[data-target=intituletrajet]').text();

        $('#messageSupprimer').value="";
        $('#messageSupprimer').append("l\'employé "+designation+" ?");
    });


    $(document).on('click','a[data-role=editer]',function(){

                var id=$(this).data('id');//Recuperer le id du trajet qui se trouve dans le button qui declanche l'action
               
                var designation=$('#'+id).children('td[data-target=designation]').text();
                var quantite=$('#'+id).children('td[data-target=quantite]').text();
                var prix=$('#'+id).children('td[data-target=prix_unit]').text();
                
                
                $('#designation').val(designation);
                $('#quantite').val(quantite);
                $('#prix_unit').val(prix);
                $('#idUp').val(id);
                $('#operation').val('update');
                //alert(designation);

                
               
            });

</script>

@endsection