<?php
           include "config.php";

        header("Content-Type: application/json");

        $response = '{
                "ResultCode": 0, 
                "ResultDesc": "Confirmation Received Successfully"
        }';

        // DATA
        $mpesaResponse = file_get_contents('php://input');

        // log the response
        $logFile = "M_PESAConfirmationResponse.txt";

        // write to file
        $log = fopen($logFile, "a");

        fwrite($log, $mpesaResponse);
        fclose($log);

        $content = json_decode($mpesaResponse);
        
      
        $TransactionType = $content->TransactionType;
        $TransID = $content->TransID;
        $TransTime = $content->TransTime;
        $TransAmount = $content->TransAmount;
        $BusinessShortCode = $content->BusinessShortCode;
        $BillRefNumber = $content->BillRefNumber;
        $InvoiceNumber = $content->InvoiceNumber;
        $OrgAccountBalance = $content->OrgAccountBalance;
        $ThirdPartyTransID = $content->ThirdPartyTransID;
        $MSISDN = $content->MSISDN;
        $FirstName = $content->FirstName;
        $MiddleName = $content->MiddleName;
        $LastName = $content->LastName;
        $Fullname=$FirstName." ". $MiddleName. " ".$LastName;

        $servername = "localhost";
        $username = "fmnywurf_dev";
        $password = "Sabugo@2021";
        $dbname = "fmnywurf_sabugo_v2";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            echo "Failed";
            die("Connection failed: " . $conn->connect_error);
        }
        
        $insert = $conn->query("INSERT INTO `till_148130`(
            `TransID`, `TransTime`, `TransAmount`, `OrgAccountBalance`, `MSISDN`, `Fullname`)
                 VALUES ('$TransID','$TransTime','$TransAmount','$OrgAccountBalance','$MSISDN','$Fullname')");
        $conn = null;
       // echo "Connection Successfully";
    
     
     
        echo $response;
?>
