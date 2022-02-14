<?php
class Comments
{
    
    function addComment($connection, $_data)
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        $client_detiles=$_data->client_detiles;
        $client_detiles->ip=$ipaddress;
        // $reply_id;
        if(isset($_data->reply_id)) $reply_id=$_data->reply_id;
        else $reply_id="0";

        $sql = "INSERT INTO contact (email,name,text,reply_id,client_detiles,date_time,extra_data)
        VALUES ('".$_data->email."', '".$_data->name."','".$_data->comment_text."','".$reply_id."','".json_encode($client_detiles)."','".date("Y-m-d")." ".date("h:i:sa")."','".$_data->url."')";

        if ($connection->query($sql) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $connection->error . "}";
        }
        return;
    }

    function updateContent($connection, $_id, $_data)
    {
        $preview="";
        if(isset($_data->body)){
            if(strlen($_data->body)>2500)
                $preview=substr($_data->body,0,900)." ... <p></p> متن کامل این مقاله را در ادامه مطلب بخوانید!";
            else
                $preview=$_data->body;
        }

        $sql = "UPDATE contents SET title='" . $_data->title . "',keywords='" . $_data->keywords . "',preview='".$preview."' ,body='" . $_data->body . "',gallery='" . json_encode($_data->images) . "',change_date='".date("d/m/Y,H:i:s")."'
        WHERE id='" . $_id . "'";

        if ($connection->query($sql) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $connection->error . "}";
        }
        return;
    }

    function listAll($connection, $ipp, $page)
    {
        $sql = "SELECT * FROM contents";

        $lim = "";
        if ($page - 1 > 0) $lim = (($page - 1) * $ipp) . ",";
        $sqlQuery = "SELECT id,title,gallery,preview FROM contents LIMIT " . $lim . " " . $ipp;
        // echo $sqlQuery;
        $result = $connection->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        mysqli_free_result($result);

        $sql = "SELECT COUNT(1) FROM contents";
        $result = $connection->query($sql);

        while ($row = mysqli_fetch_assoc($result))
            $_count[] = $row;

        $data = json_decode("{}");
        $data->contents = $res;
        if (isset($_count))
            $data->count = $_count[0];
        echo json_encode($data);
    }

    function deleteContent($connection, $_id)
    {
        $sql = "DELETE FROM contents
                WHERE id = '" . $_id . "'";

        if ($connection->query($sql) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $connection->error . "}";
        }
        return;
    }

    function getContent($connection, $_id)
    {
        $sqlQuery = "SELECT id,title,keywords,body,gallery FROM contents WHERE id = '" . $_id . "'";
        // echo $sqlQuery;
        $result = $connection->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        $data = json_decode("{}");
        $data->content = $res;
        echo json_encode($data);
    }

    function getContentsDetiles($connection, $_ids)
    {
        $sqlQuery = "SELECT id,title,gallery  FROM contents WHERE ";
        for($i=0;$i<count($_ids);$i++){
            if($i!=0 && $i!=(count($_ids))) $sqlQuery=$sqlQuery." or ";

            $sqlQuery=$sqlQuery."(id='".$_ids[$i]."')";
        }
        // echo $sqlQuery;
        $result = $connection->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        $data = json_decode("{}");
        $data->contents = $res;
        echo json_encode($data);
    }

    function getStatics($connection){
        $sqlQuery = "SELECT id,title  FROM contents "."ORDER BY date_time DESC LIMIT 3";
        // echo $sqlQuery;
        $result = $connection->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        $data = json_decode("{}");
        $data->contents = $res;
        echo json_encode($data);
    }

    function call_functions($name, $data, $config)
    {
        $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->blog);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        switch ($name) {
            case "addComment":
                // echo json_encode($data);
                $this->addComment($conn, $data);
                break;
            default:
                echo "invalid_action";
        }
    }
}
$contents = new Comments;
$contents->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
?>