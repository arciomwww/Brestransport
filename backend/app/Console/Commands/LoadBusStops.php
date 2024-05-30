<?php

namespace App\Console\Commands;

use App\Contracts\Repositories\BusStopRepositoryContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LoadBusStops extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-bus-stops';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jsonPath = public_path('js/data.json');

        $jsonData = json_decode(File::get($jsonPath), true);

        $repository = app(BusStopRepositoryContract::class);

        foreach ($jsonData as $item) {
            $busStop = [
                'title' => $item['title'],
                'next' => $item['next'],
                'lng' => $item['position']['lng'],
                'lat' => $item['position']['lat'],
            ];

            $repository->store($busStop);
        }
    }
}
