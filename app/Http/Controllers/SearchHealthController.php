<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SearchHealthController extends Controller
{
    public function search(Request $request)    {

        $validator = Validator::make($request->all(), ['search' => 'between:0,100',]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400, [], JSON_UNESCAPED_UNICODE);
        }
        $searchString = $validator->validated();
        $searchString = (isset($searchString['search']) && $searchString['search']) ? $searchString['search'] : '';



        $doctors = $this->getDoctors($searchString);

        $services= $this->getServices($searchString);
        $specials = $this->getSpecials($searchString);

        return response()->json($doctors+$services+$specials, 200, [], JSON_UNESCAPED_UNICODE);
    }
    protected function getDoctors(string $search = ''){
        $conditions = ($search) ? '  where surname LIKE "%'.$search.'%"' : '';
        $conditions .= ($search) ? '   limit 3' : ' limit 0';
        return DB::select('select TRIM(CONCAT(`surname`, " ", `name`, " ",  `middlename`)) as fio, id, "doc", uri from  modx_doc_doctors'.$conditions );
    }

    protected function getServices(string  $search = ''){
        $conditions = ($search) ? ' AND pagetitle LIKE "%'.$search.'%"' : '';
        $conditions .= ($search) ? ' limit 3' : ' limit 200';
        return DB::select('select pagetitle, id, "serv", uri from  modx_site_content where parent IN(7152,7153,7154,7155,7156,7157,7158,7159,7160,7161,7162,7163)'.$conditions
        );
    }
    protected function getSpecials(string  $search = ''){
        $conditions = ($search) ? ' AND pagetitle LIKE "%'.$search.'%"' : '';
        $conditions .= ($search) ? '   limit 3' : '  limit 0';
        return DB::select('select pagetitle, id, "spec", uri from  modx_site_content where parent IN(6766)'.$conditions);
    }

}
