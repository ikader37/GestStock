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

@endsection