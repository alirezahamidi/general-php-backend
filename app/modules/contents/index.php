<?php
class Contents
{
    function addContent($connection, $_data)
    {
        $preview="";
        if(isset($_data->body)){
            if(strlen($_data->body)>2500)
                $preview=substr($_data->body,0,900)." ... <p></p> متن کامل این مقاله را در ادامه مطلب بخوانید!";
            else
                $preview=$_data->body;
        }

        $sql = "INSERT INTO contents (id,title,categories,keywords,body,gallery,preview,date_time)
        VALUES ('" . $_data->id . "', '" . $_data->title . "', '" . json_encode($_data->categories) . "', '" . $_data->keywords . "','" . $_data->body . "','" . json_encode($_data->images) . "' , '".$preview."','".date("d/m/Y,H:i:s")."')";

        if ($connection->query($sql) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
        }

        include 'app/resource/sitemap/index.php';

        $map=new SiteMap();
        $data__=json_decode("{}");
        $data__->url=$this->config->blogBaseUrl.$_data->id;
        $data__->priority="0.8";
        $map->call_functions("addToSitemap",$data__,$this->config);
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

        $sql = "UPDATE contents SET title='" . $_data->title . "',keywords='" . $_data->keywords . "',categories='".json_encode($_data->categories)."' ,preview='".$preview."' ,body='" . $_data->body . "',gallery='" . json_encode($_data->images) . "',change_date='".date("d/m/Y,H:i:s")."'
        WHERE id='" . $_id . "'";

        if ($connection->query($sql) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
        }
        
        include 'app/resource/sitemap/index.php';

                
        $map=new SiteMap();
        $data__=json_decode("{}");
        $data__->url=$this->config->blogBaseUrl.$_data->id;
        $data__->priority="0.8";
        $map->call_functions("editSitemap",$data__,$this->config);
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
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
        }
        
        include 'app/resource/sitemap/index.php';
                
        $map=new SiteMap();
        $data__=json_decode("{}");
        $data__->url=$this->config->blogBaseUrl.$_id;
        $map->call_functions("removeFromSitemap",$data__,$this->config);
        return;
    }

    function getContent($connection, $_id)
    {
        $sqlQuery = "SELECT id,title,categories,keywords,body,gallery FROM contents WHERE id = '" . $_id . "'";
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

    // function getSale($connection, $_id)
    // {
    //     $sqlQuery = "SELECT price,selling,inventory_count,sold_count,sell_info,extra_data FROM sell_info WHERE content_id = '" . $_id . "'";
    //     // echo $sqlQuery;
    //     $result = $connection->query($sqlQuery);

    //     while ($row = mysqli_fetch_assoc($result))
    //         $res[] = $row;

    //     if (isset($res) && count($res) > 0) {
    //         $data = json_decode("{}");
    //         $data->content = $res[0];
    //         echo json_encode($data);
    //     } else {
    //         $data = json_decode("{}");
    //         $data->content = "Not-Set";
    //         echo json_encode($data);
    //     }
    // }

    // function getPrice($connection, $_id)
    // {
    //     $sqlQuery = "SELECT price,selling,inventory_count FROM sell_info WHERE content_id = '" . $_id . "'";
    //     // echo $sqlQuery;
    //     $result = $connection->query($sqlQuery);

    //     while ($row = mysqli_fetch_assoc($result))
    //         $res[] = $row;

    //     if (isset($res) && count($res) > 0) {
    //         $data = json_decode("{}");
    //         $data->content = $res[0];
    //         echo json_encode($data);
    //     } else {
    //         $data = json_decode("{}");
    //         $data->content = "Not-Set";
    //         echo json_encode($data);
    //     }
    // }

    // function saveSale($connection, $_id, $data)
    // {
    //     $sqlQuery = 'INSERT INTO sell_info(content_id, price, selling, inventory_count)
    //      VALUES("' . $data->id . '", ' . $data->price . ', ' . $data->selling . ', ' . $data->inventory_count . ')
    //       ON DUPLICATE KEY UPDATE price=' . $data->price . ', selling=' . $data->selling . ', inventory_count=' . $data->inventory_count . '';


    //     if ($connection->query($sqlQuery) === true) {
    //         echo "{\"state\":\"successfull\"}";
    //     } else {
    //         echo "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
    //     }
    //     return;
    // }

    function call_functions($name, $data, $config)
    {
        $this->config=$config;
        $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->blog);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        switch ($name) {
            case "addContent":
                $this->addContent($conn, $data->data);
                break;
            case "listAll":
                $this->listAll($conn, $data->ipp, $data->page);
                break;
            case "delete":
                $this->deleteContent($conn, $data->id);
                break;
            case "getContent":
                $this->getContent($conn, $data->id);
                break;
            case "getContentsDetiles":
                $this->getContentsDetiles($conn, $data->ids);
                break;
            case "updateContent":
                $this->updateContent($conn, $data->data->id, $data->data);
                break;
            case "getStatics":
                $this->getStatics($conn);
                break;
            // case "getSale":
            //     $this->getSale($conn, $data->id);
            //     break;
            // case "getPrice":
            //     $this->getPrice($conn, $data->id);
            //     break;
            // case "saveSale":
            //     $this->saveSale($conn, $data->id, $data);
            //     break;
            default:
                echo "invalid_action";
        }
    }
}
$contents = new Contents;
$contents->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
?>