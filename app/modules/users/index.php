<?php
class Products
{


    function getUsersList($conn, $config, $page, $ipp)
    {
        $sql = "SELECT * FROM info";

        $lim = "";
        if ($page - 1 > 0) $lim = (($page - 1) * $ipp) . ",";
        $sqlQuery = "SELECT id,name,username,access FROM info LIMIT " . $lim . " " . $ipp;
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        mysqli_free_result($result);

        $sql = "SELECT COUNT(1) FROM info";
        $result = $conn->query($sql);

        while ($row = mysqli_fetch_assoc($result))
            $_count[] = $row;

        $data = json_decode("{}");
        $data->users = $res;
        if (isset($_count))
            $data->count = $_count[0];
        return $data;
    }

    function deleteUser($conn, $config, $id)
    {
        $sql = "SELECT * FROM info";

        $sqlQuery = "DELETE FROM info WHERE id='" . $id . "'";

        if ($conn->query($sqlQuery) === true) {
            return "successfull";
        } else {
            return "failed";
        }
    }

    function editUser($conn, $config, $id, $data)
    {
        $sql = "UPDATE info SET name='" . $data->name . "' , username='" . $data->username . "' , email='" . $data->email . "' , access='" . $data->access . "' , email='" . $data->email . "' ";

        if (isset($data->password) && strlen($data->password) >= 6) {
            $sql = $sql . ", password='" . $data->password . "' ";
        }
        $sql = $sql . "WHERE id='" . $id . "'";

        if ($conn->query($sql) === true) {
            return "successfull";
        } else {
            return "failed";
        }
        $conn->close();
    }

    function getUserInfo($conn, $config, $id)
    {
        $sql = "SELECT * FROM info";

        $sqlQuery = "SELECT name,username,access,email FROM info WHERE id='" . $id . "'";
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        mysqli_free_result($result);

        if (isset($res))
            return $res[0];
        else
            return "not-found";
    }

    function getUserInfoByToken($conn, $config, $token)
    {
        $sql = "SELECT * FROM info";

        $sqlQuery = "SELECT data FROM session WHERE token='" . $token . "'";
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        mysqli_free_result($result);

        if (isset($res))
            return $res[0];
        else
            return "not-found";
    }

    
    function getUserProfile($conn, $config, $id)
    {
        // $sql = "SELECT * FROM info";
        // $sqlQuery = "SELECT data FROM session WHERE token='" . $token . "'";
        
        // $sqlQuery = "SELECT id,username,name,email,real_name,bio,phone,picture,addresses,extra_data FROM info LEFT OUTER JOIN profile ON info.id=profile.user_id WHERE id=".$id;
        $sqlQuery = "SELECT username,email,real_name,bio,phone,picture FROM info LEFT OUTER JOIN profile ON info.id=profile.user_id WHERE id=".$id;
        // echo $sqlQuery;
        
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        // mysqli_free_result($result);

        if (isset($res))
            return $res[0];
        else
            return "not-found";
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
            case "listAll":
                if (isset($data->page) && isset($data->ipp)) {
                    echo json_encode($this->getUsersList($conn, $config, $data->page, $data->ipp));
                } else {
                    echo "not-valid";
                }
                break;
            case "deleteUser":
                if (isset($data->id)) {
                    echo $this->deleteUser($conn, $config, $data->id);
                }
                break;
            case "editUser":
                if (isset($data->id)) {
                    echo $this->editUser($conn, $config, $data->id, $data->data);
                }
                break;
            case "getUserInfo":
                if (isset($data->id)) {
                    echo json_encode($this->getUserInfo($conn, $config, $data->id));
                } else if (isset($data->token)) {
                    echo json_encode($this->getUserInfoByToken($conn, $config, $data->token));
                }
                break;
            case "getUserProfile":
                if (isset($data->id)) {
                    echo json_encode($this->getUserProfile($conn, $config, $data->id));
                }
                break;
            default:
                echo "invalid_action";
        }
    }
}
$products = new Products;
$products->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
?>