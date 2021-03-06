<?php

include "./connect.php";
include "./resources.php";


$mainTbl = 'allsites_wm';
$mainTbl = 'allsites';

/*echo "Enter Chart name: ";
$cli = fopen("php://stdin", "r");
$tblname = fgets($cli);
$tblname = trim($tblname);

$gettable = mysqli_query($conn, "show tables like '$tblname'");
*/
//if (mysqli_num_rows($gettable) > 0) {
        //$rows_arr = getRowsArr($tblname, $conn);
        $gettbl_qry = "select name from tbl_columns where id in (99,100) order by id ";
        $gettbl_res = mysqli_query($conn,$gettbl_qry) or die("Cannot get table name -- ".mysqli_error($conn));
        while($row = mysqli_fetch_row($gettbl_res)){
            echo $row[0]."\n";
            
            $tblname = $row[0];
            echo "Deleting table....";
            //sleep(1);
            mysqli_query($conn,"drop table IF EXISTS $tblname") or die ("Cannot delete table -- ".mysqli_error($conn));
            $tblname_percent = substr($tblname,0,(strlen($tblname)-1))."b";
            mysqli_query($conn,"drop table IF EXISTS $tblname_percent") or die ("Cannot delete table -- ".mysqli_error($conn)); 
    
            $rows_arr = getRowsArr($tblname, $conn);
            $first_col_name = getFirstColName($tblname, $conn);
            create_table($tblname, $rows_arr, $first_col_name, $conn);
            $tblname_percent = substr($tblname,0,(strlen($tblname)-1))."b";
            mysqli_query($conn,"CREATE TABLE $tblname_percent LIKE $tblname") or die("Cannot create new percent table -- ".mysqli_error($conn));
            mysqli_query($conn,"INSERT $tblname_percent SELECT * FROM $tblname") or die("Cannot insert in new percent table -- ".mysqli_error($conn));


            $qry_index = getQuery($tblname, $conn);
            $site = getSite($tblname,$conn);
            $col_names = getTableHeaders($tblname, $conn);

            switch ($tblname) {
                case '1a';
                case '2a';
                case '3a';
                case '4a';
                case '5a';
                case '6a';
                    call_user_func_array("tab_1_2", array($conn, $tblname,$tblname_percent,$first_col_name, $rows_arr, $col_names, $qry_index));
                    break;
                case '7a';
                case '8a';case '9a';
                case '10a';case '11a';
                case '12a';case '13a';
                case '14a';case '15a';
                case '16a';case '17a';case '18a'; case '19a';case '20a'; case '21a';case '22a';case '23a';case '24a';case '25a';case '26a';case '27a';
                case '28a';case '29a';case '30a';case '31a';case '32a';case '33a';case '34a';case '35a';case '36a';case '37a';case '38a';case '39a';
                case '40a';case '41a';case '42a';case '43a';case '44a';case '45a';case '46a';case '47a';case '48a';case '49a';case '50a';case '51a';
                case '52a';case '53a';case '54a';case '55a';case '56a';case '57a';case '58a';case '59a';case '60a';case '61a';case '62a';case '63a';
                case '64a';case '65a';case '66a';case '67a';case '68a';case '69a';case '70a';case '71a';case '72a';case '73a';case '74a';case '75a';
                case '76a';case '77a';case '78a';case '79a';case '80a';case '81a';case '82a';case '83a';case '84a';case '85a';case '86a';
                    call_user_func_array("tab_3_4", array($conn, $tblname,$tblname_percent,$first_col_name, $rows_arr, $col_names, $qry_index, $site));
                break;
                case '95a';case '96a';case '97a';case '98a';
                    call_user_func_array("tab_ep", array($conn, $tblname,$tblname_percent,$first_col_name, $rows_arr, $col_names, $qry_index, $site));
                break;
                case '99a'; case '100a';case '101a';case '102a';
                    call_user_func_array("tab_ep_sp",array($conn, $tblname,$tblname_percent,$first_col_name, $rows_arr, $col_names, $qry_index, $site));
                break;
                case '103a';case '104a';
                    call_user_func_array("tab_tnm_ep",array($conn, $tblname,$tblname_percent,$first_col_name, $rows_arr, $col_names, $qry_index, $site));
                break;
                default:
                    break;
            }
        
        }

