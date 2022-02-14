<?php
class Products
{
    function addProuct($connection, $_data)
    {
        $sql = "INSERT INTO products (id,title,keywords,body,images,facilities)
        VALUES ('" . $_data->id . "', '" . $_data->title . "', '" . $_data->keywords . "','" . $_data->body . "','" . json_encode($_data->images) . "','" . json_encode($_data->facilities) . "')";

        if ($connection->query($sql) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
        }
        return;
    }

    function updateProduct($connection, $_id, $_data)
    {
        $sql = "UPDATE products SET title='" . $_data->title . "',keywords='" . $_data->keywords . "',body='" . $_data->body . "',images='" . json_encode($_data->images) . "',facilities='" . json_encode($_data->facilities) . "'
        WHERE id='" . $_id . "'";

        if ($connection->query($sql) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
        }
        return;
    }

    function listAll($connection, $ipp, $page)
    {
        $sql = "SELECT * FROM products";

        $lim = "";
        if ($page - 1 > 0) $lim = (($page - 1) * $ipp) . ",";
        $sqlQuery = "SELECT id,title,images,price FROM products LEFT OUTER JOIN sell_info ON products.id=sell_info.product_id LIMIT " . $lim . " " . $ipp;
        // echo $sqlQuery;
        $result = $connection->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        mysqli_free_result($result);

        $sql = "SELECT COUNT(1) FROM products";
        $result = $connection->query($sql);

        while ($row = mysqli_fetch_assoc($result))
            $_count[] = $row;

        $data = json_decode("{}");
        $data->products = $res;
        if (isset($_count))
            $data->count = $_count[0];
        echo json_encode($data);
    }

    function deleteProduct($connection, $_id)
    {
        $sql = "DELETE FROM products
                WHERE id = '" . $_id . "'";

        if ($connection->query($sql) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
        }
        return;
    }

    function getProduct($connection, $_id)
    {
        $sqlQuery = "SELECT id,title,keywords,body,images,facilities,price FROM products LEFT OUTER JOIN sell_info ON products.id=sell_info.product_id WHERE id = '" . $_id . "'";
        // echo $sqlQuery;
        $result = $connection->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        $data = json_decode("{}");
        $data->product = $res;
        echo json_encode($data);
    }

    function getProductsDetiles($connection, $_ids)
    {
        $sqlQuery = "SELECT id,title,images,price  FROM products LEFT OUTER JOIN sell_info ON products.id=sell_info.product_id  WHERE ";
        for($i=0;$i<count($_ids);$i++){
            if($i!=0 && $i!=(count($_ids))) $sqlQuery=$sqlQuery." or ";

            $sqlQuery=$sqlQuery."(id='".$_ids[$i]."')";
        }
        // echo $sqlQuery;
        $result = $connection->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        $data = json_decode("{}");
        $data->products = $res;
        echo json_encode($data);
    }

    function getSale($connection, $_id)
    {
        $sqlQuery = "SELECT price,selling,inventory_count,sold_count,sell_info,extra_data FROM sell_info WHERE product_id = '" . $_id . "'";
        // echo $sqlQuery;
        $result = $connection->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        if (isset($res) && count($res) > 0) {
            $data = json_decode("{}");
            $data->product = $res[0];
            echo json_encode($data);
        } else {
            $data = json_decode("{}");
            $data->product = "Not-Set";
            echo json_encode($data);
        }
    }

    function getPrice($connection, $_id)
    {
        $sqlQuery = "SELECT price,selling,inventory_count FROM sell_info WHERE product_id = '" . $_id . "'";
        // echo $sqlQuery;
        $result = $connection->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        if (isset($res) && count($res) > 0) {
            $data = json_decode("{}");
            $data->product = $res[0];
            echo json_encode($data);
        } else {
            $data = json_decode("{}");
            $data->product = "Not-Set";
            echo json_encode($data);
        }
    }

    function saveSale($connection, $_id, $data)
    {
        $sqlQuery = 'INSERT INTO sell_info(product_id, price, selling, inventory_count)
         VALUES("' . $data->id . '", ' . $data->price . ', ' . $data->selling . ', ' . $data->inventory_count . ')
          ON DUPLICATE KEY UPDATE price=' . $data->price . ', selling=' . $data->selling . ', inventory_count=' . $data->inventory_count . '';


        if ($connection->query($sqlQuery) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $sql . "<br>" . $conn->error . "}";
        }
        return;
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
            case "addProduct":
                $this->addProuct($conn, $data->data);
                break;
            case "listAll":
                $this->listAll($conn, $data->ipp, $data->page);
                break;
            case "delete":
                $this->deleteProduct($conn, $data->id);
                break;
            case "getProduct":
                $this->getProduct($conn, $data->id);
                break;
            case "getProductsDetiles":
                $this->getProductsDetiles($conn, $data->ids);
                break;
            case "updateProduct":
                $this->updateProduct($conn, $data->data->id, $data->data);
                break;
            case "getSale":
                $this->getSale($conn, $data->id);
                break;
            case "getPrice":
                $this->getPrice($conn, $data->id);
                break;
            case "saveSale":
                $this->saveSale($conn, $data->id, $data);
                break;
            default:
                echo "invalid_action";
        }
    }
}
$products = new Products;
$products->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
?>