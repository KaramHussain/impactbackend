<?php

namespace App\Imports;

use App\complaint;
use Illuminate\Support\Collection;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class complaintImport implements ToCollection, WithHeadingRow, WithChunkReading
{

    public function chunkSize(): int
    {
        return 1000;
    }

    public function trim_extra($data)
    {
    	$data = trim($data);
    	$data = str_replace("'", "\'", $data);
    	return $data;
    }

    public function formatDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public function formatPrice($price)
    {
        if(strpos($price, ','))
        {
            $price = str_replace(',', '', $price);
        }
        return (int) $price;
    }


    public function collection(Collection $rows)
    {
        $i = 0;

        $rows->each(function($row) use ($i) {


            $row = array_values($row->toArray());

            $complaint = complaint::query();

            $complaint->insertOrIgnore([
                'added_by' => auth()->user()->id,
                'consumer_id' => $this->trim_extra($row[0]),
                'old_id' => $this->trim_extra($row[1]),
                'consumer_name' => $this->trim_extra($row[2]),
                'consumer_type' => $this->trim_extra($row[3]),
                'cnic_no' => $this->trim_extra($row[4]),
                'contact_no' => $this->trim_extra($row[5]),
                'zone' => $this->trim_extra($row[6]),
                'uc' => $this->trim_extra($row[7]),
                'plot_house_no' => $this->trim_extra($row[8]),
                'house_entrance' => $this->trim_extra($row[9]),
                'plot_size' => $this->trim_extra($row[10]),
                'street' => $this->trim_extra($row[11]),
                'sector_or_mohallah' => $this->trim_extra($row[12]),
                'phase' => $this->trim_extra($row[13]),
                'area' => $this->trim_extra($row[14]),
                'billing_period_from' => $this->formatDate($row[15]),
                'billing_period_to' => $this->formatDate($row[16]),
                'issued_date' => $this->formatDate($row[17]),
                'due_date'    => $this->formatDate($row[18]),
                'water_charges'    => $this->formatPrice($row[19]),
                'conservancy_charges'    => $this->formatPrice($row[20]),
                'sewerage_charges'    => $this->formatPrice($row[21]),
                'new_connection_charges' => $this->formatPrice($row[22]),
                'total_current_dues' => $this->formatPrice($row[23]),
                'arears' => $this->formatPrice($row[24]),
                'amount_payable_by_due_date' => $this->formatPrice($row[25]),
                'surcharge_10_percent_after_due_date' => $this->formatPrice($row[26]),
                'amount_payable_after_due_date' => $this->formatPrice($row[27]),
                'created_at' => now()
            ]);
        });

        return;

    }

    public function onRow($row)
    {
    }
}
