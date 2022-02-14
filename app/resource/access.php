<?php

if (isset($_SERVER["HTTP_REQUEST_TYPE"])) {
    $request_type = $_SERVER["HTTP_REQUEST_TYPE"];
} else {
    $request_type = "un-official";
}
// echo $_SERVER["HTTP_REQUEST_TYPE"];
// echo json_encode($_POST);

$_access = 99;
if (isset($request_type) && $request_type != "") {
    // echo $request_type."<p></p>".json_encode($request_type == "anonymouse");
    if ($request_type == "post_data" || $request_type == "get_data" || $request_type == "login" || $request_type == "anonymouse") {
        // echo "inside";
        $_access = check_access($config);
        // echo "access : ".$_access;
        if (!$_access) {
            die("not-allowed");
            return;
        }
    } else {
        die("braked-request");
        return;
    }
} else {
    die("bad-request");
    return;
}


//Functions

function access_level($config)
{
    $level = 99;
    if (isset($_SERVER["HTTP_REQUEST_TYPE"])) {
        $request_type = $_SERVER["HTTP_REQUEST_TYPE"];
    } else {
        $request_type = "un-official";
    }

    // echo $request_type;

    if (isset($request_type)) {
        if ($request_type != "un-official") {
            if ($request_type == "anonymouse") {
                $level = 73;
                return $level;
            }else if($request_type == "login"){
                $level = 91;
                return $level;
            } else {
                if (isset($_SERVER["HTTP_CLIENT_TOKEN"])) {
                    $level = 89;
                    $login_result = check_token($config, $_SERVER["HTTP_CLIENT_TOKEN"]);
                    // echo json_encode($login_result);
                    // echo "\r\n<p></p>" . $login_result;
                    $level = $login_result;
                    // echo $level;
                    return $level;
                } else{
                    $level = 96;
                }
                return $level;
            }
        } else {
            $level = 99;
            return $level;
        }
    } else {
        $level = 99;
        return $level;
    }
}

function check_token($config, $token)
{
    $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->users);
    if ($conn->connect_error) {
        die("not-authorized"); //("Connection failed: ". $conn->connect_error);
        return;
    }
    mysqli_set_charset($conn, "utf8");
    $sqlQuery = "SELECT data,expire FROM session WHERE (token = '" . $token . "')";

    $result = $conn->query($sqlQuery);


    while ($row = mysqli_fetch_assoc($result))
        $res[] = $row;

    // echo $token;
    // $expire;
    // echo json_encode($res);
    if (isset($res) && count($res) > 0) {
        $expire = new DateTime($res[0]["expire"]);
        $now = new DateTime("now");
        if ($expire > $now) {
            $config->catch->userData=json_decode($res[0]["data"]);
            $now->add(new DateInterval('PT' . $config->settings->login_expire . 'M'));
            $sql = "UPDATE session SET expire='" . $now->format('Y-m-d H:i') . "' WHERE token='" . $token . "'";
            $result = $conn->query($sql);
            $conn->close();
            return json_decode($res[0]["data"])->access;
        } else {
            return 61;
        }
    } else {
        return 89;
    }
}

function check_access($config)
{
    if (isset($_POST["request"]) && isset($_POST["action"])) {
        if (isset($config->modules->$_POST["request"]) && isset($config->modules->$_POST["request"]->actions->$_POST["action"])) {
            $access_level = access_level($config);
            // echo "Module Access Level Is : " . $config->modules->$_POST["request"]->access->min . "\r\n<p></p>";
            // echo "Access Level Is : " . $access_level . "\r\n<p></p>";
            if ($config->modules->$_POST["request"]->access->min >= $access_level && $config->modules->$_POST["request"]->actions->$_POST["action"]->access >= $access_level)
            return true;
            else
            return false;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function _d______o($param)
{
    $module_address = './app/modules/' . $param . '/index.php';
    include $module_address;
}

function echoData($data)
{
    $_outdata = new \stdClass();
    $_outdata->data = $data;
    $_outdata->log = "";
    echo json_encode($_outdata);
}
 

    // Access Levels : 
    /* 
     _______________________________________________________________________________________________________________________________________________________
    |        |      1       |       2       |       3       |       4       |       5       |       6       |       7       |       8       |       9       |
    |--------|--------------|---------------|---------------|---------------|---------------|---------------|---------------|---------------|---------------|
    |   1    |  Full Admin  |  Sub Admins   |               |               |               |               |               |               |               |
    |___2____|  Manager     |  Sub Manager  |  Writer       |               |               |               |               |               |               |
    |   3    |  User        |  Visiter      |               |               |               |               |               |               |               |
    |   4    |              |               |               |               |               |               |               |               |               |
    |   5    |              |               |               |               |               |               |               |               |               |
    |   6    |              |               |               |               |               |               |               |               |               |
    |   7    |              |               |  anonymouse   |               |               |               |               |               |               |
    |   8    |              |               |               |               |               |               |               |               | TimeOut User  |
    |   9    | Inside Login |               |               |               |               |               |               |               |Outside Request|
    |________|______________|_______________|_______________|_______________|_______________|_______________|_______________|_______________|_______________|

    */
