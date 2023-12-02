<?php

namespace App\Imports;

use App\Models\BulkUploadStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use SebastianBergmann\Type\NullType;
use Maatwebsite\Excel\Concerns\Importable;

class ImportStudent implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    use Importable;

    private $newStudentCount = 0;
    private $updatedStudentCount = 0;

    public function model(array $row)
    {

        $bulkStudentData = [
            'created_by' => Auth::id(),
            'name' => isset($row['student_name']) ? trim($row['student_name']) : NULL,
            'email' => isset($row['email']) ? trim($row['email']) : NULL,
            'phone_number' => isset($row['phone_number']) ? trim($row['phone_number']) : NULL,
            'address' => isset($row['address']) ? trim($row['address']) : NULL,
            'course' => isset($row['course']) ? trim($row['course']) : NULL,
            'graduation' => isset($row['graduation']) ? trim($row['graduation']) : NULL,
            'remark' => isset($row['remark']) ? trim($row['remark']) : NULL,
        ];

        $existingStudentByEmail = BulkUploadStudent::where('email', trim($row['email']))->first();
        $existingStudentByAadharNumber = BulkUploadStudent::where('phone_number', (string)trim($row['phone_number']))->first();

        // Check if a student was updated
        if ($existingStudentByEmail || $existingStudentByAadharNumber) {
            $existingStudent = $existingStudentByEmail ?? $existingStudentByAadharNumber;
            $existingStudent->update($bulkStudentData);
            $this->updatedStudentCount++;
        } else {
            BulkUploadStudent::create($bulkStudentData);
            $this->newStudentCount++;
        }
    }

    public function getNewStudentCount()
    {
        return $this->newStudentCount;
    }

    public function getUpdatedStudentCount()
    {
        return $this->updatedStudentCount;
    }
}
