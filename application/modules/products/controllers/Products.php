<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2017 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Products
 */
class Products extends Admin_Controller
{

    /**
     * Products constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_products');
    }

    public function generate_gtin()
    {

        $products = $this->db->get("ip_products")->result_object();
        foreach ($products as $products) {
            $this->db->where("product_id", $products->product_id);
            $this->db->set("product_gtin", '0883096001447');
            $this->db->set("product_sku", '883096001447');
            $this->db->set("product_model", '177343');
            $this->db->set("product_mpn", 'FLGFAPP1000019288');
            $this->db->update("ip_products");
            echo $products->product_name . "<br>";
        }
    }

    public function add_category()
    {
        $category_name = $this->input->post("category_name");
        $category_parent = $this->input->post("category_parent");
        $category_meta = str_replace(" ", "-", $category_name);
        $category = array(
            "category_name" => $category_name,
            "category_parent" => $category_parent,
            "category_meta" => $category_meta
        );

        $this->db->insert("ip_categories", $category);
    }

    public function ReviseEbayItem()
    {
        require(APPPATH . 'third_party/keys.php');
        require(APPPATH . 'third_party/eBaySession.php');

        $product_id = $this->input->post("product_id");

        $this->db->where("product_id", $product_id);
        $product_data = $this->db->get("ip_products")->row();


        $img_name = array();


        $img_name[] = $product_data->product_image;
        if ($product_data->product_image2 != null) {
            $img_name[] = $product_data->product_image2;
        }
        if ($product_data->product_image3 != null) {
            $img_name[] = $product_data->product_image3;
        }
        if ($product_data->product_image4 != null) {
            $img_name[] = $product_data->product_image4;
        }
        //check
        ini_set('magic_quotes_gpc', false);    // magic quotes will only confuse things like escaping apostrophe
        //Get the item entered
        $listingType = "FixedPriceItem";
        $primaryCategory = $product_data->ebay_category_id;
        $itemTitle = $product_data->ebay_title;
        $startPrice = $product_data->ebay_price;
        $shippingservice = "USPSPriority";
        //$buyItNowPrice   = $_POST['buyItNowPrice'];
        $listingDuration = "GTC";
        $freeshipping = $product_data->product_free_shipping;
        if ($freeshipping == "" || $freeshipping == null) {
            $freeshipping = "false";
        }
        //$safequery = $_POST['searched_keyword'];

        if (get_magic_quotes_gpc()) {
            // print "stripslashes!!! <br>\n";
            $itemDescription = stripslashes($product_data->ebay_description);
        } else {
            $itemDescription = $product_data->ebay_description;
        }
        $itemDescription = $product_data->ebay_description;
        $itemCondition = $product_data->product_condition;
        $condition_description = $product_data->product_condition_description;
        $ebay_id = $product_data->ebay_id;
        $upc = $product_data->sku;
        $brand = $product_data->provider_name;
        $mpn = $product_data->product_mpn;
        $size_mens = "Large";
        $style = "Basic Tee";
        $size_type = "Regular";
        $sleeve_style = "Short Sleeve";
        $siteID = 0;
        $color = $product_data->product_color;
        $sizes = $product_data->product_size;
        //the call being made:
        $verb = 'ReviseItem';
        $paypalEmailAddress = 'tcesarusa@gmail.com';
        /* if ($listingType == 'FixedPriceItem') {
          $buyItNowPrice = 0.0;   // don't have BuyItNow for FixedPriceItem
          } */
        $returnWithin = "Days_30";
        $returnsAccepted = "ReturnsAccepted";
        $quantity = $product_data->product_quantity;
//        $quantity = 1;

        ///Build the request Xml string






        $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
        $requestXmlBody .= '<ReviseItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
        $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
        $requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
        $requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
        $requestXmlBody .= "<Version>$compatabilityLevel</Version>";
        $requestXmlBody .= '<Item>';
        $requestXmlBody .= "<ItemID>$ebay_id</ItemID>";
        $requestXmlBody .= "<ItemSpecifics>";
        $requestXmlBody .= "<NameValueList>
        <Name>Brand</Name>
        <Value>$brand</Value>
      </NameValueList>
      <NameValueList>
        <Name>Style</Name>
        <Value>$style</Value>
      </NameValueList>
      <NameValueList>
        <Name>Size Type</Name>
        <Value>$size_type</Value>
      </NameValueList>
      <NameValueList>
        <Name>Sleeve Style</Name>
        <Value>$sleeve_style</Value>
      </NameValueList>
      <NameValueList>
        <Name>Color</Name>
        <Value>$color</Value>
      </NameValueList>
      <NameValueList>
        <Name>Size</Name>
        <Value>$sizes</Value>
      </NameValueList>";
        $requestXmlBody .= "</ItemSpecifics>";
        $requestXmlBody .= "<ProductListingDetails>";
        $requestXmlBody .= "<UPC>Does not apply</UPC>";
        $requestXmlBody .= "</ProductListingDetails>";
        $requestXmlBody .= '<ConditionID>' . $itemCondition . '</ConditionID>';
        $requestXmlBody .= '<Site>eBayMotors</Site>';
        $requestXmlBody .= '<PrimaryCategory>';
        $requestXmlBody .= "<CategoryID>$primaryCategory</CategoryID>";
        $requestXmlBody .= '</PrimaryCategory>';
        $requestXmlBody .= '<PictureDetails>';
        //$requestXmlBody .= '<GalleryURL>http://www.choprafoundation.org/wp-content/uploads/2013/12/03-relaxation.jpg</GalleryURL>';
        foreach ($img_name as $img_name) {
            //$requestXmlBody .= '<PictureURL>http://www.choprafoundation.org/wp-content/uploads/2013/12/03-relaxation.jpg</PictureURL>';
            $requestXmlBody .= '<PictureURL>';
            $requestXmlBody .= $img_name;
            $requestXmlBody .= '</PictureURL>';
        }

