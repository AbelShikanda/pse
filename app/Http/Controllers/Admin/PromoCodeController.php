<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\PromoCodes;
use App\Services\PromoCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PromoCodeController extends Controller
{
    protected $promoCodeService;

    public function __construct(PromoCodeService $promoCodeService)
    {
        $this->promoCodeService = $promoCodeService;
    }

    /**
     * Display all promo codes.
     */
    public function index()
    {
        $promoCodes = $this->promoCodeService->getAllPromoCodes();
        return view('admin.promo.index', compact('promoCodes'));
    }

    /**
     * Show the form for creating a new promo code.
     */
    public function create()
    {
        // Fetch products to display in the dropdown
        $products = Products::all();

        return view('admin.promo.create', compact('products'));
    }

    public function createPromo(Request $request)
    {
        $request->validate([
            'discount' => 'nullable|integer|min:1|max:100',
            'max_uses' => 'nullable|integer|min:1',
            'duration_days' => 'nullable|integer|min:1',
        ]);

        $result = $this->promoCodeService->createPromoCode($request->input('product_id'), $request->input('discount', 10), $request->input('max_uses', 10), $request->input('duration_days', 30));

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return redirect()->route('promo.index')->with('message', 'Promo code created successfully! Code: ' . $result['code']);
    }

    public function applyPromo(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        if (Auth::user()->email_verified_at === null) {
            return redirect()->route('profile')->with('error', 'Please verify your email.');
        }

        $userId = auth()->id();
        $code = $request->input('code');

        $result = $this->promoCodeService->applyPromoCode($userId, $code);

        if ($result['status']) {
            Session::put('applied_promo', $code);
            return redirect()->route('cart')->with('message', $result['message']);
        }

        return redirect()->route('cart')->withErrors(['promo' => $result['message']]);
    }

    /**
     * Show a single promo code.
     */
    public function show($id)
    {
        $promoCode = $this->promoCodeService->getPromoCodeById($id);

        if (!$promoCode) {
            return back()->with('error', 'Promo code not found.');
        }

        return view('admin.promo.show', compact('promoCode'));
    }

    /**
     * Show the form for editing a promo code.
     */
    public function edit($id)
    {
        $promoCode = $this->promoCodeService->getPromoCodeById($id);

        if (!$promoCode) {
            return back()->with('error', 'Promo code not found.');
        }

        return view('admin.promo.edit', compact('promoCode'));
    }

    /**
     * Update a promo code.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'discount_percentage' => 'nullable|integer|min:1|max:100',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $result = $this->promoCodeService->updatePromoCode($id, $request->all());

        return redirect()->route('promo.index')->with('message', $result['message']);
    }

    /**
     * Delete a promo code.
     */
    public function destroy($id)
    {
        $result = $this->promoCodeService->deletePromoCode($id);

        return redirect()->route('promo.index')->with('message', $result['message']);
    }
}
