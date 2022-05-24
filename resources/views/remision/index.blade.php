@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Remisiones') }}</div>
                <div class="card-body"> 
                    <div id="app">
                        <create-remision :drivers="{{$drivers}}"></create-remision>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <br>
                  <view-remision :drivers="{{$drivers}}"></view-invoice>

                          



                 {{--    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Lote</th>
                                <th>Remision</th>
                                <th>Chofer</th>
                                <th>Producto</th>
                                <th  width="16%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($remisiones as $rem)
                            <tr>
                                <th scope="row">{{$rem->id}}</th>
                                <td>
                                    <a href="{{route('remision.show',$rem)}}">{{$rem->lote}}</a>
                                </td>
                                <td>{{$rem->remision}}</td>
                                <td>{{$rem->chofer}}</td>
                                <td>{{$rem->producto}}</td>
                                <td>
                                    {!! Form::open(['route'=>['remision.destroy',$rem], 'method'=>'DELETE']) !!}
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a class="btn btn-warning" href="/download-pdf/{{$rem->id}}" target="_blank" title="Editar">
                                            <i class="fa fa-print"></i>
                                            </a>
                                        </div>

                                        <div class="col-md-3">
                                            <a class="btn btn-secondary" href="/get-all-remisiones/{{$rem->id}}" target="_blank" title="Editar">
                                            <i class="fa fa-qrcode"></i>
                                            </a>
                                        </div>

                                        <div class="col-md-3">
                                            <a class="btn btn-info" href="{{route('remision.edit', $rem)}}" title="Editar">
                                            <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-danger" type="submit" title="Eliminar">
                                            <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                        {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@push('script')
<script type="text/javascript" src="{{ url('js/remision.js') }}"></script>
@endpush