<?php
class ProductsCategories
{
    /* function listAll($conn, $data)
    {
        $sql = "SELECT * FROM products_categories";

        if (!isset($data->type)) {
            die("not-allowed");
            return;
        }

        $menu_type;
        if ($data->type == "*")
            $menu_type = "";
        else
            $menu_type = "";

        if (isset($data->parent) && strlen($data->parent) > 0) {
            if ($data->type == "*" || strlen($data->type) == 0)
                $sqlQuery = "SELECT id,text,type,parent,enabled,options,key_ FROM products_categories  WHERE parent='" . $data->parent . "'";
            else
                $sqlQuery = "SELECT id,text,type,parent,enabled,options,key_ FROM products_categories  WHERE type='" . $data->type . "' AND parent='" . $data->parent . "'";

        } else {
            if ($data->type == "*" || strlen($data->type) == 0)
                $sqlQuery = "SELECT id,text,type,parent,enabled,options,key_ FROM products_categories";
            else
                $sqlQuery = "SELECT id,text,type,parent,enabled,options,key_ FROM products_categories  WHERE type='" . $data->type . "'";
        }
        
        // echo $sqlQuery;
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        $data_ = new \stdClass();
        if (isset($res))
            $data_->categories = $res;
        echo json_encode($data_);
    } */

    function getAll($conn, $config)
    {
        // $conn = new mysqli($config->server, $config->username, $config->password, $shopDBname);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        //     echo "failed";
        //     return;
        // }
        // mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM products_categories";

        $sqlQuery = "SELECT id,text,type,parent,enabled,options,key_,access_level FROM products_categories";

        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
        $res[] = $row;

        if (isset($res))
        return $res;
        else
        return "no-data";
    }

    function listAll($conn, $type, $parent, $config)
    {
        // $conn = new mysqli($config->server, $config->username, $config->password, $shopDBname);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        //     echo "failed";
        //     return;
        // }
        // mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM products_categories";


        if (isset($parent) && $parent != "") {
            $sqlQuery = "SELECT id,text,type,parent,enabled,options,key_,access_level FROM products_categories  WHERE type='" . $type . "' AND parent='" . $parent . "'";
        } else {
            $sqlQuery = "SELECT id,text,type,parent,enabled,options,key_,access_level FROM products_categories  WHERE type='" . $type . "'";
        }

        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
        $res[] = $row;

        if (isset($res))
        return json_encode($res);
        else
        return "no-data";
    }

    function allMenusList($conn, $config)
    {
        // $conn = new mysqli($config->server, $config->username, $config->password, $shopDBname);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        //     echo "failed";
        //     return;
        // }
        // mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM products_categories";


        
            $sqlQuery = "SELECT id,text,type,parent,enabled,options,key_,access_level FROM products_categories  WHERE type=''";
    

        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
        $res[] = $row;

        return $res;
    }

    function changeStatus($conn, $key_, $state, $config)
    {
        // $conn = new mysqli($config->server, $config->username, $config->password, $shopDBname);
        // // Check connection
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        // mysqli_set_charset($conn, "utf8");
        $sql = "UPDATE products_categories SET enabled='" . $state . "' WHERE key_='" . $key_ . "'";

        if ($conn->query($sql) === true) {
            $conn->close();
            return "successfull";
        } else {
            $conn->close();
            return "failed";
        }
    }

    function addNew($conn, $_data, $config)
    {
        // $conn = new mysqli($config->server, $config->username, $config->password, $shopDBname);

        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        // mysqli_set_charset($conn, "utf8");

        $sql = "INSERT INTO products_categories (text,type,parent,enabled,key_,access_level,options)
        VALUES ('" . $_data->text . "', '" . $_data->type . "', '" . $_data->parent . "','" . $_data->enabled . "','" . $_data->key_ . "','" . $_data->access_level . "','')";


        if ($conn->query($sql) === true) {
            $conn->close();
            return "successfull";
        } else {
            $conn->close();
            return "failed";
        }
    }

    function edit($conn, $id, $_data, $config)
    {
        // $conn = new mysqli($config->server, $config->username, $config->password, $shopDBname);

        // if (!isset($id)) return "no-data";

        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        // mysqli_set_charset($conn, "utf8");

        $sql = "UPDATE products_categories SET text = '" . $_data->text . "', type = '" . $_data->type . "' , parent = '" . $_data->parent . "', enabled = '" . $_data->enabled . "', key_ = '" . $_data->key_ . "',access_level = '" . $_data->access_level . "' WHERE id='" . $id . "'";


        if ($conn->query($sql) === true) {
            $conn->close();
            return "successfull";
        } else {
            $conn->close();
            return "failed";
        }
    }

    function delete($conn, $id, $config)
    {
        // $conn = new mysqli($config->server, $config->username, $config->password, $shopDBname);

        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        // mysqli_set_charset($conn, "utf8");

        $sql = "DELETE FROM products_categories WHERE id='" . $id . "'";


        if ($conn->query($sql) === true) {
            $conn->close();
            return "successfull";
        } else {
            $conn->close();
            return "failed";
        }
    }

    function getCateory($conn, $id, $config)
    {
        // $conn = new mysqli($config->server, $config->username, $config->password, $shopDBname);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        //     echo "failed";
        //     return;
        // }
        // mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM products_categories";

        $sqlQuery = "SELECT id,text,type,parent,enabled,options,key_,access_level FROM products_categories WHERE id='" . $id . "'";
        $result = $conn->query($sqlQuery);

        while ($row = mysqli_fetch_assoc($result))
        $res[] = $row;

        if (isset($res))
        return $res[0];
        else
        return "no-data";
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
                // case "listAll":
                //     $this->listAll($conn, $data);
                //     break;
            case "changeStatus":
                echo $this->changeStatus($conn, $data->key_, $data->state, $config);
                break;
            case "addNew":
                echo $this->addNew($conn, $data->data, $config);
                break;
            case "edit":
                echo $this->edit($conn, $data->id, $data->data, $config);
                break;
            case "delete":
                echo $this->delete($conn, $data->id, $config);
                break;
            case "listAll":
                echo $this->listAll($conn, $data->type, $data->parent, $config);
                break;
            case "getAll":
                echo json_encode($this->getAll($conn, $config));
                break;
            case "allMenusList":
                echo json_encode($this->allMenusList($conn, $config));
                break;
            case "getCateory":
                echo json_encode($this->getCateory($conn, $data->id, $config));
                break;
            default:
                echo "invalid_action";
        }
    }
}
$products_categories = new ProductsCategories;
$products_categories->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
 