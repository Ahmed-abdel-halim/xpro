<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymobService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('PAYMOB_BASE_URL', 'https://accept.paymob.com/api');
        $this->apiKey = env('PAYMOB_API_KEY');
    }

    /**
     * Step 1: Authentication Request
     */
    public function authenticate()
    {
        $response = Http::post("{$this->baseUrl}/auth/tokens", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json()['token'] ?? null;
    }

    /**
     * Step 2: Order Registration API
     */
    public function createOrder($token, $amount, $orderId, $items = [])
    {
        $response = Http::post("{$this->baseUrl}/ecommerce/orders", [
            'auth_token' => $token,
            'delivery_needed' => 'false',
            'amount_cents' => $amount * 100,
            'currency' => 'EGP',
            'merchant_order_id' => $orderId,
            'items' => $items,
        ]);

        return $response->json();
    }

    /**
     * Step 3: Payment Key Request
     */
    public function getPaymentKey($token, $amount, $orderId, $billingData, $integrationId)
    {
        $response = Http::post("{$this->baseUrl}/acceptance/payment_keys", [
            'auth_token' => $token,
            'amount_cents' => $amount * 100,
            'expiration' => 3600,
            'order_id' => $orderId,
            'billing_data' => [
                'first_name' => $billingData['first_name'] ?? 'NA',
                'last_name' => $billingData['last_name'] ?? 'NA',
                'email' => $billingData['email'] ?? 'NA',
                'phone_number' => $billingData['phone_number'] ?? 'NA',
                'apartment' => '8',
                'floor' => '1',
                'street' => 'Street Name',
                'building' => '1',
                'shipping_method' => 'PKG',
                'postal_code' => '12345',
                'city' => 'Cairo',
                'country' => 'EGY',
                'state' => 'Cairo',
            ],
            'currency' => 'EGP',
            'integration_id' => $integrationId,
        ]);

        return $response->json()['token'] ?? null;
    }

    /**
     * Wallet Payment Request (for Vodafone Cash, etc.)
     */
    public function prepareWalletPayment($paymentToken, $phoneNumber)
    {
        $response = Http::post("{$this->baseUrl}/acceptance/payments/pay", [
            'source' => [
                'identifier' => $phoneNumber,
                'subtype' => 'WALLET',
            ],
            'payment_token' => $paymentToken,
        ]);

        return $response->json();
    }

    /**
     * Kiosk Payment Request (Ref code for Aman/Masary)
     */
    public function prepareKioskPayment($paymentToken)
    {
        $response = Http::post("{$this->baseUrl}/acceptance/payments/pay", [
            'source' => [
                'identifier' => 'AGGREGATOR',
                'subtype' => 'AGGREGATOR',
            ],
            'payment_token' => $paymentToken,
        ]);

        return $response->json();
    }
}
