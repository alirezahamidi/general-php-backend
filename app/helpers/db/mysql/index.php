<?php
class MySql extends mysqli
{
    var $conn;
    function __construct($dbName, $config)
    {
        $this->conn;
        $this->conn = new mysqli($config->db->server, $config->db->username, $config->db->password, $dbName);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        mysqli_set_charset($this->conn, "utf8");

        // echo "In BaseClass constructor\n";
    }

    function getConnection()
    {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } else
            return $this->conn;
    }

    function buildViewQuery($tableName, $itemPerPage, $page, $fields, $condition)
    {
        $query = "SELECT ";
        if (isset($fields)) {
            foreach ($fields as $field) {
                $query = $query . $field;
                if (array_search($field, $fields) < count($fields) - 1) {
                    $query = $query . ",";
                }
            }
        } else {
            $query = $query . "* ";
        }
        $query = $query . " FROM " . $tableName . " ";
        if (isset($condition)) {
            $query = $query . "WHERE " . $condition;
        }

        if (isset($itemPerPage) && isset($page)) {
            $lim = "";
            if ($page - 1 > 0) $lim = (($page - 1) * $itemPerPage) . ",";
            $query = $query . " LIMIT " . $lim . " " . $itemPerPage;
        }
        return $query;
    }

    function buildAddQuery($tableName, $params, $values)
    {
        $query = "INSERT INTO " . $tableName . " (";

        for ($i = 0; $i < count($params); $i++) {
            $query = $query . $params[$i];
            if ($i < count($params) - 1) {
                $query = $query . ",";
            }
        }

        $query = $query . ") VALUES (";

        for ($i = 0; $i < count($values); $i++) {
            $query = $query . "'" .  $values[$i] . "'";
            if ($i < count($values) - 1) {
                $query = $query . ",";
            }
        }
        $query = $query . ")";
        return $query;
    }

    function buildDeleteQuery($tableName, $params, $values)
    {

        $query = "DELETE FROM " . $tableName . " WHERE ";
        for ($i = 0; $i < count($params); $i++) {
            $query = $query . $params[$i] . "=" . $values[$i];
            if ($i < count($params) - 1) {
                $query = $query . " AND ";
            }
        }

        return $query;
    }

    function buildEditQuery($tableName, $id, $params, $values)
    {
        $query = "UPDATE " . $tableName . " SET ";
        for ($i = 0; $i < count($params); $i++) {
            $query = $query . $params[$i] . "='" . $values[$i] . "'";
            if ($i < count($params) - 1) {
                $query = $query . " , ";
            }
        }
        $query = $query . " WHERE id='" . $id . "'";

        return $query;
    }

    /* function query($sqlQuery,$callback,$extraData)
    {
        // echo "<p></p>";
        // echo $sqlQuery;
        // echo "<p></p>";
        $results = $this->conn->query($sqlQuery);

        if ($results) {
            while ($row = mysqli_fetch_assoc($results)) {
                $res[] = $row;
            }


                echo "<p></p>";
                echo json_encode($res);
                echo "<p></p>";
                echo json_encode(isset($res));
                echo "<p></p>";

            if (isset($res))
                $callback($res,$extraData);
            else
                $callback(null,$extraData);
        } else {
            $callback(null,$extraData);
        }
    } */

    function error()
    {
        return $this->conn->error;
    }
}
