<?php
/*  © 2007-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */

    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = true;   // toggle to true if going against production
    $compatabilityLevel = 1067;    // eBay API version
     
    if ($production) {
        $devID = '7ab39e9a-c5fe-4f7c-ab88-13b93367e0aa';   // these prod keys are different from sandbox keys
        $appID = 'ThiagoAr-latronic-PRD-f10683bd3-e76b8f5b';
        $certID = 'PRD-10683bd352e8-2332-41f5-960c-f1b5';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**t+bhWw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AAmICnAZKBqAqdj6x9nY+seQ**uiQEAA**AAMAAA**hZt/Y99vadleaAh8cfRGnrF0TxiDP7V+6+snpc8cmqlL7vdItrzpzHIY5j0QwNDGTexKJJDfcY98CMOKno4aTmErOOoBqWQpA7EcYyICulGswe0Y8bqv101MsA6fSYYG+WM7X+7vQQDvpZuGN1zSfqStD0I/+ad8oFXKOYFYNChbtS5pNyHgEfLQ4p1Oy5Rp/zCyMlkcoYfOBWwZMRz5hBBXuR8IoUDoe/OlSKMkyxVh2llQuOHDTWPDONhxSJss6coRjOJ5P/hP7/94IhfO6dCsH+JEhzw6OW9miCm2X+GeKGP5GK6+nIFfFTjgiToGPu8Cppdg1dYI1BNDIKgoEq6jbzPR4OPdSGTEm6OA1dM0lSF2TfaNYEvFrkj2D2xNqSlnlAPexsqgOn3cegaYR6L3JmoTDZ9JhUupCQd+zEfGrhWu/nUax9oetg5MbcZZ88M0ls+5ogohvXfcWxQllbGBML8nEgWy9hS9WnzRm7cKQ66S7dafDBCBMz2+IO/LJDUUKDleZ2eMaC/X9ZV6MBRxANVoTFGM3PpQAcdIvpcChdQyDYUOhiDRn5wpkNcoY7ltVVuNb9MYoCIXWVKQbGx4VKS+KA+ZkgTaNDGatagTzBxVnNvssr+PiyVJAIWPrWILw1/zgg8oxD0kb+ghfCsreYtNH+EiAgZP9H/y+sC1+q/DpV6aQ2q7RFH+yLPfjt0Q0nCTxH+0mvPmJHVwo7wsDiu3UddlWotZy/Oh+UlQmGfHRK0CabtsZ5fj+OnQ';
        $paypalEmailAddress= 'payments@5bucksla.com';
    } else {  
        $devID = '7ab39e9a-c5fe-4f7c-ab88-13b93367e0aa';         // insert your devID for sandbox
        $appID = 'ThiagoAr-latronic-PRD-f10683bd3-e76b8f5b';   // different from prod keys
        $certID = 'PRD-10683bd352e8-2332-41f5-960c-f1b5';  // need three 'keys' and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**t+bhWw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AAmICnAZKBqAqdj6x9nY+seQ**uiQEAA**AAMAAA**hZt/Y99vadleaAh8cfRGnrF0TxiDP7V+6+snpc8cmqlL7vdItrzpzHIY5j0QwNDGTexKJJDfcY98CMOKno4aTmErOOoBqWQpA7EcYyICulGswe0Y8bqv101MsA6fSYYG+WM7X+7vQQDvpZuGN1zSfqStD0I/+ad8oFXKOYFYNChbtS5pNyHgEfLQ4p1Oy5Rp/zCyMlkcoYfOBWwZMRz5hBBXuR8IoUDoe/OlSKMkyxVh2llQuOHDTWPDONhxSJss6coRjOJ5P/hP7/94IhfO6dCsH+JEhzw6OW9miCm2X+GeKGP5GK6+nIFfFTjgiToGPu8Cppdg1dYI1BNDIKgoEq6jbzPR4OPdSGTEm6OA1dM0lSF2TfaNYEvFrkj2D2xNqSlnlAPexsqgOn3cegaYR6L3JmoTDZ9JhUupCQd+zEfGrhWu/nUax9oetg5MbcZZ88M0ls+5ogohvXfcWxQllbGBML8nEgWy9hS9WnzRm7cKQ66S7dafDBCBMz2+IO/LJDUUKDleZ2eMaC/X9ZV6MBRxANVoTFGM3PpQAcdIvpcChdQyDYUOhiDRn5wpkNcoY7ltVVuNb9MYoCIXWVKQbGx4VKS+KA+ZkgTaNDGatagTzBxVnNvssr+PiyVJAIWPrWILw1/zgg8oxD0kb+ghfCsreYtNH+EiAgZP9H/y+sC1+q/DpV6aQ2q7RFH+yLPfjt0Q0nCTxH+0mvPmJHVwo7wsDiu3UddlWotZy/Oh+UlQmGfHRK0CabtsZ5fj+OnQ';
		$paypalEmailAddress = 'payments@5bucksla.com';
    }
?>
