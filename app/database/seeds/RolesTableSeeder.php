<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 4/26/15
 * Time: 11:22 AM
 */

class RolesTableSeeder extends Seeder {
    public function run(){
        Role::create(array(
            'id'    =>  '1',
            'role'  =>  'ADMIN'
        ));

        Role::create(array(
            'id'    =>  '2',
            'role'  =>  'TASKMINATOR'
        ));

        Role::create(array(
            'id'    =>  '3',
            'role'  =>  'CLIENT_IND'
        ));

        Role::create(array(
            'id'    =>  '4',
            'role'  =>  'CLIENT_CMP'
        ));
    }
}