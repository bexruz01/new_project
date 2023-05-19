<?php

namespace App\Exports;

use App\Http\Requests\Appropriation\AcademicDebtAppropriationFilterRequest;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\Validator;
use App\Filters\Students\StudentsFilter;
use App\Models\Exam\ExamScheduleResult;
use App\Traits\ApiResponse;

class AcademicDebtAttendanceExport implements
    FromQuery,
    ShouldAutoSize,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    WithStyles,
    WithTitle

{
    use ApiResponse;

    public $n = 0, $request, $filter;

    public function __construct($request)
    {
        $this->request = $request;
        $this->filter = new StudentsFilter($request);
    }

    public function query()
    {
        $validator = Validator::make($this->request->all(), AcademicDebtAppropriationFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        return ExamScheduleResult::query()
            ->where('rating', '<', 3)
            ->whereHas('student', function ($query) {
                $query->withWhereHas('semester', function ($query) {
                    $query->with('academic_year');
                })->with('academic_group')
                    ->filter($this->filter);
            })->whereHas('exam_schedule_subject', function ($query) {
                $query->with('subject');
            });
    }

    public function title(): string
    {
        return "Academic_debt";
    }

    public function map($data): array
    {
        return [
            $this->n += 1,
            optional($data->student)->full_name,
            optional(optional($data->student)->academic_group)->name,
            optional(optional(optional($data->student)->semester)->academic_year)->name,
            optional(optional($data->student)->semester)->semester,
            optional(optional($data->exam_schedule_subject)->subject)->name,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'Q' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function headings(): array
    {
        return [
            __('exports.no.'),
            __('exports.fullname'),
            __('exports.Group'),
            __('exports.year'),
            __('exports.Semester'),
            __('exports.Subject'),

        ];
    }
}
