<?php
class CommericalParts
{
    function __construct($config)
    {
        $this->mysql = new MySql($config->db->list->commerical, $config);
    }

    function addPart($data, $config)
    {
        $conn = $this->mysql->getConnection();
        $now = new DateTime("now");
        $query = $this->mysql->buildAddQuery("parts", ["title", "body", "keywords", "date", "createrid"], [$data->title, $data->body, $data->keywords, $now->format('Y-m-d H:i'), $data->createrid]);
        if ($conn->query($query) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $conn->error . "}";
        }
        return;
    }

    function editPart($data, $config)
    {
        $conn = $this->mysql->getConnection();
        $query = $this->mysql->buildEditQuery("parts", $data->id, ["title", "body", "keywords"], [$data->title, $data->body, $data->keywords]);

        if ($conn->query($query) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $conn->error . "}";
        }
        return;
    }

    function listAll($data, $ipp, $page, $config)
    {
        $conn = $this->mysql->getConnection();
        $query = $this->mysql->buildViewQuery("parts", $ipp, $page, null, null);

        $result = $conn->query($query);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;

        mysqli_free_result($result);

        $sql = "SELECT COUNT(1) FROM parts";
        $result = $conn->query($sql);

        while ($row = mysqli_fetch_assoc($result))
            $_count[] = $row;

        $data = json_decode("{}");
        if (isset($res)) {
            $data->parts = $res;
            if (isset($_count))
                $data->count = $_count[0];
            echo json_encode($data);
        } else {
            echo "no-data";
        }
    }

    function getPart($id, $config)
    {
        $conn = $this->mysql->getConnection();
        $query = $this->mysql->buildViewQuery("parts", null, null, ["id", "title", "body", "keywords", "date"], "id= '" . $id . "'");

        $result = $conn->query($query);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;


        $data = json_decode("{}");
        if (isset($res)) {
            $data->part = $res[0];
            echo json_encode($data);
        } else {
            echo "not-found";
        }
    }

    function deletePart($id, $config)
    {
        $conn = $this->mysql->getConnection();
        $query = $this->mysql->buildDeleteQuery("parts", ["id"], [$id]);


        if ($conn->query($query) === true) {
            echo "{\"state\":\"successfull\"}";
        } else {
            echo "{\"state\":" . "Error: " . $conn->error . "}";
        }
        return;
    }

    function renderParts($config)
    {
        $conn = $this->mysql->getConnection();
        $query = $this->mysql->buildViewQuery("parts", null, null, null, null);

        $result = $conn->query($query);

        while ($row = mysqli_fetch_assoc($result))
            $res[] = $row;


        $data = json_decode("{}");
        if (isset($res)) {
            $data->parts = $res;
            echo json_encode($data);
        } else {
            echo "no-data";
        }
    }

    function call_functions($name, $data, $config)
    {
        switch ($name) {
            case "listAll":
                if (isset($data) && isset($data->ipp) && isset($data->page)) {
                    $this->listAll($data, $data->ipp, $data->page, $config);
                } else {
                    die("invalid-parameters");
                }
                break;
            case "get":
                if (isset($data) && isset($data->id)) {
                    $this->getPart($data->id, $config);
                } else {
                    die("invalid-parameters");
                }
                break;
            case "add":
                if (isset($data) && isset($data->data)) {
                    $this->addPart($data->data, $config);
                } else {
                    die("invalid-parameters");
                }
                break;
            case "edit":
                if (isset($data) && isset($data->data)) {
                    $this->editPart($data->data, $config);
                } else {
                    die("invalid-parameters");
                }
                break;
            case "delete":
                if (isset($data) && isset($data->id)) {
                    $this->deletePart($data->id, $config);
                } else {
                    die("invalid-parameters");
                }
                break;
            case "render":
                $this->renderParts($config);
                break;
            default:
                die("invalid_action");
        }
    }
}
$login = new CommericalParts($config);
$login->call_functions($_POST["action"], json_decode($_POST["data"]), $config);
// echo json_encode($_POST);
