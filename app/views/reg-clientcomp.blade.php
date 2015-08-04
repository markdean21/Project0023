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

            locationChain($('#region-comp'), $('#city-comp'),$('#registrationForm-comp'), '/chainRegion');
            locationChain($('#region-comp'), $('#province-comp'),$('#registrationForm-comp'), '/chainProvince');
            locationChain($('#city-comp'), $('#barangay-comp'),$('#registrationForm-comp'), '/chainCity');
    //        locationChain($('#region'), $('#city'),$('#registrationForm'), '/chainRegion');
    //        locationChain($('#region'), $('#province'),$('#registrationForm'), '/chainProvince');
    //        locationChain($('#city'), $('#barangay'),$('#registrationForm'), '/chainCity');
        });
    </script>
@stop

@section('content')
    <div class="taskminator-form">
        <h3 style="text-align:center">Client Registration (Company)</h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="heading" style="padding: 40px 60px">
                        <i class="icon-reorder"></i>Company Information
                    </div>
                    <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">
                        <div class="client-form-comp">
                            @if(Session::has('errorMsg'))
                                <font color="red">{{ Session::get('errorMsg') }}</font>
                            @endif
                            {{ Form::open(array('url' => '/doRegisterComp', 'id' => 'registrationForm-comp')) }}
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Company Name</label>
                                    <div class="col-md-10">
                                        {{ Form::text('companyName', Input::old('companyName'), array('data-name' => 'Company Name', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter company name', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Company Address</label>
                                    <div class="col-md-10">
                                        {{ Form::text('address', Input::old('address'), array('data-name' => 'Company Address', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter company address', 'required' => 'true')) }}
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
                                        {{ Form::text('email', Input::old('email'), array('id' => 'email', 'data-name' => 'Email', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter email address', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Business Number</label>
                                    <div class="col-md-10">
                                        {{ Form::text('businessNum', Input::old('businessNum'), array('data-name' => 'Business Number', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business name', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Business Nature</label>
                                    <div class="col-md-10">
                                        {{ Form::text('businessNature', Input::old('businessNature'), array('data-name' => 'Business Nature', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business nature', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Business Description</label>
                                    <div class="col-md-10">
                                        {{ Form::text('businessDescription', Input::old('businessDescription'), array('data-name' => 'Business Description', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business description', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Business Permit</label>
                                    <div class="col-md-10">
                                        {{ Form::text('businessPermit', Input::old('businessPermit'), array('data-name' => 'Business Permit', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter DTI/SEC Business Permit No.', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Region</label>
                                    <div class="col-md-10">
                                        <select name="region-comp" id="region-comp" class="form-control inputItem" required="required" data-name="Region">
                                            @foreach($regions as $region)
                                                <option data-regcode="{{ $region->regcode }}" value="{{ $region->regcode }}" <?php if(Input::old('region-comp') == $region->regcode){ echo('selected'); } ?>> {{ $region->regname }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><br/>
<!--                                <div class="row form-group">-->
<!--                                    <label class="control-label col-md-2">Province</label>-->
<!--                                    <div class="col-md-10">-->
<!--                                        <select name="province-comp" id="province-comp" class="form-control">-->
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div><br/>-->
                                <div class="row form-group">
                                    <label class="control-label col-md-2">City</label>
                                    <div class="col-md-10">
                                        <select name="city-comp" id="city-comp" class="form-control inputItem" required="required" data-name="City">
                                            @if(Input::old('region-comp'))
                                                @foreach(City::where('regcode', Input::old('region-comp'))->orderBy('cityname', 'ASC')->get() as $city)
                                                    <option value="{{ $city->citycode }}" <?php if(Input::old('city-comp') == $city->citycode){ echo('selected'); } ?>>{{ $city->cityname }}</option>
                                                @endforeach
                                            @else
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->citycode }}" <?php if(Input::old('city-comp') == $city->citycode){ echo('selected'); } ?>>{{ $city->cityname }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Barangay</label>
                                    <div class="col-md-10">
                                        <select name="barangay-comp" id="barangay-comp" class="form-control inputItem" required="required" data-name="Barangay">
                                            @if(Input::old('city-comp'))
                                                @foreach(Barangay::where('citycode', Input::old('city-comp'))->orderBy('bgyname', 'ASC')->get() as $bgy)
                                                    <option value="{{$bgy->bgycode}}" <?php  if(Input::old('barangay-comp') == $bgy->bgycode){ echo('selected'); } ?>>{{ $bgy->bgyname }}</option>
                                                @endforeach
                                            @else
                                                @foreach($barangays as $bgy)
                                                    <option value="{{$bgy->bgycode}}" <?php  if(Input::old('barangay-comp') == $bgy->bgycode){ echo('selected'); } ?>>{{ $bgy->bgyname }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div><br/>
                                <hr/>
                                <h5>Key Person Info</h5>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">First Name</label>
                                    <div class="col-md-10">
                                        {{ Form::text('firstName-keyperson', Input::old('firstName-keyperson'), array('data-name' => 'Point Person First Name', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter first name', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Middle Name</label>
                                    <div class="col-md-10">
                                        {{ Form::text('midName-keyperson', Input::old('midName-keyperson'), array('data-name' => 'Point Person Middle Name', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter middle name', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Last Name</label>
                                    <div class="col-md-10">
                                        {{ Form::text('lastName-keyperson', Input::old('lastName-keyperson'), array('data-name' => 'Point Person Last Name', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter last name', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Email Address</label>
                                    <div class="col-md-10">
                                        {{ Form::text('email-keyperson', Input::old('email-keyperson'), array('data-name' => 'Point Person Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter email address', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Mobile Number</label>
                                    <div class="col-md-10">
                                        {{ Form::text('mobileNum-keyperson', Input::old('mobileNum-keyperson'), array('data-name' => 'Point Person Mobile Number', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter mobile number', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Position</label>
                                    <div class="col-md-10">
                                        {{ Form::text('position-keyperson', Input::old('position-keyperson'), array('data-name' => 'Point Person Position', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter position', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <hr/>
                                <h5>Account Information</h5>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Username</label>
                                    <div class="col-md-10">
                                        {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter username', 'required' => 'true')) }}
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Password</label>
                                    <div class="col-md-6">
                                        {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter password', 'required' => 'true')) }}
                                    </div>
                                    <div class="col-md-4" id="strengthDisplay">
                                    </div>
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Confirm Password</label>
                                    <div class="col-md-10">
                                        {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'class' => 'form-control inputItem', 'placeholder' => 'Re-type password', 'required' => 'true')) }}
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
                <button onclick="$('#registrationForm-comp').submit()" class="btn btn-primary" id="confirmBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>
@stop