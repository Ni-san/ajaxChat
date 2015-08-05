<?php
namespace controllers;

use models\Data;

class Controller
{

    /**
     * @var \models\Data
     */
    public static $data;

    /**
     * Главный контроллер, отвечает за всё
     * Переменные $arrData и $arrErr "передаются" в представление
     */
    public static function run() {
        try {
            // Для обработки ajax-запросов:
            self::post();

            $arrData = [];
            $data = new Data();
            $arrData = $data->getMessages();
        } catch (\exceptions\DbException $e) {
            // Просто логирование всех исключений
            file_put_contents(BASE_PATH . '/log/exception.log', date('Y-m-d H:i:s ') . $e->getMessage() . PHP_EOL, FILE_APPEND);
        }

        $arrErr = file_get_contents('log/exception.log');
        echo include(BASE_PATH . '/views/index.phtml');
        exit;
    }

    /**
     * @throws \exceptions\DbException
     */
    public static function post() {
        if (isset($_POST) && count($_POST) > 0) {

            if (!isset(self::$data) || !(self::$data instanceof Data)) {
                self::$data = new Data();
            }

            if (isset($_POST['action'])) {
                $messages = self::$data->getMessagesAfter($_POST['maxId']);
                $counter = 0;
                while (!$messages) {
                    sleep(1);
                    $counter++;
                    if ($counter > 25) {
                        echo '[]';
                        exit;
                    }
                    $messages = self::$data->getMessagesAfter($_POST['maxId']);
                }
                echo json_encode($messages);
                exit;
            }

            if (isset($_POST['message'])) {
                self::$data->addMessage($_POST['message'], $_POST['author'] ? $_POST['author'] : 'anon');
                exit;
            }
        }
    }
}
