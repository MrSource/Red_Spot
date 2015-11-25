<?php

class ReportClass {

    private $userName;
    private $reportedUserName;
    private $establishmentToReport;
    private $message;


    //Constructor
    function __construct() {
        
    }

    function getUserName() {
        return $this->userName;
    }

    function getReportedUserName() {
        return $this->reportedUserName;
    }

    function getEstablishmentToReport() {
        return $this->establishmentToReport;
    }

    function getMessage() {
        return $this->message;
    }

   

    function setUserName() {
        $this->userName = $_SESSION['establishmentName'];
    }

    function setReportedUserName($reportedUserName) {
        $this->reportedUserName =$reportedUserName;
    }

    function setEstablishmentToReport($establishmentToReport) {
        $this->establishmentToReport = $establishmentToReport;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    
    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO report (userName, reportedUserName, establishmentToReport, message) VALUES (?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ssss", $this->userName, $this->reportedUserName, $this->establishmentToReport, $this->message);
            $stmt->execute();
            $stmt->close();
            $success = TRUE;
        } else {
            echo $mysqli->error;
            $success = FALSE;
        }


    }

    public function verifyCredentials($mysqli) {
  

}
}