        $requestXmlBody .= '</PictureDetails>';
        $requestXmlBody .= '<Country>US</Country>';
        $requestXmlBody .= '<Currency>USD</Currency>';
        $requestXmlBody .= '<DispatchTimeMax>1</DispatchTimeMax>';
        $requestXmlBody .= "<ListingDuration>$listingDuration</ListingDuration>";
        $requestXmlBody .= '<ListingType>' . $listingType . '</ListingType>';
        $requestXmlBody .= '<Location><![CDATA[Bakersfield,93306 CA]]></Location>';
        $requestXmlBody .= '<PaymentMethods>PayPal</PaymentMethods>';
        $requestXmlBody .= "<PayPalEmailAddress>$paypalEmailAddress</PayPalEmailAddress>";
        $requestXmlBody .= "<Quantity>$quantity</Quantity>";
        $requestXmlBody .= "<StartPrice>$startPrice</StartPrice>";
        $requestXmlBody .= '<ShippingTermsInDescription>True</ShippingTermsInDescription>';
        $requestXmlBody .= "<Title><![CDATA[$itemTitle]]></Title>";
        $requestXmlBody .= "<Description><![CDATA[$itemDescription]]></Description>";
        $requestXmlBody .= "<DescriptionReviseMode>Replace</DescriptionReviseMode>";
        $requestXmlBody .= '<ReturnPolicy>';
        $requestXmlBody .= '<ReturnsAcceptedOption>' . $returnsAccepted . '</ReturnsAcceptedOption>';
        $requestXmlBody .= '<ReturnsWithinOption>' . $returnWithin . '</ReturnsWithinOption>';
        $requestXmlBody .= '</ReturnPolicy>';
        $requestXmlBody .= '<ShippingPackageDetails>
          <MeasurementUnit>English</MeasurementUnit>
          <PackageDepth>9</PackageDepth>
          <PackageLength>1</PackageLength>
          <PackageWidth>8</PackageWidth>
          <ShippingIrregular>true</ShippingIrregular>
          <WeightMajor>0</WeightMajor>
          <WeightMinor>1</WeightMinor>
        </ShippingPackageDetails>';
        $requestXmlBody .= '<ShippingDetails>';
        $requestXmlBody .= '<ShippingType>Flat</ShippingType>';
        $requestXmlBody .= '<ShippingServiceOptions>';
        $requestXmlBody .= '<FreeShipping>' . $freeshipping . '</FreeShipping>';
        $requestXmlBody .= '<ShippingServiceAdditionalCost currencyID="USD">0</ShippingServiceAdditionalCost>';
        if($freeshipping == "false"){
        $requestXmlBody .= '<ShippingServiceCost currencyID="USD">3.00</ShippingServiceCost>';
        }else{
            $requestXmlBody .= '<ShippingServiceCost currencyID="USD">0</ShippingServiceCost>';
        }
        $requestXmlBody .= '<ShippingServicePriority>1</ShippingServicePriority>';
        $requestXmlBody .= '<ShippingService>' . $shippingservice . '</ShippingService>';
        $requestXmlBody .= '</ShippingServiceOptions>';
        $requestXmlBody .= '</ShippingDetails>';
        $requestXmlBody .= '</Item>';
        $requestXmlBody .= '</ReviseItemRequest>';

        //Create a new eBay session with all details pulled in from included keys.php
        $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

        //send the request and get response
        $responseXml = $session->sendHttpRequest($requestXmlBody);
        if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
            die('<P>Error sending request');

        //Xml string is parsed and creates a DOM Document object
        $responseDoc = new DomDocument();
        $responseDoc->loadXML($responseXml);
        //get any error nodes
        $errors = $responseDoc->getElementsByTagName('Errors');

