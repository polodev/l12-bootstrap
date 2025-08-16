<?php
namespace Modules\Payment\Libraries;


trait PaymentHelpersTrait
{
    /**
     * Calculate total amount with SSLCommerz gateway fee
     *
     * @param float $amount Base amount
     * @return array ['base_amount' => float, 'regular_fee' => float, 'regular_total' => float, 'premium_fee' => float, 'premium_total' => float]
     */
    public static function calculateSSLCommerzTotal($amount)
    {
        $baseAmount = (float) $amount;
        
        // Regular card fee calculation
        $regularFeePercentage = config('global.sslcommerz_payment_gateway_charge', 2.00);
        $regularFee = ($baseAmount * $regularFeePercentage) / 100;
        $regularTotal = $baseAmount + $regularFee;
        
        // Premium card fee calculation
        $premiumFeePercentage = config('global.sslcommerz_payment_gateway_charge_for_premium_card', 3.00);
        $premiumFee = ($baseAmount * $premiumFeePercentage) / 100;
        $premiumTotal = $baseAmount + $premiumFee;

        return [
            'base_amount' => $baseAmount,
            'regular_fee' => round($regularFee, 2),
            'regular_total' => round($regularTotal, 2),
            'premium_fee' => round($premiumFee, 2),
            'premium_total' => round($premiumTotal, 2)
        ];
    }

    /**
     * Calculate total amount with bKash gateway fee
     *
     * @param float $amount Base amount
     * @return array ['base_amount' => float, 'fee' => float, 'total' => float]
     */
    public static function calculateBkashTotal($amount)
    {
        $baseAmount = (float) $amount;
        $feePercentage = config('global.bkash_payment_gateway_charge', 1.5);
        $fee = ($baseAmount * $feePercentage) / 100;
        $total = $baseAmount + $fee;

        return [
            'base_amount' => $baseAmount,
            'fee' => round($fee, 2),
            'total' => round($total, 2)
        ];
    }

    /**
     * Get payment gateway fee rates
     *
     * @return array
     */
    public static function getPaymentGatewayRates()
    {
        return [
            'sslcommerz_regular' => config('global.sslcommerz_payment_gateway_charge', 2.00),
            'sslcommerz_premium' => config('global.sslcommerz_payment_gateway_charge_for_premium_card', 3.00),
            'bkash' => config('global.bkash_payment_gateway_charge', 1.5)
        ];
    }
}