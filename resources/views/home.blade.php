@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Computers') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href='/computer/create'><i class="fa fa-plus"></i>&nbsp;Add a device</a>
                    <br/>
					<ul>
						@foreach (Auth::user()->computers as $computer)
							<li>
                                <a href="/computer/{{$computer->id}}/edit" class="pointer" title="Remove">
                                   {{$computer->name}}
                                </a>
                                -
                                <a target="_blank" href="{{$computer->genUrl()}}">{{$computer->genUrl()}}</a>
                                &nbsp;&nbsp;&nbsp;
                                {!! Form::open(['method' => 'DELETE', "style"=>"display:inline",'route' => ['computer.destroy', $computer->id]]) !!}
									<a href="#" class="pointer" title="Remove" onclick="if (confirm('Confirm remove this computer ?')){$(this).parent().submit();}"><i class="fa fa-trash"></i></a>
								{!! Form::close() !!}
							</li>
						@endforeach
					</ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
