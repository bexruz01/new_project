<?php

namespace App\Exports;

use App\Http\Controllers\Appropriation\AppropriationController;
use App\Http\Resources\Appropriation\SummaryReportsResource;
use App\Services\Appropriation\AppropriationService;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Traits\ApiResponse;

class SummaryReportAttendanceExport implements
    FromQuery,
    ShouldAutoSize,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    WithStyles,
    WithTitle

{
    use ApiResponse;

    public $n = 0, $group, $subjects;

    public function __construct($request)
    {
        $this->group = AppropriationService::getInstance()->summary_report($request);
        $this->subjects = $this->group['subjects'];
    }

    public function query()
    {
        return $this->group['students'];
    }

    public function title(): string
    {
        return "Summary_report";
    }

    public function map($data): array
    {
        return [
            $this->n += 1,
            $data->full_name
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
        $list = ['No', 'Full_name'];
        foreach ($this->subjects as $subject) $list[] = $subject['name'];
        return $list;
    }
}