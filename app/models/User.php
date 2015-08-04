<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    public $timestamps = true;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    static function getNotif(){
        return Notification::where('user_id', Auth::user()->id)->where('status', 'NEW')->take(5)->orderBy('created_at', 'DESC')->get();
    }

    static function getSkills($id){
        return TaskminatorHasSkill::join('taskitems', 'taskitems.itemcode', '=', 'taskminator_has_skills.taskitem_code')
                ->where('taskminator_has_skills.user_id', $id)
                ->orderBy('taskitems.itemname', 'ASC')
                ->get();
    }

    static function getMessages(){
        $thread = [];

        foreach(Thread::where('user_id', Auth::user()->id)->select(['code'])->get() as $code){
            $thread[] = $code->code;
        };
        return Message::whereIn('thread_code', $thread)->where('status', 'NEW')->whereNotIn('user_id', [Auth::user()->id])->get();
//        return Message::whereIn('thread_code', $thread)->get();
    }

    public function contactpersons(){
        return $this->hasMany('ContactPerson');
    }

    public function contacts(){
        return $this->hasMany('Contact');
    }

    public function tasks(){
        return $this->hasMany('Task');
    }

    public function roles(){
        return $this->belongsToMany('Role', 'user_has_role');
    }
}
