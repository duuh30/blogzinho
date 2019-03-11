<?php

namespace BLOG\Domain\Models;

use Firebase\JWT\JWT;

class User
{
    public $id;
    public $name;
    public $email;
    public $password;


    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->name;
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->name = $value;
        }
    }

    /**
     * @param $data
     * @return $this
     */
    public function parse ($data)
    {
        $this->name      = $data["name"];
        $this->email     = $data["email"];
        $this->password  = password_hash($data["password"], PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * @param $data
     * @param $password
     * @return array
     * @throws \Exception
     */
    public function comparePassword ($data, $password)
    {
        if(crypt($password, $data->password) === $data->password)
            return $this->generateToken($data);
        else
            throw new \Exception('invalid password', 400);
    }

    /**
     * @param $data
     * @return array
     */
    public function generateToken ($data)
    {
        $created_at = Time();
        $expire_at  = ($created_at + 24000);
        $key        = $_ENV['KEY_JWT'];
        $alg        = 'HS256';

        $token = [
            "created_at" => $created_at,
            "expire_at"  => $expire_at,
            "id"         => $data->id,
        ];

        return [
            "data"         => ["jwt" => JWT::encode($token, $key, $alg)],
            "message"      => "success",
            "code"         => 200,
            "status_error" => false
        ];
    }
}
