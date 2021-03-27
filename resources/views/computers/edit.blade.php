@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row clearfix">
		<div class="col-lg-12">
			<div class="card">
				<div class="body card-header">
					<div class="row">
						<div class="col-lg-6 col-md-8 col-sm-12">
							<h2>Computers</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="card">
                    <div class="card-body">
                        {!! Form::model($computer, ['route' => ['computer.update', $computer->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="col-md-4 control-label">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{$computer->name}}" required />

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                    <br/>
                                    @include('map', [$latitude, $longitude])
                                </div>

                                <div class="col-md-6">
                                    <h5>Last connections:</h5>
                                    @foreach($connections as $connection)
                                        <li>
                                            {{ $connection->created_at }}
                                            <ul>
                                                @foreach (json_decode($connection->info,true) as $key=>$value)
                                                    <li>{{$key}} : {{$value}}</li>
                                                @endforeach
                                            </ul>
                                            <hr/>
                                        </li>
                                    @endforeach
                                </div>
                            </div>

                            <br/>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Save
                                        </button>

                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
