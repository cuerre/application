<?php

namespace App\Http\Controllers;

use App\StatsExceptions\StatsStatsException;
use App\StatBrowscap;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Controller to take several statistics of a QR code
 * using a sample for avoiding to saturate the system
 * 
 * Methods:
 * $stats = new StatsController($codeId)
 * $stats->GetSample()       : Illuminate\Support\Collection
 * $stats->GetSampleMax()    : int
 * $stats->GetPlatforms()    : Illuminate\Support\Collection
 * $stats->GetBrowsers()     : Illuminate\Support\Collection
 * $stats->GetDeviceTypes()  : Illuminate\Support\Collection
 * $stats->GetBrowserTypes() : Illuminate\Support\Collection
 * $stats->GetAfterDate(Carbon $date) : Illuminate\Support\Collection
 * $stats->GetLastWeek()     : Illuminate\Support\Collection
 * $stats->GetLastMonth()    : Illuminate\Support\Collection
 * $stats->GetLastYear()     : Illuminate\Support\Collection
 * 
 */
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
            
        } catch (StatsException $e){
            Log::error( $e );
            abort(404);
        }
    }
    
    
    
    /**
     * Return the whole sample
     *
     * @return Illuminate\Support\Collection
     */
    public function GetSample()
    {
        return $this->sample;
    }



    /**
     * Return the quantity of data
     * into the sample
     *
     * @return int
     */
    public function GetSampleMax()
    {
        return $this->sampleMax;
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
        
        } catch (StatsException $e){
            Log::error( $e );
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
        
        } catch (StatsException $e){
            Log::error($e);
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
        
        } catch (StatsException $e){
            Log::error($e);
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
        
        } catch (StatsException $e){
            Log::error($e);
            return collect([]);
        }
    }
    
    

    /**
     * Retrieves a collection of data
     * that were stored after an input date
     * 
     * @param Illuminate\Support\Carbon $date
     * @return Illuminate\Support\Collection
     */
    private function GetAfterDate(Carbon $date)
    {
        try {
            return StatBrowscap::select('created_at')
                               ->where('code_id', $this->codeId)
                               ->whereDate('created_at', '>', $date)
                               ->oldest()
                               ->get();

        } catch (StatsException $e){
            Log::error( $e );
            return collect([]);
        }
    }



    /**
     * Retrieves data collection of last week
     * 
     * @return Illuminate\Support\Collection
     */
    public function GetLastWeek()
    {
        try {
            # Substract a week from now
            $targetDate = Carbon::now()->subWeek();

            # Get that data from DB
            $readings = $this->GetAfterDate($targetDate);

            # Group the visitors by day
            $readings = $readings->map(function ($item, $key) {
                return collect([
                    'day' => Carbon::parse($item->created_at)->isoFormat('dddd')
                ]);
            })
            ->groupBy('day')
            ->map(function ($item, $key) {
                return $item->count();
            });

            return $readings;
        } catch (StatsException $e){
            Log::error( $e );
            return collect([]);
        }
    }



    /**
     * Retrieves data collection of last month
     * 
     * @return Illuminate\Support\Collection
     */
    public function GetLastMonth()
    {
        try {
            # Substract a month from now
            $targetDate = Carbon::now()->subMonth();

            # Get that data from DB
            $readings = $this->GetAfterDate($targetDate);

            # Group the visitors by day
            $readings = $readings->map(function ($item, $key) {
                return collect([
                    'day' => Carbon::parse($item->created_at)->isoFormat('D')
                ]);
            })
            ->groupBy('day')
            ->map(function ($item, $key) {
                return $item->count();
            });

            return $readings;

        } catch (StatsException $e){
            Log::error( $e );
            return collect([]);
        }
    }



    /**
     * Retrieves data collection of last Year
     * 
     * @return Illuminate\Support\Collection
     */
    public function GetLastYear()
    {
        try {
            # Substract a month from now
            $targetDate = Carbon::now()->subYear();

            # Get that data from DB
            $readings = $this->GetAfterDate($targetDate);

            # Group the visitors by day
            $readings = $readings->map(function ($item, $key) {
                return collect([
                    'month' => Carbon::parse($item->created_at)->isoFormat('MMMM')
                ]);
            })
            ->groupBy('month')
            ->map(function ($item, $key) {
                return $item->count();
            });

            return $readings;
        } catch (StatsException $e){
            Log::error( $e );
            return collect([]);
        }
    }
    
    
    
    
    
    
    
    
}
