<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\ExcelServiceContract;
use League\Csv\ByteSequence;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Writer;
use SplTempFileObject;

readonly class ExcelService implements ExcelServiceContract
{
    public function __construct(
        private UserRepositoryContract $userRepository,
    )
    {
    }

    public function importUsersByCSV(array $data): void
    {
        $csv = Reader::createFromPath($data['file']->getPathname(), 'r');

        $users = [];
        foreach ($csv as $record) {
            $users[] = [
                'title' => $record[0],
                'full_name' => $record[1],
                'phone_number' => $record[2],
                'email' => $record[3],
                'password' => $record[4],
            ];
        }

        $this->userRepository->insert($users);
    }

    /**
     * @throws CannotInsertRecord
     * @throws Exception
     */
    public function exportUsersByCSV(): Writer
    {
        $users = $this->userRepository->getAllForExcel();

        $csv = Writer::createFromFileObject(new SplTempFileObject());

        $csv->setOutputBOM(ByteSequence::BOM_UTF8);

        foreach ($users as $user) {
            $csv->insertOne($user->toArray());
        }

        return $csv;
    }
}
