<?php

namespace App\Exports;

use App\Filters\Report\ActiveTeacherReportFilter;
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
use App\Http\Requests\Report\ActiveTeacherReportFilterRequest;
use App\Models\Attendance\Action;
use App\Traits\ApiResponse;

class ActiveTeacherReportExport implements
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
        $validator = Validator::make($this->request->all(), ActiveTeacherReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());
        $filter = new ActiveTeacherReportFilter($this->request);
        return Action::query()
            ->whereHas('teacher', function ($query) use ($filter) {
                $query
                    ->whereHas('work_contract', function ($query) {
                        $query->where('type', 'teacher')
                            ->whereHas('department', function ($query) {
                                $query->with('faculty');
                            });
                    })->filter($filter);
            });
    }

    public function title(): string
    {
        return 'Active_teachers'; //__('exports.employment students');
    }

    public function map($data): array
    {
        return [
            $this->n += 1,
            optional($data->teacher)->full_name,
            optional(optional(optional(optional($data->teacher)->work_contract)->department)->faculty)->name,
            optional(optional(optional($data->teacher)->work_contract)->department)->name,
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
            __('exports.Faculty'),
            __('exports.Department'),
            'IP',
            __('exports.Message'),
            __('exports.Date'),
        ];
    }
}
