<?php
    function random($width) {
        $chars = "QWERTYUIOPASDFGHJKLÇZXCVBNMqwertyuiopasdfghjklçcvbnmzx!@#$%¨&*()";
        $size = strlen($chars);
        $random_str = "";
        for($i = 0; $i < $width; $i++) {
            $index = rand(0, $size - 1);
            $random_str .= $chars[$index];
        }
        return $random_str;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $key = random(10);
        $json_str = file_get_contents('users.json');
        $json_data = json_decode($json_str, true);
        if (isset($json_data[$email])) {
            $user = $json_data[$email];
        } else {
            echo "Tente se Cadastrar"
        }
        if($user['password'] == $password) {
            $user['key'] = $key;
            $json_data[$email] = $user;
            $json_new_str = json_encode($json_data);
            file_put_contents('users.json', $json_new_str);
            header("Location: /home?key=$key");
            exit();
        } else {
            echo 'Tente de novo senha errada';
        }
    } else {
        echo 'Tente de novo email errado';
    }
?>