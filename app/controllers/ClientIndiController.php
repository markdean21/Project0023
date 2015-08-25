<?php

class ClientIndiController extends \BaseController {

    function emailValidate($email){
        return preg_match('/^(([^<>()[\]\\.,;:\s@"\']+(\.[^<>()[\]\\.,;:\s@"\']+)*)|("[^"\']+"))@((\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\])|(([a-zA-Z\d\-]+\.)+[a-zA-Z]{2,}))$/', $email);
    }

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

    public function createTask(){
        $role = Auth::user()->accountType;
        $totalPost = Task::where('user_id', Auth::user()->id)->whereRaw("DATE(created_at) = '".date("Y:m:d")."'")->count();

        if($role == 'BASIC'){
            if($totalPost >= 5){
                return Redirect::back()->with('errorMsg', 'You have reached the task limit for today (5 task posts). If you want to increase limit you can upgrade your account. Click here for more details');
            }
        }else if($role == 'PREMIUM'){
            if($totalPost >= 8){
                return Redirect::back()->with('errorMsg', 'You have reached the task limit for today (8 task posts). If you want to increase limit you can upgrade your account. Click here for more details');
            }
        }else if($role == 'ULTIMATE'){
            if($totalPost >= 15){
                return Redirect::back()->with('errorMsg', 'You have reached the task limit for today (15 task posts). If you want to increase limit you can upgrade your account. Click here for more details');
            }
        }

        return View::make('client.createTask')
            ->with('regions', Region::all())
            ->with('barangays', Barangay::where('citycode', '012801')->orderBy('bgyname', 'ASC')->get())
            ->with('cities', City::where('regcode', '01')->orderBy('cityname', 'ASC')->get())
            ->with('taskcategories',TaskCategory::orderBy('categoryname', 'ASC')->get())
//            ->with('taskitems', TaskItem::orderBy('itemname', 'ASC')->get())
            ->with('intiTaskitems', TaskItem::where('item_categorycode', '006')->orderBy('itemname', 'ASC')->get());
    }

