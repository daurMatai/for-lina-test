<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;

class CountryCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country-code:set';

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
        $xmlDataString = file_get_contents(base_path('country.xml'));
        $xmlObject = simplexml_load_string($xmlDataString);

        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true);

        $country = Country::all();

        if ($country->count() === 0) {
            foreach ($phpDataArray['country'] as $item) {
                echo $item['td'][0] . "\n";
                Country::create([
                    'name' => $item['td'][0],
                    'code_2' => $item['td'][1],
                    'code_3' => $item['td'][2],
                    'numeric' => $item['td'][3],
                ]);

            }
        }

        return 0;
    }
}
