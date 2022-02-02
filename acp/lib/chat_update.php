<?php
    $var = Array(
    array(
        "id"=>"0",
        "nick"=>"Silva",
        "cargo"=>"Maringá",
        "msg"=>"Silva",
        "avatar"=>"Silva"
    )
    
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);