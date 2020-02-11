<?php

namespace App\Exports;

use DB;
use App\Models\property;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PropertiesExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return DB::table('properties')->select('unit_no', 'dewa_no', 'Building', 'area', 'Landlord', 'contact_no', 'email', 'Area_sqft', 'Bedroom', 'Price', 'rented_price', 'sale_price','property_type', 'add_by', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['Unit No.', 'Dewa No.', 'Building', 'Area', 'Landlord', 'Contact No.', 'Email', 'Area sqft', 'Bedrooms', 'Price', 'R.price', 'S.price', 'Property Type', 'Added by', 'Date'];
    }
}