function tab_tnm_ep($conn, $tblname,$tblname_percent,$first_col_name,$rows_arr, $col_names, $qry_index){
    global $mainTbl;
    $allsites_tnm_hdrs = ['T','N','M','ajcc'];
    $t_arr = ['t1','t2','t3','t4','tx','t0'];
    $n_arr = ['N1a','N1b','N1NO','N0','Nx'];
    $m_arr = ['M1','M0','Mx'];
    $ajcc_arr = ['I','II','III','IV'];
    $tnmajcc_vals = ['t1','t2','t3','t4','tx','t0','N1a','N1b','N1NO','N0','Nx','M1','M0','Mx','I','II','III','IV'];
    
    switch ($col_names){
        case 'tnm_ep':
            $tbl_hdrs = $allsites_tnm_hdrs;
            break;
        default:
            break;
    }
    for ($i = 0; $i < count($rows_arr); $i++) {
        
        $row_vals = [];
        echo "-->printing row_vals:\n";
        print_r($row_vals);
        $total = 0;

        for($j = 0; $j < count($tbl_hdrs); $j++) {
            $idx = 0;
            //echo "\n j : ".$tbl_hdrs[$j]."\n";
            switch ($tbl_hdrs[$j]) {
                case 'T':
                    $arr = $t_arr;
                    break;
                case 'N':
                    $arr = $n_arr;
                    break;
                case 'M':
                    $arr = $m_arr;
                    break;
                case 'ajcc':
                    $arr = $ajcc_arr;
                    break;
                default:
                    break;
            }
            echo "-->printing arr:\n";
            print_r($arr);
                $cols_counts = [];
                echo "-->printing cols_counts before entering the inner loop:\n";
                print_r($cols_counts);
                for($k = 0;$k < count($arr);$k++){
                    $qry_arr[0] = "select * from $mainTbl where `year_of_dx` = '$rows_arr[$i]' and `$tbl_hdrs[$j]` ='$arr[$k]' and `histology` in('Papillary','Follicular','Poorly different') and `sex` != ''";
                    $qry_arr[1] = "select * from $mainTbl where `Site` = '$rows_arr[$i]' and `$tbl_hdrs[$j]` ='$arr[$k]' and `histology` in('Papillary','Follicular','Poorly different') and `sex` != ''";
                    $r = mysqli_query($conn, $qry_arr[$qry_index]) or die("Cannot get count -- " . mysqli_error($conn));
                    $num_rows = mysqli_num_rows($r);
                    //echo "number is: ".$num_rows." | ";
                    $num_arr[$idx] = $num_rows;
                    array_push($cols_counts,$num_rows);
                    $total = $total + $num_arr[$idx];
                    $idx++;
                }
                echo "-->printing cols_counts:\n";
                print_r($cols_counts);
                if(count($row_vals) == 0){
                    echo "===row_vals is 0\n";
                    $row_vals = $cols_counts;
                }
                else{
                    echo "===row_vals has values\n";
                    $row_vals = array_merge($row_vals,$cols_counts);
                }
                echo "-->printing row_vals again: \n";
                print_r($row_vals);
                
                $num_arr[$idx++] = $total;

            }

            echo "length of row_vals : ".count($row_vals)."\n";
            
            $idx2 = 0;
                foreach ($tnmajcc_vals as $cname) {
                    echo "Updating: ".$cname."\n";
                    $q_u = "update `$tblname` set $cname = '".$row_vals[$idx2]."' where $first_col_name = '".$rows_arr[$i]."'";
                    $r_u = mysqli_query($conn, $q_u) or die("Cannot Update -- \n" . mysqli_error($conn));
                    $idx2++;
                }

        $idx3 = 0;
        foreach ($tnmajcc_vals as $cname) {
            if($cname != 'total' && $total != 0){
                //echo "Numarr is: " . round(($all_cols[$idx3]/$total)*100,2) . " | ";  
                mysqli_query($conn,"update `$tblname_percent` set `$cname` = '" .round(($row_vals[$idx3]/$total)*100,2). "' where $first_col_name = '" . $rows_arr[$i] . "'") 
                or die("Cannot update percent table -- ".mysqli_error($conn));  
                $idx3++;
            }
        }
        echo "\n";
    }

}

