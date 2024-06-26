<?php


namespace Core;


use PDO;


class Database
{
    public $connection;
    public $statement;

    public function __construct($config)
    {

        $dsn = 'mysql:' . http_build_query($config['database'], '', ';');
        $username = $config['user']['username'];
        $password = $config['user']['password'];

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    /*--------------------------------------------------------------
    Obsługa zapytania SQL i zwrócenie bieżącej instancji obiektu, co
    umożliwia dalsze operacje na wyniku zapytania.
    --------------------------------------------------------------*/
    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);

        return $this;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $result = $this->find();

        if (!$result) {
            abort();
        }

        return $result;
    }
}
