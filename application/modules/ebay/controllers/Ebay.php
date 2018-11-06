<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * 
 *
 * @author		Thiago Araujo
 */

/**
 * Class Dashboard
 */
class Ebay extends Admin_Controller {

    private function ebay_credentials($sandbox) {
        if ($sandbox == 'production') {
            $sandbox = false;
        }
        if ($sandbox == 'sandbox') {
            $sandbox = true;
        }
        $settings = $this->db->get("ip_settings")->result_object();
        foreach ($settings as $settings) {
            if ($settings->setting_key == "ebay_production_token") {
                $production_token = $settings->setting_value;
            }
            if ($settings->setting_key == "ebay_cert_id") {
                $ebay_cert_id = $settings->setting_value;
            }
            if ($settings->setting_key == "ebay_dev_id") {
                $ebay_dev_id = $settings->setting_value;
            }
            if ($settings->setting_key == "ebay_app_id") {
                $ebay_app_id = $settings->setting_value;
            }
        }
        $compat_level = 1055;
        $credentials = array(
            "compat_level" => $compat_level,
            "api_endpoint" => $sandbox ? 'https://api.sandbox.ebay.com/ws/api.dll' : 'https://api.ebay.com/ws/api.dll',
            "dev_id" => $sandbox ? "" : $ebay_dev_id,
            "app_id" => $sandbox ? "" : $ebay_app_id,
            "cert_id" => $sandbox ? "" : $ebay_cert_id,
            "auth_token" => $sandbox ? "" : $production_token
        );
print_r($credentials);
die();
        return $credentials;
    }

    public function get_ebay_suggested() {
        $credentials = $this->ebay_credentials('production');
        $call_name = 'GetSuggestedCategories';

        // Create headers to send with CURL request.
        $headers = array
            (
            'Content-Type: text/xml',
            'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $credentials['compat_level'],
            'X-EBAY-API-DEV-NAME: ' . $credentials['dev_id'],
            'X-EBAY-API-APP-NAME: ' . $credentials['app_id'],
            'X-EBAY-API-CERT-NAME: ' . $credentials['cert_id'],
            'X-EBAY-API-SITEID: ' . 0,
            'X-EBAY-API-CALL-NAME: ' . $call_name
        );

        // Generate XML request
        $xml_request = '<?xml version="1.0" encoding="utf-8"?>
<' . $call_name . 'Request xmlns="urn:ebay:apis:eBLBaseComponents">
  <RequesterCredentials>
    <eBayAuthToken>' . $credentials['auth_token'] . '</eBayAuthToken>
  </RequesterCredentials>
  <Query>tshirt</Query>
</GetSuggestedCategoriesRequest>';


// Send request to eBay and load response in $response
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $credentials['api_endpoint']);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($connection, CURLOPT_POST, 1);
        curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($connection);
        curl_close($connection);

        $dom = new DOMDocument();
        $dom->loadXML($response); // Parse data accordingly.
        $size = $dom->getElementsByTagName('Category')->length;
        $size -= 1;
        while ($size >= 0) {
            $category_id = $dom->getElementsByTagName('Category')->length ? $dom->getElementsByTagName('CategoryID')->item($size)->nodeValue : '';
            $category_suggested = $dom->getElementsByTagName('Category')->length ? $dom->getElementsByTagName('CategoryName')->item($size)->nodeValue : '';
            $category_parent_id = $dom->getElementsByTagName('Category')->length ? $dom->getElementsByTagName('CategoryParentID')->item($size)->nodeValue : '';
            $category_parent_name = $dom->getElementsByTagName('Category')->length ? $dom->getElementsByTagName('CategoryParentName')->item($size)->nodeValue : '';

            $EbaySuggestion[] = array(
                "category_id" => $category_id,
                "category_name" => $category_suggested,
                "category_parent_id" => $category_parent_id,
                "category_parent_name" => $category_parent_name
            );
            $size--;
        }
        return $EbaySuggestion;
    }

    function index() {
        $suggested_categories = $this->get_ebay_suggested();
        print_r($suggested_categories);
    }

}
