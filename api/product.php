<?php
require_once('../conn.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(!empty($_POST)){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $query = "select * from products where id = $id";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) == 1){
                $product_tobe_updated = mysqli_fetch_assoc($result);
                $data = [];
                foreach($_POST as $key => $value){
                    $data[] = "$key = '$value'";
                }

                if(isset($_FILES['img'])){
                    $location = 'images';
                    $img = $_FILES['img'];
                    $img_name = $img['name'];
                    $img_size = $img['size'];
                    $img_extension = pathinfo($img['full_path'])['extension'];
                    $img_tmp_name = $img['tmp_name'];

                    $new_name = uniqid().".".$img_extension;
                    move_uploaded_file($img_tmp_name, $location.'/'.$new_name);
                    $img = $location.'/'.$new_name;
                    $data[] = "image = '$img'";
                }

                if(isset($product_tobe_updated['image'])){
                    unlink($product_tobe_updated['image']);
                }
                
                $subquery = implode(' ,', $data);
                $query = "update products set ".$subquery." where id = $id";
                // echo json_encode($query);
                $result = mysqli_query($conn, $query);

                

                if($result){
                    msg('product updated successfully', 200);
                }else{
                    msg('error', 403);
                }


            }else{
                msg('product not found', 403);
            }

        }
        else{
            $keys = []; $values = [];
            foreach($_POST as $key => $value){
                $keys[] = $key;
                $values[] = "'$value'";
            }

            if(isset($_FILES['img'])){
                $location = 'images';
                $img = $_FILES['img'];
                $img_name = $img['name'];
                $img_size = $img['size'];
                $img_extension = pathinfo($img['full_path'])['extension'];
                $img_tmp_name = $img['tmp_name'];

                $new_name = uniqid().".".$img_extension;
                move_uploaded_file($img_tmp_name, $location.'/'.$new_name);
                $img = $location.'/'.$new_name;
                $keys[] = " image";
                $values[] = "'$img'";
            }

            $keys = implode(' ,', $keys);
            $values = implode(' ,', $values);
            $query = "insert into products ($keys) values ($values)";
            // echo json_encode($query);

            $result = mysqli_query($conn, $query);
            if($result){
                msg('product added successfully', 200);
            }else{
                msg('try again', 403);
            }
        }
        
    }
} elseif($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "select * from products where id = $id";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 1){
            $product = mysqli_fetch_assoc($result);
            echo json_encode($product);
        } else{
            msg('not found',404);
        }

    }else{
        $query = 'select * from products';
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
            $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            echo json_encode($products);
        } else{
            msg('not found',404);
        }
    }
}elseif($_SERVER['REQUEST_METHOD'] == 'DELETE'){

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "select * from products where id = $id";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 1){
            $query = "delete from products where id = $id";
            $result = mysqli_query($conn, $query);
            if($result){
                msg('product deleted successfully', 200);
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