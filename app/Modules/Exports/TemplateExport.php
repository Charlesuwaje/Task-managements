<?php

namespace App\Modules\Exports;

use App\Models\User;
use App\Modules\Enums\TaskStatus;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TemplateExport implements FromCollection, WithEvents, WithHeadings
{
    public function collection()
    {
        return new Collection([
            [
                '',
                '',
                '',
                '',
                ''
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'title',
            'description',
            'status',
            'assigned_to_email',
            'due_date',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $userEmails = User::pluck('email')->toArray();
                $statusOptions = TaskStatus::values();

                $emailDropdown = '"' . implode(',', array_map(fn($email) => str_replace('"', '\"', $email), $userEmails)) . '"';
                $statusDropdown = '"' . implode(',', $statusOptions) . '"';

                for ($row = 2; $row <= 100; $row++) {
                    $this->applyValidation($sheet, "D$row", $emailDropdown);

                    $this->applyValidation($sheet, "C$row", $statusDropdown);
                }
            },
        ];
    }

    private function applyValidation($sheet, $cell, $formula)
    {
        $validation = $sheet->getCell($cell)->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_STOP);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setFormula1($formula);
    }
}
