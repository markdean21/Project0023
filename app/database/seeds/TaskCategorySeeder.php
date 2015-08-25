<?php

class TaskCategorySeeder extends Seeder {
    public function run(){
        DB::insert("INSERT INTO `taskcategory` (`categorycode`, `categoryname`) VALUES
            ('001', 'Basic Household Chores/Errands'),
            ('002', 'Personal Care and Wellness'),
            ('003', 'Hotel and Restaurant Crew'),
            ('004', 'Landscape Architect and Agriculturist Helper/Technician'),
            ('005', 'Factory Worker'),
            ('006', 'Automotive'),
            ('007', 'Construction, Engineering and Household Repair & Maintenance Services'),
            ('008', 'Electronics'),
            ('009', 'HVAC-R Services'),
            ('010', 'Maritime Services'),
            ('011', 'Health Institution Staff'),
            ('999', 'Others')
        ");
    }
}