function tab_ep_sp($conn, $tblname,$tblname_percent,$first_col_name,$rows_arr, $col_names, $qry_index)
{
    global $mainTbl;
    $surg_vals = ['total_thx','completion','hemi','central_nd','lateral_nd','mediastinal_nd'];
    //$path_vals = ['pcfv','pav','pnv','fcv','fhcv','fnv','pda'];
    $path_vals = ['pcv','pfv','pav','pnv','fcv','fhcv','fnv','pda'];
    $tbl_hdrs = [];
    switch ($col_names) {
        case 'surg':
            $tbl_hdrs = $surg_vals;
            break;
        case 'path':
            $tbl_hdrs = $path_vals;
        default:
            break;
    }
    

    for ($i = 0; $i < count($rows_arr); $i++) {
        $idx = 0;
        $total = 0;
        for($j = 0; $j < count($tbl_hdrs); $j++) {
                $qry_arr[0] = "select * from $mainTbl where `year_of_dx` = '$rows_arr[$i]' and histology in ('Papillary','Follicular','Poorly different') and `$tbl_hdrs[$j]` = 'yes' and sex != '' ";
                $qry_arr[1] = "select * from $mainTbl where `site` = '$rows_arr[$i]' and histology in ('Papillary','Follicular','Poorly different') and `$tbl_hdrs[$j]` = 'yes' and sex != '' ";
                $qry_arr[2] = "select * from $mainTbl where `year_of_dx` = '$rows_arr[$i]' and histology in ('Papillary','Follicular','Poorly different') and $tbl_hdrs[$j] = 'yes' and sex != ''";
                $qry_arr[3] = "select * from $mainTbl where `site` = '$rows_arr[$i]' and histology in ('Papillary','Follicular','Poorly different') and $tbl_hdrs[$j] = 'yes' and sex != ''";
                $qry_arr[4] = "select * from $mainTbl where `year_of_dx` = '$rows_arr[$i]' and $tbl_hdrs[$j] = 'yes'";
                $r = mysqli_query($conn, $qry_arr[$qry_index]) or die("Cannot get count -- " . mysqli_error($conn));
                $num_rows = mysqli_num_rows($r);
                echo "i = ".$idx." --> ".$num_rows." | ";
                $num_arr[$idx] = $num_rows;
                $total = $total + $num_arr[$idx];
                $idx++;
            }
            echo "\n";
        
        

        $num_arr[$idx++] = $total;
        $idx2 = 0;
        foreach ($tbl_hdrs as $cname) {
            $q_u = "update `$tblname` set $cname = '" . $num_arr[$idx2] . "' where $first_col_name = '" . $rows_arr[$i] . "'";
            $r_u = mysqli_query($conn, $q_u) or die("Cannot Update -- \n" . mysqli_error($conn));
            $idx2++;
        }

        $idx3 = 0;
        foreach ($tbl_hdrs as $cname) {
            if($cname != 'total' && $total != 0){
                //echo "Numarr is: " . round(($num_arr[$idx3]/$total)*100,2) . " | ";  
                mysqli_query($conn,"update `$tblname_percent` set `$cname` = '" .round(($num_arr[$idx3]/$total)*100,2). "' where $first_col_name = '" . $rows_arr[$i] . "'") 
                or die("Cannot update percent table -- ".mysqli_error($conn));  
                $idx3++;
            }
        }
        echo "\n";
    }
}  


