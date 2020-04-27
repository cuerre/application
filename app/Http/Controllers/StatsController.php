<?php

namespace App\Http\Controllers;

use App\StatBrowscap as StatBrowscap;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    /**
     * Code id to extract 
     * the sample from DB
     *
     * @type int
     */
    private $codeId;
    
    /**
     * Data sample
     * 
     * @type Illuminate\Support\Collection
     */
    private $sample;
    
    /**
     * Maximum number of samples
     *
     * @type int
     */
    private $sampleMax = 100;
    
    
    
    /**
     * Take a code id, extract a sample
     * and save it into the sample atribute
     * 
     * @param int $codeId
     * @return void
     */
    function __Construct(int $codeId)
    {
        try{
            # Save code id
            $this->codeId = $codeId;
            
            # Where to save sample
            $this->sample = collect([]);
            
            # Take a sample of browser's stats
            $browsersSample = StatBrowscap::select('data')
                ->where('code_id', $codeId)
                ->limit($this->sampleMax)
                ->get();
               
            # Save the sample into the right atribute and clean memory
            $this->sample->put('browscap', $browsersSample);
            unset($browsersSample);
            
        } catch (Exception $e){
            Log::error($e->getMessage());
            abort(404); #@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        }
    }
    
    
    
    /**
     * Return the whole sample
     *
     * @return Illuminate\Support\Collection
     */
     public function GetSample(){
        return $this->sample;
     }
    
    
    
    /**
     * Retrieves a collection with
     * available operating systems
     * in the sample and the sum 
     * for each of them
     * 
     * @return Illuminate\Support\Collection
     */
    public function GetPlatforms()
    {
        try {
            $platforms = $this->sample['browscap']
                ->map(function ($item, $key) {
                    # Cast array into collection
                    $item = collect($item)->recursive();
                    
                    # Return platform
                    if ($item['data']->has('platform'))
                        return collect(['system' => $item['data']['platform']]);
                })
                ->groupBy('system')
                ->map(function ($item, $key) {
                    return $item->count();
                });
            
            return $platforms;
        
        } catch (Exception $e){
            Log::error($e->getMessage());

            return collect([]);
        }
    }
    
    
    
    /**
     * Retrieves a collection with
     * available browsers
     * in the sample and the sum 
     * for each of them
     * 
     * @return Illuminate\Support\Collection
     */
    public function GetBrowsers()
    {
        try {
            $browsers = $this->sample['browscap']
                ->map(function ($item, $key) {
                    # Cast array into collection
                    $item = collect($item)->recursive();
                    
                    # Return platform
                    if ($item['data']->has('browser'))
                        return collect(['browser' => $item['data']['browser']]);
                })
                ->groupBy('browser')
                ->map(function ($item, $key) {
                    return $item->count();
                });
            
            return $browsers;
        
        } catch (Exception $e){
            Log::error($e->getMessage());

            return collect([]);
        }
    }
    
    
    
    /**
     * Retrieves a collection with
     * available device types
     * in the sample and the sum 
     * for each of them
     * 
     * @return Illuminate\Support\Collection
     */
    public function GetDeviceTypes()
    {
        try {
            $devices = $this->sample['browscap']
                ->map(function ($item, $key) {
                    # Cast array into collection
                    $item = collect($item)->recursive();
                    
                    # Return platform
                    if ($item['data']->has('device_type'))
                        return collect(['device_type' => $item['data']['device_type']]);
                })
                ->groupBy('device_type')
                ->map(function ($item, $key) {
                    return $item->count();
                });
            
            return $devices;
        
        } catch (Exception $e){
            Log::error($e->getMessage());

            return collect([]);
        }
    }
    
    
    
    /**
     * Retrieves a collection with
     * browser types in the sample 
     * and the sum for each of them
     * 
     * @return Illuminate\Support\Collection
     */
    public function GetBrowserTypes()
    {
        try {
            $devices = $this->sample['browscap']
                ->map(function ($item, $key) {
                    # Cast array into collection
                    $item = collect($item)->recursive();
                    
                    # Return platform
                    if ($item['data']->has('browser_type'))
                        return collect(['browser_type' => $item['data']['browser_type']]);
                })
                ->groupBy('browser_type')
                ->map(function ($item, $key) {
                    return $item->count();
                });
            
            return $devices;
        
        } catch (Exception $e){
            Log::error($e->getMessage());

            return collect([]);
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    /*
        $orderbydate = DB::table('sales_flat_orders as w')
                ->select(array(DB::Raw('sum(w.total_item_count) as Day_count'),DB::Raw('DATE(w.created_at) day')))
                ->groupBy('day')
                ->orderBy('w.created_at')
                ->get();
    */
    
    
    
    
    
    
}
