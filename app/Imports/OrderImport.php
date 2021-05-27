<?php

namespace App\Imports;

use App\Models\brand;
use App\Models\color;
use App\Models\fabric;
use App\Models\size;
use App\Models\subgroup;
use App\Models\supplier;
use App\Models\Years;
use App\order;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class OrderImport implements ToCollection, WithHeadingRow, WithChunkReading
{


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        //  dd(count($rows));
        $tot = 0;
        foreach ($rows as $row) {
            $group_id = $row['groupid'];
            if ($group_id == '3u') {

                continue;
            }


            $barCode = $row['barcode'];
            $temp_order = \App\Models\order::where('barcode', 'like', '%' . $barCode . '%')->first();
            if ($temp_order) {


                $tot++;
                continue;
            }


            $year_name = $row['yearname'];
            $year = Years::where('name', $year_name)->first();
            if ($year) {
                $year_id = $year->id;

            } else {
                $tot++;
                continue;
            }


            $supplier_name = $row['suppliername'];
            $supplier = supplier::where('name', $supplier_name)->first();
            if ($supplier) {
                $supplier_id = $supplier->id;
            } else {
                $tot++;
                continue;
            }


            $subgroup_name = $row['subgroupname'];
            if ($subgroup_name) {
                $subGroup = subgroup::where('name', $subgroup_name)->first();
                if ($subGroup) {
                    $subgroup_id = $subGroup->id;
                } else {

                    subgroup::create([
                        'idNum' => $row['subgroupid'],
                        'name' => $subgroup_name,
                        'group_id' => $group_id,
                    ]);
                    continue;
                }
            } else {
                $tot++;
                continue;
            }


            $fabrictype = $row['fabrictype'];

            $fabric_id = null;
            if ($fabrictype != null && $fabrictype != '-') {
                $fabrictype = str_replace('-', '', $fabrictype);

                $fabric = fabric::where('name', 'like', '%' . $fabrictype . '%')->first();

                if ($fabric) {
                    $fabric_id = $fabric->id;
                } else {

//                    $fabric = fabric::create([
//                        'name' => $fabrictype,
//                        'code' => null,
//                    ]);
//                    $fabric_id = $fabric->id;

                }

            }


            $siresSizeQty = $row['siressizeqtynumber'];
            $siresColorQty = $row['sirescolorqtynumber'];
            $siresQty = $row['siresqtynumber'];


            $siresItemNumber = $siresSizeQty * $siresColorQty;
            $quantity = $siresQty * $siresItemNumber;

            if ($row['reservedquantity'] == 'NULL') {
                $receivedQty = 0;
            } else {
                $receivedQty = $row['reservedquantity'];
            }


            $brand_id = $row['prandid'];

            $type_id = $row['typeid'];
            $type_id == '1' ? $type_id = 4 : $type_id = $type_id;
            $season_id = $row['seasonid'];
            $modelName = $row['modelname'];
            $modelDesc = $row['modeldesc'];
            $fabric_source_id = $row['fabricsorceid'] == 0 ? 1 : $row['fabricsorceid'];

            $fabricFormula = $row['fabricformula'];
            $orderDate = $row['orderdate'];
            $fabricDate = null;
            $done = $row['done'];
            $notes = $row['notes'];



            $colors = $row['colors'];


            // dd(strpos($colors,"\n"));

            if ($colors !== "-" && $colors !== null) {
                if (str_contains($colors, "\n")) {
                    $colors = explode("\n", $colors);
                } elseif (str_contains($colors, ",")) {
                    $colors = explode(",", $colors);
                }
            } else {
                $colors = null;
            }


            $sizes = $row['sizes'];

            if ($sizes !== "-" && $sizes !== null) {
                if (str_contains($sizes, "\n")) {
                    $sizes = explode("\n", $sizes);
                } elseif (str_contains($sizes, ",")) {
                    $sizes = explode(",", $sizes);
                }
            } else {
                $sizes = null;
            }





            DB::beginTransaction();
            try {


                $newOrder = \App\Models\order::create([

                    'barcode' => $barCode,
                    'modelName' => $modelName,
                    'modelDesc' => $modelDesc,
                    'siresSizeQty' => $siresSizeQty,
                    'siresColorQty' => $siresColorQty,
                    'siresQty' => $siresQty,
                    'siresItemNumber' => $siresItemNumber,
                    'quantity' => $quantity,
                    'receivedQty' => $receivedQty,
                    'fabricFormula' => $fabricFormula,
                    'orderDate' => $orderDate != null ? Carbon::create($orderDate)->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
                    'fabricDate' => Carbon::now()->format('Y-m-d'),

                    'done' => $done,
                    'notes' => $notes,
                    'PrintNotes' => null,


                    'brand_id' => $brand_id,
                    'type_id' => $type_id,
                    'group_id' => $group_id,
                    'subgroup_id' => $subgroup_id,
                    'season_id' => $season_id,
                    'year_id' => $year_id,
                    'supplier_id' => $supplier_id,
                    'fabric_source_id' => $fabric_source_id,
                    'user_id' => Auth::id(),

                ]);

                if ($colors !== null && count($colors) > 0) {
                    foreach ($colors as $color) {
                        $tempColor = color::where('name','like','%'.$color.'%')->first();
                        if ($tempColor){
                            $newOrder->colors()->attach($tempColor->id);
                        }
                    }
                }

                if ($sizes !== null && count($sizes) > 0) {

                    foreach ($sizes as $size) {
                        $tempSize = size::where('name','like','%'.$size.'%')->first();
                        if ($tempSize){
                            $newOrder->sizes()->attach($tempSize->id);
                        }

                    }

                }


                if ($fabric_id != null) {
                    $newOrder->fabrics()->attach($fabric_id);
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $tot++;
            }

        }

    }

    public function chunkSize(): int
    {
        // TODO: Implement chunkSize() method.
        return 100;
    }
}
