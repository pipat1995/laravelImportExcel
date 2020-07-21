<?php

namespace App\Http\Controllers;

use App\Imports\VendorsImport;
use App\Vendor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportsController extends Controller
{
    public function import(Request $request)
    {
        try {
            $this->validate($request, [
                'file' => 'required|file|mimes:xls,xlsx'
            ]);

            $file = $request->file('file');
            // Excel::import(new VendorsImport, $file);
            $results = Excel::toArray(new VendorsImport, $file);
            if (\count($results[0][0]) != 4) {
                return \back()->with('error', 'imported error format header!');
            }
            $validate = \false;
            // \dd($results[0][0]);
            foreach ($results[0][0] as $key => $value) {
                if (strtoupper($value) == 'MAT_CODE') {
                    $results[0][0][0] = 'MAT_CODE';
                    $validate = \true;
                }
                if (strtoupper($value) == 'PLANT') {
                    $results[0][0][1] = 'PLANT_CODE';
                    $validate = \true;
                }
                if (strtoupper($value) == 'VENDOR ID') {
                    $results[0][0][2] = 'VENDOR_ID';
                    $validate = \true;
                }
                if (strtoupper($value) == 'VENDOR NAME') {
                    $results[0][0][3] = 'VENDOR_NAME';
                    $validate = \true;
                }
                if (!$validate) {
                    return \back()->with('error', 'imported error format header!');
                }
            }
            array_splice($results[0], 0, 1);
            foreach ($results[0] as $key => $value) {
                
                $arr = mb_str_split($value[0]);
                $delIndex = array();
                foreach ($arr as $key => $data) {
                    if (mb_convert_encoding($data,"SJIS") == "?" || mb_convert_encoding($data,"SJIS") == " ") {
                        \array_push($delIndex,$key);
                    }
                }
                foreach ($delIndex as $key => $index) {
                    unset($arr[$index]);
                }
                $value[0] = implode($arr);
                
                $vendor = Vendor::find($value[0]);
                if ($vendor) {
                    # update
                    $vendor->VENDOR_ID = $value[2];
                    $vendor->VENDOR_NAME = $value[3];
                    $vendor->save();
                } else {
                    $vendor = new Vendor;
                    # insert
                    $vendor->MAT_CODE = $value[0];
                    $vendor->PLANT_CODE = $value[1];
                    $vendor->VENDOR_ID = $value[2];
                    $vendor->VENDOR_NAME = $value[3];
                    $vendor->save();
                }
            }
            return \back()->with('success', 'imported successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteElement($element, $array)
    {
        $index = array_search($element, $array);
        if ($index !== false) {
            unset($array[$index]);
        }
    }
}
