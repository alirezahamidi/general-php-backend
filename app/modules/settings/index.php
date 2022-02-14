<?php
class Login
{
    function get($conn, $config)
    {
        $sql = "SELECT * FROM products_categories";

        $sqlQuery = "SELECT id,mobile_theme,web_theme,web_status,mobile_status,change_date,title,describtion FROM settings ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row; 

        // echo $res[0]["change_date"];
        if (isset($res[0]["change_date"])) {
            $date = new DateTime($res[0]["change_date"]);
            $res[0]["change_date"] = $date;
        }

        if (isset($res))
            return $res[0];
        else
            return "no-data";
    }

    function save($conn, $data, $config)
    {
        $now = new DateTime("now");

        $sql = "INSERT INTO settings (mobile_theme,web_theme,web_status,mobile_status,change_date,title,describtion) VALUES ('" . $data->mobile_theme . "','" . $data->web_theme . "','" . $data->web_status . "','" . $data->mobile_status . "', '" . $now->format('Y-m-d H:i') . "','" . $data->title . "','" . $data->describtion . "')";

        if ($conn->query($sql) === true) {
            return "successfull";
        } else {
            echo "failed";
        }
    }

    function call_functions($name, $data, $config)
    {
        $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->shop);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        switch ($name) {
            case "get":
                echo json_encode($this->get($conn, $config));
                break;
            case "save":
                echo json_encode($this->save($conn, $data->data, $config));
                break;
            default:
                echo "invalid_action";
        }
    }
}
$login = new Login;
$login->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
?>