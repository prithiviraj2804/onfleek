<?php
/**
 * Contains the language translations for the payment gateways
 */
$lang = array(
    // General strings
    'online_payment'                     => 'Spletno plačilo',
    'online_payments'                    => 'Spletna plačila',
    'online_payment_for'                 => 'Spletno plačilo za',
    'online_payment_method'              => 'Način spletnega plačila',
    'online_payment_creditcard_hint'     => 'If you want to pay via credit card please enter the information below.<br/>The credit card information are not stored on our servers and will be transferred to the online payment gateway using a secure connection.',
    'enable_online_payments'             => 'Enable Online Payments',
    'add_payment_provider'               => 'Add a Payment Provider',

    // Credit card strings
    'creditcard_cvv'                     => 'CVV / CSC',
    'creditcard_details'                 => 'Podatki o kreditni kartici',
    'creditcard_expiry_month'            => 'Mesec poteka',
    'creditcard_expiry_year'             => 'Leto poteka',
    'creditcard_number'                  => 'Številka kreditne kartice',
    'online_payment_card_invalid'        => 'This credit card is invalid. Please check the provided information.',

    // Payment Gateway Fields
    'online_payment_apiLoginId'          => 'Api Login Id', // Field for AuthorizeNet_AIM
    'online_payment_transactionKey'      => 'Transaction Key', // Field for AuthorizeNet_AIM
    'online_payment_testMode'            => 'Test Mode', // Field for AuthorizeNet_AIM
    'online_payment_developerMode'       => 'Developer Mode', // Field for AuthorizeNet_AIM
    'online_payment_websiteKey'          => 'Website Key', // Field for Buckaroo_Ideal
    'online_payment_secretKey'           => 'Secret Key', // Field for Buckaroo_Ideal
    'online_payment_merchantId'          => 'Merchant Id', // Field for CardSave
    'online_payment_password'            => 'Password', // Field for CardSave
    'online_payment_apiKey'              => 'Api Key', // Field for Coinbase
    'online_payment_secret'              => 'Secret', // Field for Coinbase
    'online_payment_accountId'           => 'Account Id', // Field for Coinbase
    'online_payment_storeId'             => 'Store Id', // Field for FirstData_Connect
    'online_payment_sharedSecret'        => 'Shared Secret', // Field for FirstData_Connect
    'online_payment_appId'               => 'App Id', // Field for GoCardless
    'online_payment_appSecret'           => 'App Secret', // Field for GoCardless
    'online_payment_accessToken'         => 'Access Token', // Field for GoCardless
    'online_payment_merchantAccessCode'  => 'Merchant Access Code', // Field for Migs_ThreeParty
    'online_payment_secureHash'          => 'Secure Hash', // Field for Migs_ThreeParty
    'online_payment_siteId'              => 'Site Id', // Field for MultiSafepay
    'online_payment_siteCode'            => 'Site Code', // Field for MultiSafepay
    'online_payment_accountNumber'       => 'Account Number', // Field for NetBanx
    'online_payment_storePassword'       => 'Store Password', // Field for NetBanx
    'online_payment_merchantKey'         => 'Merchant Key', // Field for PayFast
    'online_payment_pdtKey'              => 'Pdt Key', // Field for PayFast
    'online_payment_username'            => 'Username', // Field for Payflow_Pro
    'online_payment_vendor'              => 'Vendor', // Field for Payflow_Pro
    'online_payment_partner'             => 'Partner', // Field for Payflow_Pro
    'online_payment_pxPostUsername'      => 'Px Post Username', // Field for PaymentExpress_PxPay
    'online_payment_pxPostPassword'      => 'Px Post Password', // Field for PaymentExpress_PxPay
    'online_payment_signature'           => 'Signature', // Field for PayPal_Express
    'online_payment_referrerId'          => 'Referrer Id', // Field for SagePay_Direct
    'online_payment_transactionPassword' => 'Transaction Password', // Field for SecurePay_DirectPost
    'online_payment_subAccountId'        => 'Sub Account Id', // Field for TargetPay_Directebanking
    'online_payment_secretWord'          => 'Secret Word', // Field for TwoCheckout
    'online_payment_installationId'      => 'Installation Id', // Field for WorldPay
    'online_payment_callbackPassword'    => 'Callback Password', // Field for WorldPay

    // Status / Error Messages
    'online_payment_payment_cancelled'   => 'Payment cancelled.',
    'online_payment_payment_failed'      => 'Payment failed. Please try again.',
    'online_payment_payment_successful'  => 'Payment successful!',
    'online_payment_payment_redirect'    => 'Please wait while we redirect you to the payment page...',
    'online_payment_3dauth_redirect'     => 'Please wait while we redirect you to your card issuer for authentication...'
);