        //if there are error nodes
        if ($errors->length > 0) {
            $responses = $responseDoc->getElementsByTagName("AddItemResponse");
            $itemID = "";
            foreach ($responses as $response) {
                $acks = $response->getElementsByTagName("Ack");
                $ack = $acks->item(0)->nodeValue;
                echo "Ack = $ack <BR />\n";   // Success if successful
                if ($ack == "Success") {
                    $endTimes = $response->getElementsByTagName("EndTime");
                    $endTime = $endTimes->item(0)->nodeValue;
                    echo "endTime = $endTime <BR />\n";

                    $itemIDs = $response->getElementsByTagName("ItemID");
                    $itemID = @$itemIDs->item(0)->nodeValue;
                    echo "itemID = $itemID <BR />\n";

                    $linkBase = "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";
                    echo "<a href=$linkBase" . $itemID . ">$itemTitle</a> <BR />";

                    $feeNodes = $responseDoc->getElementsByTagName('Fee');
                    foreach ($feeNodes as $feeNode) {
                        $feeNames = $feeNode->getElementsByTagName("Name");
                        if ($feeNames->item(0)) {
                            $feeName = $feeNames->item(0)->nodeValue;
                            $fees = $feeNode->getElementsByTagName('Fee');  // get Fee amount nested in Fee
                            $fee = $fees->item(0)->nodeValue;
                            if ($fee > 0.0) {
                                if ($feeName == 'ListingFee') {
                                    printf("<B>$feeName : %.2f </B><BR>\n", $fee);
                                } else {
                                    printf("$feeName : %.2f <BR>\n", $fee);
                                }
                            }  // if $fee > 0
                        } // if feeName
                    } // foreach $feeNode
                } else {
                    print_r($response);
                    $itemIDs = $response->getElementsByTagName("ItemID");
                    $itemID = @$itemIDs->item(0)->nodeValue;
                }
            }
            //echo 'item updated';
            echo '<P><B>eBay returned the following error(s):</B>';
            //display each error
            //Get error code, ShortMesaage and LongMessage
            $code = $errors->item(0)->getElementsByTagName('ErrorCode');
            $shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
            $longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
            //Display code and shortmessage
            echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
            //if there is a long message (ie ErrorLevel=1), display it
            if (count($longMsg) > 0)
                echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
        } else { //no errors
            //get results nodes
            $responses = $responseDoc->getElementsByTagName("AddItemResponse");
            $itemID = "";
            foreach ($responses as $response) {
                $acks = $response->getElementsByTagName("Ack");
                $ack = $acks->item(0)->nodeValue;
                echo "Ack = $ack <BR />\n";   // Success if successful

                $endTimes = $response->getElementsByTagName("EndTime");
                $endTime = $endTimes->item(0)->nodeValue;
                echo "endTime = $endTime <BR />\n";

                $itemIDs = $response->getElementsByTagName("ItemID");
                $itemID = $itemIDs->item(0)->nodeValue;
                echo "itemID = $itemID <BR />\n";

                $linkBase = "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";
                echo "<a href=$linkBase" . $itemID . ">$itemTitle</a> <BR />";

                $feeNodes = $responseDoc->getElementsByTagName('Fee');
                foreach ($feeNodes as $feeNode) {
                    $feeNames = $feeNode->getElementsByTagName("Name");
                    if ($feeNames->item(0)) {
                        $feeName = $feeNames->item(0)->nodeValue;
                        $fees = $feeNode->getElementsByTagName('Fee');  // get Fee amount nested in Fee
                        $fee = $fees->item(0)->nodeValue;
                        if ($fee > 0.0) {
                            if ($feeName == 'ListingFee') {
                                printf("<B>$feeName : %.2f </B><BR>\n", $fee);
                            } else {
                                printf("$feeName : %.2f <BR>\n", $fee);
                            }
                        }  // if $fee > 0
                    } // if feeName
                } // foreach $feeNode
            } // foreach response
            //Insert into Database
            $xml = simplexml_load_string($responseXml);
            echo "Item revised to ebay with success.";
        } // if $errors->length > 0
    }

    public function AddEbayItem()
    {
        require(APPPATH . 'third_party/keys.php');
        require(APPPATH . 'third_party/eBaySession.php');
        $product_id = $this->input->post("product_id");
        $this->db->where("product_id", $product_id);
        $product_data = $this->db->get("ip_products")->row();


        $img_name = array();


        $img_name[] = $product_data->product_image;
        if ($product_data->product_image2 != null) {
            $img_name[] = $product_data->product_image2;
        }
        if ($product_data->product_image3 != null) {
            $img_name[] = $product_data->product_image3;
        }
        if ($product_data->product_image4 != null) {
            $img_name[] = $product_data->product_image4;
        }

        //check
        ini_set('magic_quotes_gpc', false);    // magic quotes will only confuse things like escaping apostrophe
        //Get the item entered
        $listingType = "FixedPriceItem";
        $primaryCategory = $product_data->ebay_category_id;
        $itemTitle = $product_data->ebay_title;
        $startPrice = $product_data->ebay_price;
        $shippingservice = "USPSPriority";
        //$buyItNowPrice   = $_POST['buyItNowPrice'];
        $listingDuration = "GTC";
        $freeshipping = $product_data->product_free_shipping;
        if ($freeshipping == "" || $freeshipping == null) {
            $freeshipping = "false";
        }
        //$safequery = $_POST['searched_keyword'];

        if (get_magic_quotes_gpc()) {
            // print "stripslashes!!! <br>\n";
            $itemDescription = stripslashes($product_data->ebay_description);
        } else {
            $itemDescription = $product_data->ebay_description;
        }
        $itemDescription = $product_data->ebay_description;
        $itemCondition = $product_data->product_condition;
        $brand = $product_data->provider_name;
        $mpn = $product_data->product_mpn;
        $size_mens = "Large";
        $style = "Basic Tee";
        $size_type = "Regular";
        $sleeve_style = "Short Sleeve";
        $siteID = 0;
        $color = $product_data->product_color;
        $sizes = $product_data->product_size;
        //the call being made:
        $verb = 'AddItem';
        $paypalEmailAddress = 'tcesarusa@gmail.com';

        /* if ($listingType == 'FixedPriceItem') {
          $buyItNowPrice = 0.0;   // don't have BuyItNow for FixedPriceItem
          } */
        $returnWithin = "Days_30";
        $returnsAccepted = "ReturnsAccepted";
        //$quantity = $product_data->product_quantity;
        $quantity = 1;

        ///Build the request Xml string
        $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
        $requestXmlBody .= '<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
        $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
        $requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
        $requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
        $requestXmlBody .= "<Version>$compatabilityLevel</Version>";
        $requestXmlBody .= '<Item>';
        $requestXmlBody .= "<ItemSpecifics>";
        $requestXmlBody .= "<NameValueList>
        <Name>Brand</Name>
        <Value>$brand</Value>
      </NameValueList>
      <NameValueList>
        <Name>Style</Name>
        <Value>$style</Value>
      </NameValueList>
      <NameValueList>
        <Name>Size Type</Name>
        <Value>$size_type</Value>
      </NameValueList>
      <NameValueList>
        <Name>Sleeve Style</Name>
        <Value>$sleeve_style</Value>
      </NameValueList>
      <NameValueList>
        <Name>Color</Name>
        <Value>$color</Value>
      </NameValueList>
      <NameValueList>
        <Name>Size</Name>
        <Value>$sizes</Value>
      </NameValueList>";
        $requestXmlBody .= "</ItemSpecifics>";
        $requestXmlBody .= "<ProductListingDetails>";
        $requestXmlBody .= "<BrandMPN> BrandMPNType
          <Brand> $brand </Brand>
          <MPN> $mpn </MPN>
        </BrandMPN>";
        $requestXmlBody .= "<UPC>Does not apply</UPC>";
        $requestXmlBody .= "</ProductListingDetails>";
        $requestXmlBody .= '<ConditionID>' . $itemCondition . '</ConditionID>';
        $requestXmlBody .= '<Site>eBayMotors</Site>';
        $requestXmlBody .= '<PrimaryCategory>';
        $requestXmlBody .= "<CategoryID>$primaryCategory</CategoryID>";
        $requestXmlBody .= '</PrimaryCategory>';
        $requestXmlBody .= '<PictureDetails>';
        //$requestXmlBody .= '<GalleryURL>http://www.choprafoundation.org/wp-content/uploads/2013/12/03-relaxation.jpg</GalleryURL>';
        foreach ($img_name as $img_name) {
            //$requestXmlBody .= '<PictureURL>http://www.choprafoundation.org/wp-content/uploads/2013/12/03-relaxation.jpg</PictureURL>';
            $requestXmlBody .= '<PictureURL>';
            $requestXmlBody .= $img_name;
            $requestXmlBody .= '</PictureURL>';
        }

        $requestXmlBody .= '</PictureDetails>';
        $requestXmlBody .= '<Country>US</Country>';
        $requestXmlBody .= '<Currency>USD</Currency>';
        $requestXmlBody .= '<DispatchTimeMax>1</DispatchTimeMax>';
        $requestXmlBody .= "<ListingDuration>$listingDuration</ListingDuration>";
        $requestXmlBody .= '<ListingType>' . $listingType . '</ListingType>';
        $requestXmlBody .= '<Location><![CDATA[Bakersfield,93306 CA]]></Location>';
        $requestXmlBody .= '<PaymentMethods>PayPal</PaymentMethods>';
        $requestXmlBody .= "<PayPalEmailAddress>$paypalEmailAddress</PayPalEmailAddress>";
        $requestXmlBody .= "<Quantity>$quantity</Quantity>";
        $requestXmlBody .= "<StartPrice>$startPrice</StartPrice>";
        $requestXmlBody .= '<ShippingTermsInDescription>True</ShippingTermsInDescription>';
        $requestXmlBody .= "<Title><![CDATA[$itemTitle]]></Title>";
        $requestXmlBody .= "<Description><![CDATA[$itemDescription]]></Description>";
        $requestXmlBody .= '<ReturnPolicy>';
        $requestXmlBody .= '<ReturnsAcceptedOption>' . $returnsAccepted . '</ReturnsAcceptedOption>';
        $requestXmlBody .= '<ReturnsWithinOption>' . $returnWithin . '</ReturnsWithinOption>';
        $requestXmlBody .= '</ReturnPolicy>';
        $requestXmlBody .= '<ShippingPackageDetails>
          <MeasurementUnit>English</MeasurementUnit>
          <PackageDepth>9</PackageDepth>
          <PackageLength>1</PackageLength>
          <PackageWidth>8</PackageWidth>
          <ShippingIrregular>true</ShippingIrregular>
          <WeightMajor>0</WeightMajor>
          <WeightMinor>1</WeightMinor>
        </ShippingPackageDetails>';
        $requestXmlBody .= '<ShippingDetails>';
        $requestXmlBody .= '<ShippingType>Flat</ShippingType>';
        $requestXmlBody .= '<ShippingServiceOptions>';
        $requestXmlBody .= '<FreeShipping>' . $freeshipping . '</FreeShipping>';
        $requestXmlBody .= '<ShippingServiceAdditionalCost currencyID="USD">0</ShippingServiceAdditionalCost>';
        if($freeshipping == "false"){
            $requestXmlBody .= '<ShippingServiceCost currencyID="USD">3.00</ShippingServiceCost>';
        }else{
            $requestXmlBody .= '<ShippingServiceCost currencyID="USD">0</ShippingServiceCost>';
        }
        $requestXmlBody .= '<ShippingServicePriority>1</ShippingServicePriority>';

        $requestXmlBody .= '<ShippingService>' . $shippingservice . '</ShippingService>';
        $requestXmlBody .= '</ShippingServiceOptions>';
        $requestXmlBody .= '</ShippingDetails>';
        $requestXmlBody .= '</Item>';
        $requestXmlBody .= '</AddItemRequest>';

        //echo $requestXmlBody;
        //Create a new eBay session with all details pulled in from included keys.php
        $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

        //send the request and get response
        $responseXml = $session->sendHttpRequest($requestXmlBody);
        if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
            die('<P>Error sending request');

        //Xml string is parsed and creates a DOM Document object
        $responseDoc = new DomDocument();
        $responseDoc->loadXML($responseXml);
        //get any error nodes
        $errors = $responseDoc->getElementsByTagName('Errors');

        //if there are error nodes
        if ($errors->length > 0) {
            $responses = $responseDoc->getElementsByTagName("AddItemResponse");
            $itemID = "";
            foreach ($responses as $response) {
                $acks = $response->getElementsByTagName("Ack");
                $ack = $acks->item(0)->nodeValue;
                echo "Ack = $ack <BR />\n";   // Success if successful
                if ($ack == "Success") {
                    $endTimes = $response->getElementsByTagName("EndTime");
                    $endTime = $endTimes->item(0)->nodeValue;
                    echo "endTime = $endTime <BR />\n";

                    $itemIDs = $response->getElementsByTagName("ItemID");
                    $itemID = @$itemIDs->item(0)->nodeValue;
                    echo "itemID = $itemID <BR />\n";

                    $linkBase = "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";
                    echo "<a href=$linkBase" . $itemID . ">$itemTitle</a> <BR />";

                    $feeNodes = $responseDoc->getElementsByTagName('Fee');
                    foreach ($feeNodes as $feeNode) {
                        $feeNames = $feeNode->getElementsByTagName("Name");
                        if ($feeNames->item(0)) {
                            $feeName = $feeNames->item(0)->nodeValue;
                            $fees = $feeNode->getElementsByTagName('Fee');  // get Fee amount nested in Fee
                            $fee = $fees->item(0)->nodeValue;
                            if ($fee > 0.0) {
                                if ($feeName == 'ListingFee') {
                                    printf("<B>$feeName : %.2f </B><BR>\n", $fee);
                                } else {
                                    printf("$feeName : %.2f <BR>\n", $fee);
                                }
                            }  // if $fee > 0
                        } // if feeName
                    } // foreach $feeNode
                } else {
                    print_r($response);
                    $itemIDs = $response->getElementsByTagName("ItemID");
                    $itemID = @$itemIDs->item(0)->nodeValue;
                }
            }
            //echo 'item updated';
            echo '<P><B>eBay returned the following error(s):</B>';
            //display each error
            //Get error code, ShortMesaage and LongMessage
            $code = $errors->item(0)->getElementsByTagName('ErrorCode');
            $shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
            $longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
            //Display code and shortmessage
            echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
            //if there is a long message (ie ErrorLevel=1), display it
            if (count($longMsg) > 0)
                echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
        } else { //no errors
            //get results nodes
            $responses = $responseDoc->getElementsByTagName("AddItemResponse");
            $itemID = "";
            foreach ($responses as $response) {
                $acks = $response->getElementsByTagName("Ack");
                $ack = $acks->item(0)->nodeValue;
                echo "Ack = $ack <BR />\n";   // Success if successful

                $endTimes = $response->getElementsByTagName("EndTime");
                $endTime = $endTimes->item(0)->nodeValue;
                echo "endTime = $endTime <BR />\n";

                $itemIDs = $response->getElementsByTagName("ItemID");
                $itemID = $itemIDs->item(0)->nodeValue;
                echo "itemID = $itemID <BR />\n";

                $linkBase = "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";
                echo "<a href=$linkBase" . $itemID . ">$itemTitle</a> <BR />";

                $feeNodes = $responseDoc->getElementsByTagName('Fee');
                foreach ($feeNodes as $feeNode) {
                    $feeNames = $feeNode->getElementsByTagName("Name");
                    if ($feeNames->item(0)) {
                        $feeName = $feeNames->item(0)->nodeValue;
                        $fees = $feeNode->getElementsByTagName('Fee');  // get Fee amount nested in Fee
                        $fee = $fees->item(0)->nodeValue;
                        if ($fee > 0.0) {
                            if ($feeName == 'ListingFee') {
                                printf("<B>$feeName : %.2f </B><BR>\n", $fee);
                            } else {
                                printf("$feeName : %.2f <BR>\n", $fee);
                            }
                        }  // if $fee > 0
                    } // if feeName
                } // foreach $feeNode
            } // foreach response
            //Insert into Database
            $xml = simplexml_load_string($responseXml);
        } // if $errors->length > 0
        $this->db->set("ebay_id", $itemID);
        $this->db->where("product_id", $product_id);
        $this->db->update("ip_products");
    }

    public function product_categories()
    {
        $categories = $this->db->get("ip_categories")->result_object();
        $products_tree = $this->db->get("ip_products")->result_object();
        foreach ($categories as $categories_totree) {

            $data_final[] = array(
                "id" => $categories_totree->category_id,
                "value" => $categories_totree->category_name,
                "parent_id" => $categories_totree->category_parent
            );
        }
        foreach ($products_tree as $products_tree) {
            $data_final[] = array(
                "id" => $products_tree->product_id,
                "value" => $products_tree->product_name,
                "parent_id" => $products_tree->pcategory_id
            );
        }
        $data = json_encode($data_final);
        $data = str_replace("][", ",", $data_final);
        $this->layout->set('categories', json_encode($data));
        $this->layout->set('categories_raw', $categories);
        $this->layout->buffer('content', 'products/product_categories');
        $this->layout->render();
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_products->paginate(site_url('products/index'), $page);
        $products = $this->mdl_products->result();

        $this->layout->set('products', $products);

        $this->layout->buffer('content', 'products/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        require(APPPATH . 'third_party/keys.php');
        require(APPPATH . 'third_party/eBaySession.php');
        $browse = '';
        $endpoint = 'http://open.api.ebay.com/Shopping';  // URL to call
        $responseEncoding = 'XML';   // Format of the response

        $siteID = 0; //0-US,77-DE
// Construct the FindItems call
        $apicall = "$endpoint?callname=GetCategoryInfo"
            . "&appid=$appID"
            . "&siteid=$siteID"
            . "&CategoryID=-1"
            . "&version=677"
            . "&IncludeSelector=ChildCategories";

// Load the call and capture the document returned by the GetCategoryInfo API
        $xml = simplexml_load_file($apicall);

        $errors = $xml->Errors;

//if there are error nodes
        if ($errors->count() > 0) {
            echo '<p><b>eBay returned the following error(s):</b></p>';
            //display each error
            //Get error code, ShortMesaage and LongMessage
            $code = $errors->ErrorCode;
            $shortMsg = $errors->ShortMessage;
            $longMsg = $errors->LongMessage;
            //Display code and shortmessage
            echo '<p>', $code, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg));
            //if there is a long message (ie ErrorLevel=1), display it
            if (count($longMsg) > 0)
                echo '<br>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg));
        } else { //no errors
            foreach ($xml->CategoryArray->Category as $cat) {
                if ($cat->CategoryLevel != 0):
                    $browse .= '<option value="' . $cat->CategoryID . '">' . $cat->CategoryName . '</option>';
                endif;
            }
        }
        if ($this->input->post('btn_cancel')) {

            redirect('products');
        }

        if ($this->mdl_products->run_validation()) {
            // Get the db array
            $db_array = $this->mdl_products->db_array();
            //UPLOAD THE PRODUCT IMAGE
            $config['upload_path'] = './uploads/products/images';
            $config['allowed_types'] = 'gif|jpg|png';
            //$config['max_size']             = 4000;
            //$config['max_width']            = 1600;
            //$config['max_height']           = 1400;
            $image = '';
            $this->load->library('upload', $config);
            $image_count = 0;

            $this->db->where("product_id", $id);
            $product_data = $this->db->get("ip_products")->result_object();

            while (@$_FILES['product_image']['tmp_name'][$image_count] != null) {
                // Undefined | Multiple Files | $_FILES Corruption Attack
                // If this request falls under any of them, treat it invalid.
                if (!isset($_FILES['product_image']['error'][$image_count]) ||
                    is_array($_FILES['product_image']['error'][$image_count])
                ) {
                    throw new RuntimeException('Invalid parameters.');
                }

                // Check $_FILES['upfile']['error'] value.
                switch ($_FILES['product_image']['error'][$image_count]) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new RuntimeException('No file sent.');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new RuntimeException('Exceeded filesize limit.');
                    default:
                        throw new RuntimeException('Unknown errors.');
                }

                // You should also check filesize here. 
//                if ($_FILES['product_image']['size'][$image_count] > 900000000) {
//                    throw new RuntimeException('Exceeded filesize limit.');
//                }

                // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
                // Check MIME Type by yourself.
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search(
                        $finfo->file($_FILES['product_image']['tmp_name'][$image_count]), array(
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                    ), true
                    )) {
                    throw new RuntimeException('Invalid file format.');
                }


                $sourcePath = $_FILES['product_image']['tmp_name'][$image_count]; // Storing source path of the file in a variable

                $image = random_string('alnum', 16) . "_" . str_replace(" ", "-", $_FILES['product_image']['name'][$image_count]);

                $targetPath = FCPATH . "uploads/products/images/" . $image; // Target path where file is to be stored
                move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file


                if ($image != '') {
                    if (@$product_data[0]->product_image == '') {
                        $db_array['product_image'] = base_url() . "uploads/products/images/" . $image;
                        @$product_data[0]->product_image = 1;
                    } else if (@$product_data[0]->product_image2 == '') {
                        $db_array['product_image2'] = base_url() . "uploads/products/images/" . $image;
                        @$product_data[0]->product_image2 = 1;
                    } else if (@$product_data[0]->product_image3 == '') {
                        $db_array['product_image3'] = base_url() . "uploads/products/images/" . $image;
                        $product_data[0]->product_image3 = 1;
                    } else if (@$product_data[0]->product_image4 == '') {
                        $db_array['product_image4'] = base_url() . "uploads/products/images/" . $image;
                        @$product_data[0]->product_image4 = 1;
                    }
                    /* else
                      {
                      if($product_data[0]->product_image2 == null)
                      {
                      $db_array['product_image2'] = base_url()."/uploads/products/images/".$image;
                      }else if($product_data[0]->product_image3 == null)
                      {
                      $db_array['product_image3'] = base_url()."/uploads/products/images/".$image;
                      }else if($product_data[0]->product_image4 == null)
                      {
                      $db_array['product_image4'] = base_url()."/uploads/products/images/".$image;
                      }
                      } */
                }


                $image_count++;
                if ($image_count == 4) {
                    break;
                }
            }

            //create meta tag for produts
            $db_array['product_meta'] = str_replace(" ", "-", $db_array['product_name']);
            //Product date
            $db_array['product_date'] = date("Y-m-d");
            $this->mdl_products->save($id, $db_array);

            $this->db->where("product_id", $id);
            @$thumb = $this->db->get("ip_products")->row()->product_image_thumb;

            if (!file_exists($thumb)) {
                $this->db->where("product_id", $id);
                $this->db->set("product_image_thumb", "");
                $this->db->update("ip_products");
                $this->generate_thumb($id);
            }

            $this->db->where($db_array);
            $product_info = $this->db->get("ip_products")->result_object();

            if ($id == null) {
                if ($product_info != null) {
                    $id = $product_info[0]->product_id;
                }
            }
            if ($image != '') {
                $this->generate_thumb($id);
            }
            redirect('products/form/' . $id);
        }

        if ($id and !$this->input->post('btn_submit')) {

            if (!$this->mdl_products->prep_form($id)) {
                show_404();
            }
        }

        $this->load->model('families/mdl_families');
        $this->load->model('units/mdl_units');
        $this->load->model('tax_rates/mdl_tax_rates');
        $categories = $this->db->get("ip_categories")->result_object();


        //GET COLORS
        $this->db->where("product_id", $id);
        $colors = $this->db->get("ip_colors")->result_object();

        //GET SIZES
        $this->db->where("product_id", $id);
        $sizes = $this->db->get("ip_sizes")->result_object();

        //GET COLOR_SIZES
        $this->db->join("ip_colors", "ip_colors.color_id = ip_color_sizes.color_id", 'left');
        $this->db->join("ip_sizes", "ip_sizes.size_id = ip_color_sizes.size_id", 'left');
        $this->db->where("ip_color_sizes.product_id", $id);
        $ip_color_sizes = $this->db->get("ip_color_sizes")->result_object();


        //GET PRODUCT QUANTITY
        $product_quantities = 0;
        foreach ($ip_color_sizes as $quantities) {
            $product_quantities += $quantities->color_size_quantity;
        }

        $this->layout->set(
            array(
                'families' => $this->mdl_families->get()->result(),
                'units' => $this->mdl_units->get()->result(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
                'categories' => $categories,
                'colors' => $colors,
                'sizes' => $sizes,
                'ip_color_sizes' => $ip_color_sizes,
                "product_quantities" => $product_quantities,
                "browse" => $browse
            )
        );

        $this->layout->buffer('content', 'products/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function generate_thumb($product_id = null)
    {
        $this->load->library('image_lib');
        if ($product_id != null) {
            $this->db->where("product_id", $product_id);
        }
        $products = $this->db->get("ip_products")->result_object();
        foreach ($products as $products) {
            if ($products->product_image != "") {
                $image_name = str_replace(base_url() . "uploads/products/images/", "", $products->product_image);

                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/products/images/' . $image_name;
                $config['create_thumb'] = TRUE;
                $config['new_image'] = "./uploads/products/images/thumbs/" . $image_name;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 260;
                $config['height'] = 260;

                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                    die();
                }
                $image_name = str_replace(".png", "_thumb.png", $image_name);
                $image_name = str_replace(".JPG", "_thumb.JPG", $image_name);
                $image_name = str_replace(".jpg", "_thumb.jpg", $image_name);
                $this->db->set("product_image_thumb", base_url() . '/uploads/products/images/thumbs/' . $image_name);
                $this->db->where("product_id", $products->product_id);
                $this->db->update("ip_products");
            }
        }
    }

    public function delete($id)
    {
        $this->mdl_products->delete($id);
        redirect('products');
    }

    /*function resizer($fileName, $maxWidth, $maxHeight, $fixedWidth, $fixedHeight, $oldDir, $newDir, $quality) {
        $file = $oldDir . '/' . $fileName;
        $fileDest = $newDir . '/' . $fileName;
        list($width, $height) = @getimagesize($file);
        if ($fixedWidth) {
            $newWidth = $fixedWidth;
            @$newHeight = ($newWidth / $width) * $height;
        } elseif ($fixedHeight) {
            $newHeight = $fixedHeight;
            $newWidth = ($newHeight / $height) * $width;
        } elseif ($width < $height) {   // image is portrait
            $newHeight = $maxHeight;
            $newWidth = ($newHeight / $height) * $width;
        } elseif ($width > $height) {   // image is landscape
            $newWidth = $maxWidth;
            $newHeight = ($newWidth / $width) * $height;
        } else {         // image is square
            $newWidth = $maxHeight;
            $newHeight = $maxHeight;
        }
        $extn = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        @$imageDest = imagecreatetruecolor($newWidth, $newHeight);
        // jpeg
        if ($extn == 'jpg' or $extn == 'jpeg') {
            $imageSrc = imagecreatefromjpeg($file);
            if (@imagecopyresampled($imageDest, $imageSrc, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height)) {
                imagejpeg($imageDest, $fileDest, $quality);
                imagedestroy($imageSrc);
                imagedestroy($imageDest);
                return true;
            }
            return false;
        }
        // png
        if ($extn == 'png') {
            imagealphablending($imageDest, false);
            imagesavealpha($imageDest, true);
            $imageSrc = imagecreatefrompng($file);
            if (imagecopyresampled($imageDest, $imageSrc, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height)) {
                imagepng($imageDest, $fileDest, ($quality / 10) - 1);
                imagedestroy($imageSrc);
                imagedestroy($imageDest);
                return true;
            }
            return false;
        }
    }*/
    function getCategoriesInfo()
    {
        require_once(APPPATH . 'third_party/keys.php');
        require_once(APPPATH . 'third_party/eBaySession.php');

        $endpoint = 'http://open.api.ebay.com/Shopping';  // URL to call
        $responseEncoding = 'XML';   // Format of the response
        $categoryID = $_GET['catId'];

        $siteID = 0; //0-US,77-DE
// Construct the FindItems call
        $apicall = "$endpoint?callname=GetCategoryInfo"
            . "&appid=$appID"
            . "&siteid=$siteID"
            . "&CategoryID=$categoryID"
            . "&version=677"
            . "&responseencoding=$responseEncoding"
            . "&IncludeSelector=ChildCategories";

// Load the call and capture the document returned by the GetCategoryInfo API

        $xml = simplexml_load_file($apicall);

        $errors = $xml->Errors;
        $browse = "";
        $i = isset($_GET['counter']) ? $_GET['counter'] + 1 : 0;
//echo $i;
//if there are error nodes
        if ($errors->count() > 0) {
            echo '<p><b>eBay returned the following error(s):</b>';
            //display each error
            //Get error code, ShortMesaage and LongMessage
            $code = $errors->ErrorCode;
            $shortMsg = $errors->ShortMessage;
            $longMsg = $errors->LongMessage;
            //Display code and shortmessage
            echo '<p>', $code, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg));
            //if there is a long message (ie ErrorLevel=1), display it
            if (count($longMsg) > 0)
                echo '<br>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg));
        } else { //no errors
            //if sub-categories found
            if ($xml->CategoryArray->Category->LeafCategory == 'false'):

                foreach ($xml->CategoryArray->Category as $cat) {
                    if ($cat->CategoryID != $categoryID):
                        if ($cat->CategoryLevel != 0):
                            $browse .= '<option value="' . $cat->CategoryID . '">' . $cat->CategoryName . '</option>';
                        endif;
                    endif;
                }
                $i = isset($_GET['counter']) ? $_GET['counter'] + 1 : 0;
                echo '<select size="15" class="columns form-control" style="width:280px; display:inline-block;" id="subcat_' . $i . '" onchange="select_ebay_cat(' . $i . ');">' . $browse . '</select><span class="subcat_' . $i . '"></span>';
                echo '<script>$("#continue").attr("disabled","disabled"); </script>';
            else: // if no sub-categories found
                $categorypath = str_replace(':', ' > ', $xml->CategoryArray->Category->CategoryNamePath);
                $name = $xml->CategoryArray->Category->CategoryName;
                $id = $xml->CategoryArray->Category->CategoryID;
                echo "<input type='hidden' name='category' value='<?php echo $id; ?>-<?php echo $name; ?>' /><br><br><br>
        <span class='nocategories'><img src='http://pics.ebaystatic.com/aw/pics/icon/iconSuccess_32x32.gif' alt=' '>
        You have selected a category. </span> <script type='text/javascript'>$('#ebay_category').val(\"$categorypath\");</script>";


            endif;
        }
    }
} 
