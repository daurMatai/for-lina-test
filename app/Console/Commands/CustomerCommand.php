<?php

namespace App\Console\Commands;

use App\CustomerExport;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class CustomerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try {
            $errors = [];
            $file = fopen('random.csv', 'r');

            if ($file !== FALSE) {

                while(($item = fgetcsv($file, 100, ',')) !== FALSE) {
                    if ($item[0] === 'id') continue;

                    $isErrorExist = false;
                    $fullName = explode(" ", $item[1]);
                    $country = Country::where([
                        'name' => $item[4]
                    ])->first();

                    $data = [
                        'name' => $fullName[0],
                        'surname' => isset($fullName[1]) && $fullName[1] ? $fullName[1] : '',
                        'email' => $item[2],
                        'age' => $item[3],
                        'location' => $country ? $country->name : 'Unknown',
                        'location_code' => $country ? $country->code_2 : 'Unknown',
                    ];

                    if ( ! filter_var($item[2], FILTER_VALIDATE_EMAIL)) {
                        $isErrorExist = true;
                    }

                    if ($isErrorExist) {
                        $data['email'] = $data['email'] . ' - [ERROR]';
                        $errors[] = $data;
                    } else {
                        if (intval($item[3], 10) < 99 && intval($item[3], 10) > 18) {
                            $birthdayYear = date('Y') - intval($item[3], 10);
                            $data['age'] = $birthdayYear . '.01.01';

                            Customer::create($data);
                        } else {
                            $data['age'] = $data['age'] . ' - [ERROR]';
                            $errors[] = $data;
                        }
                    }
                }

                Excel::store(new CustomerExport($errors), 'customer-errors' . time() . '.xlsx');
                fclose($file);
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }

        return 0;
    }
}
