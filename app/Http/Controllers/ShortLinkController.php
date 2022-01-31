<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShortLinkController extends Controller
{

    public function index()
    {
        $shortLinks = ShortLink::latest()->get();

        return view('shortenLink', compact('shortLinks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url'
        ]);

        $input['link'] = $request->link;
        $input['code'] = Str::random(6);
        $input['created_by'] = Auth::user()->id;
        $input['updated_by'] = Auth::user()->id;

        ShortLink::create($input);

        return response()->json(['status' => 'success'], 200);
    }

    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();

        return redirect($find->link);
    }


    public function datatable(Request $request)
    {
        $requestData = $request;

        $totalData = DB::table('short_links')->count();


        $data = DB::table('short_links as a')
            ->selectRaw('a.*, b.name')
            ->leftJoin('users as b', 'a.created_by', '=', 'b.id');
        if ($request->has('search') && $request->filled('search')) {
            $search = $request->get('search');
            if (!empty($search['value'])) {
                $data->where('a.link', 'like', '%' . $search['value'] . '%');
                $data->orWhere('a.code', 'like', '%' . $search['value'] . '%');
                $data->orWhere('b.name', 'like', '%' . $search['value'] . '%');
            }
        }

        if (Auth::user()->level != 'admin') {
            $data->where('a.created_by', Auth::user()->id);
        }

        // Sort Table
        $order = $request->get('order')[0];
        $data->orderBy($request->get('columns')[$order['column']]['name'], $order['dir']);

        $totalFiltered = $data->count();

        if ($request->has('start')) {
            $data->offset($request->get('start'));
        }
        if ($request->has('length')) {
            $data->limit($request->get('length'));
        }
        $data_result = $data->get()->toArray();


        $data = !empty($data_result) ? $data_result : [];
        $json_data = [
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];

        return response()->json($json_data);
    }

    public function delete(Request $request)
    {
        if ($request->has('id') && $request->filled('id')) {
            if (Auth::user()->level != 'admin') {
                DB::table('short_links')->where(['id' => $request->get('id'), 'created_by' => Auth::user()->id])->delete();
            } else {
                DB::table('short_links')->where('id', $request->get('id'))->delete();
            }
            return response()->json(['status' => 'success'], 200);
        }
    }
}
