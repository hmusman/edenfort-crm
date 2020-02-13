<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
 use Maatwebsite\Excel\Concerns\WithTitle;


class ColdCallingExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;

     function __construct($request) {
            $this->request = $request;
     }

    public function collection()
    {
        $query = DB::table('coldcallings')->select('unit_no', 'Building', 'area', 'Landlord', 'contact_no', 'email', 'Area_Sqft', 'Bedroom', 'rented_price', 'sale_price', 'property_type', 'created_at');
                if($this->request->p){
                    $query->where("property_type",$this->request->p);
                }
                if($this->request->type){
                    if($this->request->type=="For Sale" || $this->request->type=="For Rent" ) {
                        $query->whereIn('access',['ForSale/ForRent',$this->request->type]);
                    }else{
                        $query->where("access",$this->request->type);
                    }
                }
                if($this->request->build){
                    $query->where("Building",$this->request->build);
                }
                if($this->request->area){
                    $query->where("area",$this->request->area);
                }
                if($this->request->bedroom){
                    $query->where("Bedroom",$this->request->bedroom);
                }
                if($this->request->agent){
                    $query->where("user_id",$this->request->agent);
                }
                if($this->request->unit){
                    $query->where("unit_no","LIKE",'%'.$this->request->unit.'%');
                }
                if($this->request->contact){
                    $query->where("contact_no","LIKE",'%'.$this->request->contact.'%');
                }

                return $query->orderBy('updated_at', 'DESC')->get();

                // return Excel::download(function($excel) use ($result_data) {
                //     $excel->sheet('mySheet', function($sheet) use ($result_data)
                //     {
                //         $sheet->fromArray($result_data);
                //     });
                // },'coldcalling.xlsx');
    }
    public function title(): string
    {
        return 'Edenfort ColdCallings';
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
