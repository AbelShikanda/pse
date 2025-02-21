<?php

namespace App\Services;

use App\Models\Products;
use App\Models\PromoCodes;
use App\Models\PromoCodeUsage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PromoCodeService
{
    /**
     * Get all promo codes.
     */
    public function getAllPromoCodes()
    {
        return PromoCodes::latest()->get();
    }

    /**
     * Create a new promo code.
     *
     * @param int $productId
     * @param int $discount
     * @param int $maxUses
     * @param int $durationDays
     * @return array
     */
    public function createPromoCode($productId, $discount = 10, $maxUses = 10, $durationDays = 30)
    {
        // Generate a unique promo code
        do {
            $code = strtoupper(Str::random(10));
        } while (PromoCodes::where('code', $code)->exists());

        // Create the promo code inside a transaction
        DB::transaction(function () use ($code, $discount, $maxUses, $durationDays) {
            PromoCodes::create([
                'code' => $code,
                'discount_percentage' => $discount,
                'max_uses' => $maxUses,
                'times_used' => 0,
                'expires_at' => now()->addDays($durationDays),
            ]);
        });

        return ['status' => true, 'message' => 'Promo code created!', 'code' => $code];
    }

    /**
     * Apply a promo code for a user.
     *
     * @param int $userId
     * @param string $code
     * @return array
     */
    public function applyPromoCode($userId, $code)
    {
        $promo = PromoCodes::where('code', $code)->first();
        // dd($promo);

        if (!$promo) {
            return ['status' => false, 'message' => 'Promo code does not exist.'];
        }

        if ($promo->isExpired()) {
            return ['status' => false, 'message' => 'Promo code has expired.'];
        }

        if ($promo->isFullyUsed()) {
            return ['status' => false, 'message' => 'Promo code usage limit reached.'];
        }

        if (!$promo->canUserUse($userId)) {
            return ['status' => false, 'message' => 'You have reached the usage limit for this promo code.'];
        }

        $cart = Session::get('cart');
        $cartTotal = $cart ? $cart->totalPrice : 0;
        $minimumRequiredAmount = 2000;

        if ($cartTotal < $minimumRequiredAmount) {
            return ['status' => false, 'message' => "Promo code can only be applied to orders above $minimumRequiredAmount."];
        }

        // Apply the promo in a transaction
        DB::transaction(function () use ($promo, $userId) {
            $promo->increment('times_used');

            PromoCodeUsage::create([
                'promo_code_id' => $promo->id,
                'user_id' => $userId,
            ]);
        });

        return ['status' => true, 'message' => 'Promo code applied successfully!'];
    }

    /**
     * Get a single promo code by ID.
     */
    public function getPromoCodeById($id)
    {
        return PromoCodes::with(['usages'])->find($id);
    }

    /**
     * Update a promo code.
     */
    public function updatePromoCode($id, array $data)
    {
        $promoCode = PromoCodes::find($id);
        if (!$promoCode) {
            return ['status' => false, 'message' => 'Promo code not found.'];
        }

        $promoCode->update($data);
        return ['status' => true, 'message' => 'Promo code updated successfully.'];
    }

    /**
     * Delete a promo code.
     */
    public function deletePromoCode($id)
    {
        $promoCode = PromoCodes::find($id);
        if (!$promoCode) {
            return ['status' => false, 'message' => 'Promo code not found.'];
        }

        DB::transaction(function () use ($promoCode) {
            $promoCode->delete();
        });

        return ['status' => true, 'message' => 'Promo code deleted successfully.'];
    }
}
