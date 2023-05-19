<?php

namespace App\Exports;

use App\Http\Requests\Students\StudentFilterRequest;
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
use App\Models\User\Student;
use App\Traits\ApiResponse;

class StudentsExport implements
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
        return Student::query()
            ->filter($this->filter)
            ->with(['academic_group', 'region', 'district', 'live_place', 'payment_type'])
            ->whereHas('specialty', function ($query) {
                $query->with(['type', 'edu_type']);
            })->whereHas('academic_group', function ($query) {
                $query->whereHas('edu_plan', function ($query) {
                    $query->with('edu_form');
                });
            })->get();
    }

    public function title(): string
    {
        return 'Student_contengent';
    }

    public function map($data): array
    {
        return [
            $this->n += 1,
            $data->full_name,
            $data->gender,
            $data->pinfl,
            $data->passport,
            optional(optional($data->specialty)->type)->code . '-' . $data->specialty?->gov_specialty?->name,
            optional($data->payment_type)->name,
            optional(optional($data->specialty)->edu_type)->name,
            optional(optional(optional($data->academic_group)->edu_plan)->edu_form)->name,
            optional(optional(optional($data->academic_group)->edu_plan)->academic_year)->name,
            optional($data->academic_group)->name,
            optional($data->semester)->semester,
            optional($data->semester)->course,
            optional($data->region)->name,
            optional($data->district)->name,
            optional($data->live_place)->name,
            $data->phone,
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
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function headings(): array
    {
        return [
            __('exports.no.'),
            __('exports.fullname'),
            __('exports.gender'),
            __('exports.JSHSHR'),
            __('exports.passport'),
            __('exports.specialty'),
            __('exports.pay type'),
            __('exports.edu type'),
            __('exports.edu form'),
            __('exports.year'),
            __('exports.Group'),
            __('exports.Semester'),
            __('exports.Course'),
            __('exports.region'),
            __('exports.district'),
            __('exports.live place'),
            __('exports.phone'),
        ];
    }

    public function getGender($gender)
    {
        if ($gender == 'male' || $gender == 'erkak') {
            return __('exports.male');
        }
        if ($gender == 'female' || $gender == 'ayol') {
            return __('exports.female');
        }

        return null;
    }
}
