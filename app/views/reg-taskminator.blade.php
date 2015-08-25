@extends('layouts.registration')

@section('head')
    Register as Taskminator
@stop

@section('head-contents')
    <script>
        function removeSkill(data){
            var dataId = $(data).attr('data-removeId');
//            alert($(data).attr('data-removeId'));
            $('#div_'+dataId).remove();
            $('#input_'+dataId).remove();
        }

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
                    $('#emailConfirm').empty().append('<i class="se7en-envelope"></i> '+$('#tskmntrEmail').val());
                }

                $('#confirmModal').modal('show');
            });
//            $('#submitForm').click(function(event){
//                event.preventDefault();
//
//
//                if($('#tskmntrEmail').val() == ''){
//                    $('#emailConfirm').empty();
//                    $('#confirmMsg').empty().append('Please fill up necessary information first');
//                }else{
//                    $('#confirmMsg').empty().append('Please confirm your email information before proceeding (This email will recieve necessary updates and notifications)');
//                    $('#emailConfirm').empty().append('<i class="se7en-envelope"></i> '+$('#tskmntrEmail').val());
//                }
//                $('#confirmModal').modal('show');
//            });

            locationChain($('#region-task'), $('#city-task'),$('#registrationForm-task'), '/chainRegion');
//            locationChain($('#region-task'), $('#province-task'),$('#registrationForm-task'), '/chainProvince');
            locationChain($('#city-task'), $('#barangay-task'),$('#registrationForm-task'), '/chainCity');

            $('#taskcategory').change(function(){
                $('#taskitems').empty();
                $.ajax({
                    type    :   'POST',
                    url     :   '/chainCategoryItems',
                    data    :   $('#registrationForm-task').serialize(),
                    success :   function(data){
                        $.each(data, function(key, value){
                            $('#taskitems').append('<option value="'+ value['itemcode'] +'">'+value['itemname']+'</option>');
                        });
                    },error :   function(){
                        alert('ERR500 : Please check network connectivity');
                    }
                })
            });

            $('#addSkillBtn').click(function(){
                var category = $('#taskcategory').find('option:selected').text(),
                    skill = $('#taskitems').find('option:selected').text(),
                    skillCode = $('#taskitems').val();

                if($('#div_'+skillCode).size() > 0){
                    alert('This skill has already been added.');
                }else{
                    var display = '<div id="div_'+skillCode+'" style="margin: 0;"><span data-removeId="'+skillCode+'" onclick="removeSkill(this)" class="glyphicon glyphicon-remove removeSkill" style="cursor:pointer; color: #3498DB; opacity: 1;"></span>&nbsp;&nbsp;&nbsp;'+category+' - '+skill+'</div>',
                        newSkillInput = '<input id="input_'+skillCode+'" type="hidden" name="skills[]" value="'+skillCode+'" />';

                    $('#addedSkills').append(display).append(newSkillInput);
                }
            })
        });
    </script>
@stop

