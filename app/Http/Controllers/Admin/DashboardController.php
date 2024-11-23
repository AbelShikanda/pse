<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order_Items;
use App\Models\OrderItems;
use App\Models\Products;
use App\Models\VisitorData;
use App\Models\VisitorJourney;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * function to display the dashboard
     *
     * This function does the following:
     * - Step 1
     * - Step 2
     * - Step 3
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function index()
    {
        // Get the start and end of the current week
        $startOfThisWeek = Carbon::now()->startOfWeek();
        $endOfThisWeek = Carbon::now()->endOfWeek();

        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++page views++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $dailyPageViews = [];
        for ($day = 0; $day < 7; $day++) {
            $date = $startOfThisWeek->copy()->addDays($day);

            // Count page views for this day
            $dailyCount = VisitorJourney::where('event_type', 'page_visit')
                ->whereDate('created_at', $date)
                ->count();

            $dailyPageViews[] = $dailyCount; // Append count to the array
        }

        $thisWeekViews = array_sum($dailyPageViews);

        $startOfLastWeek = $startOfThisWeek->copy()->subWeek();
        $endOfLastWeek = $startOfThisWeek->copy()->subDay();

        $lastWeekViews = VisitorJourney::where('event_type', 'page_visit')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->count();

        $percentageViewChange = $lastWeekViews > 0 ? (($thisWeekViews - $lastWeekViews) / $lastWeekViews) * 100 : 0;

        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // ++++++++++++++++++++++++++++++++++++++Conversions++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $thisWeekConversions = VisitorJourney::where('page_url', 'like', '%checkout%')
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->count();

        // Get conversion count for last week
        $startOfLastWeek = $startOfThisWeek->copy()->subWeek();
        $endOfLastWeek = $startOfThisWeek->copy()->subDay();

        $lastWeekConversions = VisitorJourney::where('page_url', 'like', '%checkout%')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->count();

        $percentageConversionChange = $lastWeekConversions > 0 ? (($thisWeekConversions - $lastWeekConversions) / $lastWeekConversions) * 100 : 0;

        $conversionBreakdown = [
            'organic' => VisitorData::where('utm_medium', 'organic')
                ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                ->count(),
            'referral' => VisitorData::where('utm_medium', 'referral')
                ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                ->count(),
            'paid' => VisitorData::where('utm_medium', 'paid')
                ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                ->count(),
        ];

        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // ++++++++++++++++++++++++++++++++++++Visitors+++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $lastWeekVisitorIds = VisitorData::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->pluck('id')
            ->toArray();

        // Get count of visitors this week who were not there last week
        $uniqueVisitorsCount = VisitorData::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->whereNotIn('id', $lastWeekVisitorIds)
            ->count();

        // Get total visitors this week
        $thisWeekVisitorsCount = VisitorData::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->count();

        // Calculate the percentage change
        $percentageVisitorChange = $thisWeekVisitorsCount > 0 ? (($uniqueVisitorsCount - $thisWeekVisitorsCount) / $thisWeekVisitorsCount) * 100 : 0;

        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // ++++++++++++++++++++++++++++++++++++++Trends+++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $pageViewsTrend = [];
        $visitorTrend = [];
        $ConversionTrend = [];

        for ($i = 6; $i >= 0; $i--) {
            $dayStart = Carbon::now()->subDays($i)->startOfDay();
            $dayEnd = Carbon::now()->subDays($i)->endOfDay();

            $visitorTrend[] = VisitorData::whereBetween('created_at', [$dayStart, $dayEnd])->count();
            $pageViewsTrend[] = VisitorJourney::whereBetween('created_at', [$dayStart, $dayEnd])->count();
            $ConversionTrend[] = VisitorJourney::where('page_url', 'like', '%checkout%')
                ->whereBetween('created_at', [$dayStart, $dayEnd])->count();
        }

        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++Sales+++++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $topSellingProducts = Products::select(
            'products.id',
            'products.name',
            'products.meta_keywords',
            DB::raw('SUM(order_items.quantity) as sales'),
            DB::raw('(SUM(order_items.quantity) / (SELECT SUM(quantity) FROM order_items) * 100) as percentage_sold')
        )
            ->join('order_items', 'order_items.product_id', '=', 'products.id') // Join with order_items table
            ->groupBy('products.id', 'products.name', 'products.meta_keywords') // Group by product columns
            ->orderByDesc('sales')
            ->with('productImage') // Eager load the product images
            ->take(7) // Fetch the top 4 products
            ->get();

        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++Regions+++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $regionData = Order_Items::select(
            'users.town', // Fetch town from the users table
            'users.location', // Fetch location from the users table
            DB::raw('SUM(order_items.quantity) as total_sales'),
            DB::raw('SUM(order_items.quantity) / (SELECT SUM(quantity) FROM order_items) * 100 as sales_percentage')
        )
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('users', 'users.id', '=', 'orders.user_id') // Join with the users table
            ->groupBy('users.town', 'users.location') // Group by town and location
            ->orderByDesc('total_sales')
            ->take(7) // Fetch the top 4 products
            ->get();

        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++Trafic++++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $trafficData = [
            'organic' => VisitorData::where('utm_medium', 'organic')
                ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                ->count(),
            'referral' => VisitorData::where('utm_medium', 'referral')
                ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                ->count(),
            'paid' => VisitorData::where('utm_medium', 'paid')
                ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                ->count(),
            'direct' => VisitorData::whereNull('utm_medium') // Assuming 'direct' has no utm_medium
                ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                ->count(),
        ];

        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++Browser+++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $totalCount = VisitorData::count(); // Total number of visitors

        $browsers = VisitorData::select(
            'user_agent',
            DB::raw('COUNT(*) as count'),
            DB::raw('ROUND(COUNT(*) / ' . $totalCount . ' * 100, 2) as percentage') // Calculate percentage
        )
            ->groupBy('user_agent')
            ->orderByDesc('count')
            ->limit(4)
            ->get();

        // dd($browsers);
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        return view('admin.dashboard.dashboard', with([
            'thisWeekViews' => $thisWeekViews,
            'thisWeekConversions' => $thisWeekConversions,
            'thisWeekVisitorsCount' => $thisWeekVisitorsCount,
            'uniqueVisitorsCount' => $uniqueVisitorsCount,
            'percentageViewChange' => $percentageViewChange,
            'percentageConversionChange' => $percentageConversionChange,
            'percentageVisitorChange' => $percentageVisitorChange,
            'conversionBreakdown' => $conversionBreakdown,
            'ConversionTrend' => $ConversionTrend,
            'pageViewsTrend' => $pageViewsTrend,
            'visitorTrend' => $visitorTrend,
            'topSellingProducts' => $topSellingProducts,
            'regionData' => $regionData,
            'trafficData' => $trafficData,
            'browsers' => $browsers,
        ]));
    }

    /**
     * function to display an overview of the schedules
     *
     * This function does the following:
     * - Step 1
     * - Step 2
     * - Step 3
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function schedules()
    {
        return view('admin.dashboard.schedules');
    }

    /**
     * function to display product posting page
     *
     * This function does the following:
     * - Step 1
     * - Step 2
     * - Step 3
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function postPost()
    {
        return view('admin.products.create');
    }

    /**
     * function to display the blog posting page
     *
     * This function does the following:
     * - Step 1
     * - Step 2
     * - Step 3
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function postBlog()
    {
        return view('admin.blogs.create');
    }
}
