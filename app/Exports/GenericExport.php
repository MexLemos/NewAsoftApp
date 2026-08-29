<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class GenericExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    protected $data;
    protected $headings;
    protected $title;

    public function __construct($data, array $headings, string $title = "Exportacao")
    {
        $this->data     = $data;
        $this->headings = $headings;
        $this->title    = $title;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                "fill"  => ["fillType" => "solid", "startColor" => ["rgb" => "1e3a8a"]],
                "font"  => ["bold" => true, "color" => ["rgb" => "FFFFFF"], "size" => 11],
            ],
        ];
    }
}