function tab_1_2($conn, $tblname,$tblname_percent,$first_col_name, $rows_arr, $col_names, $qry_index)
{
    global $t_arr, $n_arr, $n1, $n0x,$mainTbl;;

    for ($i = 0; $i < count($rows_arr); $i++) {
        $idx = 0;
        $total = 0;
        foreach ($col_names as $col_val) {
            if($col_val != "total"){
                $tn_val = getTValue($col_val);
                //echo "t_val is : " . $tn_val[0] . "\n";
                //echo "n_val is : " . $tn_val[1] . "\n";
                //echo "n_val is : " . $tn_val[2] . "\n";
                $qry_arr[0] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = '$tn_val[0]' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'$tn_val[1]') and M != 'M1'";
                $qry_arr[1] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = '$tn_val[0]' and isRAI = 'yes' and dose != 0 and FIND_IN_SET(N,'$tn_val[1]') and M != 'M1'";
                $qry_arr[2] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = '$tn_val[0]' and isRAI = 'yes' and dose != 0 and FIND_IN_SET(N,'$tn_val[1]') and treatment = '$tn_val[2]' and M != 'M1'";
                $qry_arr[3] = "select * from $mainTbl where `Site`= '$rows_arr[$i]' and T = '$tn_val[0]' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'$tn_val[1]') and M != 'M1'";
                $qry_arr[4] = "select * from $mainTbl where `Site` = '$rows_arr[$i]' and T = '$tn_val[0]' and isRAI = 'yes' and dose != 0 and FIND_IN_SET(N,'$tn_val[1]') and M != 'M1'";
                $qry_arr[5] = "select * from $mainTbl where `Site` = '$rows_arr[$i]' and T = '$tn_val[0]' and isRAI = 'yes' and dose != 0 and FIND_IN_SET(N,'$tn_val[1]') and treatment = '$tn_val[2]' and M != 'M1'";
                $r = mysqli_query($conn, $qry_arr[$qry_index]) or die("Cannot get count -- " . mysqli_error($conn));
                $num_rows = mysqli_num_rows($r);
                /*while ($row = mysqli_fetch_row($r)){
                    $qi = "insert into pid_x_tbl (patientID) values('$row[0]')";
                    $ri = mysqli_query($conn,$qi) or die("cannot insert into pid_x_tbl -- ".mysqli_error($conn));
                }*/
                echo "i: -- ".$idx.": ".$num_rows." | ";
                $num_arr[$idx] = $num_rows;
                $total = $total + $num_arr[$idx];
                $idx++;
            }
        }
        echo "\n";

        $num_arr[$idx++] = $total;

        $idx2 = 0;
        foreach ($col_names as $cname) {
            $q_u = "update `$tblname` set $cname = '" . $num_arr[$idx2] . "' where $first_col_name = '" . $rows_arr[$i] . "'";
            $r_u = mysqli_query($conn, $q_u) or die("Cannot Update -- \n" . mysqli_error($conn));
            $idx2++;
        }

        $idx3 = 0;
        foreach ($col_names as $cname) {
            if($cname != 'total' && $total != 0){
                //echo "Numarr is: " . round(($num_arr[$idx3]/$total)*100,2) . " | ";  
                mysqli_query($conn,"update `$tblname_percent` set `$cname` = '" .round(($num_arr[$idx3]/$total)*100,2). "' where $first_col_name = '" . $rows_arr[$i] . "'") 
                or die("Cannot update percent table -- ".mysqli_error($conn));  
                $idx3++;
            }
        }
        echo "\n";
    }
}

