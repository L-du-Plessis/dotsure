<?php
abstract class Connector
{
    protected $server = "mysql:host=localhost; dbname=koticujk_dotsure";
    protected $user = "test_user";
    protected $pass = "PWl=12lnms0}";
    protected $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);    
    protected $con;
     
    abstract protected function openConnection();
    
    /**
     * Close PDO connection
     */
    public function closeConnection() 
    {
        $this->con = null;
    }
}

class Connection extends Connector 
{
    /**
     * Open PDO connection
     *
     * @return connection object
     */
    public function openConnection()
    {
        try {
            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->con;
        }
        catch (PDOException $e) {
            echo "Error in connection: " . $e->getMessage();
        }
    }    
}
?>