<?php
/**
 * Contains the language translations for the payment gateways
 */
$lang = array(
    // General strings
    'online_payment'                     => 'Ηλεκτρονική Πληρωμή',
    'online_payments'                    => 'Ηλεκτρονικές Πληρωμές',
    'online_payment_for'                 => 'Ηλεκτρονική Πληρωμή για',
    'online_payment_method'              => 'Μέθοδος Ηλεκτρονικής Πληρωμής',
    'online_payment_creditcard_hint'     => 'If you want to pay via credit card please enter the information below.<br/>The credit card information are not stored on our servers and will be transferred to the online payment gateway using a secure connection.',
    'enable_online_payments'             => 'Enable Online Payments',
    'add_payment_provider'               => 'Add a Payment Provider',

    // Credit card strings
    'creditcard_cvv'                     => 'AEK / KAK',
    'creditcard_details'                 => 'Credit Card details',
    'creditcard_expiry_month'            => 'Expiry Month',
    'creditcard_expiry_year'             => 'Expiry Year',
    'creditcard_number'                  => 'Credit Card Number',
    'online_payment_card_invalid'        => 'This credit card is invalid. Please check the provided information.',

    // Payment Gateway Fields
    'online_payment_apiLoginId'          => 'Api Login Id', // Field for AuthorizeNet_AIM
    'online_payment_transactionKey'      => 'Transaction Key', // Field for AuthorizeNet_AIM
    'online_payment_testMode'            => 'Δοκιμαστική Λειτουργία', // Field for AuthorizeNet_AIM
    'online_payment_developerMode'       => 'Λειτουργία Προγραμματιστή', // Field for AuthorizeNet_AIM
    'online_payment_websiteKey'          => 'Κλειδί Ιστοσελίδας', // Field for Buckaroo_Ideal
    'online_payment_secretKey'           => 'Μυστικό Κλειδί', // Field for Buckaroo_Ideal
    'online_payment_merchantId'          => 'Αναγνωριστικό Εμπόρου', // Field for CardSave
    'online_payment_password'            => 'Συνθηματικό', // Field for CardSave
    'online_payment_apiKey'              => 'Κλειδί API', // Field for Coinbase
    'online_payment_secret'              => 'Μυστικό', // Field for Coinbase
    'online_payment_accountId'           => 'Αναγνωριστικό λογαριασμού', // Field for Coinbase
    'online_payment_storeId'             => 'Αναγνωριστικό καταστήματος', // Field for FirstData_Connect
    'online_payment_sharedSecret'        => 'Shared Secret', // Field for FirstData_Connect
    'online_payment_appId'               => 'Αναγνωριστικό εφαρμογής', // Field for GoCardless
    'online_payment_appSecret'           => 'Μυστικό Εφαρμογής', // Field for GoCardless
    'online_payment_accessToken'         => 'Διακριτικό Πρόσβασης', // Field for GoCardless
    'online_payment_merchantAccessCode'  => 'Merchant Access Code', // Field for Migs_ThreeParty
    'online_payment_secureHash'          => 'Secure Hash', // Field for Migs_ThreeParty
    'online_payment_siteId'              => 'Αναγνωριστικό ιστοσελίδας', // Field for MultiSafepay
    'online_payment_siteCode'            => 'Κωδικός ιστοσελίδας', // Field for MultiSafepay
    'online_payment_accountNumber'       => 'Αριθμός Λογαριασμού', // Field for NetBanx
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