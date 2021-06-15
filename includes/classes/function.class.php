<?php
namespace Code;

class Functions
{

    private static $con;
    private static $db;

    public function __construct()
    {
        self::$db  = $GLOBALS['dbc'];
        self::$con = self::$db->connect();
    }

    public function guid() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function addUser($username, $email, $password)
    {

        $res["success"] = true;
        $query = 'INSERT INTO `user`(
                `username`,
                `email`,
                `password`
            ) VALUES (?,?,?)';

        $sql = self::$con->prepare($query);
        $sql->execute([
            $username,
            $email,
            md5($password)
        ]);
        return $res;
    }


    public function checkLogin($email, $password)
    {
        $res["success"] = false;
        $query = 'SELECT `password`,`ID` FROM `user` WHERE `email` LIKE ?';

        $sql = self::$con->prepare($query);
        $sql->execute([
            $email
        ]);
        $result = $sql->fetch();

        if($result != null) {
            if($result["password"] == md5($password)) {
                $res["success"] = true;
                $res["result"] = $result["ID"];       
            }
        }
        return $res;
    }

    public function addCode($uid,$path)
    {
        $res["success"] = true;
        $query = 'INSERT INTO `code`(
                `uid`,
                `path`
            ) VALUES (?,?)';

        $sql = self::$con->prepare($query);
        $sql->execute([
            $uid,
            $path
        ]);
        return $res;
    }

    public function addCodeFile($uid, $data) {
        $name = self::guid();
        $path = "../code/".$name.".json";
        file_put_contents($path, $data);
        $res["success"] = true;
        $res["result"] = $path;
        self::addCode($uid,$path);
        return $res;
    }

    public function updateCodeFile($pid, $data) {
        $path = "../code/".$pid.".json";
        file_put_contents($path, $data);
        $res["success"] = true;
        $res["result"] = $path;
        return $res;
    }

    public function getCode($uid)
    {
        $res = [];
        $res["success"] = true;
        $query = 'SELECT * FROM `code` WHERE `uid` = ?';

        $sql = self::$con->prepare($query);
        $sql->execute([
            $uid
        ]);
        $result = $sql->fetchAll();
        $res["result"] = $result;
        return $res;
    }

    public function deleteCode($id)
    {
        $res["success"] = true;
        $query = 'DELETE FROM `code` WHERE `ID` = ?';

        $sql = self::$con->prepare($query);
        $sql->execute([
            $id
        ]);
        return $res;
    }
}
