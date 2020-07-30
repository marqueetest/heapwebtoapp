<?php



function find1(){
    $hostname = "localhost";
    $database = "rsites_heaplan_a";
    $username = "rsites_heaplan_a";
    $password = "M0cn@lp@3h!";

    $Conn_db = mysqli_connect($hostname, $username, $password,$database) or die(mysqli_error());
    mysqli_select_db($Conn_db, $database);

    for($i=0; $i<= 2500 ; $i++){

        $query = "SELECT * FROM `clients` WHERE id=$i";

        $res =mysqli_query($Conn_db,$query);
  
        $res_obj = mysqli_fetch_assoc($res);
        $id = $res_obj['id'];
        if($id){
            $password = $res_obj['password'];
            if($password != ''){
                $bc_password  = password_hash( $password, PASSWORD_DEFAULT);
                $update_query = "UPDATE `clients` SET `plain_password`='$bc_password'  WHERE id=$i";
    
                $update_res =mysqli_query($Conn_db,$update_query);
                $row = mysqli_affected_rows($Conn_db);
                    if ($row == 1) { 
                        print_r($i);
                    }else{
                        print_r("Not Updated");
                    }
            }
           
        }
    }
    

}

function find(){
    $hostname = "localhost";
    $database = "rsites_heaplan_a";
    $username = "rsites_heaplan_a";
    $password = "M0cn@lp@3h!";

    $Conn_db = mysqli_connect($hostname, $username, $password,$database) or die(mysqli_error());
    mysqli_select_db($Conn_db, $database);

        $query = "SELECT * FROM `clients` WHERE id=1992";

        $res =mysqli_query($Conn_db,$query);

        $res_obj = mysqli_fetch_assoc($res);
        $id = $res_obj['id'];
        if($id){
            $password1 = $res_obj['password'];
            $bc_password  = password_hash( $password1, PASSWORD_DEFAULT);
            $update_query = "UPDATE `clients` SET `plain_password`='$bc_password'  WHERE id= $id";

            $update_res =mysqli_query($Conn_db,$update_query);

            $row = mysqli_affected_rows($Conn_db);
                if ($row == 1) { 
                    print_r("Updated");
                }else{
                    print_r("Not Updated");
                }
        }

}




?>