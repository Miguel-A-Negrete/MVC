<?php

    class View{
        public static function returnJSON($data){
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public static function returnHTML($data){
            header('Content-Type: text/html');
            echo json_encode($data);
        }
    }
