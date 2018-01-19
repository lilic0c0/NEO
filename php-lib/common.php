<?php
function remove_utf8_bom($str){

        $bom = pack("CCC", 0xef, 0xbb, 0xbf);
        if (0 === strncmp($str, $bom, 3)) {
                //echo "BOM detected - file is UTF-8\n";
                $str = substr($str, 3);
        }
        return $str;
}

function p_n_2_index2d($input)
{
        $m=count($input);
        for($i=0;$i<$m;$i++)
        {
                for($j=0;$j<$m;$j++)
                {
                        if($i!=$j){
                                $output[$input[$i]][$input[$j]]=0;
                        }
                }
        }
        return ($output);
}
function p_n_2_pair($input)
{
    $m=count($input);
    for($i=0;$i<$m;$i++)
    {
        for($j=0;$j<$m;$j++)
        {
            if($i!=$j){
                $output[]=array($input[$i],$input[$j]);
            }
        }
    }
    return ($output);
}
/*
function get_vertices_from_graph($graph_array){
    $vertices = array();
    foreach ($graph_array as $edge) {
        //把所有點加入$vertices
        array_push($vertices, $edge[0], $edge[1]);
        //紀錄點的所有連接點及權值
        $neighbours[$edge[0]][] = array("name" => $edge[1], "cost" => $edge[2]);
        //若加入相反邊，則是無向圖
        //$neighbours[$edge[1]][] = array("end" => $edge[0], "cost" => $edge[2]);
    }
    //把重複的點剃除
    $vertices = array_unique($vertices);
    return array_values($vertices);

}*/
function get_vertices_from_graph($graph_array){
        $vertices = array();
        foreach ($graph_array as $edge) {
                array_push($vertices, $edge[0], $edge[1]);
        }
        $vertices = array_unique($vertices);
        return array_values($vertices);
}

function get_vertices_all_pairs($pair_array){
    $vertices = array();
    foreach ($pair_array as $edge) {
        array_push($vertices, $edge['source'], $edge['target']);
    }
    $vertices = array_unique($vertices);
    return array_values($vertices);

}
?>
