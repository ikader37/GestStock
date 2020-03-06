@extends('layout/applicationLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST">
                    	
                       {{csrf_field()}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                        
                        <div class="form-group">
                            <label for="email" class="col-md-12 control-label">Nom d'utilisateur</label>

                            <div class="col-md-12">
                                <input id="username" type="text" class="form-control" name="username" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-12 control-label">Password</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    Se connecter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection