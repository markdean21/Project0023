<?php

class TaskTypesTableSeeder extends Seeder {
    public function run(){
        DB::insert("INSERT INTO `taskitems` (`item_categorycode`, `itemcode`, `itemname`) VALUES
            ('001', '001001', 'Laundry'),
            ('001', '001002', 'House Cleaning'),
            ('001', '001003', 'Bill Paying'),
            ('001', '001004', 'Document Filing'),
            ('001', '001005', 'Pet Services'),
            ('001', '001006', 'Furniture Assembly/Repair'),
            ('001', '001007', 'Lipat-bahay'),

            ('002', '002001', 'Hilot/Wellness Massage'),
            ('002', '002002', 'Massage Therapy'),
            ('002', '002003', 'Manicure'),
            ('002', '002004', 'Pedicure'),
            ('002', '002005', 'Beauty Care (Make-up & Hairdressing)'),
            ('002', '002006', 'Barber'),

            ('003', '003001', 'Bartender/Barista'),
            ('003', '003002', 'Waiter'),
            ('003', '003003', 'Baker'),
            ('003', '003004', 'Cook'),
            ('003', '003005', 'Room Attendant'),
            ('003', '003006', 'Housekeeper'),
            ('003', '003007', 'Customer Service/Front Office Staff'),
            ('003', '003008', 'Event Organizer'),
            ('003', '003009', 'Light and Sound technician'),

            ('004', '004001', 'Agricultural Crops/ Horticulture Production Technician'),
            ('004', '004002', 'Animal Production Technician'),
            ('004', '004003', 'Aquaculture /Fish Culture Production Technician'),
            ('004', '004004', 'Landscape Installation & Maintenance Technician'),

            ('005', '005001', 'Food Processor'),
            ('005', '005002', 'Slaughtering Operator/Butcher'),
            ('005', '005003', 'Dressmaker'),
            ('005', '005004', 'Tailor'),
            ('005', '005005', 'Jewelry Maker'),
            ('005', '005006', 'Furniture Maker'),
            ('005', '005007', 'Footwear Maker'),

            ('006', '006001', 'Automotive Electrical & Mechanical Assembly Technician'),
            ('006', '006002', 'Automotive Engine Rebuilder/Machinist'),
            ('006', '006003', 'Automotive Painter/Repair Mechanic'),
            ('006', '006004', 'Automotive Services Technician'),
            ('006', '006005', 'Motorcycle/Small Engine Servicing Technician'),

            ('007', '007001', 'Electrician'),
            ('007', '007002', 'Carpenter'),
            ('007', '007003', 'Painter'),
            ('007', '007004', 'Mason'),
            ('007', '007005', 'Plumber'),
            ('007', '007006', 'Welder'),
            ('007', '007007', 'Foreman'),
            ('007', '007008', 'Electrical Installation and Maintenance Technician'),
            ('007', '007009', 'Heavy Equipment Operator and Rigger'),
            ('007', '007010', 'Tile Setting Technician'),
            ('007', '007011', 'Foundry Services Technician'),
            ('007', '007012', 'Forging Machine Operator'),
            ('007', '007013', 'Power Plant Operation and Maintenance Technician'),
            ('007', '007014', 'Pyrotechnics Services'),

            ('008', '008001', 'Computer/Laptop/Cellphone Repair Services'),
            ('008', '008002', 'Cable Installation Technician'),
            ('008', '008003', 'Telecom OSP Installation Fiber Optic Cable Technician'),
            ('008', '008004', 'CAD/CAM Operator & CATV System Operator'),

            ('009', '009001', 'Refrigeration and Air-conditioning Technician'),
            ('009', '009002', 'Air Duct Technician/Tinsmith'),
            ('009', '009003', 'Appliance Repair'),

            ('010', '010001', 'Deck Seafaring Technician'),
            ('010', '010002', 'Engine Seafaring Technician'),
            ('010', '010003', 'Ship Crew'),

            ('011', '011001', 'Medical Transcription Technician'),
            ('011', '011002', 'Health/Nursing Aide'),
            ('011', '011003', 'Dental Laboratory / Prosthetics Technician'),
            ('011', '011004', 'Dental Hygienist / Dental Assistant'),
            ('011', '011005', 'Emergency Medical Technician/Assistant'),
            ('011', '011006', 'Medical Coder/Biller'),
            ('011', '011007', 'Medical Transcriptionist'),
            ('011', '011008', 'Optician'),
            ('011', '011009', 'Pharmacy Assistant'),
            ('011', '011010', 'Laboratory and Metrology Calibration Services Technician'),

            ('999', '012001', 'Driver'),
            ('999', '012002', 'Security Guard'),
            ('999', '012003', 'Call Center Agents'),
            ('999', '012004', 'Caregiver'),
            ('999', '012005', 'Housekeeping / Laundry'),
            ('999', '012006', 'Photography'),
            ('999', '012007', 'Visual Graphic Designer'),
            ('999', '012008', 'Training Facilitator/Coordinator'),
            ('999', '012009', 'Tutor'),
            ('999', '012010', 'Tour Guide'),
            ('999', '012011', 'Personal Assistant')
        ");
    }
}