    public function doCreateTask(){

        // CHECK IF CLIENT HAS ENOUGH POINTS FOR A DIRECT TASK
        switch(Input::get('hiringType')){
            case 'DIRECT'   :
                switch(Input::get('worktime')){
                    case 'PTIME'    :
                        if(Auth::user()->points < 25){
                            return Redirect::back()
                                ->with('errorMsg', 'You must have at least 25 points to create a Direct Task with a Part Time working time (Points will still be deducted upon successful hiring)')
                                ->withInput(Input::except('password'));
                        }
                        break;
                    case 'FTIME'    :
                        if(Auth::user()->points < 100){
                            return Redirect::back()
                                ->with('errorMsg', 'You must have at least 100 points to create a Direct Task with a Full Time Time working time (Points will still be deducted upon successful hiring)')
                                ->withInput(Input::except('password'));
                        }
                        break;
                }
                break;
        }

        // VALIDATE TASK TITLE
        if(Input::get('title') == null || strlen(str_replace(' ', '', strip_tags(Input::get('title')))) == 0){
            return Redirect::back()->with('errorMsg', 'Title cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE CITY
        if(Input::get('city') == null || Input::get('city') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE BARANGAY
        if(Input::get('barangay') == null || Input::get('barangay') == 0){
            return Redirect::back()->with('errorMsg', 'Barangay cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE WORK TIME
        if(Input::get('worktime') == null){
            return Redirect::back()->with('errorMsg', 'Work time cannot be null or empty')->withInput(Input::except('password'));
        }
        // VALIDATE TASK CATEGORY
        if(Input::get('taskcategory') == 0 || Input::get('taskcategory') == null){
            return Redirect::back()->with('errorMsg', 'City cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE TASK TYPE
        if(Input::get('taskitems') == 0 || Input::get('taskitems') == null){
            return Redirect::back()->with('errorMsg', 'City cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE SALARY RANGE
        if(!ctype_digit(Input::get('salaryRange'))){
            return Redirect::back()->with('errorMsg', 'Salary only accepts numbers')->withInput(Input::except('password'));
        }else if(Input::get('salaryRange') < 1){
            return Redirect::back()->with('errorMsg', 'Salary cannot be 0')->withInput(Input::except('password'));
        }

        // VALIDATE DESCRIPTION
        if(strlen(strip_tags(Input::get('description'))) == 0){
            return Redirect::back()->with('errorMsg', 'Please enter a description for your task')->withInput(Input::except('password'));
        }

        // VALIDATE TOS
        if(!Input::get('TOS')){
            return Redirect::back()->with('errorMsg', 'You must agree to Terms of Agreements (TOS) to create a task')->withInput(Input::except('password'));
        }

        // VALIDATE MODE OF PAYMENT
//        dd(Input::get('modeOfPayment'));
        if(Input::get('modeOfPayment') == null){
            return Redirect::back()->with('errorMsg', 'Please choose a mode of payment')->withInput(Input::except('password'));
        }

        // VALIDATE COUNTRY
        if(Input::get('country') != null){
            $country = Input::get('country');
        }else{
            $country = 'PHILIPPINES';
        }

        // VALIDATE DEADLINE
        if(Input::get('deadline') == '' || Input::get('deadline') == null){
            return Redirect::back()->with('errorMsg', 'Please choose a deadline')->withInput(Input::except('password'));
        }else if(!$this->validateDate(Input::get('deadline'))){
            return Redirect::back()->with('errorMsg', 'Please choose a deadline')->withInput(Input::except('password'));
        }else if(date_create(Input::get('deadline')) < date_create('today')){
            return Redirect::back()->with('errorMsg', 'Deadline date cannot be a past date')->withInput(Input::except('password'));
        }

        // HIRING TYPE VALIDATION
        if(Input::get('hiringType') == null){
            return Redirect::back()->with('errorMsg', 'Please choose a hiring type')->withInput(Input::except('password'));
        }

        date_default_timezone_set("Asia/Manila");
        Task::insert(array(
            'user_id'           =>  Auth::user()->id,
            'name'              =>  strip_tags(Input::get('title')),
            'description'       =>  strip_tags(Input::get('description')),
            'salary'            =>  Input::get('salaryRange'),
            'status'            =>  'OPEN',
            'worktime'          =>  Input::get('worktime'),
            'taskCategory'      =>  Input::get('taskcategory'),
            'taskType'          =>  Input::get('taskitems'),
            'country'           =>  $country,
            'city'              =>  Input::get('city'),
            'barangay'          =>  Input::get('barangay'),
            'modeOfPayment'     =>  Input::get('modeOfPayment'),
            'hiringType'        =>  Input::get('hiringType'),
            'deadline'          =>  Input::get('deadline'),
            'created_at'        =>  date("Y:m:d H:i:s"),
            'updated_at'        =>  date("Y:m:d H:i:s"),
        ));

//        $taskId = DB::connection('mysql')->pdo->lastInsertId();
        date_default_timezone_set("Asia/Manila");
        AuditTrail::insert(array(
            'user_id'       =>  Auth::user()->id,
            'content'       =>  'Created a task  at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.DB::getPdo()->lastInsertId()
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        return Redirect::to('/tasks');
    }

    public function messages(){

    }

    public function editTask($id){
//        dd(Task::join('task_has_bidders', 'tasks.id', '=', 'task_has_bidders.task_id')->where('tasks.id', $id)->count());
        if(Task::join('task_has_bidders', 'tasks.id', '=', 'task_has_bidders.task_id')->where('tasks.id', $id)->count() > 0 || Task::join('task_has_taskminator', 'tasks.id', '=', 'task_has_taskminator.task_id')->where('tasks.id', $id)->count() > 0){
            return Redirect::back()->with('errorMsg', 'A Taskminator(s) has already been hired or have bid on this task.');
        }

        $task = Task::where('id', $id)->first();

        return View::make('client.editTask')
            ->with('task', $task)
            ->with('regions', Region::orderBy('regname', 'ASC')->get())
            ->with('cities', City::orderBy('cityname', 'ASC')->get())
            ->with('barangays', Barangay::where('bgycode', $task->barangay)->get())
            ->with('taskcategories',TaskCategory::orderBy('categoryname', 'ASC')->get())
//            ->with('taskitems', TaskItem::orderBy('itemname', 'ASC')->get())
            ->with('intiTaskitems', TaskItem::where('item_categorycode', $task->taskCategory)->orderBy('itemname', 'ASC')->get());
    }

    public function doEditTask(){
        // VALIDATE TASK TITLE
        if(Input::get('title') == null || strlen(str_replace(' ', '', strip_tags(Input::get('title')))) == 0){
            return Redirect::back()->with('errorMsg', 'Title cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE REGION
        if(Input::get('region') == null || Input::get('region') == 0){
            return Redirect::back()->with('errorMsg', 'Region cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE CITY
        if(Input::get('city') == null || Input::get('city') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE BARANGAY
        if(Input::get('barangay') == null || Input::get('barangay') == 0){
            return Redirect::back()->with('errorMsg', 'Barangay cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE WORK TIME
        if(Input::get('worktime') == null){
            return Redirect::back()->with('errorMsg', 'Work time cannot be null or empty')->withInput(Input::except('password'));
        }
        // VALIDATE TASK CATEGORY
        if(Input::get('taskcategory') == 0 || Input::get('taskcategory') == null){
            return Redirect::back()->with('errorMsg', 'City cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE TASK TYPE
        if(Input::get('taskitems') == 0 || Input::get('taskitems') == null){
            return Redirect::back()->with('errorMsg', 'City cannot be null or empty')->withInput(Input::except('password'));
        }

        // VALIDATE SALARY RANGE
        if(!ctype_digit(Input::get('salaryRange'))){
            return Redirect::back()->with('errorMsg', 'Salary only accepts numbers')->withInput(Input::except('password'));
        }else if(Input::get('salaryRange') < 1){
            return Redirect::back()->with('errorMsg', 'Salary cannot be 0')->withInput(Input::except('password'));
        }

        // VALIDATE DESCRIPTION
        if(strlen(strip_tags(Input::get('description'))) == 0){
            return Redirect::back()->with('errorMsg', 'Please enter a description for your task')->withInput(Input::except('password'));
        }

        // VALIDATE MODE OF PAYMENT
//        dd(Input::get('modeOfPayment'));
        if(Input::get('modeOfPayment') == null){
            return Redirect::back()->with('errorMsg', 'Please choose a mode of payment')->withInput(Input::except('password'));
        }

        // VALIDATE COUNTRY
        if(Input::get('country') != null){
            $country = Input::get('country');
        }else{
            $country = 'PHILIPPINES';
        }

        // VALIDATE DEADLINE
        if(Input::get('deadline') == '' || Input::get('deadline') == null){
            return Redirect::back()->with('errorMsg', 'Please choose a deadline')->withInput(Input::except('password'));
        }else if(!$this->validateDate(Input::get('deadline'))){
            return Redirect::back()->with('errorMsg', 'Please choose a deadline')->withInput(Input::except('password'));
        }else if(date_create(Input::get('deadline')) < date_create('today')){
            return Redirect::back()->with('errorMsg', 'Deadline date cannot be a past date')->withInput(Input::except('password'));
        }

        // HIRING TYPE VALIDATION
        if(Input::get('hiringType') == null){
            return Redirect::back()->with('errorMsg', 'Please choose a hiring type')->withInput(Input::except('password'));
        }
//        dd(Input::all());

        date_default_timezone_set("Asia/Manila");
        Task::where('id', Input::get('taskId'))->update(array(
            'user_id'           =>  Auth::user()->id,
            'name'              =>  strip_tags(Input::get('title')),
            'description'       =>  strip_tags(Input::get('description')),
            'salary'            =>  Input::get('salaryRange'),
            'status'            =>  'OPEN',
            'worktime'          =>  Input::get('worktime'),
            'taskCategory'      =>  Input::get('taskcategory'),
            'taskType'          =>  Input::get('taskitems'),
            'country'           =>  $country,
            'city'              =>  Input::get('city'),
            'barangay'          =>  Input::get('barangay'),
            'modeOfPayment'     =>  Input::get('modeOfPayment'),
            'hiringType'        =>  Input::get('hiringType'),
            'deadline'          =>  Input::get('deadline'),
            'updated_at'        =>  date("Y:m:d H:i:s"),
        ));

        AuditTrail::insert(array(
            'user_id'   =>  Auth::user()->id,
            'content'   =>  'Edited a task at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.Input::get('taskId')
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));
//        return Redirect::to('/')->with('errorMsg', 'Task has been successfully edited.');
        return Redirect::back()->with('successMsg', 'Task has been successfully edited.');
    }

    public function deleteTask($id){
        date_default_timezone_set("Asia/Manila");
        $taskQuery = Task::where('id', $id);
        $taskQuery->update(array('status' => 'CANCELLED', 'cancelled_at' => date("Y:m:d H:i:s")));
        $taskName = $taskQuery->pluck('name');

        TaskHasTaskminator::where('task_id', $id)->delete();
        TaskHasBidder::where('task_id', $id)->delete();

        Thread::where('task_id', $id)
        ->update(array(
            'status' => 'CLOSED'
        ));

        AuditTrail::insert(array(
            'user_id'   =>  Auth::user()->id,
            'content'   =>  'Cancelled a task titled : <span style="color: blue">'. $taskName .'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$id
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        return Redirect::back();
//        return Redirect::to('/taskDetails/'.$id);
    }

    public function tasks(){
        return View::make('client.taskList')->with('tasks', Task::where('user_id', Auth::user()->id)->whereNotIn('status', ['CANCELLED', 'COMPLETE'])->orderBy('created_at', 'DESC')->paginate(10));
    }

    public function taskDetails($id){
        $taskType = Task::where('id', $id)->pluck('hiringType');

        if($taskType == 'BIDDING'){
            return View::make('client.taskDetails_bid')
                ->with('task', Task::where('id', $id)->first())
                ->with('bidders', TaskHasBidder::where('task_id', $id)->get());
        }else if($taskType == 'AUTOMATIC'){
            return View::make('client.taskDetails_direct')
                ->with('task', Task::where('id', $id)->first())
                ->with('hired', TaskHasTaskminator::where('task_id', $id)->get())
                ->with('offers', TaskminatorHasOffer::where('task_id', $id)->get());
        }else if($taskType == 'DIRECT'){
            return View::make('client.taskDetails_direct')
                ->with('task', Task::where('id', $id)->first())
                ->with('offers', TaskminatorHasOffer::where('task_id', $id)->get())
                ->with('hired', TaskHasTaskminator::where('task_id', $id)->get());
        }else{
            return Redirect::back()->with('errorMsg', 'UNKNOWN REQUEST');
        }
    }

    public function hireTskmntr($userid, $taskid){
        date_default_timezone_set("Asia/Manila");
        $client = User::where('id', Auth::user()->id);
        $taskDetails = Task::where('id', $taskid)->first();
        $threadCode = $this->generateUniqueId();
        $authUserId = Auth::user()->id;
        $currentDate = date('Y:m:d H:i:s');
        $taskName = $taskDetails->name;
        $pointDeduction = 0;
        $mobileNum = Contact::where('user_id', $userid)->where('ctype', 'mobileNum')->pluck('content');

        if($taskDetails->workTime == 'PTIME'){
            if($client->pluck('points') < 25){
                return Redirect::back()->with('errorMsg', 'You need 25 points to hire a taskminator for a part-time task. Click <a href="/addPoints_'.Auth::user()->id.'">here</a> for more details');
            }
            $pointDeduction = 25;
        }else if($taskDetails->workTime == 'FTIME'){
            if($client->pluck('points') < 100){
                return Redirect::back()->with('errorMsg', 'You need 25 points to hire a taskminator for a full-time task. Click <a href="/addPoints_'.Auth::user()->id.'">here</a> for more details');
            }
            $pointDeduction = 100;
        }else{
            return Redirect::back()->with('errorMsg', 'UNKNOWN REQUEST');
        }
//        if($client->pluck('points') < 25){
//            return Redirect::back()->with('errorMsg', 'You need 25 points to hire a taskminator. Click <a href="/addPoints_'.Auth::user()->id.'">here</a> for more details');
//        }

        $bidInfo = TaskHasBidder::where('taskminator_id', $userid)->where('task_id', $taskid)->first();

        TaskHasTaskminator::insert(array(
            'task_id'   =>  $taskid,
            'taskminator_id'   =>  $userid,
            'proposedRate'   =>  $bidInfo->proposedRate,
            'message'   =>  $bidInfo->message,
            'created_at'   =>  date("Y:m:d H:i:s"),
        ));

        Task::where('id', $taskid)->update(array(
            'status'    =>  'ONGOING'
        ));

        $client->update(array('points' => ($client->pluck('points')-$pointDeduction)));

//         CREATE THREAD FOR CHAT MODULE
        DB::insert("INSERT INTO `threads` (`user_id`, `task_id`,`title`, `code`, `created_at`, `status`) VALUES
            ('$authUserId', '$taskid', '$taskName', '$threadCode', '$currentDate', 'OPEN'),
            ('$userid', '$taskid', '$taskName', '$threadCode', '$currentDate', 'OPEN')
        ");

        Notification::insert(array(
            'content'   =>  "You've been hired!. Your bid for '.$taskDetails->name.' has been approved!",
            'user_id'   =>  $userid,
            'notif_url'       =>  '/taskDetails_'.$taskDetails->id,
            'status'    =>  'NEW',
            'created_at'=>  date("Y:m:d H:i:s")
        ));
        $smsMessage = "You've been hired!. Your bid for '.$taskDetails->name.' has been approved!";
        $this->sendSms($mobileNum, $smsMessage, $userid);

        $tskmntrDetails = User::where('id', $userid)->first();

        AuditTrail::insert(array(
            'user_id'   =>  Auth::user()->id,
            'content'   =>  'Hired <span style="color:#2980B9">'.$tskmntrDetails->fullName.'</span> for <span style="color:#16A085">'.$taskDetails->name.'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskid
        ));

        AuditTrail::insert(array(
            'user_id'   =>  $tskmntrDetails->id,
            'content'   =>  'Hired by '.Auth::user()->fullName.' for <span style="color:#16A085">'.$taskDetails->name.'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskid
        ));

        $user = User::where('id', $userid)->first();
        return Redirect::back()->with('successMsg', $user->firstName.' '.$user->lastName.' has been hired');
    }

    public function tskmntrSearch(){
        return View::make('client.tskmntrSearch')
            ->with('cities', City::orderBy('cityname', 'ASC')->get())
            ->with('directTasks', Task::where('status', 'OPEN')->where('user_id', Auth::user()->id)->where('hiringType', 'DIRECT')->get());
    }

    public function doTskmntrSearch($searchField, $searchKeyword, $city){
        $query = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')->where('users.status', 'ACTIVATED')->where('user_has_role.role_id', '2');

        if($searchField == 'fullName' || $searchField == 'username'){
            if($searchKeyword != 0){
                $query = $query->where('users.'.$searchField, 'LIKE', '%'.$searchKeyword.'%')->orderBy('users.fullName');
            }
        }

        if($searchField == 'city'){
            if($searchKeyword != 0){
                $query = $query->where('fullName', 'LIKE','%'.$searchKeyword.'%');
            }else{
                $query = $query->where($searchField, $city);
            }
        }
//        $query = $query->get();
        $query = $query->paginate(10);

        return View::make('client.tskmntrSearch')
            ->with('taskminators', $query)
            ->with('cities', City::orderBy('cityname', 'ASC')->get())
            ->with('directTasks', Task::where('status', 'OPEN')->where('user_id', Auth::user()->id)->where('hiringType', 'DIRECT')->get());
    }

    public function viewTaskminator($id){
        return View::make('client.viewTaskminator')->with('tm', User::where('id', $id)->first());
    }

    public function directHire($id){
        $tasksQuery = Task::where('user_id', Auth::user()->id)->where('status', 'OPEN')->where('hiringType', 'DIRECT')->get();
//        $tasksQuery = Task::join('taskminator_has_offer', 'taskminator_has_offer.task_id', '=', 'tasks.id')
//                        ->where('tasks.user_id', Auth::user()->id)
//                        ->where('tasks.status', 'OPEN')
//                        ->where('tasks.hiringType', 'DIRECT')
//                        ->whereNotIn('taskminator_has_offer.taskminator_id', [$id])
//                        ->get();

//        dd($tasksQuery->count());
        return View::make('client.directHireSummary')
            ->with('tasks', $tasksQuery)
//            ->with('tasks', Task::where('user_id', Auth::user()->id)->where('status', 'OPEN')->where('hiringType', 'DIRECT')->get())
            ->with('tskmntr', User::where('id', $id)->first());
    }

    public function doDirectHire($tskmntrId, $taskId){
        date_default_timezone_set("Asia/Manila");

        $taskDetails = Task::where('id', $taskId)->first();
        $tskmntrDetails = User::where('id', $tskmntrId)->first();
        $mobileNum = Contact::where('user_id', $tskmntrId)->where('ctype', 'mobileNum')->pluck('content');

        TaskminatorHasOffer::insert(array(
            'task_id'           =>  $taskId,
            'client_id'         =>  Auth::user()->id,
            'taskminator_id'    =>  $tskmntrId,
            'created_at'        =>  date("Y:m:d H:i:s"),
            'updated_at'        =>  date("Y:m:d H:i:s"),
        ));

        AuditTrail::insert(array(
            'user_id'       =>  Auth::user()->id,
            'content'       =>  'Offered task '.$taskDetails->name.' to '.$tskmntrDetails->fullName.' at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskDetails->id
        ));

        AuditTrail::insert(array(
            'user_id'       =>  $tskmntrDetails,
            'content'       =>  'Offered task '.$taskDetails->name.' by '.Auth::user()->fullName.' at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskDetails->id
        ));

        Notification::insert(array(
            'user_id'           =>  $tskmntrId,
            'content'           =>  'You have an offer! '.$taskDetails->name,
            'notif_url'         =>  'taskDetails_'.Input::get('taskid'),
            'created_at'        =>  date("Y:m:d H:i:s")
        ));

        $smsMessage = 'You have an offer! '.$taskDetails->name;
        $this->sendSms($mobileNum, $smsMessage, $tskmntrId);

        return Redirect::to('/taskDetails/'.$taskId)->with('successMsg', 'Offer has been sent.');
    }

    public function retractOffer($taskId, $tskmntrId){
        TaskminatorHasOffer::where('task_id', $taskId)->where('taskminator_id', $tskmntrId)->delete();
        return Redirect::back()->with('successMsg', 'Offer has been retracted');
    }

    public function completeTask($taskId){
        $userQuery = User::join('task_has_taskminator', 'users.id', '=', 'task_has_taskminator.taskminator_id')
            ->where('task_has_taskminator.task_id', $taskId)
            ->select([
                'users.id',
                'users.fullName',
            ])->get();

        return View::make('client.rateTaskminator')
            ->with('task', Task::where('id', $taskId)->first())
            ->with('users', $userQuery);
    }

    public function rateTaskminator(){
        $taskDetails = Task::where('id', Input::get('taskid'))->first();
        $tskmntr = User::where('id', Input::get('taskminatorid'))->first();
        $mobileNum = Contact::where('user_id', Input::get('taskminatorid'))->where('ctype', 'mobileNum')->pluck('content');

        date_default_timezone_set("Asia/Manila");
        Task::where('id', Input::get('taskid'))
        ->update(array(
            'status'        =>  'COMPLETE',
            'completed_at'  =>  date("Y:m:d H:i:s"),
            'completed_by'  =>  $tskmntr->id
        ));

        Thread::where('task_id', $taskDetails->id)
        ->update(array(
            'status' => 'CLOSED'
        ));

        Rate::insert(array(
            'taskminator_id'    =>  Input::get('taskminatorid'),
            'client_id'         =>  Auth::user()->id,
            'message'           =>  Input::get('message'),
            'stars'             =>  Input::get('star'),
            'created_at'        =>  date("Y:m:d H:i:s")
        ));

        Notification::insert(array(
            'user_id'           =>  Input::get('taskminatorid'),
            'content'           =>  'You have accomplished a task! '.$taskDetails->name.' has been accomplished!',
            'notif_url'         =>  'taskDetails_'.Input::get('taskid'),
            'created_at'        =>  date("Y:m:d H:i:s")
        ));

        $smsMessage = 'You have accomplished a task! '.$taskDetails->name.' has been accomplished!';
        $this->sendSms($mobileNum, $smsMessage, Input::get('taskminatorid'));

//        Thread::where('')

        AuditTrail::insert(array(
            'user_id'       =>  Auth::user()->id,
            'content'       =>  'Closed task : '.$taskDetails->name.' at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.Input::get('taskid')
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        AuditTrail::insert(array(
            'user_id'       =>  Auth::user()->id,
            'content'       =>  'Reviewed taskminator : '.$tskmntr->fullName.' at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.Input::get('taskminatorid')
//            'at_url'        =>  '/taskDetails/'.Input::get('taskid')
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        AuditTrail::insert(array(
            'user_id'       =>  Auth::user()->id,
            'content'       =>  'Received a review from '.Auth::user()->fullName.' for task : '.$taskDetails->name.' at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.Input::get('taskminatorid')
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        return Redirect::to('/taskDetails/'.Input::get('taskid'))->with('successMsg', 'Task Has been completed');
    }

    public function accomplishedTasks(){
        return View::make('client.taskList_complete')->with('tasks', Task::where('user_id', Auth::user()->id)->where('status', 'COMPLETE')->orderBy('completed_at', 'DESC')->get());
    }

    public function cancelledTasks(){
        return View::make('client.taskList_cancelled')->with('tasks', Task::where('user_id', Auth::user()->id)->where('status', 'CANCELLED')->orderBy('completed_at', 'DESC')->get());
    }

    public function automaticSearch($taskid){
        $taskQuery  = Task::where('id', $taskid)->first();
        if($taskQuery->status == 'ONGOING'){
            return Redirect::to('/');
        }
        $usersQuery = User::join('taskminator_has_skills', 'taskminator_has_skills.user_id', '=', 'users.id')
                        ->where('taskminator_has_skills.taskcategory_code', $taskQuery->taskCategory)
                        ->where('taskminator_has_skills.taskitem_code', $taskQuery->taskType)
                        ->select([
                            'users.fullName',
                            'users.id',
                            'users.address',
                        ])
                        ->get();

        return View::make('client.automaticSearch')
                ->with('task', $taskQuery)
                ->with('users', $usersQuery);
    }

    public function automaticOffer($taskId, $tskmntrId){
        date_default_timezone_set("Asia/Manila");

        $taskDetails = Task::where('id', $taskId)->first();
        $tskmntrDetails = User::where('id', $tskmntrId)->first();

        TaskminatorHasOffer::insert(array(
            'task_id'           =>  $taskId,
            'client_id'         =>  Auth::user()->id,
            'taskminator_id'    =>  $tskmntrId,
            'created_at'        =>  date("Y:m:d H:i:s"),
            'updated_at'        =>  date("Y:m:d H:i:s"),
        ));

        AuditTrail::insert(array(
            'user_id'       =>  Auth::user()->id,
            'content'       =>  'Offered task '.$taskDetails->name.' to '.$tskmntrDetails->fullName.' at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskDetails->id
        ));

        AuditTrail::insert(array(
            'user_id'       =>  $tskmntrDetails,
            'content'       =>  'Offered task '.$taskDetails->name.' by '.Auth::user()->fullName.' at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/taskDetails/'.$taskDetails->id
        ));

        return Redirect::to('/taskDetails/'.$taskId)
            ->with('successMsg', 'Offer has been sent');
    }

    public function cltEditPersonalInfo(){
        if(UserHasRole::where('user_id', Auth::user()->id)->pluck('role_id') == 3){
            $formUrl = '/doCltIndiEditPersonalInfo';
        }else{
            $formUrl = '/doCltEditPersonalInfo';
        }

        return View::make('client.editPersonalInfo')
            ->with('user', Auth::user())
            ->with('cities', City::orderBy('cityname', 'ASC')->get())
            ->with('barangays', Barangay::orderBy('bgyname', 'ASC')->where('citycode', Auth::user()->city)->get())
            ->with('formUrl', $formUrl);
    }

    public function doCltEditPersonalInfo(){
        // COMPANY NAME VALIDATION
        if(strlen(trim(strip_tags(Input::get('companyName')))) == 0){
            return Redirect::back()->with('errorMsg', 'Company name cannot be empty')->withInput(Input::except('password'));
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

        // ADDRESS VALIDATION
        if(strlen(Input::get('address')) == 0){
            return Redirect::back()->with('errorMsg', 'Address cannot be empty')->withInput(Input::except('password'));
        }else if(strlen(strip_tags(Input::get('address'))) == 0){
            return Redirect::back()->with('errorMsg', 'Address cannot contain tags')->withInput(Input::except('password'));
        }

        // CITY VALIDATION
        if(Input::get('city-comp') == null || Input::get('city-comp') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be empty')->withInput(Input::except('password'));
        }

        // BARANGAY VALIDATION
        if(Input::get('barangay-comp') == null || Input::get('barangay-comp') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be empty')->withInput(Input::except('password'));
        }

        User::where('id', Auth::user()->id)
            ->update(array(
                'companyName'           =>  Input::get('companyName'),
                'fullName'              =>  Input::get('companyName'),
                'businessNature'        =>  Input::get('businessNature'),
                'businessDescription'   =>  Input::get('businessDescription'),
                'address'               =>  Input::get('address'),
                'city'                  =>  Input::get('city-comp'),
                'barangay'              =>  Input::get('barangay-comp'),
            ));

        return Redirect::back()->with('successMsg', 'Personal Information has been successfully edited');
    }

    public function cltEditContactInfo(){
        if(UserHasRole::where('user_id', Auth::user()->id)->pluck('role_id') == 3){
            $formUrl = '/doCltEditIndiContactInfo';
        }else{
            $formUrl = '/doCltEditContactInfo';
        }
        return View::make('client.editContactInfo')
            ->with('contacts', Contact::where('user_id', Auth::user()->id)->get())
            ->with('formUrl',   $formUrl);
    }

    public function doCltEditContactInfo(){
        // BUSINESS NUMBER VALIDATION
        if(!ctype_digit(Input::get('businessNum'))){
            return Redirect::back()->with('errorMsg', 'Business number must be numbers only');
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
        }else if(Contact::where('content', Input::get('email'))->where('ctype', 'email')->whereNotIn('user_id', [Auth::user()->id])->count() > 0){
            return Redirect::back()->with('errorMsg', 'Email is already taken')->withInput(Input::except('password'));
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
                'ctype'       =>  'mobileNum',
                'content'       =>  Input::get('mobileNum'),
            ),
            array(
                'user_id'       =>  Auth::user()->id,
                'ctype'       =>  'businessNum',
                'content'       =>  Input::get('businessNum'),
            )
        ));

        return Redirect::back()->with('successMsg', 'Successfully edited contact information.');
    }

    public function cltEditAcctInfo(){
        return View::make('client.changePass');
    }

    public function doCltEditPass(){
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

    public function doCltIndiEditPersonalInfo(){

        // FIRSTNAME VALIDATION
        if(!ctype_alpha(str_replace(' ', '', trim(Input::get('firstName'))))){
            return Redirect::back()->with('errorMsg', 'First name must be letters only')->withInput(Input::except('password'));
        }else if(strlen(trim(Input::get('firstName'))) == 0){
            return Redirect::back()->with('errorMsg', 'First name cannot be empty')->withInput(Input::except('password'));
        }

        // MIDDLE NAME VALIDATION
        if(!ctype_alpha(str_replace(' ', '',trim(Input::get('midName'))))){
            return Redirect::back()->with('errorMsg', 'Middle name must be letters only')->withInput(Input::except('password'));
        }else if(strlen(trim(Input::get('midName'))) == 0){
            return Redirect::back()->with('errorMsg', 'Middle name cannot be empty')->withInput(Input::except('password'));
        }

        // LAST NAME VALIDATION
        if(!ctype_alpha(str_replace(' ', '',trim(Input::get('lastName'))))){
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
        if(Input::get('city') == null || Input::get('city') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be empty')->withInput(Input::except('password'));
        }

        // BARANGAY VALIDATION
        if(Input::get('barangay') == null || Input::get('barangay') == 0){
            return Redirect::back()->with('errorMsg', 'City cannot be empty')->withInput(Input::except('password'));
        }

        User::where('id', Auth::user()->id)
            ->update(array(
//                'companyName'           =>  Input::get('companyName'),
                'firstName'             =>  Input::get('firstName'),
                'midName'               =>  Input::get('midName'),
                'lastName'              =>  Input::get('lastName'),
                'fullName'              =>  Input::get('firstName').' '.Input::get('midName').' '.Input::get('lastName'),
                'address'               =>  Input::get('address'),
                'city'                  =>  Input::get('city'),
                'barangay'              =>  Input::get('barangay'),
                'gender'                =>  Input::get('gender'),
            ));

        return Redirect::back()->with('successMsg', 'Successfully edited personal information.');
    }

    public function doCltEditIndiContactInfo(){

        // MOBILE NUMBER VALIDATION
        if(!ctype_digit(Input::get('mobileNum'))){
            return Redirect::back()->with('errorMsg', 'Mobile number must be letters only')->withInput(Input::except('password'));
        }else if(strlen(Input::get('mobileNum')) == 0 || strlen(Input::get('mobileNum')) < 11){
            return Redirect::back()->with('errorMsg', 'Mobile number cannot be empty and must be more than 11 digits')->withInput(Input::except('password'));
        }

        // EMAIL VALIDATION
        if(!$this->emailValidate(Input::get('email'))){
            return Redirect::back()->with('errorMsg', 'Please enter valid email')->withInput(Input::except('password'));
        }else if(Contact::where('content', Input::get('email'))->where('ctype', 'email')->whereNotIn('user_id', [Auth::user()->id])->count() > 0){
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

        return Redirect::back()->with('successMsg', 'Successfully edited contact information');
    }
}
