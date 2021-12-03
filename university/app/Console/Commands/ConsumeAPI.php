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
        # Task: consume API and retrieve all universities in Canada and United States

        # Start timing
        $startTime = microtime(true);

        # Loop for each country
        foreach (['Canada', 'United States'] as $country) {
            # Start a timer for the loop
            $loopStartTime = microtime(true);

            # Create endpoint URL string with country
            $endpoint = 'http://universities.hipolabs.com/search?country='.urlencode($country);

            # Connect to the search API, tell the user what is happening
            echo "Loading $endpoint ... ";
            $response = Http::get($endpoint)->json();
            echo "[OK]\n";

            # Iterate over the response and create University models
            $i = 0; # Counter
            $total = count($response); # Total number of records
            $step = min(250, max(50, $total / 20)); # Step size for user feedback: 5% of total, min 50, max 250
            echo "Inserting $total records ... \n";
            foreach ($response as $record) {
                # Create the University record
                $university = University::create($record);

                # Create any Domain records
                foreach ($record['domains'] as $domain) {
                    Domain::create([
                        'university_id' => $university->id,
                        'domain_name' => $domain,
                    ]);
                }

                # Create any WebPage records
                foreach ($record['web_pages'] as $webpage) {
                    WebPage::create([
                        'university_id' => $university->id,
                        'url' => $webpage,
                    ]);
                }

                # If we're on a step interval, update the user on the progress
                if (++$i % $step == 0) {
                    printf("%.0f%% completed, %d / %d\n", ($i / $total * 100), $i, $total);
                }
            }

            # Tell the user what we did
            printf("Inserted %d records in %.2f seconds. ", $i, microtime(true) - $loopStartTime);
            if ($i == $total) {
                echo "[OK]\n";
            } else {
                echo "[ERROR]\n";
            }
        }

        # Report execution time to the user
        printf("Finished in %.1f seconds.\n", microtime(true) - $startTime);

        return Command::SUCCESS;
    }
}
