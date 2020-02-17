<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;


class PropertiesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
	// use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;

     function __construct($request) {
            $this->request = $request;
     }

    public function collection()
    {
        $query = DB::table('properties')->select('unit_no', 'dewa_no', 'Building', 'area', 'Landlord', 'contact_no', 'email', 'Area_Sqft', 'Bedroom', 'Price', 'rented_price', 'sale_price', 'property_type', 'created_at');
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
                if($this->request->unit_no){
                    $query->where("unit_no",$this->request->unit_no);
                }
                return $query->orderBy('updated_at', 'DESC')->get();

        // return DB::table('properties')->select('unit_no', 'dewa_no', 'Building', 'area', 'Landlord', 'contact_no', 'email', 'Area_sqft', 'Bedroom', 'Price', 'rented_price', 'sale_price','property_type', 'add_by', 'created_at')->get();
    }
    public function title(): string
    {
        return 'Edenfort Properties';
    }

    public function headings(): array
    {
        return ['Unit No.', 'Dewa No.', 'Building', 'Area', 'Landlord', 'Contact No.', 'Email', 'Area sqft', 'Bedrooms', 'Price', 'R.price', 'S.price', 'Property Type','Date'];
    }
    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator('Edenfort.ae');
            },
            
            AfterSheet::class => function (AfterSheet $event) {
                // $cells = $event->sheet->mergeCells('A1:N1');
                // $last_column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($this->request));                
                // $highestColumn = $event->sheet->getHighestColumn();
                // $highestRow = $event->sheet->getHighestRow() + 2 + 1 + 1;
                // $event->sheet->insertNewRowBefore(1, 2);
                // $event->sheet->mergeCells(sprintf('A1:%s1',$highestColumn));
                // $event->sheet->mergeCells(sprintf('A2:%s2',$highestColumn));
                // $event->sheet->mergeCells(sprintf('A%d:%s%d',$highestRow,$highestColumn,$highestRow));
                // assign cell values
                // $event->sheet->setCellValue('A1','EDENFORT PROPERTIES');
                // $event->sheet->setCellValue('A2','PROPERTIES CLASSIFICATION BY ('.$this->request->type.') [Generator: EDENFORT_ADMIN]');
                // $event->sheet->setCellValue(sprintf('A%d',$highestRow),'PROPERTIES CLASSIFICATION by(.'.$this->request->type.'.) [Generated By: EDENFORT ADMIN]');

                $event->sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
                // $style_text_center = [
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                //     ],
                //     'font' => [
                //         'bold' => true
                //     ]
                // ];


                $cellRange = 'A1:N1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
                // $event->sheet->getStyle('A1:A2')->applyFromArray($style_text_center);
                // $event->sheet->getStyle(sprintf('A%d',$highestRow))->applyFromArray($style_text_center);

            },
        ];
    }
}
