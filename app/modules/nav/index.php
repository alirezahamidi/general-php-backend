<?php
class Products
{
    function listAll($connection, $ipp, $page)
    {
        $sql = "SELECT * FROM products";

        $lim = "";
        if ($page - 1 > 0) $lim = (($page - 1) * $ipp) . ",";
        // $sqlQuery = "SELECT id,title,images FROM products LIMIT " . $lim . " " . $ipp;
        $sqlQuery = "SELECT id,title,images,price FROM products_categories UNION ";
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

    function call_functions($name, $data, $config)
    {
        $conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $config->db->list->shop);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($conn, "utf8");

        switch ($name) {
            case "getAll":
                $this->getAll($conn);
                break;
            default:
                echo "invalid_action";
        }
    }
}
$products = new Products;
$products->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
?>