<?php

   $Name =  $_POST["Name"];
   $dob =  $_POST["dob"];
   $Gender =  $_POST["Gender"];
   $telephone =  $_POST["telephone"];
   $email =  $_POST["email"];
   $occ = $_POST["occ"];
   $Valid_id = $_POST["Valid_id"];
   $pat_id = $_POST["pat_id"];

    if( !empty($Name) || !empty($dob) || !empty($Gender) || !empty($telephone) || !empty($email) || !empty($occ) || !empty($Valid_id) || !empty( $pat_id) ){
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "patient_details";

        $conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);

        if(mysqli_connect_error()){
            die('Connect error('.mysqli_connect_error().')'.mysqli_connect_error());
        }else{
            $SELECT = " SELECT email From patient where email = ? Limit 1 ";
            $INSERT = " INSERT Into patient (Name,dob,Gender,telephone,email,occ,Valid_id,pat_id) values(?,?,?,?,?,?,?,?)";

            $stmt = $conn -> prepare($SELECT);
            $stmt -> bind_param("s",$email);
            $stmt -> execute();
            $stmt -> bind_result($email);
            $stmt ->store_result();
            $rnum = $stmt ->num_rows;

            if($rnum == 0){
                $stmt ->close();

                $stmt = $conn->prepare($INSERT);
                $stmt -> bind_param("sisissii",$Name,$dob,$Gender,$telephone,$email ,$occ ,$Valid_id,$pat_id );
                $stmt->execute();
                echo "New Record inserted Successfully";
            }else{
                echo "Someone is already registered with this email";
            }
            $stmt->close();
            $conn->close();
         }
    }
    else{
        echo "All Fields are Required";
        die();
    }
?>