<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
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
    protected $signature = 'consume:api {url=http://universities.hipolabs.com/search : API URL to consume}';

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

        # Validate that the URL is well-formatted
        $validator = Validator::make($this->arguments(), [
            'url' => 'required|url'
        ]);
        if ($validator->fails()) {
            $this->error("URL is invalid.");
            return Command::INVALID;
        }
        $url = $validator->validated()['url'];

        $this->info('Using API endpoint '.$url);

        # Set up list of countries
        $countries = ['Canada', 'United States'];
        if(env('APP_ENV') == 'testing') {
            $countries = ['Canada'];
        }

        # Start timing
        $startTime = microtime(true);

        # Loop for each country
        foreach ($countries as $country) {
            # Create endpoint URL string with country
            $endpoint = $url.'?country='.urlencode($country);

            # Connect to the search API, tell the user what is happening
            $this->info("Loading $endpoint ... ");

            # Validate that the URL is connectable
            try {
                $response = Http::get($endpoint);
            } catch(\Illuminate\Http\Client\ConnectionException $e) {
                $this->error("Could not connect to $url");
                return Command::FAILURE;
            }

            # Validate that the response was successful
            if($response->successful()) {
                # Process the response as JSON
                $universities = $response->json();

                # Iterate over the response and create University models
                $bar = $this->output->createProgressBar(count($universities));
                foreach ($universities as $record) {
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

                    $bar->advance();
                }
                $bar->finish();
            } else {
                $this->error("Could not connect to $url");
                return Command::FAILURE;
            }
            $this->newline();
        }

        # Report execution time to the user
        $this->info(sprintf("Finished in %.1f seconds.", microtime(true) - $startTime));

        return Command::SUCCESS;
    }
}
