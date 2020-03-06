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
                <h3 class="panel-title"><center>CATEGORIES</center></h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal " method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="operation" value="ajouter" id="operation">
                    <input type="hidden" name="id" id="id">
                    

                    @if(!empty($bon))
                            @if($bon)
                                <div class="form-group">
                                   <div class="alert alert-success alert-dismissable fade in">
                                        <i class="icon icon_check_alt icon-lg"></i>
                                        <strong>Reussit:</strong> Enregistrement reussit.
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                   <div class="alert alert-danger alert-dismissable fade in">
                                        <i class="icon icon_check_alt icon-lg"></i>
                                        <strong>Echec !</strong> Enregistrement echoué.
                                    </div>
                                </div>
                            @endif
                        @endif



                    <div class="form-group">
                        <label class="col-sm-6 control-label">Libelle:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="libelle" id="libelle" required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="col-sm-10 btn btn-primary col-sm-offset-2" type="submit">Enregistrer</button>
                        <button class="col-sm-10 btn btn-danger col-sm-offset-2" type="reset">Annuler</button>
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
                <h2><center>LISTE DES CATEGORIES</center></h2>
            </div>
            <div class="panel panel-body">
                <table class="table table-striped table-advance table-hover">
                    <tbody>
                        <thead>
                            
                            <tr>
                                <th>#Numero</th>
                                <th><i class="icon_profile"></i>Libelle</th>
                                
                                <th><i class="icon_mail_alt"></i> Opérations</th>
                            </tr>
                        </thead>


                        @if(!empty($categories))
                      @foreach($categories as $cat)
                        <tr id="{{$cat->ID}}">

                            <td>{{$loop->index +1}}</td>
                            <td data-role="libelle" data-target="libelle">{{$cat->LIBELLE}}</td>
                        

                            <td>
                                <div class="btn btn-group">
                                    <a class="btn btn-success edit" href="#" value="{{$cat->ID}}" id="editer {{$cat->ID}}"  data-id="{{$cat->ID}}" data-role="editer"><i class="icon icon-edit"></i></a>

                                    <a class="btn btn-danger delete"  value="{{$cat->ID}}" id="delete {{$cat->ID}}"  data-role="delete" data-id="{{$cat->ID}}" data-toggle="modal" href="#modalSupprimer" ><i class="icon icon-times-circle"></i></a>
                                    <a class="btn btn-primary infos"  value="{{$cat->ID}}" id="detail {{$cat->ID}}"  data-role="detail" data-id="{{$cat->ID}}" ><i class="icon icon-info-circle"></i></a>
                                </div>
                            </td>

                            @endforeach
                            @endif

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    

    $(document).on('click','a[data-role=editer]',function(){

                var id=$(this).data('id');
                var libelle=$('#'+id).children('td[data-target=libelle]').text();
                $('#libelle').val(libelle);
                $('#id').val(id);
                $('#operation').val('update');
            }
            );

</script>


@endsection
