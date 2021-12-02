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
        # Connect to the University API and search all
        echo "Loading http://universities.hipolabs.com/search ... ";
        $response = Http::get('http://universities.hipolabs.com/search')->json();
        echo "[Done]\n";

        # Iterate over the response and create University models
        echo "Inserting records ... \n";
        $i = 0; $total = count($response);
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
            if(++$i % ($total / 20) == 0)
            {
                echo sprintf("%d%% completed, %d / %d\n", ($i / $total * 100), $i, $total);
            }
        }

        return Command::SUCCESS;
    }
}
