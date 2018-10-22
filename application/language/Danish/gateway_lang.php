<?php
/**
 * Contains the language translations for the payment gateways
 */
$lang = array(
    // General strings
    'online_payment'                     => 'Online betaling',
    'online_payments'                    => 'Online betalinger',
    'online_payment_for'                 => 'Online betaling for',
    'online_payment_for_invoice'         => 'Online Payment for Invoice',
    'online_payment_method'              => 'Online betalingsmetode',
    'online_payment_creditcard_hint'     => 'Hvis du ønsker at betale via kreditkort, indtast venligst oplysninger nedenfor. <br/> Kreditkortoplysningerne gemmes ikke på vores servere og vil blive overført til online-betalingsgateway ved hjælp af en sikker forbindelse.',
    'enable_online_payments'             => 'Aktiver online-betalinger',
    'payment_provider'                   => 'Betalingsudbyder',
    'add_payment_provider'               => 'Tilføje en betalingsudbyder',
    'transaction_reference'              => 'Reference til',
    'payment_description'                => 'Payment for Invoice %s',

    // Credit card strings
    'creditcard_cvv'                     => 'CVV / CSC',
    'creditcard_details'                 => 'Kreditkortoplysninger',
    'creditcard_expiry_month'            => 'Udløbsmåned',
    'creditcard_expiry_year'             => 'Udløbsår',
    'creditcard_number'                  => 'Kreditkortnummer',
    'online_payment_card_invalid'        => 'Dette kreditkort er ugyldig. Tjek venligst de angivne oplysninger.',

    // Payment Gateway Fields
    'online_payment_apiLoginId'          => 'API Login-Id', // Field for AuthorizeNet_AIM
    'online_payment_transactionKey'      => 'Transaktionsnøgle', // Field for AuthorizeNet_AIM
    'online_payment_testMode'            => 'Test Mode', // Field for AuthorizeNet_AIM
    'online_payment_developerMode'       => 'Udviklertilstand', // Field for AuthorizeNet_AIM
    'online_payment_websiteKey'          => 'Hjemmeside nøgle', // Field for Buckaroo_Ideal
    'online_payment_secretKey'           => 'Hemmelige nøgle', // Field for Buckaroo_Ideal
    'online_payment_merchantId'          => 'Sælger-ID', // Field for CardSave
    'online_payment_password'            => 'Adgangskode', // Field for CardSave
    'online_payment_apiKey'              => 'API-nøgle', // Field for Coinbase
    'online_payment_secret'              => 'Hemmeligt', // Field for Coinbase
    'online_payment_accountId'           => 'Konto ID', // Field for Coinbase
    'online_payment_storeId'             => 'Butiks-id', // Field for FirstData_Connect
    'online_payment_sharedSecret'        => 'Delt hemmelighed', // Field for FirstData_Connect
    'online_payment_appId'               => 'App Id', // Field for GoCardless
    'online_payment_appSecret'           => 'App hemmelighed', // Field for GoCardless
    'online_payment_accessToken'         => 'Adgangs token', // Field for GoCardless
    'online_payment_merchantAccessCode'  => 'Merkant Adgangs Kode', // Field for Migs_ThreeParty
    'online_payment_secureHash'          => 'Sikker Hash', // Field for Migs_ThreeParty
    'online_payment_siteId'              => 'Websted-Id', // Field for MultiSafepay
    'online_payment_siteCode'            => 'Side kode', // Field for MultiSafepay
    'online_payment_accountNumber'       => 'Kontonummer', // Field for NetBanx
    'online_payment_storePassword'       => 'Butik adgangskode', // Field for NetBanx
    'online_payment_merchantKey'         => 'Merchant Key', // Field for PayFast
    'online_payment_pdtKey'              => 'PDT nøgle', // Field for PayFast
    'online_payment_username'            => 'Brugernavn', // Field for Payflow_Pro
    'online_payment_vendor'              => 'Kreditor', // Field for Payflow_Pro
    'online_payment_partner'             => 'Partner', // Field for Payflow_Pro
    'online_payment_pxPostUsername'      => 'PX Post Username', // Field for PaymentExpress_PxPay
    'online_payment_pxPostPassword'      => 'PX Post Password', // Field for PaymentExpress_PxPay
    'online_payment_signature'           => 'Underskrift', // Field for PayPal_Express
    'online_payment_referrerId'          => 'Referrer-Id', // Field for SagePay_Direct
    'online_payment_transactionPassword' => 'Transaktion adgangskode', // Field for SecurePay_DirectPost
    'online_payment_subAccountId'        => 'Sub-konto-Id', // Field for TargetPay_Directebanking
    'online_payment_secretWord'          => 'Hemmelige ord', // Field for TwoCheckout
    'online_payment_installationId'      => 'Installations-id\'et', // Field for WorldPay
    'online_payment_callbackPassword'    => 'Tilbagekald adgangskode', // Field for WorldPay

    // Status / Error Messages
    'online_payment_payment_cancelled'   => 'Betalingen annulleret.',
    'online_payment_payment_failed'      => 'Betaling mislykkedes. Prøv venligst igen.',
    'online_payment_payment_successful'  => 'Payment for Invoice %s successful!',
    'online_payment_payment_redirect'    => 'Vent venligst mens vi omdirigere dig til en betalingsside...',
    'online_payment_3dauth_redirect'     => 'Vent venligst mens vi omdirigerer dig til din kortudsteder for godkendelse...'
);