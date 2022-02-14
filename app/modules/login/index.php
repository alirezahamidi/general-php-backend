<?php
class Login
{
    function __construct($config)
    {
        $this->mysql = new MySql($config->db->list->users, $config);
    }

    function loginUser($conn, $data, $config)
    {
        if (isset($data->username) && isset($data->password)) {
            $result = $this->Authorize($conn, $config, $data->username, $data->password);
            echo $result;
        } else if (isset($data->token)) {
            $result = $this->CheckToken($conn, $config, $data->token);
            if (isset($result) && $result != "not_found" && $result != "timeout") {
                $data->stat = "logged_in";
                $data->res = $result;
                echo json_encode($data);
            } else
                echo "Not-Authorized";
        } else
            echo "Not-Authorized";
        return;
    }

    function signup($conn, $data, $config)
    {
        if (isset($data->username) && isset($data->password)) {
            $result = $this->CheckUserExist($conn, $config, $data->username);
            if ($result == true) {
                echo "exist";
                return;
            } else {
                $result_ = $this->CreateNewUser($conn, $config, $data);
                if ($result_ == true) {
                    $result = $this->Authorize($conn, $config, $data->username, $data->password);
                    echo $result;
                    return;
                } else
                    echo "failed";
                return;
            }
        } else
            echo "Bad-Request";
        return;
    }

    function CheckLogin($data)
    {
    }

    function Authorize($conn, $config, $username, $password)
    {
        $sqlQuery = "SELECT id,access,email,username FROM info WHERE (email = '" . $username . "' OR username = '" . $username . "') AND (password = '" . $password . "');";
        // echo $sqlQuery;        
        // $sqlQuery="SELECT id,access,email,name,username FROM users";

        // echo $sqlQuery;
        $results = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($results))
            $res[] = $row;

        // echo json_encode($res);

        if (isset($res))
            return "{\"stat\":\"loged_in\",\"token\":\"" . $this->NewToken($conn, $config, $res[0]) . "\",\"loginData\":" . json_encode($res[0]) . "}";
        else {
            return "{\"stat\":\"not_authorized\"}";
        }
    }

    function CheckUserExist($conn, $config, $username)
    {
        $sqlQuery = "SELECT id FROM info WHERE (email = '" . $username . "' OR username = '" . $username . "');";

        $results = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($results))
            $res[] = $row;

        if (isset($res))
            return true;
        else {
            return false;
        }
    }

    function CreateNewUser($conn, $config, $data)
    {
        $sqlQuery = "INSERT INTO `info` (`id`, `username`, `email`, `password`,`access`) VALUES (NULL, '" . $data->username . "', '" . $data->email . "', '" . $data->password . "', '31');";

        if ($conn->query($sqlQuery) === true) {
            return true;
        } else {
            return false;
        }
        return;
    }

    function NewToken($conn, $config, $loginData)
    {
        $t = time();
        $token = base64_encode(rand(0, 99999) . "_" . $t . "_" . rand(0, 99999));

        $now = new DateTime("now");

        $now->add(new DateInterval('PT' . $config->settings->login_expire . 'M'));

        $sql = "INSERT INTO session (token,data,expire)
        VALUES ('" . $token . "', '" . json_encode($loginData) . "', '" . $now->format('Y-m-d H:i') . "')";

        if ($conn->query($sql) === true) {
            return $token;
        } else {
            die("{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}");
        }
    }

    function CheckToken($conn, $config, $token)
    {
        $sqlQuery = "SELECT data,expire,extra_data FROM session WHERE token = '" . $token . "'";

        // echo $sqlQuery;
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        //$expire;
        if (isset($res) && count($res) > 0) {
            $expire = new DateTime($res[0]["expire"]);
            $now = new DateTime("now");

            if ($expire > $now) {
                $now->add(new DateInterval('PT' . $config->settings->login_expire . 'M'));
                $sql = "UPDATE session SET expire='" . $now->format('Y-m-d H:i') . "' WHERE token='" . $token . "'";
                $conn->query($sql);
                $conn->close();
                $res[0]["expire"] = $now->format('Y-m-d H:i');

                echo json_encode($res[0]);
            } else {
                echo "timeout";
            }
        } else {
            echo "not_found";
        }
    }

    function call_functions($name, $data, $config)
    {
        $conn = $this->mysql->getConnection();
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        switch ($name) {
            case "login":
                $this->loginUser($conn, $data, $config);
                break;
            case "signupUser":
                $this->signup($conn, $data, $config);
                break;
            case "checkToken":
                $this->CheckToken($conn, $config, $data->token);
                break;
            default:
                echo "invalid_action";
        }
    }
}
$login = new Login($config);
$login->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
// echo json_encode($_POST);
