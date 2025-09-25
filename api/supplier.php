<?php
require_once('../conn.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "select * from supplier where id = $id";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 1){
            $supplier = mysqli_fetch_assoc($result);
            echo json_encode($supplier);
        } else{
            msg('not found',404);
        }

    }else{
        $query = 'select * from supplier';
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
            $suppliers = mysqli_fetch_all($result, MYSQLI_ASSOC);
            // var_dump($suppliers);
            echo json_encode($suppliers);
        } else{
            msg('not found',404);
        }
    }
    

} elseif($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_GET['id'])){
        // var_dump($_GET['id']);
        $id = $_GET['id'];
        $query = "select * from supplier where id = $id";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 1){
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $birth_date = $_POST['birth_date'];

            $query = "update supplier set name = '$name', phone = '$phone', email = '$email', birth_date = STR_TO_DATE('$birth_date', '%d/%m/%Y') where id = $id";
            $result = mysqli_query($conn, $query);
            
            if($result){
                msg('supplier updated succefully', 200);
            }else{
                msg('error, try again', 404);
            }
        }else{
            msg('supplier not found', 404);
        }

        
    }else{
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $birth_date = $_POST['birth_date'];

        $query = "insert into supplier (name, phone, email, birth_date)
            values ('$name', '$phone', '$email', STR_TO_DATE('$birth_date', '%d/%m/%Y'))";
        $result = mysqli_query($conn, $query);
        
        if($result){
            msg('supplier added succefully', 200);
        }else{
            msg('error, try again', 404);
        }
    }
}elseif($_SERVER['REQUEST_METHOD'] == 'DELETE'){

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "select * from supplier where id = $id";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 1){
            $query = "delete from supplier where id = $id";
            $result = mysqli_query($conn, $query);
            if($result){
                msg('supplier deleted successfully', 200);
            } else{
                msg('error', 403);
            }
        } else{
            msg('not found', 404);
        }
    }
    
}else{
    echo 'wrong method';
}