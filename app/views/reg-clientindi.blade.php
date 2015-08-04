@extends('layouts.registration')

@section('head')
    Register as Client (Individual)
@stop

@section('head-contents')
    <script>
        $(document).ready(function(){
            $('#submitForm').click(function(event){
                event.preventDefault();
                var inputs = $('.inputItem'),
                    missingInputs = '',
                    trigger = false;

                for(var x=0; x < inputs.size(); x++){
                    if(inputs.eq(x).val() == ''){
                        trigger = true;
                        break;
                    }
                }

                if(trigger){
                    for(var i=0; i < inputs.size(); i++){
                        if(inputs.eq(i).val() == ''){
                            missingInputs += '- '+inputs.eq(i).attr('data-name')+'<br/>';
                        }
                    }

                    $('#confirmBtn').prop('disabled', true);
                    $('#emailConfirm').empty();
                    $('#confirmMsg').empty().append('Please fill up necessary information first<br/>'+missingInputs);
                }else{
                    $('#confirmBtn').prop('false', true);
                    $('#confirmMsg').empty().append('Please confirm your email information before proceeding (This email will recieve necessary updates and notifications)');
                    $('#emailConfirm').empty().append('<i class="se7en-envelope"></i> '+$('#email').val());
                }

                $('#confirmModal').modal('show');
            });


            locationChain($('#region'), $('#city'),$('#registrationForm'), '/chainRegion');
            locationChain($('#region'), $('#province'),$('#registrationForm'), '/chainProvince');
            locationChain($('#city'), $('#barangay'),$('#registrationForm'), '/chainCity');
        });
    </script>
@stop

@section('content')
    <div class="taskminator-form">
        <h3 style="text-align:center">Client Registration (Individual)</h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="heading" style="padding: 40px 60px">
                        <i class="icon-reorder"></i>Personal Information
                    </div>
                    <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">
                        <div class="client-form-indi">
                            @if(Session::has('errorMsg'))
                            <font color="red">{{ Session::get('errorMsg') }}</font>
                            @endif
                            {{ Form::open(array('url' => '/doRegisterIndi', 'id' => 'registrationForm')) }}
                                <div class="row form-group">
                                    <label class="control-label col-md-2">First Name</label>
                                    <div class="col-md-10">
                                        {{ Form::text('firstName', Input::old('firstName'), array('data-name' => 'First Name', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter first name', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Middle Name</label>
                                    <div class="col-md-10">
                                        {{ Form::text('midName', Input::old('midName'), array('data-name' => 'Middle Name', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter middle name', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Last Name</label>
                                    <div class="col-md-10">
                                        {{ Form::text('lastName', Input::old('lastName'), array('data-name' => 'Last Name', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter last name', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Address</label>
                                    <div class="col-md-10">
                                        {{ Form::text('address', Input::old('address'), array('data-name' => 'Address', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter address', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Gender</label>
                                    <div class="col-md-10">
                                        <select name="gender" required="required" class="form-control inputItem" data-name="Gender">
                                            <option value="MALE">Male</option>
                                            <option value="FEMALE">Female</option>
                                        </select>
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Mobile Number</label>
                                    <div class="col-md-10">
                                        {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter mobile number', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Email Address</label>
                                    <div class="col-md-10">
                                        {{ Form::text('email', Input::old('email'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter email address', 'required' => 'true', 'id' => 'email')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Facebook</label>
                                    <div class="col-md-10">
                                        {{ Form::text('facebook', Input::old('facebook'), array('data-name' => 'Facebook', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter link to Facebook account', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">LinkedIn</label>
                                    <div class="col-md-10">
                                        {{ Form::text('linkedin', Input::old('linkedin'), array('data-name' => 'LinkedIn', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter link to LinkedIn account', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Region</label>
                                    <div class="col-md-10">
                                        <select name="region" id="region" class="form-control inputItem" data-name="Region">
                                            @foreach($regions as $region)
                                                <option data-regcode="{{ $region->regcode }}" value="{{ $region->regcode }}">{{ $region->regname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><br/>
<!--                                <div class="row form-group">-->
<!--                                    <label class="control-label col-md-2">Province</label>-->
<!--                                    <div class="col-md-10">-->
<!--                                        <select name="province" id="province" class="form-control">-->
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div><br/>-->
                                <div class="row form-group">
                                    <label class="control-label col-md-2">City</label>
                                    <div class="col-md-10">
                                        <select name="city" id="city" class="form-control inputItem" data-name="City">
                                            @if(Input::old('region'))
                                                @foreach(City::where('regcode', Input::old('region'))->orderBy('cityname', 'ASC')->get() as $city)
                                                    <option value="{{ $city->citycode }}" <?php if(Input::old('city') == $city->citycode){ echo('selected'); } ?>>{{ $city->cityname }}</option>
                                                @endforeach
                                            @else
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->citycode }}" <?php if(Input::old('city') == $city->citycode){ echo('selected'); } ?>>{{ $city->cityname }}</option>
                                                @endforeach
                                            @endif

                                            @foreach($cities as $city)
                                                <option value="{{ $city->citycode }}" <?php if(Input::old('city') == $city->citycode){ echo('selected'); } ?>>{{ $city->cityname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Barangay</label>
                                    <div class="col-md-10">
                                        <select name="barangay" id="barangay" class="form-control inputItem" data-name="Barangay">
                                            @if(Input::old('city'))
                                                @foreach(Barangay::where('citycode', Input::old('city'))->orderBy('bgyname', 'ASC')->get() as $bgy)
                                                    <option value="{{$bgy->bgycode}}" <?php  if(Input::old('barangay') == $bgy->bgycode){ echo('selected'); } ?>>{{ $bgy->bgyname }}</option>
                                                @endforeach
                                            @else
                                                @foreach($barangays as $bgy)
                                                    <option value="{{$bgy->bgycode}}" <?php  if(Input::old('barangay') == $bgy->bgycode){ echo('selected'); } ?>>{{ $bgy->bgyname }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div><br/>
                                <hr/>
                                <h6>Account Information</h6>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Username</label>
                                    <div class="col-md-10">
                                        {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter username', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Password</label>
                                    <div class="col-md-6">
                                        {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter password', 'required' => 'true')) }}
                                    </div>
                                    <div class="col-md-4" id="strengthDisplay">
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Confirm Password</label>
                                    <div class="col-md-10">
                                        {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'class' => 'inputItem form-control', 'placeholder' => 'Re-type password', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Terms of Service</label>
                                    <div class="col-md-10">
                                        {{ Form::checkbox('TOS', '1', array('class' => 'form-control'));}}
                                    </div>
                                </div><br/>
                                <br/>
                                <button class="btn btn-primary" type="submit" id="submitForm">Register</button>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm Email</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin: 0;">
                    <span id="confirmMsg">Please confirm your email information before proceeding (This email will recieve necessary updates and notifications)</span>
                    <p id="emailConfirm" style="font-size: 1.5em; margin-top: 2em;"></p>
                </div>
            </div>
            <div class="modal-footer" style="margin: 0; padding: 0.8em;">
                <button data-dismiss="modal" class="btn btn-danger">Cancel</button>
                <button onclick="$('#registrationForm').submit()" class="btn btn-primary" id="confirmBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>
@stop