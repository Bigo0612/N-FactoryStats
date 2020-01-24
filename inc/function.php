<?php

///////////////////////////////////////
// FONCTION DE CLEAN
///////////////////////////////////////

function clean($string) {
    $cleaner = trim(strip_tags($string));
    return $cleaner; }


function debug($tableau) {
    echo '<pre>'; print_r($tableau); echo '</pre>';
}

///////////////////////////////////////
// FONCTION DE VALIDATION DE L'EMAIL
///////////////////////////////////////

function emailValid($err, $mail, $key) {
    if (!empty($mail)) {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $err[$key] = 'Email non valide';
        }
    } else {
        $err[$key] = "Veuillez renseigner ce champ";
    }
    return $err;
}

///////////////////////////////////////
// FONCTION DE VALIDATION DES TEXTES
///////////////////////////////////////

function textValid($err, $text, $key, $x, $y) {
    if (!empty($text)) {
        if (mb_strlen($text) < $x) {
            $err[$key] = 'Minimum '.$x.' caractères';
        }elseif (mb_strlen($text) > $y) {
            $err[$key] = 'Maximum '.$y.' caractères';
        }
    }else {
        $err[$key] = 'Veuillez renseigner ce champ';
    }
    return $err;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function is_logged()
{
    $roles = array('abonne','admin');

    if(!empty($_SESSION['email'])) {
        if(!empty($_SESSION['email']['id']) && is_numeric($_SESSION['email']['id'])) {
            if(!empty($_SESSION['email']['email'])) {
                if(!empty($_SESSION['email']['role'])) {
                    if(in_array($_SESSION['email']['role'],$roles)) {
                        if(!empty($_SESSION['email']['ip'])) {
                            if($_SESSION['email']['ip'] == $_SERVER['REMOTE_ADDR']) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
    }
    return false;
}