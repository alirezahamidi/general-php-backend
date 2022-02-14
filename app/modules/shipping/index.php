<?php
class Shipping
{
    function add_to_basket($id, $config)
    {
        // echo "adding To Basket";
        $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->users);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        $now = new DateTime("now");

        $sqlQuery = "SELECT extra_data FROM session WHERE token='".$_SERVER["HTTP_CLIENT_TOKEN"]."'";
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row; 


        if (isset($res)) {
            $updateData=$res[0];
            if(isset($updateData["extra_data"])){
                $updateData=json_decode($updateData["extra_data"]);
            }
            // echo gettype($updateData);
            if(is_array($updateData)){
                if(!in_array($id,$updateData)){
                    array_push($updateData,$id);
                }
                else{
                    return "{\"state\":\"exist\"}";
                    die("");
                    return;                   
                }
            }else{
                $updateData=new \stdClass();
                $updateData=array($id);
            }
            mysqli_free_result($result);
            $sql_ = "UPDATE session SET extra_data='" . json_encode($updateData) . "' WHERE token='" . $_SERVER["HTTP_CLIENT_TOKEN"] . "'";


            if ($conn->query($sql_) === true) {
                return "{\"state\":\"successfull\"}";
            } else {
                return "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
            }
            return;

        }else{
            return "session_not_found";
        }
    }
    
    function remove_from_basket($id, $config)
    {
        // echo "adding To Basket";
        $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->users);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        $now = new DateTime("now");

        $sqlQuery = "SELECT extra_data FROM session WHERE token='".$_SERVER["HTTP_CLIENT_TOKEN"]."'";
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row; 


        if (isset($res)) {
            $updateData=$res[0];
            if(isset($updateData["extra_data"])){
                $updateData=json_decode($updateData["extra_data"]);
            }
            // echo gettype($updateData);
            if(is_array($updateData)){
                if(in_array($id,$updateData)){
                    // array_push($updateData,$id);
                    $updateData = \array_diff($updateData, [$id]);
                }
                else{
                    return "{\"state\":\"not-exist\"}";
                    die("");
                    return;                   
                }
            }else{
                $updateData=new \stdClass();
                $updateData=array();
            }
            mysqli_free_result($result);
            $sql_ = "UPDATE session SET extra_data='" . json_encode($updateData) . "' WHERE token='" . $_SERVER["HTTP_CLIENT_TOKEN"] . "'";


            if ($conn->query($sql_) === true) {
                return "{\"state\":\"successfull\"}";
            } else {
                return "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
            }
            return;

        }else{
            return "session_not_found";
        }
    }

    function get_basket($config){
        $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->users);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        // echo "hi";
        $now = new DateTime("now");

        $sqlQuery = "SELECT extra_data FROM session WHERE token='".$_SERVER["HTTP_CLIENT_TOKEN"]."'";
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row; 


        if (isset($res) && count($res)>0 && strlen($res[0]["extra_data"])>0) {
            return $res[0]["extra_data"];
        }else
            return "no-data";
    }

    function is_bought($id,$config){
        $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->users);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        // echo "hi";
        $now = new DateTime("now");

        $sqlQuery = "SELECT extra_data FROM session WHERE token='".$_SERVER["HTTP_CLIENT_TOKEN"]."'";
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row; 


        if (isset($res) && count($res)>0 && strlen($res[0]["extra_data"])>0) {
            return $res[0]["extra_data"];
        }else
            return "no-data";
    }

    function pay($config){        
        $pin='56C57981F70590AD7640';
        $url = 'http://panel.98pal.ir/api/create'; //returns the current URL
        $parts = explode('/',$url);
        $callback = 'http://4152production.ir';
        for ($i = 0; $i < count($parts) - 1; $i++) {
        $callback .= $parts[$i] . "/";
        }
        $callback .= "verify.php";

        if(! Empty($_POST)){
            $url = 'http://panel.98pal.com/api/create/'; // don't change
            $description = "";
            if(!Empty($_POST["name"])){
                $description .= "نام و نام خانوادگی : ".'علیرضا'."\n";
            }
            if(!Empty($_POST["email"])){
                $description .= "ادرس ایمیل : ".'alirezahamidi.urp@gmail.com'."\n";
            }
            if(!Empty($_POST["phone"])){
                $description .= "شماره موبایل : ".'09350832905'."\n";
            }
            if(!Empty($_POST["details"])){
                $description .= "توضیحات کاربر : ".''."\n";
            }
            if(Empty($_POST["amount"]) or $_POST["amount"] < 100){ $_POST["amount"] = '100'; }
        }

        $callback .= "?amount=20000";
        $fields = array(
            'amount' => urlencode($_POST["amount"]),
            'pin' => urlencode($pin),
            'description' => urlencode($description),
            'callback' => urlencode($callback),
        );
        $fields_string = "";
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');
        // echo $fields_string;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);


        echo $result."||Res";
        if(is_numeric($result)){
            echo '
            <span style="color:red">ارور : '.$result.'</span>';
        } else {
            echo $result;
            // header('Location: http://panel.98pal.com/startpay/'.$result);
        }
    }

    function call_functions($name, $data, $config)
    {
        switch ($name) {
            case "addToBasket":
                echo json_encode($this->add_to_basket($data->id, $config));
                break;
            case "removeFromBasket":
                echo json_encode($this->remove_from_basket($data->id, $config));
                break;
            case "getBasket":
                echo $this->get_basket($config);
                break;
            case "isBought":
                echo $this->is_bought($data->id,$config);
                break;
            case "pay":
                $this->pay($config);
                break;
            default:
                echo "invalid_action";
        }
    }
}
$shipping = new Shipping;
$shipping->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
?>