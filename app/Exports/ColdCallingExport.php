<?php

namespace App\Exports;

use DB;
use App\Models\coldcallingModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class ColdCallingExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
 //    public function headings(): array
	// {
	// 	return $this->collection()->keys()->toArray();
	// }

    public function collection()
    {
        return DB::table('coldcallings')->select('unit_no', 'Building', 'area', 'Landlord', 'contact_no', 'email', 'Area_sqft', 'Bedroom', 'rented_price', 'sale_price', 'property_type', 'created_at')->get();
    }

    public function headings(): array
    {
        // return ['this is my headings.'];
        return ['Unit No.', 'Building', 'Area', 'Landlord', 'Contact No.', 'Email', 'Area sqft', 'Bedrooms', 'R.price', 'S.price', 'Property Type', 'Date'];
    }

     public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator('Edenfort.ae');
            },

            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:Z1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]

                ]);
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
            },

        ];
    }

}
