<?php

namespace App\Http\Controllers;

use App\Models\{
    Campaign,
    CampaignCreative
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Cache::remember('campaigns', 3600, function () {
            return Campaign::with('creatives')->orderBy('id','desc')->get();
        });
        return response()->json($campaigns);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'from'          => 'required|date',
            'to'            => 'required|date',
            'daily_budget'  => 'required|numeric|min:1',
            'total_budget'  => 'required|numeric|min:1',
            'creatives'     => 'required',
            'creatives.*'   => 'mimes:jpg,jpeg,png',
        ]);

        DB::beginTransaction();
        try {
            $campaign = Campaign::create([
                'name'          => $request->name,
                'from'          => $request->from,
                'to'            => $request->to,
                'total_budget'  => $request->total_budget,
                'daily_budget'  => $request->daily_budget
            ]);

            $campaignCreatives = [];
            foreach ($request->file('creatives') as $creative) {
                $campaignCreatives[] = new CampaignCreative([
                    'img_path'    => Storage::put('campaign/creatives', $creative)
                ]);
            }

            $campaign->creatives()->saveMany($campaignCreatives);

            DB::commit();

            return response(['created' => true],201);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Campaign create error : {$exception->getMessage()}");
            return response($exception->getMessage(),400);
        }
    }

    public function show($id)
    {
        $campaign = Cache::remember("campaign-{$id}", 3600, function () {
            return Campaign::findOrFail($id);
        });
        return response()->json($campaign);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'from'          => 'required|date',
            'to'            => 'required|date',
            'daily_budget'  => 'required|numeric|min:1',
            'total_budget'  => 'required|numeric|min:1'
        ]);

        try{
            $campaign               = Campaign::findOrFail($id);
            $campaign->name         = $request->name;
            $campaign->from         = $request->from;
            $campaign->to           = $request->to;
            $campaign->total_budget = $request->total_budget;
            $campaign->daily_budget = $request->daily_budget;
            $campaign->save();

            return response(['updated' => true],204);
        } catch (\Exception $exception) {
            Log::error("Campaign update error : {$exception->getMessage()}, ID : {$id}");
            return response($exception->getMessage(),400);
        }
    }
}