@section('content')
<!--TASKMINATOR REGISTRATION FORM-->
<!--<div class="taskminator-form" style="display: none;">-->
<div class="taskminator-form">
    <h3 style="text-align:center">Seeker Information</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix">

                @if(Session::has('errorMsg'))
                    <div class="alert alert-danger">
                        {{ Session::get('errorMsg') }}
                    </div>
                @endif

                <div class="heading" style="padding: 40px 60px">
                    <i class="icon-reorder"></i>Personal Information
                </div>
                <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">

                    {{ Form::open(array('url' => '/doRegisterSeeker', 'id' => 'registrationForm-task')) }}
                        <div class="form-group">
                            <label class="control-label row" style="margin-left: 5px;">Name</label>
                            <div class="row">
                                <div class="col-md-4" style="margin-bottom: 2px;">
                                    {{ Form::text('firstName', Input::old('firstName'), array('data-name' => 'First Name', 'class' => 'inputItem form-control', 'placeholder' => 'First name', 'required' => 'true')) }}
                                </div>
                                <div class="col-md-3" style="margin-bottom: 2px;">
                                    {{ Form::text('midName', Input::old('midName'), array('data-name' => 'Middle Name', 'class' => 'inputItem form-control', 'placeholder' => 'Middle name', 'required' => 'true')) }}
                                </div>
                                <div class="col-md-5">
                                    {{ Form::text('lastName', Input::old('lastName'), array('data-name' => 'Last Name', 'class' => 'inputItem form-control', 'placeholder' => 'Last name', 'required' => 'true')) }}
                                </div>
                            </div>
                        </div><br/>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 5px;">Gender</label>
                                <select name="gender" required="required" class="form-control inputItem" data-name="Gender">
                                    <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 5px;">Nationality</label>
                                {{ Form::text('occupation', Input::old('nationality'), array('data-name' => 'Nationality', 'class' => 'inputItem form-control', 'placeholder' => 'Ex. Filipino', 'required' => 'true')) }}
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Birth Date</label>
                                <div class="row">
                                    <div class="col-md-4" style="margin-bottom: 2px;">
                                        {{ Form::selectMonth('month', Input::old('month'), array('data-name' => 'Month', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                                    </div>
                                    <div class="col-md-2" style="margin-bottom: 2px;">
                                        {{ Form::selectRange('date', 1, 31, Input::old('date'), array('data-name' => 'Date', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                                    </div>
                                    <div class="col-md-3" style="margin-bottom: 2px;">
                                        {{ Form::selectYear('year', 2015, 1955, Input::old('year'), array('data-name' => 'Year', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Mobile Number</label>
                                {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'inputItem form-control', 'placeholder' => 'Mobile number', 'required' => 'true')) }}
                            </div>
                        </div><br/>

                        <div class="row form-group">
                            <label class="control-label col-md-2">Preffered Job</label>
                            <div class="col-md-10">
                                {{ Form::text('address', Input::old('prefferedJob'), array('data-name' => 'Preffered Job', 'class' => 'form-control inputItem', 'placeholder' => 'Ex. Carpenter', 'required' => 'true')) }}
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 5px;">Experience</label>
                                 {{ Form::text('address', Input::old('experience'), array('data-name' => 'Experience', 'class' => 'form-control inputItem', 'placeholder' => 'Experiences', 'required' => 'true')) }}
                            
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 5px;">Rate</label>
                                {{ Form::text('occupation', Input::old('nationality'), array('data-name' => 'Nationality', 'class' => 'inputItem form-control', 'placeholder' => 'Rate', 'required' => 'true')) }}
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            <label class="control-label">Email Address</label>
                            {{ Form::text('email', Input::old('email'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Email address', 'required' => 'true', 'id' => 'email')) }}
                        </div><br/>
                                
                        <hr/>
                                
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'inputItem form-control', 'placeholder' => 'Username', 'required' => 'true')) }}
                        </div><br/>
                        
                        <div class="form-group">
                                    <label class="control-label">Password <h6>(minimum of 8 characters)</h6></label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter password', 'required' => 'true')) }}
                                        </div>
                                        <div class="col-md-7" id="strengthDisplay"></div>
                                    </div>
                                </div><br/>

                        <div class="form-group">
                            <label class="control-label">Confirm Password</label>
                            <div class="row">
                                <div class="col-md-5">
                                    {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'class' => 'inputItem form-control', 'placeholder' => 'Re-type password', 'required' => 'true')) }}
                                </div>
                                <div class="col-md-7"></div>
                            </div>
                        </div><br/>


                                <p>
                                    {{ HTML::image(URL::to('simplecaptcha'),'Captcha', array('class' => 'img-rounded')) }}<br><br>
                                    <label>CAPTCHA</label>
                                    {{ Form::text('captcha', '', array('data-name' => 'Captcha', 'class' => 'inputItem form-control', 'id' => 'captcha','placeholder' => 'Type code above', 'required' => 'true', 'style' => 'width: 130px;')) }}
                                </p>

                        <div class="form-group" style="margin-left: 5px;">
                            <input id="TOS" name="TOS" type="checkbox" value="1" onclick="enableSubmit(this)">
                            <label class="control-label" style="margin-left: 5px;">Terms of Service</label>
                        </div>
                        
                        <button class="btn btn-primary" type="submit" id="submitForm" onclick="$('#registrationForm').submit();" disabled>Register</button>
                                {{ Form::reset('Reset', array('class' => 'btn btn-default')) }}
                            {{ Form::close() }}



<!--                        <div class="row form-group">
                            <label class="control-label col-md-2">Educational Background</label>
                            <div class="col-md-10">
                                {{ Form::text('educationalBackground', Input::old('educationalBackground'), array('data-name' => 'Educational Background', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter educational attainment(s)', 'required' => 'true')) }}
                              
                            </div>
                        </div>
                        <br/>
-->
<!--                        <div class="row form-group">-->
<!--                            <label class="control-label col-md-2">Service Offered</label>-->
<!--                            <div class="col-md-10">-->
<!--                                {{ Form::text('serviceOffered', Input::old('serviceOffered'), array('class' => 'form-control', 'placeholder' => 'Please enter the service/s you can offer', 'required' => 'true')) }}-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <br/>-->
<!--                        <div class="row form-group">
                            <label class="control-label col-md-2">Gender</label>
                            <div class="col-md-10">
                                <select name="gender" required="required" class="form-control inputItem">
                                    <option value="MALE" <?php if(Input::old('gender') == 'MALE'){ echo('selected'); } ?>>Male</option>
                                    <option value="FEMALE" <?php if(Input::old('gender') == 'FEMALE'){ echo('selected'); } ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="row form-group">
                            <label class="control-label col-md-2">Employment Type</label>
                            <div class="col-md-10">
                                <select name="workTime" id="workTime" class="form-control inputItem" required="required" data-name="Employment Type">
                                    <option value="">Please select your preferred work time</option>
                                    <option value="PTIME" <?php if(Input::old('workTime') == 'PTIME'){ echo('selected'); } ?>>Part Time</option>
                                    <option value="FTIME" <?php if(Input::old('workTime') == 'FTIME'){ echo('selected'); } ?>>Full Time</option>
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="row form-group">
                            <label class="control-label col-md-2">Minimum Rate</label>
                            <div class="col-md-10">
                                {{ Form::text('minRate', Input::old('minRate'), array('data-name' => 'Minimum Rate', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter your minimum rate', 'required' => 'true')) }}
                            </div>
                        </div>
                        <br/>
                        <div class="row form-group">
                            <label class="control-label col-md-2">Maximum Rate</label>
                            <div class="col-md-10">
                                {{ Form::text('maxRate', Input::old('maxRate'), array('data-name' => 'Maximum Rate', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter your maximum rate', 'required' => 'true')) }}
                            </div>
                      </div>
-->
<!--                        <br/>-->
<!--                        <div class="row form-group">-->
<!--                            <label class="control-label col-md-6">Key Skills (Certification)</label>-->
<!--                            <div class="col-md-6">-->
<!--                                <input type="file" name="keySkills[]" accept='image/*' multiple/>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <br/>-->
<!--                        <div class="row form-group">-->
<!--                            <label class="control-label col-md-6">Upload 1 old document with complete name and address (i.e Transcript of record, birth certificate, etc. Accepted files are .doc, .pdf and .docx)</label>-->
<!--                            <div class="col-md-6">-->
<!--                                <input type="file" name="document" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"/>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                     <br/>
                        <hr/>
                    <h5>Contact Details</h5><br/>

                    <div class="row form-group">
                        <label class="control-label col-md-2">Facebook</label>
                        <div class="col-md-10">
                            {{ Form::text('facebook', Input::old('facebook'), array('data-name' => 'Facebook', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter link to your Facebook profile', 'required' => 'true')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">LinkedIn</label>
                        <div class="col-md-10">
                            {{ Form::text('linkedin', Input::old('linkedin'), array('data-name' => 'LinkedIn', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter link to your LinkedIn profile', 'required' => 'true')) }}
                        </div>
                    </div>
                    <br/>

                  
                    <div class="row form-group">
                        <label class="control-label col-md-2">Email</label>
                        <div class="col-md-10">
                            {{ Form::text('email', Input::old('email'), array('data-name' => 'Email', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter email address', 'required' => 'true', 'id' => 'tskmntrEmail')) }}
                        </div>
                    </div>
                    <br/>

                    <div class="row form-group">
                        <label class="control-label col-md-2">Mobile Number</label>
                        <div class="col-md-10">
                            {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter mobile number', 'required' => 'true')) }}
                        </div>
                    </div>
                    <br/>
                    <hr/>
                    <h5>Skills and Services Offered (You can add this later on your profile)</h5><br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Years of experience</label>
                        <div class="col-md-10">
                            {{ Form::text('yearsOfExperience', Input::old('yearsOfExperience'), array('data-name' => 'Years of experience', 'class' => 'form-control', 'placeholder' => 'Please enter the number of years of experience', 'required' => 'true')) }}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Skill Category</label>
                        <div class="col-md-10">
                            <select class="form-control" id="taskcategory" name="taskcategory">
                                @foreach($categories as $tc)
                                <option value="{{ $tc->categorycode }}">{{ $tc->categoryname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Skill</label>
                        <div class="col-md-8">
                            <select class="form-control" id="taskitems" name="taskitems">
                                @foreach($skillsList as $sl)
                                <option value="{{ $sl->itemcode }}">{{ $sl->itemname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success btn-block" id="addSkillBtn">Add Skill</button>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-10 col-md-offset-2" id="addedSkills">
                        </div>
                    </div>
                    <hr/>
                    <h5>Point Person and Contact details from the school where you got the certificate </h5><br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">First Name</label>
                        <div class="col-md-10">
                            {{ Form::text('firstName-pperson', Input::old('firstName-pperson'), array('data-name' => '1st Point Person : First Name', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter first name', 'required' => 'true')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Middle Name</label>
                        <div class="col-md-10">
                            {{ Form::text('midName-pperson', Input::old('midName-pperson'), array('data-name' => '1st Point Person : Middle Name', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter middle name.', 'required' => 'true')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Last Name</label>
                        <div class="col-md-10">
                            {{ Form::text('lastName-pperson', Input::old('lastName-pperson'), array('data-name' => '1st Point Person : Last Name', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter last name.', 'required' => 'true')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Email Address</label>
                        <div class="col-md-10">
                            {{ Form::text('email-pperson', Input::old('email-pperson'), array('data-name' => '1st Point Person : Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter email address', 'required' => 'true')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Mobile Number</label>
                        <div class="col-md-10">
                            {{ Form::text('mobileNum-pperson', Input::old('mobileNum-pperson'), array('data-name' => '1st Point Person : Mobile Number', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter mobile number', 'required' => 'true')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Position</label>
                        <div class="col-md-10">
                            {{ Form::text('position-pperson', Input::old('position-pperson'), array('data-name' => '1st Point Person : Position', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter your position', 'required' => 'true')) }}
                        </div>
                    </div>
                    <hr/>
                    <h5>Second (2nd) Point Person and Contact details from the school where you got the certificate </h5><br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">First Name</label>
                        <div class="col-md-10">
                            {{ Form::text('firstName-pperson2', Input::old('firstName-pperson2'), array('class' => 'form-control', 'placeholder' => 'Please enter first name')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Middle Name</label>
                        <div class="col-md-10">
                            {{ Form::text('midName-pperson2', Input::old('midName-pperson2'), array('class' => 'form-control', 'placeholder' => 'Please enter middle name.')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Last Name</label>
                        <div class="col-md-10">
                            {{ Form::text('lastName-pperson2', Input::old('lastName-pperson2'), array('class' => 'form-control', 'placeholder' => 'Please enter last name.')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Email Address</label>
                        <div class="col-md-10">
                            {{ Form::text('email-pperson2', Input::old('email-pperson2'), array('class' => 'form-control', 'placeholder' => 'Please enter email address')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Mobile Number</label>
                        <div class="col-md-10">
                            {{ Form::text('mobileNum-pperson2', Input::old('mobileNum-pperson2'), array('class' => 'form-control', 'placeholder' => 'Please enter mobile number')) }}
                        </div>
                    </div>
                    <br/>
                    <div class="row form-group">
                        <label class="control-label col-md-2">Position</label>
                        <div class="col-md-10">
                            {{ Form::text('position-pperson2', Input::old('position-pperson'), array('class' => 'form-control', 'placeholder' => 'Please enter your position', 'required' => 'true')) }}
                        </div>
                    </div>
                    <br/>
                    <hr/>

                        <h5>Account Information</h5><br/>
                        <div class="row form-group">
                            <label class="control-label col-md-2">Username</label>
                            <div class="col-md-10">
                                {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter username', 'required' => 'true')) }}
                            </div>
                        </div>
                        <br/>
                        <div class="row form-group">
                            <label class="control-label col-md-2">Password</label>
                            <div class="col-md-6">
                                {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter password', 'required' => 'true')) }}
                            </div>
                            <div class="col-md-4" id="strengthDisplay">
                            </div>
                        </div>
                        <br/>
                        <div class="row form-group">
                            <label class="control-label col-md-2">Confirm Password</label>
                            <div class="col-md-10">
                                {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'class' => 'form-control inputItem', 'placeholder' => 'Re-type password', 'required' => 'true')) }}
                            </div>
                        </div>
                        <br/>
                        <div class="row form-group">
                            <label class="control-label col-md-2">Terms of Service</label>
                            <div class="col-md-10">
                                {{ Form::checkbox('TOS', '1', array('class' => 'form-control'));}}
                            </div>
                        </div><br/>
                        <br/>
                        <button class="btn btn-primary" id="submitForm" type="submit">Register</button>
                    {{ Form::close() }}

                -->
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
                <button onclick="$('#registrationForm-task').submit()" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
@stop