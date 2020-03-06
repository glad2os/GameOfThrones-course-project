<?php

namespace Database;

use Config\Database;
use Exception\DbConnectionException;
use Exception\DbException;

class MySQLi extends \MySQLi
{
    /*
     * Alphabet for token generation
     */
    private const alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

    /**
     * MySQLi constructor.
     * @throws DbConnectionException in case of SQL connection error
     */
    public function __construct()
    {
        parent::__construct(Database::HOST, Database::USER, Database::PASSWORD, Database::DATABASE);
        if ($this->connect_errno) throw new DbConnectionException('Could not connect to MySQL server. ' . $this->connect_error);
        $this->set_charset('utf8');
    }

    /*
     * Users Table
     */

    /**
     * Registration
     * @param $login
     * @param $password
     * @param $firstName
     * @param $secondName
     * @param $lastName
     * @return int inserted id
     * @throws DbException in case of SQL error
     */
    public function registerUser($login, $password)
    {
        $stmt = $this->prepare("insert into users (login, password_hash) value (?, md5(?))");
        $stmt->bind_param("ss", $login, $password);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = $stmt->insert_id;
        $stmt->close();
        return $result;
    }

    /**
     * Registration
     * @param $id
     * @param $permissions
     * @throws DbException in case of SQL error
     */
    public function setUserPermissions($id, $permissions)
    {
        $stmt = $this->prepare("update users set permissions = ? where id = ?");
        $stmt->bind_param("ii", $permissions, $id);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $stmt->close();
    }

    /**
     * Authentication. Check user for valid with password
     * @param $login
     * @param $password
     * @return bool true if user exists, otherwise false
     * @throws DbException in case of SQL error
     */
    public function authentication($login, $password)
    {
        $stmt = $this->prepare("select count(*) from users where login = ? and password_hash = md5(?)");
        $stmt->bind_param("ss", $login, $password);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = (bool)$stmt->get_result()->fetch_array(MYSQLI_NUM)[0];
        $stmt->close();
        return $result;
    }

    /**
     * Authentication and authorization by token. Check user for valid with token
     * @param $id
     * @param $token
     * @return bool true if user exists with this token, otherwise false
     * @throws DbException in case of SQL error
     */
    public function authByToken($id, $token)
    {
        $stmt = $this->prepare("select count(*) from tokens t left join users u on t.user_id = u.id where u.id = ? and t.token = ? and current_timestamp() < t.expiration");
        $stmt->bind_param("is", $id, $token);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = (bool)$stmt->get_result()->fetch_array(MYSQLI_NUM)[0];
        $stmt->close();
        return $result;
    }

    /**
     * Authorization. Token issuance
     * @param $userId
     * @return string 32 chars
     * @throws DbException in case of SQL error
     */
    public function authorization($userId)
    {
        do {
            $token = "";
            for ($i = 0; $i < 32; ++$i) {
                $token .= self::alphabet[rand(0, strlen(self::alphabet) - 1)];
            }
            $stmt = $this->prepare("select count(*) from tokens where token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
            $result = (bool)$stmt->get_result()->fetch_array(MYSQLI_NUM)[0];
            $stmt->close();
        } while ($result);
        $stmt = $this->prepare("insert into tokens (user_id, token, expiration) value (?, ?, current_timestamp() + interval 1 day)");
        $stmt->bind_param("is", $userId, $token);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $stmt->close();
        return $token;
    }

    /**
     * Get user id by login
     * @param $login
     * @return int
     * @throws DbException in case of SQL error
     */
    public function getUserId($login)
    {
        $stmt = $this->prepare("select id from users where login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = $stmt->get_result()->fetch_array(MYSQLI_NUM)[0];
        $stmt->close();
        return $result;
    }

    /**
     * Get user info by id
     * @param $id
     * @return array
     * @throws DbException in case of SQL error
     */
    public function getUserInfo($id)
    {
        $stmt = $this->prepare("select id, login, permissions from users where id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    /**
     * Get user permissions
     * @param $id
     * @return int
     * @throws DbException in case of SQL error
     */
    public function getUserPermissions($id)
    {
        $stmt = $this->prepare("select permissions from users where id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = $stmt->get_result()->fetch_array(MYSQLI_NUM)[0];
        $stmt->close();
        return $result;
    }

    /**
     * Check user exists by login
     * @param $login
     * @return bool
     * @throws DbException in case of SQL error
     */
    public function checkUserExists($login)
    {
        $stmt = $this->prepare("select count(*) from users where login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = (bool)$stmt->get_result()->fetch_array(MYSQLI_NUM)[0];
        $stmt->close();
        return $result;
    }

    /**
     * Invalidate Token
     * @param $userId
     * @param $token
     * @throws DbException in case of SQL error
     */
    public function invalidateToken($userId, $token) // fuck this php!
    {
        $stmt = $this->prepare("delete from tokens where user_id = ? and token = ?");
        $stmt->bind_param("is", $userId, $token);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $stmt->close();
    }

    /**
     * Update User Info
     * @param $login
     * @param $password
     * @param $firstName
     * @param $secondName
     * @param $lastName
     * @throws DbException in case of SQL error
     */
    public function updateUser($id, $login, $password, $firstName, $secondName, $lastName)
    {
        $stmt = $this->prepare("update users set login = ?, password_hash = md5(?), first_name = ?, second_name = ?, last_name = ? where id = ?");
        $stmt->bind_param("sssssi", $login, $password, $firstName, $secondName, $lastName, $id);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $stmt->close();
    }

    /* Thread Table */

    /**
     * @param $id
     * @return array|null
     */
    public function checkThreadExist($id)
    {
        $stmt = $this->prepare("SELECT count(*) FROM threads WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function getThread($id)
    {
        $stmt = $this->prepare("SELECT id, title, text, date_post, img, verified FROM threads WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function getAuthorsOfThread($threadId)
    {
        $stmt = $this->prepare("select login from users u left join threads_links tl on u.id = tl.user_id where tl.thread_id = ?");
        $stmt->bind_param("i", $threadId);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function countOfThreads()
    {
        $stmt = $this->prepare("select count(id) from threads");
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $result = $stmt->get_result()->fetch_array(MYSQLI_NUM)[0];
        $stmt->close();
        return $result;
    }

    /**
     * @param mixed ...$string
     * @return int
     */
    public function addThread($title, $text, $img)
    {
        $stmt = $this->prepare("INSERT INTO threads (title, text, img) VALUES (?,?,?)");
        $stmt->bind_param("sss", $title, $text, $img);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $output = $stmt->insert_id;
        $stmt->close();
        return $output;
    }

    public function linkThread($authorId, $threadId)
    {
        $stmt = $this->prepare("insert into threads_links (user_id, thread_id ) values (?, ?)");
        $stmt->bind_param("ii", $authorId, $threadId);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error, $stmt->errno);
        $stmt->close();
    }
}