<?php

namespace App\Http\Middleware;

use App\Models\VisitorData;
use App\Models\VisitorJourney;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tree\Visitor\Visitor;

class TrackVisitorJourney
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get IP address
        $ip = $request->ip();

        // Fetch location data from an external API
        if ($ip === '127.0.0.1') {
            $locationData = [
                'country' => 'Local',
                'region' => 'N/A',
                'city' => 'N/A',
                'referrer' => 'N/A',
                'user_agent' => 'N/A',
                'utm_source' => 'N/A',
                'utm_medium' => 'N/A',
                'utm_campaign' => 'N/A',
            ];
        } else {
            // Fetch location data from ipinfo.io
            $locationData = Http::get("http://ipinfo.io/{$ip}/json")->json();
        }
        
        // Capture page URL
        $pageUrl = $request->url();

        // Capture referrer
        $referrer = $request->headers->get('referer');
        $userAgent = $request->header('User-Agent');

        // Capture UTM parameters (if available)
        $utmSource = $request->query('utm_source');
        $utmMedium = $request->query('utm_medium');
        $utmCampaign = $request->query('utm_campaign');

        // Check if visitor already exists in the VisitorData table
        $visitor = VisitorData::firstOrCreate([
            'ip_address' => $ip,
        ], [
            'country' => $locationData['country'] ?? 'Unknown',
            'region' => $locationData['region'] ?? 'Unknown',
            'city' => $locationData['city'] ?? 'Unknown',
            'referrer' => $referrer ?? 'Direct',
            'user_agent' => $userAgent ?? 'Browser',
            'utm_source' => $utmSource ?? 'Unknown',
            'utm_medium' => $utmMedium ?? 'Unknown',
            'utm_campaign' => $utmCampaign ?? 'Unknown',
        ]);
        
        // Store page visit event in VisitorJourney table
        VisitorJourney::create([
            'visitor_data_id' => $visitor->id,  // Reference the VisitorData record
            'event_type' => VisitorJourney::EVENT_TYPE_PAGE_VISIT,
            'page_url' => $pageUrl,  // Save the page visited
        ]);

        // Capture button click event (assuming you're sending it in the request)
        $buttonClicked = $request->input('button_id');  // Expecting button_id from frontend (JavaScript)
        // dd($buttonClicked);
        
        // Store button click event (only if button ID is present)
        if ($buttonClicked) {
            VisitorJourney::create([
                'visitor_data_id' => $visitor->id,  // Reference the VisitorData record
                'event_type' => VisitorJourney::EVENT_TYPE_BUTTON_CLICK,
                'button_clicked' => $buttonClicked,  // Save the button ID
            ]);
        }

        return $next($request);
    }
}
