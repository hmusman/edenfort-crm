<?php

namespace App\Exports;

use DB;
use App\Models\coldcallingModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ColdCallingExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return ['Unit No.', 'Building', 'Area', 'Landlord', 'Contact No.', 'Email', 'Area sqft', 'Bedrooms', 'R.price', 'S.price', 'Property Type', 'Date'];
    }
}
