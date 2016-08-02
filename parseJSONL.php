<?php
    $finalstr = '{ "extractorData" : {';

    function searchOBJ($name,$obj,$isArr){
        global $finalstr;
        if(is_object($obj)){
            foreach ($obj as $key => $value) {
                //echo $name." ---- ".$key." --- foundOBJ</br>";
                searchOBJ($key,$value,false);
            }
        }else{
            if(is_array($obj)){
                foreach ($obj as $key => $value) {
                    //echo $name." --- foundArray</br>";
                    searchOBJ($key,$value,true);
                }
            }else{
                if($isArr){

                }
                echo  $name." ---- ".$obj." --- value</br>";
                $finalstr = $finalstr. '"'.$name.'"\:"'.$obj.'",';
                //aToFile($name,$obj);
            }
        }
    }



    $myfile = fopen("io.jsonl", "r") or die("Unable to open file!");
    $jLine = fread($myfile,filesize("io.jsonl"));
    $fullObj = json_decode($jLine);
    foreach ($fullObj as $key => $value) {
        searchOBJ($key,$value,false);
    }
    fclose($myfile);
    echo "DONE</br>";
    $finalstr = str_replace('\\','',$finalstr);
    $finalstr = trim($finalstr, ",");
    $finalstr = $finalstr."}}";
    echo $finalstr;
    $myfile = fopen("io.json", "w");
    fwrite($myfile, $finalstr);
    fclose($myfile);




?>
