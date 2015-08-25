@extends('layouts.registration')

@section('head')
    Register as Client (Company)
@stop

@section('head-contents')
    <script>
        function enableSubmit(val){
            var sbmt = document.getElementById("submitForm");
            if (val.checked){
                sbmt.disabled = false;
            }
            else{
                sbmt.disabled = true;
            }
        }
        /*
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
        */
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
                                <div class="form-group">
                                    <label class="control-label">Company Name</label>
                                    {{ Form::text('companyName', Input::old('companyName'), array('data-name' => 'Company Name', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter company name', 'required' => 'true')) }}
                                </div><br/>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Nature of Business</label>
                                        {{ Form::text('businessNature', Input::old('businessNature'), array('data-name' => 'Business Nature', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter nature of business', 'required' => 'true')) }}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Years in Operation</label>
                                        {{Form::number('operationYears', Input::old('operationYears'), array('data-name' => 'Years in Operation', 'class' => 'inputItem form-control', 'placeholder' => 'Please input years in operation', 'min' => '0', 'required' => 'true'))}}
                                    </div>
                                </div><br/>
                                <div class="form-group">
                                    <label class="control-label">Business Description</label>
                                    {{ Form::text('businessDescription', Input::old('businessDescription'), array('data-name' => 'Business Description', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business description', 'required' => 'true')) }}
                                </div><br/>
                                <div class="form-group">
                                    <label class="control-label">Business Address</label>
                                    {{ Form::text('address', Input::old('address'), array('data-name' => 'Company Address', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter company address', 'required' => 'true')) }}
                                </div><br/>
                                <div class="form-group">
                                    <label class="control-label">Business Number</label>
                                    {{ Form::text('businessNum', Input::old('businessNum'), array('data-name' => 'Business Number', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business number', 'required' => 'true')) }}
                                </div><br/>
                                <div class="form-group">
                                    <label class="control-label">Key Contact Person</label>
                                    <div class="row">
                                        <div class="col-md-7" style="margin-bottom: 2px;">
                                            {{ Form::text('firstName-keyperson', Input::old('firstName-keyperson'), array('data-name' => 'Point Person First Name', 'class' => 'form-control inputItem', 'placeholder' => 'First name', 'required' => 'true')) }}
                                        </div>
                                        <div class="col-md-5">
                                            {{ Form::text('lastName-keyperson', Input::old('lastName-keyperson'), array('data-name' => 'Point Person Last Name', 'class' => 'form-control inputItem', 'placeholder' => 'Last name', 'required' => 'true')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Position</label>
                                    {{ Form::text('position-keyperson', Input::old('position-keyperson'), array('data-name' => 'Point Person Position', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter position', 'required' => 'true')) }}
                                </div><br/>
                                <div class="form-group">
                                    <label class="control-label">SEC/DTI Registration Number</label>
                                    {{ Form::text('regNum', Input::old('regNum'), array('data-name' => 'Registration Number', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter SEC/DTI Registration Number', 'required' => 'true')) }}
                                </div><br/>
                                <div class="form-group">
                                    <label class="control-label">Email Address</label>
                                    {{ Form::text('email', Input::old('email'), array('id' => 'email', 'data-name' => 'Email', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter email address', 'required' => 'true')) }}
                                </div><br/>
                                <hr>
                                <h5>Account Information</h5>
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter username', 'required' => 'true')) }}
                                </div><br/>
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter password', 'required' => 'true')) }}
                                    <div class="col-md-4" id="strengthDisplay"></div>
                                </div><br/>
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'class' => 'form-control inputItem', 'placeholder' => 'Re-type password', 'required' => 'true')) }}
                                </div><br/>
                                <div class="row form-group">
                                    <label class="control-label col-md-2">Terms of Service</label>
                                    <div class="col-md-10">
                                        {{ Form::checkbox('TOS', '1', array('class' => 'form-control'));}}
                                    </div>
                                </div><br/>
                                <br/>
                                <button onclick="$('#registrationForm-comp').submit()" class="btn btn-primary" type="submit" id="submitForm">Register</button>
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