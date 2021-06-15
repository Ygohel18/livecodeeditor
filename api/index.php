<?php
namespace Code;
use Code\Functions as FUN;
include_once '../includes/load.php';

header("Access-Control-Allow-Origin: *");

$responce = array();

if(isset($_REQUEST['do'])) {
    switch($_REQUEST['do']) {
        case "delete":
            deleteCode($_REQUEST['id']);
            break;
    }
}

if(isset($_REQUEST['action'])) {
    switch($_REQUEST["action"]) {
        case "addUser":
            addUser($_REQUEST['username'],$_REQUEST['email'],$_REQUEST['password']);
            break;
        case "checkLogin":
            checkLogin($_REQUEST['email'],$_REQUEST['password']);
            break;
        case "addCode":
            addCode($_REQUEST['uid'],$_REQUEST['path']);
            break;
        case "getCode":
            getCode($_REQUEST['uid']);
            break;
        case "deleteCode":
            deleteCode($_REQUEST['id']);
            break;
        case "addCodeFile":
            addCodeFile($_REQUEST['uid'],$_REQUEST['data']);
            break;
        case "updateCodeFile":
            updateCodeFile($_REQUEST['pid'],$_REQUEST['data']);
            break;
        default:
            http_response_code(400);
            echo "Unknown request";
            break;
    }
} else {
    http_response_code(401);
    echo "Access denaid";
}

function addUser($username,$email,$password) {
    $fun  = new FUN;
    $res = $fun->addUser($username,$email,$password);
    sendResponce($res);
}

function checkLogin($email,$password) {
    $fun  = new FUN;
    $res = $fun->checkLogin($email,$password);
    sendResponce($res);
}

function addCode($uid,$path) {
    $fun  = new FUN;
    $res = $fun->addCode($uid,$path);
    sendResponce($res);
}

function getCode($uid) {
    $fun  = new FUN;
    $res = $fun->getCode($uid);
    sendResponce($res);
}

function deleteCode($id) {
    $fun  = new FUN;
    $res = $fun->deleteCode($id);
    sendResponce($res);
}

function addCodeFile($uid,$data) {
    $fun  = new FUN;
    $res = $fun->addCodeFile($uid,$data);
    sendResponce($res);
}

function updateCodeFile($pid,$data) {
    $fun  = new FUN;
    $res = $fun->updateCodeFile($pid,$data);
    sendResponce($res);
}

function sendResponce($res) {
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($res, JSON_UNESCAPED_SLASHES);
}