function tab_3_4($conn, $tblname,$tblname_percent,$first_col_name, $rows_arr, $col_names, $qry_index, $site)
{
    global $t_arr, $n_arr, $n1, $n0x, $dose_range,$mainTbl;
    $dose_keys = array_keys($dose_range);
 
    for ($i = 0; $i < count($rows_arr); $i++) {
        $idx = 0;
        $total = 0;
        for ($j = 0; $j < count($dose_range) ; $j++) {
            switch ($j) {
                case '0':
                    $lower_range = $dose_range[$dose_keys[$j]] - .31;
                    $upper_range = ($dose_range[$dose_keys[$j + 1]] + $dose_range[$dose_keys[$j]]) / 2;
                    echo "Lower is: $lower_range  And Upper: $upper_range \n";
                    break;
                case count($dose_range) -1:
                    $upper_range = $dose_range[$dose_keys[$j]] + 5;
                    $lower_range = ($dose_range[$dose_keys[$j - 1]] + $dose_range[$dose_keys[$j]]) / 2;
                    echo "Lower is: $lower_range  And Upper: $upper_range \n";
                    break;
                default:
                    $upper_range = ($dose_range[$dose_keys[$j + 1]] + $dose_range[$dose_keys[$j]]) / 2;
                    $lower_range = ($dose_range[$dose_keys[$j - 1]] + $dose_range[$dose_keys[$j]]) / 2;
                    echo "Lower is: $lower_range  And Upper: $upper_range \n";
                    break;
            }
            //tab3
            $qry_arr[0] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = 'T1' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[1] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = 'T1' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[2] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = 'T2' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[3] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = 'T2' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[4] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = 'T3' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[5] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = 'T3' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[6] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = 'T4' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[7] = "select * from $mainTbl where year_of_dx = $rows_arr[$i] and T = 'T4' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            //tab4
            $qry_arr[8] = "select * from $mainTbl where Site = '$rows_arr[$i]' and T = 'T1' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[9] = "select * from $mainTbl where Site = '$rows_arr[$i]' and T = 'T1' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[10] = "select * from $mainTbl where Site = '$rows_arr[$i]' and T = 'T2' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[11] = "select * from $mainTbl where Site = '$rows_arr[$i]' and T = 'T2' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[12] = "select * from $mainTbl where Site = '$rows_arr[$i]' and T = 'T3' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[13] = "select * from $mainTbl where Site = '$rows_arr[$i]' and T = 'T3' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[14] = "select * from $mainTbl where Site = '$rows_arr[$i]' and T = 'T4' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[15] = "select * from $mainTbl where Site = '$rows_arr[$i]' and T = 'T4' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            //23a --> qry_var = 16;
            $qry_arr[16] = "select * from $mainTbl where year_of_dx = '$rows_arr[$i]' and Site = '$site' and T = 'T1' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[17] = "select * from $mainTbl where year_of_dx = '$rows_arr[$i]' and Site = '$site' and T = 'T1' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[18] = "select * from $mainTbl where year_of_dx = '$rows_arr[$i]' and Site = '$site' and T = 'T2' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[19] = "select * from $mainTbl where year_of_dx = '$rows_arr[$i]' and Site = '$site' and T = 'T2' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[20] = "select * from $mainTbl where year_of_dx = '$rows_arr[$i]' and Site = '$site' and T = 'T3' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[21] = "select * from $mainTbl where year_of_dx = '$rows_arr[$i]' and Site = '$site' and T = 'T3' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[22] = "select * from $mainTbl where year_of_dx = '$rows_arr[$i]' and Site = '$site' and T = 'T4' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N1a,N1b') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $qry_arr[23] = "select * from $mainTbl where year_of_dx = '$rows_arr[$i]' and Site = '$site' and T = 'T4' and histology in ('Papillary','Follicular') and FIND_IN_SET(N,'N0,Nx') and M != 'M1' and isRAI = 'yes' and dose between $lower_range and $upper_range";
            $r = mysqli_query($conn, $qry_arr[$qry_index]) or die("Cannot get count -- " . mysqli_error($conn));
            $num_rows = mysqli_num_rows($r);
            //echo "i: -- " . $idx . ": " . $num_rows . "\n";
            $num_arr[$idx] = $num_rows;  
            $idx++;
        }

        $idx2 = 0;
        foreach ($col_names as $cname) {
            echo "Numarr is: " . $num_arr[$idx2] . " | ";
            $q_u = "update `$tblname` set `$cname` = '" . $num_arr[$idx2] . "' where $first_col_name = '" . $rows_arr[$i] . "'";
            $r_u = mysqli_query($conn, $q_u) or die("Cannot Update -- \n" . mysqli_error($conn));
            $idx2++;
        }
        //calculate total across columns and store in total
        $total = array_sum($num_arr);
        //store total in table's last column
        mysqli_query($conn,"update `$tblname` set `total` = '$total' where $first_col_name = '".$rows_arr[$i]."'") or die("Cannot update total -- ".mysqli_error($conn));
        echo "Total: ".$total."\n";

        $idx3 = 0;
        foreach ($col_names as $cname) {
            if($cname != 'total'){
                if($total > 0){  
                    echo "Numarr is: " . round(($num_arr[$idx3]/$total)*100,2) . " | ";  
                    mysqli_query($conn,"update `$tblname_percent` set `$cname` = '" .round(($num_arr[$idx3]/$total)*100,2). "' where $first_col_name = '" . $rows_arr[$i] . "'") 
                    or die("Cannot update percent table -- ".mysqli_error($conn));
                }
                else
                    echo "Total is ZERO \n";
                $idx3++;
            }
        }
        echo "\n";
    }      
}

