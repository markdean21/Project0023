<?php

class AdminController extends \BaseController {
    public function index(){
        $userList = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
                    ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
                    ->where('user_has_role.role_id', '2')
                    ->whereNotIn('users.status', ['PRE_ACTIVATED'])
//                    ->where('users.status', 'ACTIVATED')
                    ->orderBy('users.created_at', 'DESC')
                    ->select([
                        'users.id',
                        'users.fullName',
                        'users.status',
                        'users.username',
                    ])
                    ->paginate(10);

        return View::make('admin.index')->with('users', $userList);
    }

    public function userList(){
        return View::make('admin.userlist')
                ->with('users', User::orderBy('name')->get());
    }

    public function userListTaskminators(){
        $userList = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
                    ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
                    ->where('user_has_role.role_id', '2')
                    ->whereNotIn('users.status', ['PRE_ACTIVATED'])
//                    ->where('users.status', 'ACTIVATED')
                    ->orderBy('users.created_at', 'DESC')
                    ->select([
                        'users.id',
                        'users.fullName',
                        'users.status',
                        'users.username',
                    ])
                    ->paginate(10);

        return View::make('admin.userlist_taskminators')
                ->with('users', $userList);
    }

    public function userListClientIndi(){
        $userList = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '3')
            ->whereNotIn('users.status', ['PRE_ACTIVATED'])
            ->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.username',
                'users.status',
            ])
            ->paginate(10);

        return View::make('admin.userlist_client_indi')
            ->with('users', $userList);
    }

    public function userListClientComp(){
        $userList = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '4')
            ->whereNotIn('users.status', ['PRE_ACTIVATED'])
            ->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.username',
                'users.status',
            ])
            ->paginate(10   );

        return View::make('admin.userlist_client_comp')
            ->with('users', $userList);
    }

    public function adminActivate($id){
        $query = User::where('id', $id);

        $query->update(array(
            'status'    =>  'ACTIVATED'
        ));

        // TRAIL FOR ADMIN
        AuditTrail::insert(array(
            'user_id'   =>  Auth::user()->id,
            'content'   =>  'Administratively activate account for <span style="color: #2980B9;">'.$query->pluck('fullName').'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.$id
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        // TRAIL FOR USER
        AuditTrail::insert(array(
            'user_id'   =>  $id,
            'content'   =>  'Account administratively activated by <span style="color: #E74C3C;">'.Auth::user()->fullName.'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.$id
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

//        return Redirect::back();
        return Redirect::to('/viewUserProfile/'.$id);
    }

    public function adminDeactivate($id){
        $query = User::where('id', $id);
        $query->update(array(
            'status'    =>  'ADMIN_DEACTIVATED'
        ));

        // TRAIL FOR ADMIN
        AuditTrail::insert(array(
            'user_id'   =>  Auth::user()->id,
            'content'   =>  'Administratively deactivate account for <span style="color: #2980B9;">'.$query->pluck('fullName').'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.$id
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

        // TRAIL FOR USER
        AuditTrail::insert(array(
            'user_id'   =>  $id,
            'content'   =>  'Account administratively deactivated by <span style="color: #E74C3C;">'.Auth::user()->fullName.'</span> at '.date('D, M j, Y \a\t g:ia'),
            'created_at'    =>  date("Y:m:d H:i:s"),
            'at_url'        =>  '/viewUserProfile/'.$id
//                'module'   =>  'Logged in at '.date('D, M j, Y \a\t g:ia'),
        ));

//        return Redirect::back()->with('successMsg', 'User has been deactivated.');
        return Redirect::to('/viewUserProfile/'.$id)->with('successMsg', 'User has been deactivated.');
    }

    public function viewUserProfile($id){
        if(UserHasRole::where('user_id', $id)->pluck('role_id') == '1'){
            Auth::logout();
            return Redirect::to('/');
        }else if(UserHasRole::where('user_id', $id)->pluck('role_id') == '2'){
            $maxStars = Rate::where('taskminator_id', $id)->max('stars');
            $starCount = Rate::where('taskminator_id', $id)->count();

            if($maxStars != 0 && $starCount != 0){
                $starRatings = $maxStars / $starCount;
            }else{
                $starRatings = 0;
            }

            return View::make('admin.viewUserProfile_tskmntr')
                ->with('user', User::where('id', $id)->first())
                ->with('contactpersons', ContactPerson::where('user_id', $id)->get())
                ->with('keyskills', Photo::where('user_id', $id)->where('type', 'KEYSKILLS')->get())
                ->with('photos', Photo::where('user_id', $id)->whereNotIn('type', ['KEYSKILLS', 'DOCUMENT'])->get())
                ->with('docs', Document::where('user_id', $id)->where('type', 'DOCUMENT')->get())
                ->with('miscDocs', Document::where('user_id', $id)->whereNotIn('type', ['KEYSKILLS', 'DOCUMENT'])->get())
                ->with('ratings', Rate::where('taskminator_id', $id)->count())
                ->with('starRatings', $starRatings)
                ->with('skills', TaskminatorHasSkill::where('user_id', $id)->get());
        }else if(UserHasRole::where('user_id', $id)->pluck('role_id') == '3'){
            return View::make('admin.viewUserProfile_cindi')
                ->with('user', User::where('id', $id)->first())
                ->with('contactpersons', ContactPerson::where('user_id', $id)->get())
                ->with('docs', Document::where('user_id', $id)->get())
                ->with('photos', Document::where('user_id', $id));
        }else if(UserHasRole::where('user_id', $id)->pluck('role_id') == '4'){
            return View::make('admin.viewUserProfile_ccomp')
                ->with('user', User::where('id', $id)->first())
                ->with('keyperson', ContactPerson::where('user_id', $id)->get())
                ->with('photos', Photo::where('user_id', $id)->get())
                ->with('docs', Document::where('user_id', $id)->get());
        }else{
            Auth::logout();
            return Redirect::to('/');
        }
    }

    public function pendingTskmntr(){
        $userList = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '2')
            ->where('users.status', ['PRE_ACTIVATED'])
            ->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.status',
                'users.username',
            ])
            ->paginate(10);

        return View::make('admin.viewUsers_pending')
            ->with('users', $userList)
            ->with('pageTitle', 'Pending Taskminator Accounts')
            ->with('formUrl', '/pendingTskmntr=search');
    }

    public function pendingTskmntrSearch($searchBy, $searchWord){
        $userList = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '2')
            ->where('users.status', ['PRE_ACTIVATED']);

        if($searchBy != '0'){
            $searchByQuery = 'users.'.$searchBy;
            $searchWordQuery = 'users.'.$searchWord;

            $userList = $userList->where($searchByQuery, 'LIKE', '%'.$searchWordQuery.'%');
        }

        $userList = $userList->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.status',
                'users.username',
            ])
            ->paginate(10);

        return View::make('admin.viewUsers_pending')
            ->with('users', $userList)
            ->with('searchBy', $searchBy)
            ->with('searchWord', $searchWord)
            ->with('pageTitle', 'Pending Taskminator Accounts')
            ->with('formUrl', '/pendingTskmntr=search');
    }

    public function pendingClientIndi(){
        $userList = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '3')
            ->where('users.status', ['PRE_ACTIVATED'])
            ->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.username',
                'users.status',
            ])->paginate(10);

        return View::make('admin.viewUsers_pending')
            ->with('users', $userList)
            ->with('pageTitle', 'Pending Client (Individual) Accounts')
            ->with('formUrl', '/pendingClientIndi=search');
    }

    public function pendingClientIndiSearch($searchBy, $searchWord){
        $query = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '3')
            ->where('users.status', 'PRE_ACTIVATED');

        if($searchBy != '0'){
            $searchByQuery = 'users.'.$searchBy;
            $searchWordQuery = 'users.'.$searchWord;

            $query = $query->where($searchByQuery, 'LIKE', '%'.$searchWordQuery.'%');
        }

        $query = $query->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.status',
                'users.username',
            ])
            ->paginate(10);

        return View::make('admin.viewUsers_pending')
            ->with('pageTitle', 'Pending Client (Individual) Accounts')
            ->with('users', $query)
            ->with('searchBy', $searchBy)
            ->with('searchWord', $searchWord)
            ->with('formUrl', '/pendingClientIndi=search');
    }

    public function pendingClientComp(){
        $userList = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '4')
            ->where('users.status', ['PRE_ACTIVATED'])
            ->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.status',
                'users.username',
            ])->paginate(10);

        return View::make('admin.viewUsers_pending')
            ->with('users', $userList)
            ->with('pageTitle', 'Pending Client (Company) Accounts')
            ->with('formUrl', '/pendingClientComp=search');
    }

    public function pendingClientCompSearch($searchBy, $searchWord){
        $query = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '4')
            ->where('users.status', 'PRE_ACTIVATED');

        if($searchBy != '0'){
            $searchByQuery = 'users.'.$searchBy;
            $searchWordQuery = 'users.'.$searchWord;

            $query = $query->where($searchByQuery, 'LIKE', '%'.$searchWordQuery.'%');
        }

        $query = $query->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.status',
                'users.username',
            ])->paginate(10);

        return View::make('admin.viewUsers_pending')
            ->with('pageTitle', 'Pending Client (Company) Accounts')
            ->with('users', $query)
            ->with('searchBy', $searchBy)
            ->with('searchWord', $searchWord)
            ->with('formUrl', '/pendingClientComp=search');
    }

    public function categoryAndSkills(){
        return View::make('admin.categoryAndSkills')->with('taskCategory', TaskCategory::orderBy('categoryCode', 'ASC')->get());
    }

    public function auditTrail($role){
        $query = User::join('user_has_role', 'user_has_role.user_id', '=', 'users.id')
                     ->join('roles', 'roles.id', '=', 'user_has_role.role_id');

        switch($role){
            case 'taskminator'  :
                $query->where('roles.role', 'TASKMINATOR');
                break;
            case 'clientindi'  :
                $query->where('roles.role', 'CLIENT_IND');
                break;
            case 'clientcomp'  :
                $query->where('roles.role', 'CLIENT_CMP');
                break;
            default :
                return Redirect::back()->with('errorMsg', 'UNKNOWN REQUEST');
        }

        $query->select(array(
            'users.id',
            'users.fullName',
            'users.status',
        ));

        return View::make('admin.AT_userList')->with('users', $query->paginate(10));
    }

    public function userAuditTrail($id){
        return View::make('admin.userTrail')
            ->with('user', User::where('id', $id)->first())
            ->with('trails', AuditTrail::where('user_id', $id)->paginate(10));
    }

    public function taskDetails($taskid){
        $taskQuery = Task::where('id', $taskid)->first();
        $taskminator = null;

        if($taskQuery->status == 'ONGOING' || $taskQuery->status == 'COMPLETE'){
            $taskminator = User::join('task_has_taskminator', 'task_has_taskminator.taskminator_id', '=', 'users.id')
                            ->where('task_has_taskminator.task_id', $taskQuery->id)
                            ->select([
                                'users.fullName',
                                'users.id',
                                'task_has_taskminator.created_at'
                            ])
                            ->first();
        }

        return View::make('admin.taskDetails')
                ->with('task', $taskQuery)
                ->with('client', User::where('id', $taskQuery->user_id)->first())
                ->with('taskminator', $taskminator);
    }

    public function viewRatings($tskmntrId){
        return View::make('admin.ratings')
                ->with('ratings', Rate::where('ratings.taskminator_id', $tskmntrId)->get())
                ->with('tskmntr', User::where('id', $tskmntrId)->first());
    }

    public function taskListBidding(){
        return View::make('admin.taskList')
            ->with('tasks', Task::where('hiringType', 'BIDDING')->orderBy('created_at', 'ASC')->paginate(10))
            ->with('pageName', 'Bidding Tasks')
            ->with('formUrl', '/taskListBidding=search');
    }

    public function taskListBiddingSearch($searchBy, $searchWord, $workTimeValue, $status){
        $query = Task::where('hiringType', 'BIDDING')->orderBy('created_at', 'ASC');

        if($searchBy == 'name'){
            if($searchWord != ''){
                $query = $query->where($searchBy, 'LIKE', '%'.$searchWord.'%');
            }
        }else if($searchBy == 'workTime'){
            $query = $query->where($searchBy, $workTimeValue);
            if($searchWord != ''){
                $query = $query->where('name', 'LIKE', '%'.$searchWord.'%');
            }
        }

        if($status != 'ALL'){
            $query = $query->where('status', $status);
        }

        return View::make('admin.taskList')
            ->with('tasks', $query->paginate(10))
            ->with('pageName', 'Bidding Tasks')
            ->with('formUrl', '/taskListBidding=search')
            ->with('searchBy', $searchBy)
            ->with('searchWord', $searchWord)
            ->with('workTimeValue', $workTimeValue)
            ->with('status', $status);
    }

    public function taskListAuto(){
        return View::make('admin.taskList')
            ->with('tasks', Task::where('hiringType', 'AUTOMATIC')->orderBy('created_at', 'ASC')->paginate(10))
            ->with('pageName', 'Automatic Tasks')
            ->with('formUrl', '/taskListAuto=search');
    }

    public function taskListAutoSearch($searchBy, $searchWord, $workTimeValue, $status){
        $query = Task::where('hiringType', 'AUTOMATIC')->orderBy('created_at', 'ASC');

        if($searchBy == 'name'){
            if($searchWord != ''){
                $query = $query->where($searchBy, 'LIKE', '%'.$searchWord.'%');
            }
        }else if($searchBy == 'workTime'){
            $query = $query->where($searchBy, $workTimeValue);
            if($searchWord != ''){
                $query = $query->where('name', 'LIKE', '%'.$searchWord.'%');
            }
        }

        if($status != 'ALL'){
            $query = $query->where('status', $status);
        }

        return View::make('admin.taskList')
            ->with('tasks', $query->paginate(10))
            ->with('pageName', 'Automatic Tasks')
            ->with('formUrl', '/taskListAuto=search')
            ->with('searchBy', $searchBy)
            ->with('searchWord', $searchWord)
            ->with('workTimeValue', $workTimeValue)
            ->with('status', $status);
    }

    public function taskListDirect(){
        return View::make('admin.taskList')
            ->with('tasks', Task::where('hiringType', 'DIRECT')->orderBy('created_at', 'ASC')->paginate(10))
            ->with('pageName', 'Direct Tasks')
            ->with('formUrl', '/taskListDirect=search');
    }

    public function taskListDirectSearch($searchBy, $searchWord, $workTimeValue, $status){
        $query = Task::where('hiringType', 'DIRECT')->orderBy('created_at', 'ASC');

        if($searchBy == 'name'){
            if($searchWord != ''){
                $query = $query->where($searchBy, 'LIKE', '%'.$searchWord.'%');
            }
        }else if($searchBy == 'workTime'){
            $query = $query->where($searchBy, $workTimeValue);
            if($searchWord != ''){
                $query = $query->where('name', 'LIKE', '%'.$searchWord.'%');
            }
        }

        if($status != 'ALL'){
            $query = $query->where('status', $status);
        }

        return View::make('admin.taskList')
            ->with('tasks', $query->paginate(10))
            ->with('pageName', 'Direct Tasks')
            ->with('formUrl', '/taskListDirect=search')
            ->with('searchBy', $searchBy)
            ->with('searchWord', $searchWord)
            ->with('workTimeValue', $workTimeValue)
            ->with('status', $status);
    }

    public function adminTskmntrSearch(){
        $query = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '2')
            ->whereNotIn('users.status', ['PRE_ACTIVATED']);

        if(Input::get('searchBy') != '0'){
            if(Input::get('searchWord') != ''){
                $query->where(Input::get('searchBy'), 'LIKE', '%'.Input::get('searchWord').'%');
            }
        }

        $query = $query->orderBy('users.created_at', 'DESC')
                    ->select([
                        'users.id',
                        'users.fullName',
                        'users.status',
                        'users.username',
                    ]);
        return View::make('admin.userlist_taskminators')
                ->with('users', $query->get())
                ->with('searchBy', Input::get('searchBy'))
                ->with('searchWord', Input::get('searchWord'));
    }

    public function adminClientIndiSearch(){
        $query = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '3')
            ->whereNotIn('users.status', ['PRE_ACTIVATED']);

        if(Input::get('searchBy') != '0'){
            if(Input::get('searchWord') != ''){
                $query->where(Input::get('searchBy'), 'LIKE', '%'.Input::get('searchWord').'%');
            }
        }

        $query = $query->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.status',
                'users.username',
            ]);

        return View::make('admin.userlist_client_indi')
            ->with('users', $query->get())
            ->with('searchBy', Input::get('searchBy'))
            ->with('searchWord', Input::get('searchWord'));
    }

    public function adminClientCompSearch(){
        $query = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_has_role.role_id')
            ->where('user_has_role.role_id', '4')
            ->whereNotIn('users.status', ['PRE_ACTIVATED']);
//            ->orderBy('users.created_at', 'DESC')
//            ->select([
//                'users.id',
//                'users.fullName',
//                'users.username',
//                'users.status',
//            ])->get();

        if(Input::get('searchBy') != '0'){
            if(Input::get('searchWord') != ''){
                $query->where(Input::get('searchBy'), 'LIKE', '%'.Input::get('searchWord').'%');
            }
        }

        $query = $query->orderBy('users.created_at', 'DESC')
            ->select([
                'users.id',
                'users.fullName',
                'users.status',
                'users.username',
            ]);

        return View::make('admin.userlist_client_comp')
            ->with('users', $query->get())
            ->with('searchBy', Input::get('searchBy'))
            ->with('searchWord', Input::get('searchWord'));
    }

    public function viewUsersTasks($clientid){
        return View::make('admin.clientTask')
                ->with('tasks', Task::where('user_id', $clientid)->orderBy('created_at', 'DESC')->paginate(10))
                ->with('client', User::where('id', $clientid)->first());
    }

    public function viewUsersTasksSearch(){
        $query = Task::where('user_id', Input::get('clientid'));

        if(Input::get('hiringType') != 'ALL'){
            $query = $query->where('hiringType', Input::get('hiringType'));
        }

        if(Input::get('searchBy') == 'name'){
            if(Input::get('searchWord') != ''){
                $query = $query->where(Input::get('searchBy'), 'LIKE', '%'.Input::get('searchWord').'%');
            }
        }else if(Input::get('searchBy') == 'workTime'){
            $query = $query->where(Input::get('searchBy'), Input::get('workTimeValue'));
            if(Input::get('searchWord') != ''){
                $query = $query->where('name', 'LIKE', '%'.Input::get('searchWord').'%');
            }
        }

        if(Input::get('status') != 'ALL'){
            $query = $query->where('status', Input::get('status'));
        }

        return View::make('admin.clientTask')
            ->with('tasks', $query->get())
            ->with('client', User::where('id', Input::get('clientid'))->first())
            ->with('searchBy', Input::get('searchBy'))
            ->with('workTimeValue', Input::get('workTimeValue'))
            ->with('hiringType', Input::get('hiringType'));
    }

    public function userListTaskminatorsSearch($searchBy, $searchWord){
        $query = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')->where('users.status', 'ACTIVATED')->where('user_has_role.role_id', '2');

        if($searchBy != '0'){
            $query = $query->where($searchBy, 'LIKE', '%'.$searchWord.'%');
        }

        return View::make('admin.index')
            ->with('searchBy', $searchBy)
            ->with('searchWord', $searchWord)
            ->with('users', $query->orderBy('fullName', 'ASC')->paginate(10));
    }

    public function userListClientIndiSearch($searchBy, $searchWord){
        $query = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')->where('users.status', 'ACTIVATED')->where('user_has_role.role_id', '3');

        if($searchBy != '0'){
            $query = $query->where($searchBy, 'LIKE', '%'.$searchWord.'%');
        }

        return View::make('admin.userlist_client_indi')
            ->with('searchBy', $searchBy)
            ->with('searchWord', $searchWord)
            ->with('users', $query->orderBy('fullName', 'ASC')->paginate(1));
    }

    public function userListClientCompSearch($searchBy, $searchWord){
        $query = User::join('user_has_role', 'users.id', '=', 'user_has_role.user_id')->where('users.status', 'ACTIVATED')->where('user_has_role.role_id', '4');

        if($searchBy != '0'){
            $query = $query->where($searchBy, 'LIKE', '%'.$searchWord.'%');
        }

        return View::make('admin.userlist_client_comp')
            ->with('searchBy', $searchBy)
            ->with('searchWord', $searchWord)
            ->with('users', $query->orderBy('fullName', 'ASC')->paginate(10));
    }

    public function newSkill(){
        if(strlen(trim(Input::get('newSkillInput'))) == 0){
            return Redirect::back()->with('errorMsg', 'New skill cannot be empty');
        }else if(Input::get('newSkillInput') == ''){
            return Redirect::back()->with('errorMsg', 'New skill cannot be empty');
        }

        if(Input::get('category') == ''){
            return Redirect::back()->with('errorMsg', 'Please select a category');
        }

        if(TaskCategory::where('categorycode', Input::get('category'))->count() == 0){
            return Redirect::back()->with('errorMsg', 'Please select a valid category');
        }
        $maxSkillCode = str_replace(Input::get('category'), '', TaskItem::where('item_categorycode', Input::get('category'))->max('itemcode'));
        $maxSkillCode = ++$maxSkillCode;
        $maxSkillCode = str_pad($maxSkillCode, 3, '0', STR_PAD_LEFT);

        TaskItem::insert(array(
            'item_categorycode'     =>  Input::get('category'),
            'itemname'              =>  Input::get('newSkillInput'),
            'itemcode'              =>  Input::get('category').''.$maxSkillCode
        ));

        return Redirect::to('/categoryAndSkills')->with('successMsg', 'New skill is successfully added');
    }

    public function newCategory(){
        if(Input::get('newCategoryInput') == ''){
            return Redirect::back()->with('errorMsg', 'Please input a valid category name');
        }

        $maxCatCode = TaskCategory::whereNotIn('categoryname', ['Others'])->max('categorycode');
        $maxCatCode = ++$maxCatCode;
        $maxCatCode = str_pad($maxCatCode, 3, '0', STR_PAD_LEFT);

        TaskCategory::insert(array(
            'categoryname'      =>  Input::get('newCategoryInput'),
            'categorycode'      =>  $maxCatCode
        ));

        return Redirect::to('/categoryAndSkills')->with('successMsg', 'New category is successfully added');
    }

    public function deleteCategory($categorycode){
        TaskCategory::where('categorycode', $categorycode)->delete();
        TaskItem::where('item_categorycode', $categorycode)->delete();

        return Redirect::back()->with('successMsg', 'Category has been successfully deleted');
    }

    public function deleteSkill($skillcode){
        TaskItem::where('itemcode', $skillcode)->delete();
        return Redirect::back()->with('successMsg', 'Skill has been successfully deleted');
    }
}
