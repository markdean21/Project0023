@extends('layouts.main')

@section('head')
    View Client
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
	<div class="page-title">
        <h1>
            Task Details
        </h1>
    </div>
    <div class="row">
    	<div class="col-md-8">
            <div class="widget-container" style="min-height: 150px; padding-bottom: 5px; padding-top: 20px;">
                <div class="widget-content padded">
					<h4>{{ $client->fullName }}</h4>
					<span style="color: grey; font-size: 1em">
						Address 
					</span>: 
					<span style="margin-left: 5px">{{ $client->address }}</span><br/>
					<span style="color: grey; font-size: 1em">
						City 
					</span>: 
					<span style="margin-left: 5px">{{ City::where('citycode', $tm->city)->pluck('cityname') }}</span><br/>
					<span style="color: grey; font-size: 1em">
						Barangay 
					</span>: 
					<span style="margin-left: 5px">{{ Barangay::where('bgycode', $tm->barangay)->pluck('bgyname') }}</span><br/>

					@if(Task::where('user_id', Auth::user()->id)->where('status', 'OPEN')->where('hiringType', 'DIRECT')->count() > 0)
						<br/><a href="/directHire_{{ $tm->id }}" class="btn btn-primary">Hire for Direct Task</a>
					@endif
				</div>
			</div>
		</div>
	</div>
@stop