<?php

class TaskminatorController extends \BaseController {

    function generateUniqueId(){
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

    public function taskSearch(){
        return View::make('taskminator.search')->with('cities', City::orderBy('cityname', 'ASC')->get());
    }

    public function doTaskSearch($workingTime, $searchField, $searchCity, $searchWord, $rateRange, $rangeValue){
        $errorMsg = null;

        $query = new Task;

        if($searchField != '0'  && $searchField != null){
            if($searchField == 'city' && $searchWord != '0'){
                $query = $query->where($searchField, $searchCity)->where('name', 'LIKE', '%'.$searchWord.'%');
            }else if($searchField == 'city' && $searchWord == '0'){
                $query = $query->where($searchField, $searchCity);
            }else{
                $query = $query->where('name', 'LIKE', '%'.Input::get('searchWord').'%');
            }
        }

        if($rangeValue != '0'){
            switch($rateRange){
                case 'ABOVE' :
                    $query = $query->where('salary', '>', $rangeValue);
                    break;
                case 'BELOW' :
                    $query = $query->where('salary', '<', $rangeValue);
                    break;
            }
        }

        $query = $query->where('workTime', $workingTime)
                    ->where('hiringType', 'BIDDING')
                    ->where('status', 'OPEN')->orderBy('created_at', 'DESC')
                    ->paginate(10);

        return View::make('taskminator.search')
            ->with('tasks', $query)
            ->with('errorMsg', $errorMsg)
            ->with('cities', City::orderBy('cityname', 'ASC')->get())
            ->with('workingTime', $workingTime)
            ->with('searchField', $searchField)
            ->with('searchCity', $searchCity)
            ->with('searchWord', $searchWord)
            ->with('rateRange', $rateRange)
            ->with('rangeValue', $rangeValue);
    }

    public function messages(){
        return View::make('taskminator.messages')
            ->with('threads', Thread::where('user_id', Auth::user()->id)->where('status', 'OPEN')->orderBy('created_at', 'ASC')->get());
    }

    public function bidPtime($id){
        if(TaskHasBidder::where('task_id', $id)->where('taskminator_id', Auth::user()->id)->count() > 0){
            return Redirect::back()->with('errorMsg', 'You have already made a bid for this task');
        }

        if(Auth::user()->status == 'PRE_ACTIVATED'){
            return Redirect::back()->with('preAcMsg', 'You have to complete your registration before you can bid for a task.<br/> Click <a href="/editProfile">here</a> to complete your registration<br/><br/>');
        }else{
            return View::make('taskminator.bid')->with('hiringType', 'PART')->with('task_id', $id)->with('task', Task::where('id', $id)->first());
        }
    }

    public function bidFtime($id){
        if(TaskHasBidder::where('task_id', $id)->where('taskminator_id', Auth::user()->id)->count() > 0){
            return Redirect::back()->with('errorMsg', 'You have already made a bid for this task');
        }

        if(Auth::user()->status == 'PRE_ACTIVATED'){
            return Redirect::back()->with('preAcMsg', 'You have to complete your registration before you can bid for a task.<br/> Click <a href="/editProfile">here</a> to complete your registration<br/><br/>');
        }else{
            return View::make('taskminator.bid')->with('hiringType', 'FULL')->with('task_id', $id)->with('task', Task::where('id', $id)->first());
        }
    }

    public function initBid(){
        date_default_timezone_set("Asia/Manila");
        $clientId = Task::where('id', Input::get('taskId'))->pluck('user_id');
        $clientDetails = User::where('id', $clientId)->first();
        $mobileNum = Contact::where('user_id', $clientId)->where('ctype', 'mobileNum')->pluck('content');

        // proposed rate validation
        if(!ctype_digit(Input::get('proposedRate'))){
            return Redirect::back()->with('errorMsg', 'Proposed rate must be numbers only')->withInput(Input::except('password'));
        }

        // message validation
        if(Input::get('message') == '' || Input::get('message') == null){
            return Redirect::back()->with('errorMsg', 'Message cannot be empty')->withInput(Input::except('password'));
        }

        // VALIDATE DEADLINE
        if(Input::get('proposedDuration') == '' || Input::get('proposedDuration') == null){
            return Redirect::back()->with('errorMsg', 'Please choose a Proposed Date')->withInput(Input::except('password'));
        }else if(!$this->validateDate(Input::get('proposedDuration'))){
            return Redirect::back()->with('errorMsg', 'Please choose a Proposed Date')->withInput(Input::except('password'));
        }else if(date_create(Input::get('proposedDuration')) < date_create('today')){
            return Redirect::back()->with('errorMsg', 'Proposed Date cannot be a past date')->withInput(Input::except('password'));
        }

        // update relationship between task and taskminator
        TaskHasBidder::insert(array(
            'task_id'           =>  Input::get('taskId'),
            'taskminator_id'    =>  Auth::user()->id,
            'proposedRate'      =>  Input::get('proposedRate'),
            'message'           =>  Input::get('message'),
            'created_at'        =>  date("Y:m:d H:i:s"),
            'updated_at'        =>  date("Y:m:d H:i:s")
        ));

        Notification::insert(array(
            'content'       =>  Auth::user()->fullName.' has made a bid on '.Task::where('id', Input::get('taskId'))->pluck('name'),
            'user_id'       =>  $clientId,
            'notif_url'     =>  '/taskDetails/'.Input::get('taskId'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'status'        =>  'NEW'
        ));

        $smsMessage = Auth::user()->fullName.' has made a bid on '.Task::where('id', Input::get('taskId'))->pluck('name');
        $this->sendSms($mobileNum, $smsMessage, $clientId);

        $taskDetails = Task::where('id', Input::get('taskId'))->first();

        AuditTrail::insert(array(
            'user_id'   =>  Auth::user()->id,
            'content'   =>  'Bid for task titled <span style="color: #2980B9;">'.$taskDetails->name.'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskDetails->id
        ));

        return Redirect::to('/tskmntr_taskBids');
    }

    public function doUploadDocuments(){
        date_default_timezone_set("Asia/Manila");
        $document = Input::file('document');
        $keySkills = Input::file('keySkills');
        $destinationPath = 'public/upload/'.Auth::user()->confirmationCode.'_'.Auth::user()->id;

        if(!isset($document)){
            return Redirect::back()->with('errorMsg', 'Please attach a document before submitting');
        }

        if(!isset($keySkills)){
            return Redirect::back()->with('errorMsg', 'Please attach at least 2 (Two) certification of skill before submitting');
        }else if(count($keySkills) < 2){
            return Redirect::back()->with('errorMsg', 'Please attach at least 2 (Two) certification of skill before submitting');
        }

        // UPLOADING DOCUMENT
        $rules = array('file' => 'required|mimes:pdf,doc,docx');
        $validator = Validator::make(array('file'=> $document), $rules);
        if($validator->passes()){
            $filename   =   $document->getClientOriginalName();
            $upload_success =   $document->move($destinationPath, $filename);

            Document::insert(array(
                'user_id'       =>  Auth::user()->id,
                'docname'       =>  $filename,
                'path'          =>  '/upload/'.Auth::user()->confirmationCode.'_'.Auth::user()->id.'/'.$filename,
                'type'          =>  'DOCUMENT',
                'created_at'    =>  date("Y:m:d H:i:s"),
                'updated_at'    =>  date("Y:m:d H:i:s"),
            ));
        }else{
            return Redirect::back()->with('errorMsg', $validator);
        }

        // UPLOADING KEYSKILLS (IMAGES)

        $rules = array('file' => 'required|mimes:png,jpeg,jpg');

        foreach($keySkills as $ks){
            $newFileName = md5(uniqid(rand(), true));
            $validator = Validator::make(array('file'=> $ks), $rules);
            if($validator->passes()){
                $filename = $newFileName.'.'.$ks->getClientOriginalExtension();
                $upload_success = $ks->move($destinationPath, $filename);

                Photo::insert(array(
                    'user_id'       =>  Auth::user()->id,
                    'imgname'       =>  $filename,
                    'path'          =>  '/upload/'.Auth::user()->confirmationCode.'_'.Auth::user()->id.'/'.$filename,
                    'type'          =>  'KEYSKILLS',
                    'created_at'    =>  date("Y:m:d H:i:s"),
                    'updated_at'    =>  date("Y:m:d H:i:s"),
                ));
            }else{
                return Redirect::back()->with('errorMsg', $validator);
            }
        }

        AuditTrail::insert(array(
            'user_id'   =>  Auth::user()->id,
            'content'   =>  'Uploaded files for full activation at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.Auth::user()->id
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        return Redirect::back()->with('errorMsg', 'Upload successful. Please while your profile is being reviewed. This might take more or less than (24) hours.');
    }

    public function taskDetails($id){
        $taskType = Task::where('id', $id)->pluck('hiringType');

        if($taskType == 'BIDDING'){
            return View::make('taskminator.taskDetails_bid')
                ->with('task', Task::where('id', $id)->first())
                ->with('bid', TaskHasBidder::where('taskminator_id', Auth::user()->id)->first());
//                ->with('bidders', TaskHasBidder::where('task_id', $id)->get());

        }else if($taskType == 'AUTOMATIC'){
            return View::make('taskminator.taskDetails_direct')
                ->with('task', Task::where('id', $id)->first())
                ->with('hired', TaskHasTaskminator::where('task_id', $id)->get());
        }else{
            return View::make('taskminator.taskDetails_direct')
                ->with('task', Task::where('id', $id)->first())
                ->with('bidders', TaskHasTaskminator::where('task_id', $id)->get());
        }
    }

    public function tskmntr_taskOffers(){
        $taskOffer = Task::join('taskminator_has_offer', 'tasks.id', '=', 'taskminator_has_offer.task_id')
            ->where('taskminator_has_offer.taskminator_id', Auth::user()->id)
            ->where('tasks.status', 'OPEN')
            ->select([
                'tasks.id',
                'tasks.name',
                'tasks.created_at as taskDate',
                'taskminator_has_offer.created_at as offerDate',
                'tasks.deadline',
                'tasks.user_id',
            ])
//            ->get();
            ->paginate(10);

        return View::make('taskminator.currentTask')
            ->with('taskOffer', $taskOffer)
            ->with('pageTitle', 'Task Offers');
    }

    public function tskmntr_taskBids(){
        $tasksBid = Task::join('task_has_bidders', 'tasks.id', '=', 'task_has_bidders.task_id')
            ->where('task_has_bidders.taskminator_id', Auth::user()->id)
            ->where('tasks.status', 'OPEN')
            ->select([
                'tasks.id',
                'tasks.name',
                'tasks.created_at as taskDate',
                'task_has_bidders.created_at as bidDate',
                'tasks.deadline',
                'tasks.user_id',
            ])
//            ->get();
            ->paginate(10);

        return View::make('taskminator.currentTask')
            ->with('tasksBid', $tasksBid)
            ->with('pageTitle', 'Task Bids');
    }

    public function tskmntr_onGoing(){
        $tasksTaken = Task::join('task_has_taskminator', 'tasks.id', '=', 'task_has_taskminator.task_id')
            ->where('task_has_taskminator.taskminator_id', Auth::user()->id)
            ->where('tasks.status', 'ONGOING')
            ->select([
                'tasks.id',
                'tasks.name',
                'tasks.created_at as taskDate',
                'task_has_taskminator.created_at as hireDate',
                'tasks.deadline',
                'tasks.user_id',
            ])
//            ->get();
            ->paginate(10);

        return View::make('taskminator.currentTask')
            ->with('tasksTaken', $tasksTaken)
            ->with('pageTitle', 'On Going Tasks');
    }

    public function tskmntr_completed(){
        $tasksDone = Task::join('task_has_taskminator', 'tasks.id', '=', 'task_has_taskminator.task_id')
            ->where('task_has_taskminator.taskminator_id', Auth::user()->id)
            ->where('tasks.status', 'COMPLETE')
            ->select([
                'tasks.id',
                'tasks.name',
                'tasks.created_at as taskDate',
                'task_has_taskminator.created_at as hireDate',
                'tasks.deadline',
                'tasks.user_id',
                'tasks.completed_at',
            ])
//            ->get();
            ->paginate(10);

        return View::make('taskminator.currentTask')
            ->with('tasksDone', $tasksDone)
            ->with('pageTitle', 'Completed Tasks');
    }

    public function cancelBid($id){
        TaskHasBidder::where('task_id', $id)->where('taskminator_id', Auth::user()->id)->delete();

        AuditTrail::insert(array(
            'user_id'   =>  Auth::user()->id,
            'content'   =>  'Cancelled bid on task titled <span style="color: #2980B9;">'.Task::where('id', $id)->pluck('name').'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$id
        ));

        return Redirect::back()->with('errorMsg', 'Bid has been cancelled');
    }

    public function viewClient($id){
        $role = User::join('user_has_role', 'user_has_role.user_id', '=', 'users.id')->where('users.id', $id)->pluck('role_id');
//        if($role == 4){
//
//        }else if()
        return View::make('taskminator.viewClient')->with('client', User::where('id', $id)->first());
    }

    public function confirmOffer($taskid){
        date_default_timezone_set("Asia/Manila");
        $taskDetails = Task::where('id', $taskid)->first();
        $threadCode = $this->generateUniqueId();
        $authUserId = Auth::user()->id;
        $currentDate = date('Y:m:d H:i:s');
        $taskName = $taskDetails->name;
        $clientDetails = User::where('id', $taskDetails->user_id)->first();
        $mobileNum = Contact::where('user_id', $clientDetails->id)->where('ctype', 'mobileNum')->pluck('content');

        if($clientDetails->points < 25){
            return Redirect::back()->with('errorMsg', 'Cannot accept request because client has insufficient funds.');
        }else{
            User::where('id', $clientDetails->id)->update(array('points' => ($clientDetails->points - 25)));
        }

        TaskminatorHasOffer::where('task_id', $taskid)->delete();

        TaskHasTaskminator::insert(array(
            'task_id'   =>  $taskid,
            'taskminator_id'   =>  Auth::user()->id,
            'proposedRate'   =>  $taskDetails->salary,
//            'message'   =>  $bidInfo->message,
            'created_at'   =>  date("Y:m:d H:i:s"),
        ));

        Task::where('id', $taskid)->update(array(
            'status'    =>  'ONGOING'
        ));

        // CREATE THREAD FOR CHAT MODULE
        DB::insert("INSERT INTO `threads` (`user_id`, `task_id`,`title`, `code`, `created_at`, `status`) VALUES
            ('$authUserId', '$taskid', '$taskName', '$threadCode', '$currentDate', 'OPEN'),
            ('$clientDetails->id', '$taskid', '$taskName', '$threadCode', '$currentDate', 'OPEN')
        ");

//        DB::insert("INSERT INTO `threads` (`user_id`, `title`, `code`, `created_at`) VALUES
//            ('$authUserId', '$taskName', '$threadCode', '$currentDate'),
//            ('$clientDetails->id', '$taskName', '$threadCode', '$currentDate')
//        ");

        Notification::insert(array(
            'content'   =>  "Your offer to ".Auth::user()->fullName." has been accepted for task ".$taskDetails->name,
            'user_id'   =>  $clientDetails->id,
            'notif_url' =>  '/taskDetails_'.$taskDetails->id,
            'status'    =>  'NEW',
            'created_at'=>  date("Y:m:d H:i:s")
        ));

        $smsMessage = "Your offer to ".Auth::user()->fullName." has been accepted for task ".$taskDetails->name;
        $this->sendSms($mobileNum, $smsMessage, $clientDetails->id);

        AuditTrail::insert(array(
            'user_id'       =>  $clientDetails->id,
            'content'       =>  'Offer accepted by <span style="color:#2980B9">'.Auth::user()->fullName.'</span> for task <span style="color:#16A085">'.$taskDetails->name.'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskid
        ));

        AuditTrail::insert(array(
            'user_id'       =>  Auth::user()->id,
            'content'       =>  'Accepted task offered by '.$clientDetails->fullName.' for <span style="color:#16A085">'.$taskDetails->name.'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskid
        ));

        return Redirect::to('/taskDetails_'.$taskid)
                ->with('successMsg', 'Task has been accepted');
    }

    public function denyOffer($taskId){

        $taskDetails = Task::where('id', $taskId)->first();
        $clientDetails = User::where('id', $taskDetails->user_id)->first();
        $mobileNum = Contact::where('user_id', $clientDetails->id)->where('ctype', 'mobileNum')->pluck('content');

        date_default_timezone_set("Asia/Manila");
        TaskminatorHasOffer::where('taskminator_id', Auth::user()->id)->where('task_id', $taskId)->delete();

        Notification::insert(array(
            'content'   =>  "Your offer to ".Auth::user()->fullName." has been deniend for task ".$taskDetails->name,
            'user_id'   =>  $clientDetails->id,
            'notif_url' =>  '/taskDetails_'.$taskDetails->id,
            'status'    =>  'NEW',
            'created_at'=>  date("Y:m:d H:i:s")
        ));

        $smsMessage = "Your offer to ".Auth::user()->fullName." has been deniend for task ".$taskDetails->name;
        $this->sendSms($mobileNum, $smsMessage, $clientDetails->id);

        AuditTrail::insert(array(
            'user_id'       =>  $clientDetails->id,
            'content'       =>  'Offer denied by <span style="color:#2980B9">'.Auth::user()->fullName.'</span> for task <span style="color:#16A085">'.$taskDetails->name.'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskId
        ));

        AuditTrail::insert(array(
            'user_id'       =>  Auth::user()->id,
            'content'       =>  'Deniend task offered by '.$clientDetails->fullName.' for <span style="color:#16A085">'.$taskDetails->name.'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskId
        ));

        return Redirect::back()->with('successMsg', 'Offer has been denied');
    }

    public function editPersonalInfo(){
        return View::make('taskminator.editPersonalInfo')
                ->with('user', Auth::user())
                ->with('cities', City::orderBy('cityname', 'ASC')->get())
                ->with('barangays', Barangay::orderBy('bgyname', 'ASC')->where('citycode', Auth::user()->city)->get());
    }

    public function doEditPersonalInfo(){
        // FIRSTNAME VALIDATION
        if(!ctype_alpha(str_replace(' ', '', trim(Input::get('firstName'))))){
            return Redirect::back()->with('errorMsg', 'First name must be letters only')->withInput(Input::except('password'));
        }else if(strlen(trim(Input::get('firstName'))) == 0){
            return Redirect::back()->with('errorMsg', 'First name cannot be empty')->withInput(Input::except('password'));
        }

        // MIDDLE NAME VALIDATION
        if(!ctype_alpha(str_replace(' ', '', trim(Input::get('midName'))))){
            return Redirect::back()->with('errorMsg', 'Middle name must be letters only')->withInput(Input::except('password'));
        }else if(strlen(trim(Input::get('midName'))) == 0){
            return Redirect::back()->with('errorMsg', 'Middle name cannot be empty')->withInput(Input::except('password'));
        }

        // LAST NAME VALIDATION
        if(!ctype_alpha(str_replace(' ', '', trim(Input::get('lastName'))))){
            return Redirect::back()->with('errorMsg', 'Last name must be letters only')->withInput(Input::except('password'));
        }else if(strlen(trim(Input::get('lastName'))) == 0){
            return Redirect::back()->with('errorMsg', 'Last name cannot be empty')->withInput(Input::except('password'));
        }

        // ADDRESS VALIDATION
        if(strlen(Input::get('address')) == 0){
            return Redirect::back()->with('errorMsg', 'Address cannot be empty')->withInput(Input::except('password'));
        }else if(strlen(strip_tags(Input::get('address'))) == 0){
            return Redirect::back()->with('errorMsg', 'Address cannot contain tags')->withInput(Input::except('password'));
        }

        // CITY VALIDATION
        if(Input::get('city-task') == null || Input::get('city-task') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be empty')->withInput(Input::except('password'));
        }

        // BARANGAY VALIDATION
        if(Input::get('barangay-task') == null || Input::get('barangay-task') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be empty')->withInput(Input::except('password'));
        }

        User::where('id', Auth::user()->id)->update(array(
            'firstName'         =>  Input::get('firstName'),
            'midName'           =>  Input::get('midName'),
            'lastName'          =>  Input::get('lastName'),
            'fullName'          =>  Input::get('firstName').' '.Input::get('midName').' '.Input::get('lastName'),
            'gender'            =>  Input::get('gender'),
            'address'           =>  strip_tags(Input::get('address')),
            'city'              =>  Input::get('city-task'),
            'barangay'          =>  Input::get('barangay-task'),
        ));

        return Redirect::back()
                ->with('successMsg', 'Personal Information has been successfully edited.');
    }

    public function editContactInfo(){
        return View::make('taskminator.editContactInfo')
            ->with('contacts', Contact::where('user_id', Auth::user()->id)->get());
    }

    public function doEditContactInfo(){
        // EMAIL VALIDATION
        if(!$this->emailValidate(Input::get('email'))){
            return Redirect::back()->with('errorMsg', 'Please enter valid email')->withInput(Input::except('password'));
        }else if(Contact::where('ctype', 'email')->where('content', Input::get('email'))->whereNotIn('user_id', [Auth::user()->id])->count() > 0){
            return Redirect::back()->with('errorMsg', 'Email is already taken')->withInput(Input::except('password'));
        }

        // FACEBOOK VALIDATION
        if(strlen(trim(strip_tags(Input::get('facebook')))) == 0){
            return Redirect::back()->with('errorMsg', 'Facebook field cannot be empty')->withInput(Input::except('password'));
        }

        // LINKEDIN VALIDATION
        if(strlen(trim(strip_tags(Input::get('linkedin')))) == 0){
            return Redirect::back()->with('errorMsg', 'LinkedIn field cannot be empty')->withInput(Input::except('password'));

        }

        // MOBILE NUMBER VALIDATION
        if(!ctype_digit(Input::get('mobileNum'))){
            return Redirect::back()->with('errorMsg', 'Mobile number must be numbers only')->withInput(Input::except('password'));
        }else if(strlen(Input::get('mobileNum')) == 0 || strlen(Input::get('mobileNum')) < 11){
            return Redirect::back()->with('errorMsg', 'Mobile number cannot be empty and must be more than 11 digits')->withInput(Input::except('password'));
        }
        Contact::where('user_id', Auth::user()->id)->delete();
        Contact::insert(array(
            array(
                'user_id'       =>  Auth::user()->id,
                'ctype'       =>  'email',
                'content'       =>  Input::get('email'),
            ),
            array(
                'user_id'       =>  Auth::user()->id,
                'ctype'       =>  'facebook',
                'content'       =>  Input::get('facebook'),
            ),
            array(
                'user_id'       =>  Auth::user()->id,
                'ctype'       =>  'linkedin',
                'content'       =>  Input::get('linkedin'),
            ),
            array(
                'user_id'       =>  Auth::user()->id,
                'ctype'       =>  'mobileNum',
                'content'       =>  Input::get('mobileNum'),
            )
        ));

        return Redirect::back()->with('successMsg', 'Successfully edited contact information.');
    }

//    public function doEditContactInfo(){
////        dd(Input::all());
//        $query = Contact::where('user_id', Auth::user()->id);
////        $query->delete();
//        foreach(Input::all() as $key => $value){
//            foreach($value as $val){
////                var_dump($val.'<br/>');
//                switch($key){
//                    case 'email'        :
//                        if(!$this->emailValidate($val){
//                            return Redirect::back()->with('errorMsg', 'Please enter valid email')->withInput(Input::except('password'));
//                        }else if(Contact::where('ctype', 'email')->where('content', Input::get('email'))->count() > 0){
//                            return Redirect::back()->with('errorMsg', 'Email is already taken')->withInput(Input::except('password'));
//                        }
//                        break;
//                    case 'facebook'     :
//                        break;
//                    case 'linkedin'     :
//                        break;
//                    case 'mobileNum'    :
//                        break;
//                }
//
////                $query->insert(array(
////                    'user_id'   =>  Auth::user()->id,
////                    'ctype'     =>  $key,
////                    'content'   =>  $val
////                ));
//            }
//        }
//
////        return Redirect::back()->with('successMsg', 'Successfully edited contact information.');
//    }

    public function editSkillInfo(){
        $query = TaskminatorHasSkill::join('taskcategory', 'taskcategory.categorycode', '=', 'taskminator_has_skills.taskcategory_code')
                ->join('taskitems', 'taskitems.itemcode', '=', 'taskminator_has_skills.taskitem_code')
                ->where('taskminator_has_skills.user_id', Auth::user()->id)
                ->select([
                    'taskminator_has_skills.taskitem_code',
                    'taskminator_has_skills.taskcategory_code',
                    'taskminator_has_skills.user_id',
                    'taskitems.itemname',
                    'taskcategory.categoryname',
                ])
                ->get();

        return View::make('taskminator.editSkillInfo')
                ->with('skills', $query)
                ->with('categories', TaskCategory::orderBy('categoryname', 'ASC')->get())
                ->with('categorySkills', TaskItem::where('item_categorycode', '006')->orderBy('itemname', 'ASC')->get());
    }

    public function doEditSkillInfo(){
        $query = TaskminatorHasSkill::where('user_id', Auth::user()->id);
        if($query->where('taskitem_code', Input::get('taskitems'))->count() > 0){
            return Redirect::back()->with('errorMsg', 'You already have this skill');
        }else{
            TaskminatorHasSkill::insert(array(
                'user_id'           =>  Auth::user()->id,
                'taskitem_code'     =>  Input::get('taskitems'),
                'taskcategory_code' =>  Input::get('taskcategory')
            ));

            return Redirect::back()->with('successMsg', 'Skill successfully added');
        }
    }

    public function removeSkill($taskitemId){
        TaskminatorHasSkill::where('user_id', Auth::user()->id)
            ->where('taskitem_code', $taskitemId)->delete();

        return Redirect::back()->with('successMsg', 'Skill successfully deleted');
    }

    public function editPass(){
        return View::make('taskminator.changePass');
    }

    public function doEditPass(){
        if(!Auth::attempt(array('username'=>Auth::user()->username, 'password' => Input::get('oldPass')))){
            return Redirect::back()->with('errorMsg', 'Your old password is incorrect');
        }

        if(Input::get('newPass') != Input::get('confirmNewPass')){
            return Redirect::back()->with('errorMsg', 'Passwords does not match');
        }

        // PASSWORD VALIDATION
        if(!ctype_alnum(Input::get('newPass'))){
            return Redirect::back()->with('errorMsg', 'Password must be alphanumeric (numbers and letters) only');
        }else if(strlen(Input::get('newPass')) < 8){
            return Redirect::back()->with('errorMsg', 'Password must be more than 8 characters');
        }

        User::where('id', Auth::user()->id)->update(array(
            'password'  =>  Hash::make(Input::get('newPass'))
        ));

        return Redirect::back()->with('successMsg', 'Password successfully changed');
    }

    public function sendVerificationCode(){
        //Generate PIN CODE
        $letters = '01234ABCDEFGHIJKLM56789NOPQRSTUVWXYZ';
        $key = '';
        for($i = 1; $i <= 5; $i++)
        {
         $key .= $letters[mt_rand(0, strlen($letters) - 1)];
        }
        //END OF Generate PIN CODE


        //INSERT PINCODE TO DB
         DB::table('contacts')
                ->where('user_id', Auth::user()->id)
                ->update(['pincode' => $key]);

        //GET Mobile Number
        $mobileNum = Contact::where('user_id', Auth::user()->id )->where('ctype', 'mobileNum')->pluck('content');

        //Send PIN to Mobile Number via SMS
        $arr_post_body = array(
            "message_type" => "SEND",
            "mobile_number" =>  $mobileNum,
            "shortcode" => "292906377",
            "message_id" => "12345678901234567890123456789012",
          //  "message" => urlencode("Hello World this is from proveek testing app. Pogi ni sir dean!"),
            "message" => $key." .Use this to verify your mobile number in Proveek.", 
            "client_id" => "6df7472869b1ae7542fedd1244bc588aa4215564a0ad064a08a2001f8701fdb2",
            "secret_key" => "6389e577850a038b66a1274c789e7b8c13493efcfeda56a15b4e57f171d216b0"
        );

        $query_string = "";
        foreach($arr_post_body as $key => $frow)
            {
                $query_string .= '&'.$key.'='.$frow;
            }

        $URL = "https://post.chikka.com/smsapi/request";

        $curl_handler = curl_init();
        curl_setopt($curl_handler, CURLOPT_URL, $URL);
        curl_setopt($curl_handler, CURLOPT_POST, count($arr_post_body));
        curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
        curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handler);
        curl_close($curl_handler);

        return View::make('taskminator.doVerifyMobileNumber')
           ->with('contacts', Contact::where('user_id', Auth::user()->id)->get());
    }    

    public function doVerifyMobileNumber(){
        // pincode already verified
        $pincode = Contact::where('user_id', Auth::user()->id)->pluck('pincode');
        if($pincode == 'verified'){
            //return View::make('editProfile_tskmntr')->with('user', User::where('id', Auth::user()->id)->first());       
            return View::make('verifysuccess');
        }
        if($pincode == null){
            $this->sendVerificationCode();    
        }
    
        return View::make('taskminator.doVerifyMobileNumber')
           ->with('contacts', Contact::where('user_id', Auth::user()->id)->get());
    }

    public function verifyPIN(){
        // trim white space
        Input::merge(array_map('trim', Input::all()));

        //GET PIN FROM DB
        $pin = Contact::where('user_id',  Auth::user()->id)->pluck('pincode');

        // pincode already verified
        if($pin == 'verified'){
            //return View::make('editProfile_tskmntr')->with('user', User::where('id', Auth::user()->id)->first());       
            return View::make('verifysuccess');
        }

        //VALIDATE USER INPUT
        $rules = array(
            'pinCode' => "required"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()){
            //echo $validator->messages()->first();
            return Redirect::back()->with('errorMsg', $validator->messages()->first());
        }

        // check if matched
        if(Input::get('pinCode') == $pin){

            //UPDATE TEH CONTACT STATUS OF MOBILE NUMBER
             DB::table('contacts')
                ->where('user_id', Auth::user()->id)
                ->where('ctype', 'mobileNum' )
                ->update(['pincode' => 'verified']);          

            //return View::make('editProfile_tskmntr')->with('user', User::where('id', Auth::user()->id)->first());       
            return View::make('verifysuccess');
        }
        else{
            return Redirect::back()->with('errorMsg', 'Wrong Pin Code')->withInput(Input::except('inputpin'));
        }
    }
}
