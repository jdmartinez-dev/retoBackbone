<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use \DB;

class ImportZipcodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:zipcodes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Zipcodes Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        $getfile = file(public_path(). DIRECTORY_SEPARATOR ."import". DIRECTORY_SEPARATOR ."import_data_zipcode.txt");
        $getfile = array_chunk($getfile, 1000, true);
        $import_data = [];
        $settlement_types = [];

        // Format data zipcodes
        foreach ($getfile as $groupLines) {
            foreach ($groupLines as $index => $line) {
                $line = rtrim($line, "\r\n");
                $dataline = explode("|", $line);
                $zipcode = $dataline[0]; # d_codigo
                // ID's
                $state_id = (Int) $dataline[7]; # c_estado
                $municipality_id = (Int) $dataline[11]; # c_mnpio
                $settlement_type_id = (Int) $dataline[10]; # c_tipo_asenta
                // Names
                $stateName = $this->uppercase($dataline[4]); # d_estado
                $cityName = $this->uppercase($dataline[5]); # d_asenta
                $municipalityName = $this->uppercase($dataline[3]);
                $settlementName = $this->uppercase($dataline[1]);
                $zoneType = $this->uppercase($dataline[13]); # d_zona

                // Data structure for import to database - Settlement Types
                $settlement_types[$settlement_type_id] = $dataline[2]; # d_tipo_asenta  

                // Data structure for import to database - States / Municipalities / Zipcodes / Settlements 
                $import_data[$stateName]['key'] = $state_id;
                $import_data[$stateName]['municipalities'][$municipalityName]['key'] = $municipality_id;
                $import_data[$stateName]['municipalities'][$municipalityName]['zipcodes'][$zipcode]['city'] = $cityName;          
                $import_data[$stateName]['municipalities'][$municipalityName]['zipcodes'][$zipcode]['settlements'][$index] = json_encode([
                    "key" => (Int) $dataline[12], # id_asenta_cpcons
                    "name" => $settlementName, # d_asenta
                    "zone_type" => $zoneType, # d_zona
                    "settlement_type_id" => $settlement_type_id, # c_tipo_asenta
                ]);
            }
        }

        $this->info('Start command - import Zipcodes');
        // Insert model - SettlementTypes
        ksort($settlement_types);
        foreach ($settlement_types as $key => $settlement_type_name) {
            DB::insert('insert into `settlement_types` (`id`, `name`) values (?, ?)', [$key, $settlement_type_name]);  
        }
        // Insert Model - States / Municipalities / Zipcodes / Settlements
        foreach ($import_data as $stateName => $state) {
            if (!DB::insert('insert into `states` (`key`, `name`) values (?, ?)', [
                $state['key'],
                $stateName,
            ])) break;

            $stateId = DB::getPdo()->lastInsertId();
            foreach ($state['municipalities'] as $municipalityName => $municipality) {
                if (!DB::insert('insert into `municipalities` (`key`, `name`, `state_id`) values (?, ?, ?)', [
                    $municipality['key'],
                    $municipalityName,           
                    $stateId,
                ])) break;

                $municipalityId = DB::getPdo()->lastInsertId();
                foreach ($municipality['zipcodes'] as $zipcode => $rows) {
                    if (!DB::insert('insert into `zipcodes` (`zip_code`, `locality`, `municipality_id`) values (?, ?, ?)', [
                        $zipcode,
                        $rows['city'],
                        $municipalityId,
                    ]));

                    $zipcodeId = DB::getPdo()->lastInsertId();                    
                    foreach ($rows['settlements'] as $settlement) {
                        $dataSettlement = json_decode($settlement, true);
                        DB::insert('insert into `settlements` (`key`, `name`, `zone_type`, `settlement_type_id`, `zipcode_id`) values (?, ?, ?, ?, ?)', [
                            $dataSettlement['key'],
                            $dataSettlement['name'],
                            $dataSettlement['zone_type'],
                            $dataSettlement['settlement_type_id'],
                            $zipcodeId,
                        ]);
                    }
                }
            }

            $this->info("Create [State, municipalities, Zipcodes, settlements] for {{ $stateName }}!!");
        }
        
        $this->info('End command - import Zipcodes');
        return true;
    }

    protected function uppercase($text = "")
    {   
        $text = preg_replace('/[^a-z\s]/i', '', iconv("UTF-8", "US-ASCII//TRANSLIT", $text));
        return strtoupper($text);
    }
}
