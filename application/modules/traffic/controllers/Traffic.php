<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Traffic extends MX_Controller {

    /**
     * Quotes constructor.
     */
    var $proxies;

    public function __construct() {
        parent::__construct();
        //read proxy file
        $this->proxies = file("/home3/atobla/admin_www/assets/proxy.txt");
    }

    public function traffic_generator() {
        //Let's make sure no warrnings are displayed by PHP
        error_reporting(1);
// Specify url that shoud receive hits
// make sure to include trailing slash "/" at the end of folders
        $url_1 = "https://5bucksla.com/";

// Specify your server and port
        $myserver = "5bucksla.com:80";

// Specify how many hits to receive every time the script is run
        $randnr = 100;

//now we will get a random proxy address from the proxies.txt file
        $getrand = array_rand($proxies, $randnr);
        $curl = curl_init();
        $timeout = 30;
// Not more than 2 at a time
        for ($x = 0; $x < $randnr; $x++) {
       
//setting time limit to zero will ensure the script doesn&#039t get timed out
            set_time_limit(0);
//now we will separate proxy address from the port
            $PROXY_URL = $this->proxies[$getrand[$x]];
          
            curl_setopt($curl, CURLOPT_URL, $url_1);
            curl_setopt($curl, CURLOPT_PROXY, $this->proxies[$x]);
            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($curl, CURLOPT_REFERER, "http://google.com/");
            $text = curl_exec($curl);
            echo "Hit Generated :" . $x . "<br>";
            sleep(5);
        }
    }


}
