<?php
include_once "connector.php";

class UsersController
{
    protected $database;
    protected $db;
    
    public function __construct()
    {
        $this->database = new Connection();
        $this->db = $this->database->openConnection();
    }

    /**
     * List all users
     *
     * @return users array
     */
    public function all()
    {
        $query = $this->db->prepare("SELECT * FROM users ORDER BY id");
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        
        return json_encode($data);
    }
    
    /**
     * Add new user
     *
     * @param $first_name
     * @param $surname
     * @param $email
     * @param $username
     * @param $password
     *
     * @return boolean
     */
    public function create($first_name, $surname, $email, $username, $password)
    {
        $query = $this->db->prepare("INSERT INTO users(first_name, surname, email, username, password) VALUES " . 
            "(:first_name, :surname, :email, :username, :password)");
        $query->bindParam("first_name", $first_name, PDO::PARAM_STR);
        $query->bindParam("surname", $surname, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password", $password, PDO::PARAM_STR);

        return $query->execute();
    }
    
    /**
     * Get user details
     *
     * @param $user_id
     *
     * @return user object
     */
    public function get($user_id)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);

        return json_encode([
            "id"         => $user_id,
            "first_name" => $row["first_name"],
            "surname"    => $row["surname"],
            "email"      => $row["email"],
            "username"   => $row["username"],
            "password"   => $row["password"]
        ]);
    }
    
    /**
     * Update a user
     *
     * @param $first_name
     * @param $surname
     * @param $email
     * @param $username
     * @param $password
     * @param $user_id
     *
     * @return boolean
     */
    public function update($first_name, $surname, $email, $username, $password, $user_id)
    {
        $query = $this->db->prepare("UPDATE users SET first_name = :first_name, surname = :surname, email = :email, " . 
            "username = :username, password = :password WHERE id = :id");
        $query->bindParam("first_name", $first_name, PDO::PARAM_STR);
        $query->bindParam("surname", $surname, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password", $password, PDO::PARAM_STR);
        $query->bindParam("id", $user_id, PDO::PARAM_STR);

        return $query->execute();
    }
    
    /**
     * Delete a user
     *
     * @param $user_id
     *
     * @return boolean
     */
    public function delete($user_id)
    {
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        
        return $query->execute();
    }
}
?>