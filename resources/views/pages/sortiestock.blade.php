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


            @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="icon icon-minus-circle">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

	        <div class="panel panel-primary">
	            <div class="panel-heading">
	                <h3 class="panel-title"><center>SORTIES DE STOCK</center></h3>
	            </div>
	            <div class="panel-body">
	            	 <form class="form-horizontal " method="POST">
	                    {{csrf_field()}}
                    	<input type="hidden" name="_token" value="{{csrf_token()}}">

                    	<input type="hidden" name="operation" value="ajouter" id="operation" name="operation">


                    	@if(!empty($bon))
                            @if($bon)
                                <div class="form-group">
                                   <div class="alert alert-success alert-dismissable fade in">
                                        <i class="icon icon-check icon-lg"></i>
                                        <strong>Reussit:</strong> Opération reussit.
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                   <div class="alert alert-danger alert-dismissable fade in">
                                        <i class="icon icon-minus-circle icon-lg"></i>
                                        <strong>Echec !</strong> Opération echoué.
                                    </div>
                                </div>
                            @endif
                        @endif


                        @if(!empty($bol))
                            @if($bol==0)
                            	<div class="form-group">
                                   <div class="alert alert-danger alert-dismissable fade in">
                                        <i class="icon icon_check_alt icon-lg"></i>
                                        <strong>Echec !</strong> La quantité saisie est incorrecte
                                    </div>
                                </div>
                           
                            @endif
                        @endif



	                    <div class="form-group">
	                        <label class="col-sm-6 control-label">Articles:</label>
	                        <div class="col-sm-18">
	                          <select name="id" id="id">
	                          	@if(!empty($articles))
		                          	@foreach($articles as $article)
		                          		<option value="{{$article->ID}}">{{$article->DESIGNATION  }} {{ $article->QUANTITE}}</option>
		                          	@endforeach
	                          	@endif
	                          </select>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label class="col-sm-6 control-label">Quantité sortante:</label>
	                        <div class="col-sm-10">
	                          <input type="number" class="form-control" name="quantite" required="true">
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <button class="col-sm-10 btn btn-primary col-sm-offset-2" type="submit"><i class="icon icon-check-circle"></i> Enregistrer</button>
	                        <button class="col-sm-10 btn btn-danger col-sm-offset-2" type="reset"><i class="icon icon-times-circle"></i> Annuler</button>
	                    </div>
		            </form>

	            </div>
	        </div>
	    </div>
	</div>




<div class="row">
    <div class="col-lg-20 col-lg-offset-3">
        <div class="panel panel-success">
            <div class="panel panel-heading">
                <h2><center>LES SORTIES DU STOCK</center></h2>
            </div>
            <div class="panel panel-body">
                <table class="table table-striped table-advance table-hover">
                    <tbody>
                        <thead>
                            
                            <tr>
                                <th><i class="icon_profile"></i>#</th>
                                <th><i class="icon_adress"></i> Désignation</th>
                                <th><i class="icon_mail_alt"></i> Quantité sortie</th>
                                <th><i class="icon_mail_alt"></i>Date de sortie </th>
                                
                                <th>Opérations</th>
                            </tr>
                        </thead>


                        @if(!empty($vendres))
                      @foreach($vendres as $vente)
                        <tr id="{{$vente->ID}}">

                            <td>{{$loop->index +1}}</td>
                            <td data-role="designation" data-target="designation">{{$vente->DESIGNATION}}</td>
                            <td data-role="quantite" data-target="quantite">{{$vente->QUANTITE}}</td>
                            <td data-role="date_sortie" data-target="date_sortie">{{$vente->DATE_SORTIE}}</td>
                            

                            <td>
                                <div class="btn btn-group">
                                    <a class="btn btn-success edit" href="#" value="{{$vente->ID}}" id="editer {{$vente->ID}}"  data-id="{{$vente->ID}}" data-role="editer"><i class="icon icon-edit"></i></a>

                                    <a class="btn btn-danger delete"  value="{{$vente->ID}}" id="delete {{$vente->ID}}"  data-role="delete" data-id="{{$vente->ID}}" data-toggle="modal" href="#modalSupprimer" ><i class="icon icon-times-circle"></i></a>
                                    <!--<a class="btn btn-primary infos"  value="{{$vente->ID}}" id="detail {{$vente->ID}}"  data-role="detail" data-id="{{$vente->ID}}" ><i class="icon icon-info-circle"></i></a>
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
                <form class="form-horizontal" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="operation2" id="operation2" value="delete">
                    <input type="hidden" name="idasupprimer" id="idasupprimer">
                    <p id="messageSupprimer">Voulez-vous supprimer </p>
                    <button type="submit" class="bn btn-primary"><i class="icon_trash_alt"></i> Supprimer</button>
                    <button type="reset" class="btn btn-inverse" data-dismiss="modal" id="reset"><i class="icon icon-times icon-lg"></i> Fermer</button>
                </form>
                
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	

	$(document).on('click','a[data-role=delete]',function(){
        var id=$(this).data('id');
        console.log('ID A SUPPRIMER'+id);
        $('#idasupprimer').val(id);
        //alert(idheureDepart);

        $('#operation2').val('delete');
        var designation=$('#'+id).children('td[data-target=designation]').text();
        var quantite=$('#'+id).children('td[data-target=quantite]').text();
        //var tra=$('#'+idheureDepart).children('td[data-target=intituletrajet]').text();

        $('#messageSupprimer').value="";
        $('#messageSupprimer').append("l\'employé "+designation+" "+quantite+"?");
    });

    $(document).on('click','#reset',function(){
    	$('#messageSupprimer').value="";
    	$('#idasupprimer').value="";
    	$('#operation2').val('delete');

    });


    $(document).on('click','a[data-role=editer]',function(){

        		var id=$(this).data('id');//Recuperer le id du trajet qui se trouve dans le button qui declanche l'action
        		
        		var quantite=$('#'+id).children('td[data-target=quantite]').text();
        		var desi=$('#'+id).children('td[data-target=designation]').text();
        		//alert(heuredepart);
        		$('#quantite').val(heuredepart);
        		$('#designation').val(desi);
        	});

</script>
@endsection