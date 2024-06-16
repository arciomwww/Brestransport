<?php

namespace App\Services;

use App\Contracts\Presenters\BusStopPresenterContract;
use App\Contracts\Presenters\UserPresenterContract;
use App\Contracts\Repositories\BusStopRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\ExcelServiceContract;
use League\Csv\ByteSequence;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use League\Csv\Writer;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use SplTempFileObject;

readonly class ExcelService implements ExcelServiceContract
{
    public function __construct(
        private UserRepositoryContract $userRepository,
        private BusStopRepositoryContract $busStopRepository,
        private BusStopPresenterContract $busStopPresenter,
        private UserPresenterContract $userPresenter,
    )
    {
    }

    /**
     * @throws UnavailableStream
     * @throws NotFound
     */
    public function importUsersByCSV(array $data): void
    {
        $csv = Reader::createFromPath($data['file']->getPathname());

        $users = [];
        foreach ($csv as $record) {
            // gets length of record array
            $recordLength = count($record);
            // checks that record length greater than two
            $recordLengthGreaterThanTwo = $recordLength > 2;
            if ($recordLengthGreaterThanTwo) {
                // gets bus stop
                $findData = [
                    'title' => $record[0],
                    'next' => $record[1],
                ];
                $busStopKeys = ['id'];
                // if someone will read this, know, you need refactor this line
                $busStop = $this->busStopRepository
                    ->findByTitleAndNext($findData, $busStopKeys)
                    ?? throw new NotFound("Bus stop \"$record[0] with next $record[1]\" not found");
                $busStop = $this->busStopPresenter->presentOneByKeys($busStop, $busStopKeys);

                // sets user data
                $users[] = [
                    'bus_stop_id' => $busStop->id,
                    'full_name' => $record[2],
                    'phone_number' => $record[3],
                    'email' => $record[4],
                    'password' => $record[5],
                ];
            }
        }

        $this->userRepository->insert($users);
    }

    /**
     * Exports a file that stores a list of users at bus stops.
     *
     * @return Writer
     * @throws CannotInsertRecord
     * @throws Exception
     */
    public function exportUsersByCSV(): Writer
    {
        // gets bus stops
        $select = [
            'id',
            'title',
            'next'
        ];
        $busStops = $this->busStopRepository->all($select);
        $this->busStopPresenter->presentByKeys($busStops, $select);

        // creates empty csv file
        $csv = Writer::createFromFileObject(new SplTempFileObject());

        // sets the coding
        $csv->setOutputBOM(ByteSequence::BOM_UTF8);

        foreach ($busStops as $busStop) {
            // for each bus stop search list of users
            $users = $this->userRepository->findByStop($busStop->id);
            $userProperties = [
                'full_name',
                'phone_number',
                'email',
                'password'
            ];
            $users = $this->userPresenter->presentByKeys($users,$userProperties);

            // if not found, only adds the bus stop
            if ($users->isEmpty()) {
                $csv->insertOne([
                    $busStop->title,
                    $busStop->next,
                ]);
            }

            // otherwise adds each user separately
            foreach ($users as $user) {
                $csv->insertOne([
                    $busStop->title,
                    $busStop->next,
                    $user->full_name,
                    $user->phone_number,
                    $user->email,
                    $user->password,
                ]);
            }
        }

        return $csv;
    }
}
