<?php

    class RegionTableSeeder extends Seeder {

        public function run()
        {

            DB::delete('delete from regions');

            DB::insert("INSERT INTO `regions` (`regcode`, `regname`) VALUES
            ('01', 'REGION I (ILOCOS REGION)'),
            ('02', 'REGION II (CAGAYAN VALLEY)'),
            ('03', 'REGION III (CENTRAL LUZON)'),
            ('04', 'REGION IV-A (CALABAR ZON)'),
            ('05', 'REGION V (BICOL REGION)'),
            ('06', 'REGION VI (WESTERN VISAYAS)'),
            ('07', 'REGION VII (CENTRAL VISAYAS)'),
            ('08', 'REGION VIII (EASTERN VISAYAS)'),
            ('09', 'REGION IX (ZAMBOANGA PENINSULA)'),
            ('10', 'REGION X (NORTHERN MINDANAO)'),
            ('11', 'REGION XI (DAVAO REGION)'),
            ('12', 'REGION XII (SOCCSKSA RGEN)'),
            ('13', 'NATIONAL CAPITAL REGION (NCR)'),
            ('14', 'CORDILLERA ADMINISTRA TIVE REGION (CAR)'),
            ('15', 'AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)'),
            ('16', 'REGION XIII (CARAGA)'),
            ('17', 'REGION IV-B (MIMAROPA)')");

        }

    }