function tab_ep($conn, $tblname,$tblname_percent,$first_col_name, $rows_arr, $col_names, $qry_index)
{
    global $mainTbl;
    $sex = ['male','female'];
    $age_group = ['1','2','3','4','5','6'];


    for ($i = 0; $i < count($rows_arr); $i++) {
        $idx = 0;
        $total = 0;
        for($j = 0; $j < count($age_group); $j++) {
            for($k = 0; $k < count($sex); $k++){
           

                $qry_arr[0] = "select * from $mainTbl where `year_of_dx` = $rows_arr[$i] and histology in ('Papillary','Follicular','Poorly different') and sex = '$sex[$k]' and age_group = '$age_group[$j]' ";
                $qry_arr[1] = "select * from $mainTbl where `year_of_dx` = $rows_arr[$i] and histology in ('Papillary','Follicular')  and isRAI = 'yes' and sex = '$sex[$k]' and age_group = '$age_group[$j]' ";
                $qry_arr[2] = "select * from $mainTbl where `Site` = '$rows_arr[$i]' and histology in ('Papillary','Follicular','Poorly different') and sex = '$sex[$k]' and age_group = '$age_group[$j]' ";
                $qry_arr[3] = "select * from $mainTbl where `Site` = '$rows_arr[$i]' and histology in ('Papillary','Follicular') and isRAI = 'yes' and sex = '$sex[$k]' and age_group = '$age_group[$j]' ";
                $r = mysqli_query($conn, $qry_arr[$qry_index]) or die("Cannot get count -- " . mysqli_error($conn));
                $num_rows = mysqli_num_rows($r);
                echo "i: -- ".$idx.": ".$num_rows." | ";
                $num_arr[$idx] = $num_rows;
                $total = $total + $num_arr[$idx];
                $idx++;
            }
        }
        echo "\n";

        $num_arr[$idx++] = $total;

        $idx2 = 0;
        foreach ($col_names as $cname) {
            $q_u = "update `$tblname` set $cname = '" . $num_arr[$idx2] . "' where $first_col_name = '" . $rows_arr[$i] . "'";
            $r_u = mysqli_query($conn, $q_u) or die("Cannot Update -- \n" . mysqli_error($conn));
            $idx2++;
        }

        $idx3 = 0;
        foreach ($col_names as $cname) {
            if($cname != 'total' && $total != 0){
                //echo "Numarr is: " . round(($num_arr[$idx3]/$total)*100,2) . " | ";  
                mysqli_query($conn,"update `$tblname_percent` set `$cname` = '" .round(($num_arr[$idx3]/$total)*100,2). "' where $first_col_name = '" . $rows_arr[$i] . "'") 
                or die("Cannot update percent table -- ".mysqli_error($conn));  
                $idx3++;
            }
        }
        echo "\n";
    }
}



?>