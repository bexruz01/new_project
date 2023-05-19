<?php

namespace App\Exports;

use App\Filters\Report\ActiveStudentReportFilter;
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
use App\Http\Requests\Report\ActiveStudentReportFilterRequest;
use App\Models\Attendance\Action;
use App\Traits\ApiResponse;

class ActiveStudentReportExport implements
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
        $validator = Validator::make($this->request->all(), ActiveStudentReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());
        $filter = new ActiveStudentReportFilter($this->request);
        return Action::query()
            ->whereHas('student', function ($query) use ($filter) {
                $query->filter($filter)
                    ->whereHas('specialty', function ($query) {
                        $query->with(['gov_specialty', 'edu_type']);
                    })->with('department');
            });
    }

    public function title(): string
    {
        return 'Active_students'; //__('exports.employment students');
    }

    public function map($data): array
    {
        return [
            $this->n += 1,
            optional($data->student)->full_name,
            optional($data->academic_group)->name,
            optional(optional($data->student)->department)->name,
            optional(optional($data->specialty)->type)->code,
            optional($data->payment_type)->name,
            optional(optional(optional($data->student)->specialty)->edu_type)->name,
            optional(optional(optional($data->academic_group)->edu_plan)->edu_form)->name,
            $data->ip,
            $data->text,
            formatDateTime($data->created_at),
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
            __('exports.Faculty'),
            __('exports.Specialty_code'),
            __('exports.pay type'),
            __('exports.edu type'),
            __('exports.edu form'),
            'IP',
            __('exports.Message'),
            __('exports.Date'),

        ];
    }
}
