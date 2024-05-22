<?php

namespace App\Http\Controllers;

use GeoIp2\Database\Reader;

use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException; 
use ZanySoft\LaravelSerpApi\Facades\SerpApi;

class HotelController extends Controller
{
    
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function getPublicIP()
    {
        $apiUrl = env('API_IP');                                   
        try {
            $response = $this->httpClient->get($apiUrl); 
        } catch (ClientException $e) {
            // Handle HTTP error (e.g., 404, 500)
            return response()->json(['error' => $e->getMessage()]);
        }
        $responseData = json_decode($response->getBody()->getContents(), true); 
        $publicIP = $responseData['ip'];

        return $publicIP;
    }

    public function index()
    {
        $publicIP = $this->getPublicIP(); 
        $reader = new Reader(storage_path('app/geoip2/GeoLite2-City.mmdb'));
        $result = $reader->city($publicIP);

        // Extract city and country from GeoIP2 data
        $country                = $result->country->name;
        $state                  = $result->mostSpecificSubdivision->name;
        $city                   = $result->city->name; 
        $formattedCheckInDate   = Carbon::parse(date('Y-m-d'));
        $formattedCheckOutDate  = $formattedCheckInDate->addDays(7)->addDays(4);
        $checkInDate            = $formattedCheckInDate->format('Y-m-d');
        $checkOutDate           = $formattedCheckOutDate->format('Y-m-d');
        $checkOutDate           = Carbon::parse($checkOutDate)->addDay()->format('Y-m-d');
        $dataIp                 = ['country' => $country, 'state' => $state, 'city' => $city, 'checkInDate' => $checkInDate, 'checkOutDate' => $checkOutDate];
        $client                 = SerpApi::GoogleSearch(); 
        $destination            = "Hotels in $city";
        $location               = $city.','.$state.','.$country;
        $query                  = ["q" => $destination, "check_in_date" => $checkInDate, "check_out_date" => $checkOutDate];          
        $response0              = $client->publicSearch('json', $query);
        $hotels                 = json_decode(json_encode($response0), true);   
        $message                = "You are in the city of $city";
        return view('index', ['message' => $message,'userIp' => $publicIP, 'dataIp' => $dataIp, 'hotels' => $hotels]);
    }

    public function getHotelsData(Request $request)
    {
        $today = now();
        $publicIP = $this->getPublicIP(); 
        $reader = new Reader(storage_path('app/geoip2/GeoLite2-City.mmdb'));
        $result = $reader->city($publicIP);
        $defaultCountry = $result->country->name;
        $defaultState   = $result->mostSpecificSubdivision->name;
        $defaultCity = $result->city->name;
        $country = $request->input('country') ?? $defaultCountry;
        $state = $request->input('state') ?? $defaultState;
        $city = $request->input('city') ?? $defaultCity;
        $destination = $request->input('destination') ?? "Hotels in $city";
        $location = $city.','.$state.','.$country;
        $checkin_date = $request->input('checkin_date') ?? $today->format('Y-m-d');
        $checkout_date = $request->input('checkout_date') ?? $today->addDays(1)->format('Y-m-d');
        $adults = $request->input('adults');
        $rooms = $request->input('rooms');
        $client = SerpApi::GoogleSearch(); 
        $query = ["q" => $destination, "check_in_date" => $checkin_date, "check_out_date" => $checkout_date];          
        $response0 = $client->publicSearch('json', $query);
        $hotels = json_decode(json_encode($response0), true);
        //dd($hotels);
        return $hotels;
    }
    
    public function searchHotels(Request $request)
    { 
        $hotels = $this->getHotelsData($request);
        $message = "Were found " . count($hotels) . " hoteles";
        return view('index', ['message' => $message, 'hotels' => $hotels]);
    }
    
    public function searchHotelsPost(Request $request)
    {
        $hotels = $this->getHotelsData($request);
        return view('hotels.list', ['hotels' => $hotels])->render();
    }

}
