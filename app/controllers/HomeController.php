<?php

// Importing the BotDetectCaptcha class
use Captcha\Integration\BotDetectCaptcha;

class HomeController extends BaseController {

    function generateConfirmationCode(){
        $random = '';
        while(1){
            $random = md5(uniqid(rand(), true));
            if(User::where('confirmationCode', $random)->count() == 0){
                break;
            }
        }
        return $random;
    }

    function emailValidate($email){
        return preg_match('/^(([^<>()[\]\\.,;:\s@"\']+(\.[^<>()[\]\\.,;:\s@"\']+)*)|("[^"\']+"))@((\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\])|(([a-zA-Z\d\-]+\.)+[a-zA-Z]{2,}))$/', $email);
    }


    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */

    public function logout(){
        date_default_timezone_set("Asia/Manila");
        AuditTrail::insert(array(
            'user_id'       =>  Auth::user()->id,
            'content'       =>  'Logged out at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s")
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));
        Auth::logout();
        return Redirect::to('/');
    }

    public function register(){
        return View::make('register')->with('regions', Region::all());
    }

    public function doRegisterComp(){
        // COMPANY NAME VALIDATION
        if(strlen(trim(strip_tags(Input::get('companyName')))) == 0){
            return Redirect::back()->with('errorMsg', 'Company name cannot be empty')->withInput(Input::except('password'));
        }

        // MOBILE NUMBER VALIDATION
        if(!ctype_digit(Input::get('mobileNum'))){
            return Redirect::back()->with('errorMsg', 'Mobile number must be numbers only')->withInput(Input::except('password'));
        }else if(strlen(Input::get('mobileNum')) == 0 || strlen(Input::get('mobileNum')) < 11){
            return Redirect::back()->with('errorMsg', 'Mobile number cannot be empty and must be more than 11 digits')->withInput(Input::except('password'));
        }

        // EMAIL VALIDATION
        if(!$this->emailValidate(Input::get('email'))){
            return Redirect::back()->with('errorMsg', 'Please enter valid email')->withInput(Input::except('password'));
        }else if(Contact::where('content', Input::get('email'))->where('ctype', 'email')->count() > 0){
            return Redirect::back()->with('errorMsg', 'Email is already taken')->withInput(Input::except('password'));
        }

        // BUSINESS NUMBER VALIDATION
        if(!ctype_digit(Input::get('businessNum'))){
            return Redirect::back()->with('errorMsg', 'Business number must be numbers only')->withInput(Input::except('password'));
        }

        // BUSINESS NATURE VALIDATION
        if(strlen(trim(strip_tags(Input::get('businessNature')))) == 0){
            return Redirect::back()->with('errorMsg', 'Business nature name cannot be empty')->withInput(Input::except('password'));
        }

        // BUSINESS DESCRIPTION VALIDATION
        if(strlen(trim(strip_tags(Input::get('businessDescription')))) == 0){
            return Redirect::back()->with('errorMsg', 'Company name cannot be empty')->withInput(Input::except('password'));
        }else if(strlen(Input::get('businessDescription')) > 50){
            return Redirect::back()->with('errorMsg', 'Business description  must be at least or more than 50 characters')->withInput(Input::except('password'));
        }

        // BUSINESS PERMIT VALIDATION
        if(strlen(trim(strip_tags(Input::get('businessPermit')))) == 0){
            return Redirect::back()->with('errorMsg', 'Company name cannot be empty')->withInput(Input::except('password'));
        }

        // ADDRESS VALIDATION
        if(strlen(Input::get('address')) == 0){
            return Redirect::back()->with('errorMsg', 'Address cannot be empty')->withInput(Input::except('password'));
        }else if(strlen(strip_tags(Input::get('address'))) == 0){
            return Redirect::back()->with('errorMsg', 'Address cannot contain tags')->withInput(Input::except('password'));
        }

        // REGION VALIDATION
        if(Input::get('region-comp') == null || Input::get('region-comp') == 0){
            return Redirect::back()->with('errorMsg', 'Region cannot be empty');
        }

        // CITY VALIDATION
        if(Input::get('city-comp') == null || Input::get('city-comp') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be empty')->withInput(Input::except('password'));
        }

        // BARANGAY VALIDATION
        if(Input::get('barangay-comp') == null || Input::get('barangay-comp') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be empty')->withInput(Input::except('password'));
        }

//        // PROVINCE VALIDATION
//        if(Input::get('province-comp') == null || Input::get('province-comp') == 0){
//            return Redirect::back()->with('errorMsg', 'City cannot be empty');
//        }

        // KEY PERSON VALIDATION -- START
            // FIRSTNAME VALIDATION
            if(!ctype_alpha(str_replace(' ', '',trim(Input::get('firstName-keyperson'))))){
                return Redirect::back()->with('errorMsg', 'Key person first name must be letters only')->withInput(Input::except('password'));
            }else if(strlen(trim(Input::get('firstName-keyperson'))) == 0){
                return Redirect::back()->with('errorMsg', 'Key person first name cannot be empty')->withInput(Input::except('password'));
            }

            // MIDDLE NAME VALIDATION
            if(!ctype_alpha(str_replace(' ', '', trim(Input::get('midName-keyperson'))))){
                return Redirect::back()->with('errorMsg', 'Key person middle name must be letters only')->withInput(Input::except('password'));
            }else if(strlen(trim(Input::get('midName-keyperson'))) == 0){
                return Redirect::back()->with('errorMsg', 'Key person middle name cannot be empty')->withInput(Input::except('password'));
            }

            // LAST NAME VALIDATION
            if(!ctype_alpha(str_replace(' ', '', trim(Input::get('lastName-keyperson'))))){
                return Redirect::back()->with('errorMsg', 'Key person last name must be letters only')->withInput(Input::except('password'));
            }else if(strlen(trim(Input::get('lastName-keyperson'))) == 0){
                return Redirect::back()->with('errorMsg', 'Key person last name cannot be empty')->withInput(Input::except('password'));
            }

            // POSITION VALIDATION
            if(Input::get('position-keyperson') == null || strlen(trim(Input::get('position-keyperson'))) == 0){
                return Redirect::back()->with('errorMsg', 'Key person position cannot be empty')->withInput(Input::except('password'));
            }

            // MOBILE NUMBER VALIDATION
            if(!ctype_digit(Input::get('mobileNum-keyperson'))){
                return Redirect::back()->with('errorMsg', 'Key person mobile number must be numbers only')->withInput(Input::except('password'));
            }

            // EMAIL VALIDATION
            if(!$this->emailValidate(Input::get('email-keyperson'))){
                return Redirect::back()->with('errorMsg', 'Key person email must be valid')->withInput(Input::except('password'));
            }
        // KEY PERSON VALIDATION -- END

        // USERNAME VALIDATION
        if(Input::get('username') == '' || Input::get('username') == null){
            return Redirect::back()->with('errorMsg', 'Username cannot be empty 1')->withInput(Input::except('password'));
        }else if(strlen(trim(Input::get('username'))) == 0){
            return Redirect::back()->with('errorMsg', 'Username cannot be empty')->withInput(Input::except('password'));
        }else if(!ctype_alnum(Input::get('username'))){
            return Redirect::back()->with('errorMsg', 'Username is alphanumeric (numbers and letters) only')->withInput(Input::except('password'));
        }else if(strlen(Input::get('username')) < 8){
            return Redirect::back()->with('errorMsg', 'Username must be more than 8 characters')->withInput(Input::except('password'));
        }else if(User::where('username', Input::get('username'))->count() > 0){
            return Redirect::back()->with('errorMsg', 'Username is already taken')->withInput(Input::except('password'));
        }

        // PASSWORD VALIDATION
        if(!ctype_alnum(Input::get('password'))){
            return Redirect::back()->with('errorMsg', 'Password is alphanumeric (numbers and letters) only')->withInput(Input::except('password'));
        }else if(strlen(Input::get('password')) < 8){
            return Redirect::back()->with('errorMsg', 'Password must be more than 8 characters')->withInput(Input::except('password'));
        }else if(Input::get('password') != Input::get('confirmpass')){
            return Redirect::back()->with('errorMsg', 'Passwords does not match')->withInput(Input::except('password'));
        }

        // TOS VALIDATION
        if(!Input::get('TOS')){
            return Redirect::back()->with('errorMsg', 'You must agree to TASKminator Terms of Agreements (TOS)')->withInput(Input::except('password'));
        }

        if(User::count() < 30){
            $points = 100;
        }else{
            $points = 0;
        }

        date_default_timezone_set("Asia/Manila");
        User::insert(array(
            'companyName'           =>  Input::get('companyName'),
            'fullName'              =>  Input::get('companyName'),
            'address'               =>  strip_tags(Input::get('address')),
            'businessNature'        =>  Input::get('businessNature'),
            'businessDescription'   =>  Input::get('businessDescription'),
            'businessPermit'        =>  Input::get('businessPermit'),
            'region'                =>  Input::get('region-comp'),
            'city'                  =>  Input::get('city-comp'),
            'barangay'              =>  Input::get('barangay-comp'),
            'username'              =>  Input::get('username'),
            'password'              =>  Hash::make(Input::get('password')),
            'confirmationCode'      =>  $this->generateConfirmationCode(),
            'status'                =>  'PRE_ACTIVATED',
//            'status'                =>  'ACTIVATED',
            'country'               =>  'PHILIPPINES',
            'created_at'            =>  date("Y:m:d H:i:s"),
            'updated_at'            =>  date("Y:m:d H:i:s"),
            'points'                =>  $points,
            'accountType'           =>  'BASIC',
        ));

        $userId = User::where('username', Input::get('username'))->pluck('id');

        UserHasRole::insert(array(
            'user_id'   =>  $userId,
            'role_id'   =>  '4'
        ));

        ContactPerson::insert(array(
            'user_id'   => $userId,
            'firstName'   => Input::get('firstName-keyperson'),
            'midName'   => Input::get('midName-keyperson'),
            'lastName'   => Input::get('lastName-keyperson'),
            'contactNum'   => Input::get('mobileNum-keyperson'),
            'email'   => Input::get('email-keyperson'),
            'position'   => Input::get('position-keyperson'),
            'country'   => 'PHILIPPINES'
        ));

        Contact::insert(array(
            array(
                'user_id'       =>  $userId,
                'ctype'       =>  'email',
                'content'       =>  Input::get('email'),
            ),
            array(
                'user_id'       =>  $userId,
                'ctype'       =>  'mobileNum',
                'content'       =>  Input::get('mobileNum'),
            ),
            array(
                'user_id'       =>  $userId,
                'ctype'       =>  'businessNum',
                'content'       =>  Input::get('businessNum'),
            )
        ));

        AuditTrail::insert(array(
            'user_id'   =>  $userId,
            'content'   =>  'Created a Client Company account at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.$userId
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')));
        return Redirect::to('/')->with('successMsg', 'Registration Success. You may now login.');
    }

    public function checkCaptcha(){
        // check captcha
        $check = SimpleCaptcha::check($_POST['captcha']);

        if(!$check) {
            return false;
        }
    }

    public function doRegisterIndi(){
        Input::merge(array_map('trim', Input::all()));
        $check = SimpleCaptcha::check($_POST['captcha']);

        if(!$check) {
            return Redirect::back()->with('errorMsg', 'Captcha does not match. Please retry.')->withInput(Input::except('password', 'captcha'));
        }

        $rules = array(
            'firstName' => "required|regex:/^[\p{L}\s'.-]+$/",
            'midName'  => "required|regex:/^[\p{L}\s'.-]+$/",
            'lastName' => "required|regex:/^[\p{L}\s'.-]+$/",
            'gender' => 'required',
            'occupation' => "required|regex:/^[\p{L}\s'()]+$/",
            'month' => 'required',
            'date' => 'required',
            'year' => 'required',
            'mobileNum' => 'required|numeric|min:11',
            'tin1' => 'required|regex:/^[0-9]+$/|digits:3',
            'tin2' => 'required|regex:/^[0-9]+$/|digits:3',
            'tin3' => 'required|regex:/^[0-9]+$/|digits:3',
            'email' => 'required|email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'confirmpass' => 'required|min:8|same:password',
            'TOS' => 'required'
        );

        $messages = array(
            'firstName.regex' => 'Name must be letters only',
            'midName.regex' => 'Name must be letters only',
            'lastName.regex' => 'Name must be letters only',
            'occupation.regex' => 'Occupation should not have special characters',
            'tin1.regex' => 'Wrong TIN number',
            'tin2.regex' => 'Wrong TIN number',
            'tin3.regex' => 'Wrong TIN number',
            'tin1.required' => 'Fill up all fields for TIN number',
            'tin2.required' => 'Fill up all fields for TIN number',
            'tin3.required' => 'Fill up all fields for TIN number',
        );

        $validator = Validator::make(Input::all(), $rules, $messages);

        if($validator->fails()){
            return Redirect::back()->with('errorMsg', $validator->messages()->first())->withInput(Input::except('password'));
        }

        // if validation is successful
        if(User::count() < 30){
            $points = 100;
        }else{
            $points = 0;
        }

        $userId = User::insertGetId(array(
            'username'      =>  Input::get('username'),
            'password'      =>  Hash::make(Input::get('password')),
            'firstName'     =>  Input::get('firstName'),
            'midName'       =>  Input::get('midName'),
            'lastName'      =>  Input::get('lastName'),
            'fullName'      =>  Input::get('firstName').' '.Input::get('midName').' '.Input::get('lastName'),
            'birthdate'     =>  Input::get('year').'-'.Input::get('month').'-'.Input::get('date'),
            'tin'           =>  Input::get('tin1').'-'.Input::get('tin2').'-'.Input::get('tin3').'-000',
            'gender'        =>  Input::get('gender'),
            'status'        =>  'PRE_ACTIVATED',
            'created_at'    =>  date("Y:m:d H:i:s"),
            'updated_at'    =>  date("Y:m:d H:i:s"),
            'points'        =>  $points,
            'accountType'   =>  'BASIC',
        ));

        UserHasRole::insert(array(
            'user_id'   =>  $userId,
            'role_id'   =>  '3'
        ));

        Contact::insert(array(
            array(
                'user_id'       =>  $userId,
                'ctype'       =>  'email',
                'content'       =>  Input::get('email'),
            ),
            array(
                'user_id'       =>  $userId,
                'ctype'       =>  'mobileNum',
                'content'       =>  Input::get('mobileNum'),
            )
        ));

        AuditTrail::insert(array(
            'user_id'   =>  $userId,
            'content'   =>  'Created a Client Individual account at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.$userId
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')));
        return Redirect::to('/')->with('successMsg', 'Registration Success. You may now login.');
    }
    public function  doRegisterTaskminator(){
        Input::merge(array_map('trim', Input::all()));
        
        $check = SimpleCaptcha::check($_POST['captcha']);

        if(!$check) {
            return Redirect::back()->with('errorMsg', 'Captcha does not match. Please retry.')->withInput(Input::except('password', 'captcha'));
        }
        
        $rules = array(
            'firstName'         => "required|regex:/^[\p{L}\s'.-]+$/",
            'midName'           => "required|regex:/^[\p{L}\s'.-]+$/",
            'lastName'          => "required|regex:/^[\p{L}\s'.-]+$/",
            'month'             => 'required',
            'date'              => 'required',
            'year'              => 'required',
            'gender'            => 'required',
            'mobileNum'         => 'required|numeric|min:11',
            'nationality'       => 'required',
            'preferredJob'      => 'required',
            'experience'        => 'required',
            'minRate'           => 'required',
            'maxRate'           => 'required',
            'tin1'              => 'required_with_all: tin2, tin3|regex:/^[0-9]+$/|digits:3',
            'tin2'              => 'required_with_all: tin1, tin3|regex:/^[0-9]+$/|digits:3',
            'tin3'              => 'required_with_all: tin1, tin2|regex:/^[0-9]+$/|digits:3',
            'username'          => 'required|unique:users,username',
            'password'          => 'required|min:8',
            'confirmpass'       => 'required|min:8|same:password',
            'TOS'               => 'required'
        );

        $messages = array(
            'firstName.regex' => 'Name must be letters only',
            'midName.regex' => 'Name must be letters only',
            'lastName.regex' => 'Name must be letters only',
            'tin1.regex' => 'Wrong TIN number',
            'tin2.regex' => 'Wrong TIN number',
            'tin3.regex' => 'Wrong TIN number',
        );

        $validator = Validator::make(Input::all(), $rules, $messages);

        if($validator->fails()){
            return Redirect::back()->with('errorMsg', $validator->messages()->first())->withInput(Input::except('password', 'captcha'));
        }
        // validation successful

        $userId = User::insertGetId(array(
            'username'              =>  Input::get('username'),
            'password'              =>  Hash::make(Input::get('password')),
            'firstName'             =>  Input::get('firstName'),
            'midName'               =>  Input::get('midName'),
            'lastName'              =>  Input::get('lastName'),
            'fullName'              =>  Input::get('firstName').' '.Input::get('midName').' '.Input::get('lastName'),
            'gender'                =>  Input::get('gender'),
            'birthdate'             =>  Input::get('year').'-'.Input::get('month').'-'.Input::get('date'),
            //'nationality'           =>  Input::get('nationality'),
            'yearsOfExperience'     =>  Input::get('experience'),
            'tin'                   =>  Input::get('tin1').'-'.Input::get('tin2').'-'.Input::get('tin3').'-000',
            'confirmationCode'      =>  $this->generateConfirmationCode(),
            'status'                =>  'PRE_ACTIVATED',
            'skills'                =>  Input::get('preferredJob'),
            'minRate'               =>  Input::get('minRate'),
            'maxRate'               =>  Input::get('maxRate'),
            'created_at'            =>  date("Y:m:d H:i:s"),
            'updated_at'            =>  date("Y:m:d H:i:s"),
        ));

        UserHasRole::insert(array(
            'user_id'   =>  $userId,
            'role_id'   =>  '2'
        ));

        Contact::insert(array(
            array(
                'user_id'       =>  $userId,
                'ctype'         =>  'mobileNum',
                'content'       =>  Input::get('mobileNum'),
            ),
            array(
                'user_id'       =>  $userId,
                'ctype'         =>  'email',
                'content'       =>  Input::get('email'),
            )
        ));
/*
        if(Input::get('skills') !== null){
            foreach(Input::get('skills') as $skill){
                $skillCode = TaskCategory::where('categorycode', TaskItem::where('itemcode', $skill)->pluck('item_categorycode'))->pluck('categorycode');

                TaskminatorHasSkill::insert(array(
                    'user_id'           =>  $userId,
                    'taskitem_code'     =>  $skill,
                    'taskcategory_code' =>  $skillCode
                ));
            }
        }
*/
        AuditTrail::insert(array(
            'user_id'   =>  $userId,
            'content'   =>  'Created a Taskminator account at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.$userId
        ));

        Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')));

        return Redirect::to('/doVerifyMobileNumber');

    }

    public function login(){
        if(Auth::check()){
            return Redirect::to('/');
        }else{
            return View::make('login');
        }
    }

    public function home(){

        return View::make('home');
    }

    public function howitworks(){

        return View::make('howitworks');
    }

    public function whychooseproveek(){

        return View::make('whychooseproveek');
    }  

    public function pricing(){

        return View::make('pricing');
    }  

    public function index(){
        if(Auth::check()){
            switch(Auth::user()->status){
                case 'DEACTIVATED'      :
                case 'SELF_DEACTIVATED' :
                case 'ADMIN_DEACTIVATED':
                    Auth::logout();
                    return Redirect::to('/login')->with('errorMsg', 'Your account has been deactivated. Contact us for more information');
            }

            $role = Role::join('user_has_role', 'roles.id', '=', 'user_has_role.role_id')
                ->where('user_has_role.user_id', Auth::user()->id)
                ->pluck('role');

            switch($role){
                case 'ADMIN' :
                    return Redirect::to('/admin');
                    break;
                case 'TASKMINATOR' :
                    $bidCount = Task::join('task_has_bidders', 'task_has_bidders.task_id', '=', 'tasks.id')
                        ->where('task_has_bidders.taskminator_id', Auth::user()->id)
                        ->where('tasks.status', 'OPEN')
                        ->where('tasks.hiringType', 'BIDDING')->count();

                    $offerCount = Task::join('taskminator_has_offer', 'taskminator_has_offer.task_id', '=', 'tasks.id')
                        ->where('taskminator_has_offer.taskminator_id', Auth::user()->id)
                        ->where('tasks.status', 'OPEN')->count();

                    $ongoingCount = Task::join('task_has_taskminator', 'task_has_taskminator.task_id', '=', 'tasks.id')
                        ->where('task_has_taskminator.taskminator_id', Auth::user()->id)
                        ->where('tasks.status', 'ONGOING')->count();

                    $completedCount = Task::join('task_has_taskminator', 'task_has_taskminator.task_id', '=', 'tasks.id')
                        ->where('task_has_taskminator.taskminator_id', Auth::user()->id)
                        ->where('tasks.status', 'COMPLETE')->count();

                    return View::make('taskminator.index')
                            ->with('bidCount', $bidCount)
                            ->with('offerCount', $offerCount)
                            ->with('ongoingCount', $ongoingCount)
                            ->with('completedCount', $completedCount);
                    break;
                case 'CLIENT_IND' :
                case 'CLIENT_CMP' :
                    return View::make('client.index');
                    break;
                default :
                    return Redirect::to('/');
                    break;
            }
        }else{
            //return Redirect::to('/login');
            return Redirect::to('/home');
        }
    }

    public function doLogin(){
        if(Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')))){

            date_default_timezone_set("Asia/Manila");
            AuditTrail::insert(array(
                'user_id'   =>  Auth::user()->id,
                'content'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
                'created_at'    =>  date("Y:m:d H:i:s")
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
            ));

            switch(Auth::user()->status){
                case 'DEACTIVATED'          :
                case 'ADMIN_DEACTIVATED'    :
                case 'SELF_DEACTIVATED'     :
                    Auth::logout();
                    return Redirect::back()->with('errorMsg', 'This account has been deactivated. Please email us at taskminator@gmail.com for account management.')->withInput();
                    break;
            }

            return Redirect::to('/');
        }else if(User::where('username', Input::get('username'))->count() == 0){
            return Redirect::back()->with('successMsg', 'This account has not been registered. Click <a href="/register">here</a> to register.');
        }else{
            return Redirect::back()->with('errorMsg', 'Username or Password is incorrect')->withInput();
        }
    }

    public function chainCity(){
        if(Input::get('city') != null){
            $city = Input::get('city');
        }else if(Input::get('city-comp') != null){
            $city = Input::get('city-comp');
        }else if(Input::get('city-task') != null){
            $city = Input::get('city-task');
        }else{
            $city = 'NONE';
        }

        if($city == 'NONE'){
            return Barangay::all();
        }else{
            return Barangay::where('citycode', $city)->orderBy('bgyname', 'ASC')->get();
        }
    }

    public function chainRegion(){
        if(Input::get('region') != null){
            $region = Input::get('region');
        }else if(Input::get('region-comp') != null){
            $region = Input::get('region-comp');
        }else if(Input::get('region-task') != null){
            $region = Input::get('region-task');
        }else{
            $region = 'NONE';
        }

        if($region == 'NONE'){
            return City::all();
        }else{
            return City::where('regcode', $region)->orderBy('cityname', 'ASC')->get();
        }
    }

    public function chainProvince(){
        if(Input::get('region') != null){
            $region = Input::get('region');
        }else if(Input::get('region-comp') != null){
            $region = Input::get('region-comp');
        }else if(Input::get('region-task') != null){
            $region = Input::get('region-task');
        }else{
            $region = 'NONE';
        }

        if($region == 'NONE'){
            return City::all();
        }else{
            return Province::where('regcode', $region)->orderBy('provname', 'ASC')->get();
        }
    }

    public function regTaskminator(){
        return View::make('reg-taskminator')
            ->with('regions', Region::all())
            ->with('barangays', Barangay::where('citycode', '012801')->orderBy('bgyname', 'ASC')->get())
            ->with('cities', City::where('regcode', '01')->orderBy('cityname', 'ASC')->get())
            ->with('categories', TaskCategory::orderBy('categoryname', 'ASC')->get())
            ->with('skillsList', TaskItem::where('item_categorycode', '006')->orderBy('itemname', 'ASC')->get());
    }

    public function regClientComp(){
        return View::make('reg-clientcomp')
            ->with('regions', Region::all())
            ->with('barangays', Barangay::where('citycode', '012801')->orderBy('bgyname', 'ASC')->get())
            ->with('cities', City::where('regcode', '01')->orderBy('cityname', 'ASC')->get());
    }

    public function regClientIndi(){
        return View::make('reg-clientindi')
            ->with('regions', Region::all())
            ->with('barangays', Barangay::where('citycode', '012801')->orderBy('bgyname', 'ASC')->get())
            ->with('cities', City::where('regcode', '01')->orderBy('cityname', 'ASC')->get());
    }

    public function changePassword(){
        $flag = 'SUCCESS';
        $msg = '';
        $userId = Contact::where('ctype', 'email')->where('content', Input::get('email'))->pluck('user_id');

        // EMAIL VALIDATE
        if(!$this->emailValidate(Input::get('email'))){
            $msg = 'Please enter a valid email';
            $flag = 'FAILED';
        }else if(Contact::where('ctype', 'email')->where('content', Input::get('email'))->count() == 0){
            $msg = 'This email is not registered';
            $flag = 'FAILED';
        }else if(User::where('id', $userId)->pluck('status') == 'ADMIN_DEACTIVATED'){
            $msg = 'The account registered to this email has been deactivated by an admin. <br/> For more inquiries please email us at taskminator@gmail.com';
            $flag = 'FAILED';
        }

        if($flag == 'SUCCESS'){
            // DEACTIVATE USER
            User::where('id', $userId)->update(array(
                'status'        =>  'DEACTIVATED'
            ));

            $email = Input::get('email');


            if(Input::get('process') == 'CHPASS'){
                $msg = 'Please click the link below to initialize changing your password';
                $url = URL::to('/').'/activateChangePass/'.User::where('id', $userId)->pluck('confirmationCode');
            }else{
                $msg = 'Please click the link below to initialize resetting your password';
                $url = URL::to('/').'/activateResetPass/'.User::where('id', $userId)->pluck('confirmationCode');
            }

            $data = ['url'  =>  $url, 'msg' => $msg];

            Mail::send('emails.changepass_Template', $data, function($message) use($email)
            {
                $message->from('taskminator.mail@gmail.com', 'Taskminator');
                $message->to($email)->subject('TASKminator Password Management');
            });

            $msg = 'Forgot Password link has been sent';
        }

        return array(
            'msg'       =>  $msg,
            'flag'      =>  $flag
        );
    }

//    public function forgotPassword(){
//        $flag = 'SUCCESS';
//        $msg = '';
//        $userId = Contact::where('ctype', 'email')->where('content', Input::get('email'))->pluck('user_id');
//
//        // EMAIL VALIDATE
//        if(!$this->emailValidate(Input::get('email'))){
//            $msg = 'Please enter a valid email';
//            $flag = 'FAILED';
//        }else if(Contact::where('ctype', 'email')->where('content', Input::get('email'))->count() == 0){
//            $msg = 'This email is not registered';
//            $flag = 'FAILED';
//        }else if(User::where('id', $userId)->pluck('status') == 'ADMIN_DEACTIVATED'){
//            $msg = 'The account registered to this email has been deactivated by an admin. <br/> For more inquiries please email us at taskminator@gmail.com';
//            $flag = 'FAILED';
//        }
//
//        if($flag == 'SUCCESS'){
//            // DEACTIVATE USER
//            User::where('id', $userId)->update(array(
//                'status'        =>  'DEACTIVATED'
//            ));
//
//            $email = Input::get('email');
//            $url = URL::to('/').'/activateChangePass/'.User::where('id', $userId)->pluck('confirmationCode');
//
//            $data = ['url'  =>  $url];
//
//            Mail::send('emails.forgotpass', $data, function($message) use($email)
//            {
//                $message->from('taskminator.mail@gmail.com', 'Taskminator');
//                $message->to($email)->subject('Taskminator Forgot password');
//            });
//
//            $msg = 'Forgot Password link has been sent';
//        }
//
//        return array(
//            'msg'       =>  $msg,
//            'flag'      =>  $flag
//        );
//    }

    public function activateResetPass($confirmationCode){
        $user = User::where('confirmationCode', $confirmationCode);

        if($user->count() == 0){
            return Redirect::to('/');
        }else if($user->pluck('status') != 'DEACTIVATED'){
            return Redirect::to('/');
        }else{
            return View::make('forgotpass')->with('user', User::where('confirmationCode', $confirmationCode)->first());
        }
    }

    public function activateChangePass($confirmationCode){
        $user = User::where('confirmationCode', $confirmationCode);

        if($user->count() == 0){
            return Redirect::to('/');
        }else if($user->pluck('status') != 'DEACTIVATED'){
            return Redirect::to('/');
        }else{
            return View::make('changepass')->with('user', User::where('confirmationCode', $confirmationCode)->first());
        }
    }

    public function confirmReset(){

        if(!ctype_alnum(Input::get('password'))){
            return Redirect::back()->with('errorMsg', 'Password is alphanumeric (numbers and letters) only')->withInput(Input::except('password'));
        }else if(strlen(Input::get('password')) < 8){
            return Redirect::back()->with('errorMsg', 'Password must be more than 8 characters')->withInput(Input::except('password'));
        }else if(Input::get('password') != Input::get('confirmPassword')){
            return Redirect::back()->with('errorMsg', 'Passwords does not match')->withInput(Input::except('password'));
        }

        User::where('id', Input::get('userId'))->update(array(
            'password'      =>  Hash::make(Input::get('password')),
            'status'        =>  'ACTIVATED'
        ));

        Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')));
        return Redirect::to('/');
    }

    public function confirmChange(){
        if(Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('old_password')))){
            Auth::logout();
        }else{
            return Redirect::back()->with('errorMsg', 'Old password is incorrect')->withInput(Input::except('password'));
        }

        if(!ctype_alnum(Input::get('password'))){
            return Redirect::back()->with('errorMsg', 'Password is alphanumeric (numbers and letters) only')->withInput(Input::except('password'));
        }else if(strlen(Input::get('password')) < 8){
            return Redirect::back()->with('errorMsg', 'Password must be more than 8 characters')->withInput(Input::except('password'));
        }else if(Input::get('password') != Input::get('confirmPassword')){
            return Redirect::back()->with('errorMsg', 'Passwords does not match')->withInput(Input::except('password'));
        }



        User::where('id', Input::get('userId'))->update(array(
            'password'      =>  Hash::make(Input::get('password')),
            'status'        =>  'ACTIVATED'
        ));

        Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')));
        return Redirect::to('/');
    }

    public function chainCategoryItems(){
        return TaskItem::where('item_categorycode', Input::get('taskcategory'))->get();
    }

    public function profile($id){

        if(UserHasRole::where('user_id', $id)->pluck('role_id') == 2){
            return View::make('profile')
                ->with('user', User::where('id', $id)->first())
                ->with('ratings', Rate::where('taskminator_id', $id));
        }else{
            return View::make('profile_clients')
                ->with('user', User::where('id', $id)->first())
                ->with('ratings', Rate::where('taskminator_id', $id));
        }
//        $userDetails = User::where('id', $id)->first();
//        switch(User::join('user_has_role', 'users.id', '=','user_has_role.user_id')->where('users.id', $id)->pluck('role_id')){
//            case '2' :
//                return View::make('profile_tskmntr')->with('user', $userDetails);
//            case '3' :
//                return View::make('profile_clientindi')->with('user', $userDetails);
//            case '4' :
//                return View::make('profile_clientcomp')->with('user', $userDetails);
//        }
//        return Redirect::back();
    }

    public function editProfile(){
        switch(UserHasRole::where('user_id', Auth::user()->id)->pluck('role_id')){
            case '1'    :
                return View::make('editProfile_admin')->with('user', User::where('id', Auth::user()->id)->first());
            case '2'    :
                return View::make('editProfile_tskmntr')->with('user', User::where('id', Auth::user()->id)->first());
            case '3'    :
            case '4'    :
                return View::make('editProfile_client')
                    ->with('user', User::where('id', Auth::user()->id)->first())
                    ->with('contacts', Contact::where('user_id', Auth::user()->id)->get());
        }

        return Redirect::back();
    }

    public function uploadProfilePic(){
        date_default_timezone_set("Asia/Manila");
        $pic = Input::file('profilePic');
        $newFileName = md5(uniqid(rand(), true));

        $destinationPath = 'public/upload/'.Auth::user()->confirmationCode.'_'.Auth::user()->id;

        if(!isset($pic)){
            return Redirect::back()->with('errorMsg', 'Please attach an image file before submitting');
        }

        $rules = array('file' => 'required|mimes:png,jpeg,jpg');
        $validator = Validator::make(array('file'=> $pic), $rules);
        if($validator->passes()){
//            $filename = $pic->getClientOriginalName();
            $filename = $newFileName.'.'.$pic->getClientOriginalExtension();
            $upload_success = $pic->move($destinationPath, $filename);
            $path = '/upload/'.Auth::user()->confirmationCode.'_'.Auth::user()->id.'/'.$filename;

            User::where('id', Auth::user()->id)->update(array(
                'profilePic' => $path
            ));

            Photo::insert(array(
                'user_id'   =>  Auth::user()->id,
                'path'      =>  $path,
                'type'      =>  'PROFILE_PIC',
                'created_at'      =>  date("Y:m:d H:i:s"),
            ));
        }else{
            return Redirect::back()->with('errorMsg', $validator);
        }

        return Redirect::back()->with('successMsg', 'Profile pic upload successful');
    }

    public function getNotification(){
        $query = Notification::where('status', 'NEW')->where('user_id', Auth::user()->id);
        return array(
            'notifCount'    =>  $query->count(),
            'notifContent'  =>  $query->orderBy('created_at', 'DESC')->take(5)->get(),
        );
    }

    public function showAllNotif(){
        Notification::where('status', 'NEW')
            ->where('user_id', Auth::user()->id)
            ->update(array(
                'status' => 'OLD'
            ));

        return View::make('showAllNotif')
                ->with('notifications', Notification::where('user_id', Auth::user()->id)->paginate(15));
    }

    public function messages(){
        return View::make('messages')
            ->with('threads', Thread::where('user_id', Auth::user()->id)->where('status', 'OPEN')->orderBy('created_at', 'ASC')->get());
    }

    public function getMessages($threadCode){
        $messages = Message::join('users', 'users.id', '=', 'messages.user_id')
                    ->where('thread_code', $threadCode)
                    ->orderBy('messages.created_at', 'ASC')
                    ->select([
                        'users.fullName',
                        'users.id',
                        'messages.content',
                        'messages.created_at',
                    ]);

        Message::where('thread_code', $threadCode)->whereNotIn('user_id', [Auth::user()->id])->update(array('status' => 'OLD'));

        return array(
            'messages'  =>  $messages->get(),
            'msgCount'  =>  Message::where('thread_code', $threadCode)->count()
        );
    }

    public function sendMsg(){

        date_default_timezone_set("Asia/Manila");
        Message::insert(array(
            'thread_code'   =>  Input::get('threadCode'),
            'user_id'       =>  Auth::user()->id,
            'status'        =>  'NEW',
            'content'       =>  htmlspecialchars(Input::get('postMessage')),
            'created_at'    =>  date("Y:m:d H:i:s")
        ));

        return 'SUCCESS';
    }

    public function checkMsgThread($threadCode){
        $messages = Message::join('users', 'users.id', '=', 'messages.user_id')
            ->whereNotIn('messages.user_id', [Auth::user()->id])
            ->where('messages.thread_code', $threadCode)
            ->Where('messages.status', 'NEW')
            ->orderBy('messages.created_at', 'ASC')
            ->select([
                'users.fullName',
                'users.id',
                'messages.content',
                'messages.created_at',
            ])->get();

        if($messages->count() > 0){
            Message::where('thread_code', $threadCode)->update(array('status' => 'OLD'));
        }

        return array(
            'messages'  =>  $messages,
            'msgCount'  =>  $messages->count()
        );
    }

    public function checkMsgs($threadCode){
        $messages = Message::join('users', 'users.id', '=', 'messages.user_id')
            ->whereNotIn('messages.user_id', [Auth::user()->id])
            ->where('messages.thread_code', $threadCode)
            ->Where('messages.status', 'NEW')->count();

        return array(
            'msgCount'  =>  $messages,
            'threadCode'    =>  $threadCode
        );
    }

    public function checkMsgCount(){
        return User::getMessages()->count();
    }
}

