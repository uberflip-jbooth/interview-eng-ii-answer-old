<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Domain;
use App\Models\University;
use App\Models\WebPage;

class ConsumeAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume the university API and insert records into the database.';

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
        foreach(['Canada', 'United States'] as $country)
        {
            $endpoint = 'http://universities.hipolabs.com/search?country='.urlencode($country);
            # Connect to the University API and search all
            echo "Loading $endpoint ... ";
            $response = Http::get($endpoint)->json();
            echo "[Done]\n";

            # Iterate over the response and create University models
            $i = 0;
            $total = count($response);
            $step = max(100, $total / 20);
            echo "Inserting $total records ... \n";
            foreach($response as $record)
            {
                # Create the university record
                $university = University::create($record);

                # Create any domain records
                foreach($record['domains'] as $domain)
                {
                    Domain::create([
                        'university_id' => $university->id,
                        'domain_name' => $domain,
                    ]);
                }

                # Create any web page records
                foreach($record['web_pages'] as $webpage)
                {
                    WebPage::create([
                        'university_id' => $university->id,
                        'url' => $webpage,
                    ]);
                }

                # Keep the user updated on the progress
                if(++$i % $step == 0)
                {
                    echo sprintf("%.0f%% completed, %d / %d\n", ($i / $total * 100), $i, $total);
                }
            }
            echo "Inserted $i records. ";
            if($i == $total)
            {
                echo "[OK]\n";
            } else {
                echo "[ERROR]\n";
            }
        }

        return Command::SUCCESS;
    }
}