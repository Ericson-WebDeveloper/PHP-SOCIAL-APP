<?php


class Connection
{

    public $connection;
    private $error;
    private $host = "localhost";
    private $databasename = "php_pusher_chat";
    private $username = "root";
    private $password = "";

    /**
     * Public method for creating an OCI connection
     * @return Mix
     */
    public function __construct()
    {
        if (!$this->connection) {
            try {
                $this->connection = new PDO(
                    'mysql:host=' . $this->host . ';dbname=' . $this->databasename . '',
                    $this->username,
                    $this->password,
                    array(PDO::MYSQL_ATTR_LOCAL_INFILE => true)
                );
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die('Error : ' . $e->getMessage());
            }
        }

        return $this->connection;
    }

    function first($query)
    {
        $result = $this->connection->query($query);
        $ret = $result->execute();
        $result->setFetchMode(PDO::FETCH_OBJ);
        $reponse = $result->fetch();

        return $reponse;
    }

    function get($query)
    {
        $result = $this->connection->query($query);
        $ret = $result->execute();
        $result->setFetchMode(PDO::FETCH_OBJ);
        $reponse = $result->fetchAll();

        return $reponse;
    }

    function execute($query)
    {
        $result = $this->connection->query($query);

        return true;
    }

    function disconnect()
    {
        if ($this->connection) {
            $this->connection = null;
        }
    }
}
