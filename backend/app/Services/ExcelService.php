<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\ExcelServiceContract;
use League\Csv\ByteSequence;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
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
        $handle = fopen($data['file']->getPathname(), 'r');
        $users = [];
        while (($data = fgetcsv($handle, 1000)) !== false) {
            $users[] = [
                'title' => $data[0],
                'full_name' => $data[1],
                'phone_number' => $data[2],
                'email' => $data[3],
                'password' => $data[4],
            ];
        }

        fclose($handle);

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

        $csv->output('users.csv');

        return $csv;
    }
}
