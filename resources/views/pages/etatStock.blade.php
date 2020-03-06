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

        @if(!empty($bon))
            @if($bon)
                
                   <div class="alert alert-success alert-dismissable fade in ">
                        <i class="icon icon-check icon-lg"></i>
                        <strong>Reussit:</strong> Enregistrement reussit.
                    
                </div>
            @else
                
                   <div class="alert alert-danger alert-dismissable fade in ">
                        <i class="icon icon-minus-circle icon-lg"></i>
                        <strong>Echec !</strong> Enregistrement echoué.
                    
                </div>
            @endif
        @endif


    	@if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="icon icon-minus-circle">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
        <div class="panel panel-info">
            <div class="panel panel-heading">
                <h2><center>ETAT DU STOCK</center></h2>
            </div>

            


            <div class="panel panel-body table-responsive">
                <table class="table table-striped table-advance table-hover">
                    <tbody>
                        <thead>
                            
                            <tr>
                                <th>#Numero</th>
                                <th><i class="icon_profile"></i>Désignation</th>
                                <th><i class="icon_adress"></i> Prix unitaire</th>
                                <th><i class="icon_mail_alt"></i> Quantité</th>
                                <th><i class="icon_mail_alt"></i> Categorie</th>
                                <th><i class="icon_mail_alt"></i> Fournisseur</th>
                                <th><i class="icon_mail_alt"></i> Opérations</th>
                            </tr>
                        </thead>


                        @if(!empty($articles))
	                      @foreach($articles as $ar)

	                        <tr id="{{$ar->ID}}" class="@if($ar->QUANTITE<=5) danger @else @if($ar->QUANTITE<=10) warming @else @if($ar->QUANTITE>10) success @endif @endif @endif" >

	                            <td>{{$loop->index +1}}</td>
	                            <td data-role="designation" data-target="designation">{{$ar->DESIGNATION}}</td>
	                            <td data-role="prix_unit" data-target="prix_unit">{{$ar->PRIX_UNITAIRE}}</td>
	                            <td data-role="quantite" data-target="quantite">{{$ar->QUANTITE}}</td>
	                            <td data-role="categorie" data-target="categorie">{{$ar->LIBELLE}}</td>
	                            <td data-role="fournisseur" data-target="fournisseur">{{$ar->NOM }}  {{$ar->PRENOM}}</td>

	                            <td>
	                                <div class="btn btn-group">
	                                    <a class="btn btn-success edit" value="{{$ar->ID}}" id="editer {{$ar->ID}}"  data-id="{{$ar->ID}}" data-role="editer" data-toggle="modal" href="#myModal"><i class="icon icon-edit"></i>Renouveller</a>
	                                    
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


<!-- Modale -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-40">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">RENOUVELLER LE STOCK</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal " id="form" method="POST" >

                    {{csrf_field()}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="operation" value="renouveller" id="operation" name="operation">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Quantité:</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="quantite" id="quantite" required="true">
                        </div>
                    </div>

                    <br/>
                    <div class="form-group">
                        
                            <button class="col-sm-8 btn btn-primary col-sm-offset-2 icon icon-check-circle" type="submit" id="submit"> Valider</button>
                        
                            <button class="col-sm-8 btn btn-danger col-sm-offset-2 icon icon-repeat" type="reset" id="reset"> Reset</button>
                        
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).on('click','a[data-role=editer]',function(){
        var id=$(this).data('id');
        $('#id').val(id);
        //alert(id);

    });

    $(document).on('submit','#form',function(){
    	//alert("DDDD");
    	var q=$(this).getElementById('$quantite');
    	//alert(q);
    });

    function verifier() {

    	var q=document.getElementById('#quantite').value;
    	if(q==null || q<=0){
    		alert("La quantité doit être supérieure à 0 "+q);

    		return false;
    	}else{
    		console.log("BIEN");
    		return true;
    	}
    }


</script>
@endsection