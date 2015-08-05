<?php
namespace models;

use exceptions\DbException;

/**
 * Class Data
 * @package models
 */
class Data
{
    /**
     * @var \mysqli
     */
    protected $mysqli;

    /**
     * @throws DbException
     */
    public function __construct() {
        $this->mysqli = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->mysqli->connect_errno) {
            throw new DbException('Не удалось подключиться к MySQL: ' . $this->mysqli->connect_error);
        }
    }

    /**
     * @return array
     * @throws DbException
     */
    public function getMessages() {
        $result = $this->mysqli->query("SELECT * FROM test ORDER BY id DESC");
        if(!$result) {
            throw new DbException('Не удалось получить сообщения');
        }
        $ret = [];
        while ($row = $result->fetch_assoc()) {
            $ret[] = $row;
        }
        return $ret;
    }

    /**
     * @param int $id
     * @return array|bool
     * @throws DbException
     */
    public function getMessagesAfter($id) {
        $result = $this->mysqli->query("SELECT * FROM test WHERE `id`>" . (int)$id . " ORDER BY id DESC");
        if(!$result) {
            throw new DbException('Не удалось получить новые сообщения');
        }
        $ret = [];
        while ($row = $result->fetch_assoc()) {
            $ret[] = $row;
        }
        if(count($ret) === 0) {
            return false;
        }
        return $ret;
    }

    /**
     * @param string $text
     * @param string $author
     * @throws DbException
     */
    public function addMessage($text, $author) {
        $result = $this->mysqli->query("INSERT INTO `test`(`text`,`author`) VALUES ('" . $text . "', '" . $author . "')");
        if(!$result) {
            throw new DbException('Не удалось добавить сообщение');
        }
    }
}
