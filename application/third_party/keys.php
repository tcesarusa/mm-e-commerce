<?php
/*  © 2007-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */

    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = true;   // toggle to true if going against production
    $compatabilityLevel = 1067;    // eBay API version
     
    if ($production) {
        $devID = 'dc370a1a-1893-4848-8778-4126996fbe4d';   // these prod keys are different from sandbox keys
        $appID = '5BucksLa-5bucksla-PRD-e7f4c67ed-10cf3b85';
        $certID = 'PRD-7f44a023f19d-d1c7-48e2-a760-a8cd';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**tPnHWw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AMlYOgDZOHpA+dj6x9nY+seQ**9xAFAA**AAMAAA**OsDv4DT1Zkp2uQmIhMFq16zJA6+GeVo0sYuLF4gky8WeQ14KTgGZxy7Wd6cwZsI/Dwwdqx9aycPAaCDwqlR5RExUsZD/56qAzwu4BtgzCHy6xENwHlKbM5qMSWqKhAVpqvQ+g0lbyI1Fgxa0RhjnrYpdeDkT+iQXAk+Df3PQIJoKTgEWGLKqF452DwOpYalbiOLW+YMd7Ea/Fh5vtPfq72PToFf39Xgh1c+OvARLKCHflM2aOft6e9B/KAA9pylqVXxdjIUCQM+3qrdkYTi0yI8h1HcA8UiirWlBrenuQi7dBaeO8oA0irKwGsOw4qNeURcYkYyF+wgzUAtvMdrRwoDpt62wpWHc9Sdtbo8lVft1FAB/E7zF0NxrsqG7BZkhZE4M6gEmsBON6YYyF89x8OS5aaSD0gmG5FEBWS+ulkWyv/f8HY+swNCwDj8+CmocuSzZ0sIfXl3vMGW3G7p69lV86Wlqpze40D3MS1gJTE0ZRUEo07JMB4YGLNxNJFVez0/IMpw/pted0JbaSPh25RuCjAueH9LU1S0FfKMf0XVWZAtBYe1AuPQu6giZ4cKjV+NvXccjWnwoeUhjlC1sunItG5SeaiNabqeiNyM0DsntzOTebLd5ca3AL7TaBJQftO+7MCcQobE3wdkMFhSQXOfaOUod/ys7f5eBhjAFNkNg5B4O34EwqZiSIF2RVnn1Bor0ylFzDjIYR35unC14yhW5d7O3nsHjeGtpF7j6PcOC8kT3NsmY76akg8lt9TTL'; 
        $paypalEmailAddress= 'payments@5bucksla.com';
    } else {  
        $devID = '7ab39e9a-c5fe-4f7c-ab88-13b93367e0aa';         // insert your devID for sandbox
        $appID = 'ThiagoAr-latronic-SBX-85d7a0307-bbda9cfa';   // different from prod keys
        $certID = 'SBX-5d7a0307bbc3-37b8-48f5-8ff4-920c';  // need three 'keys' and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**tZnzWg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4agDZGHowidj6x9nY+seQ**XWkEAA**AAMAAA**kGVN4Czp1yAVx2pHJ4I7RZfQFB2d2/8RcOuzZKwqrwS7bRjjW/yHSRW46bG2re/POAXvozIaPoM6fqu1fJT9oIn8NRXbYWSqzoL+biUN2i8C6WMixRlQBmasyZJpfVGPbK9fVx2ECflRPgobx9PVT20c/G/VRfaOqb19jzuaa2DPrIWKGPpTI3XjeWU/NItBfDHJmV99Ch8GicnoXcNCmDBUqNOm/opsssJ2SeHdPh+08YZMOygbAodbwaO5znXbuwYVIeXu0pGzotY9xszd2hjIqLD0CK02SFVYZly3CnBaOPO3j790pnBtnc5l7UpqSsM6lfsSGhFfhG66ouXrtHgKWyUPLyrbilC3XNSZVTe8oHQLvgwZu9sNzy7+01M3sW7O4Pp2MJVwCQxlm6fGAFvO3AlfFTA8Rtz5l1YSrGLOgXET2dsZBT/Vjf6LuK55/TKP1X7flYWPmt1zIU8Cr/qsrG0BDZK8KWrq6bASbe5UaZ9s8YnEe3zPaZygqWhDpExcyj4bU8qI2QTZJ13pFOmIqMn+9wZab2eNZJ3/ZWuwulK6QjhNyE40V16X0EUErP9CCXB5bDkH0q5SrtO6NOxhZDvaw+dlgTUvLTuqKKC6/y+J4WcWl5ynhBb9GkZy+NeWJ723AzX3Ck2+Y57dK2Lo1h/fQ6n7wEzWVZ2TKmhaIbaDBbNg+jBNST4ZTDn8ZYoPqjgvJ0OSwtMIhjVeAZg6Ny2m3+H1Rn4gdFW/ZOK0W1vCa/MZ5RlhVsIWARDO'; 
		$paypalEmailAddress = 'tcesarusa@gmail.com';		
    }
?>
