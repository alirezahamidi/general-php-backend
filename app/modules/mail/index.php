<?php
class Mail
{
    function send_email($email,$subject,$text,$config){
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: Your name <info@address.com>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
        $msg = wordwrap($text,70);
        
        // send email
        mail($email,$subject,$msg,$headers);
    }

    function call_functions($name, $data, $config)
    {
        $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->users);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        switch ($name) {
            case "sendEMail":
                $this->send_email($data->email,$data->subject,$data->text, $config);
                break;
            default:
                echo "invalid_action";
        }
    }

}
$mails = new Mail;
$mails->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
?>