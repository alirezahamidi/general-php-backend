
<?php
    // include '../config.php';
    
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Headers: client-token,request-type');
    
    // echo "hi";

if(isset($_POST["data"])){
    $data=$_POST["data"];
    $data=json_decode($data);

    $outData=array();
    $files = scandir(".");

    switch($data->type){
        case "thumb":
            foreach ($files as $file){
                $path_info = pathinfo($file);
                if($file!="." && $file!=".." && isset($path_info['extension']) && $path_info['extension']!="php" && strpos($file,"_thumb.jpg")!=null){
                    array_push($outData,$file);
                }
            }
        break;
        case "detiledList":
        foreach ($files as $file){
            $path_info = pathinfo($file);
            $temp=json_decode("{}");
            if($file!="." && $file!=".." && isset($path_info['extension']) && $path_info['extension']!="php" && strpos($file,"_thumb.jpg")==null){
                $temp->filename=$file;
                $temp->filesize=filesize("./".$file);
                if(file_exists("./".$file."_thumb.jpg")){
                    $temp->thumbnail=$file."_thumb.jpg";
                }

                array_push($outData,$temp);
            }
        }

        break;
    }

    echo json_encode($outData);
    return;
}else{
    $files1 = scandir(".");
    $outp=array();

    foreach ($files1 as $file){
        $path_info = pathinfo($file);
        if($file!="." && $file!=".." && isset($path_info['extension']) && $path_info['extension']!="php"){
            array_push($outp,$file);
        }
    }

    echo json_encode($outp);
    return;
}
?>
