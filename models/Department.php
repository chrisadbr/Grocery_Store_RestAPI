<?php
class Department
{
    private $conn;
    private $table = "departments";
    //
    public $id;
    public $name;
    //public $created_at;
    //
    public function __construct($db)
    {
        $this->conn = $db;
    }
    //Add new Departments
    public function create_dpt()
    {
        $sql_cmd = "INSERT INTO " . $this->table . " SET name = :name";
        //
        $stmt = $this->conn->prepare($sql_cmd);
        //Clean Data
        $this->name = htmlspecialchars(strip_tags($this->name));
        //Bind Parameter
        $stmt->bindParam(':name', $this->name);
        //
        if ($stmt->execute()) {
            return true;
        } else
            //printf("Error %s\.n", $stmt->error);
            return false;
    }
    //Fetch Departments
    public function read_dpt()
    {
        $sql_cmd = "SELECT 
                    id,
                    name
                    FROM " . $this->table;

        $stmt = $this->conn->prepare($sql_cmd);
        //Execute query
        $stmt->execute();
        return $stmt;
    }
    //Upadate Departments
    public function update_dpt()
    {
        $sql_cmd = 'UPDATE ' . $this->table . ' 
                    SET 
                    name = :name 
                    WHERE id = :id';
        //
        $stmt = $this->conn->prepare($sql_cmd);
        //Sanitize data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //Bind Parameter
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        //Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    //Delete Department
    public function delete_dpt()
    {
        $sql_cmd = "DELETE FROM 
                    " . $this->table . ' 
                    WHERE id = ?';
        //
        $stmt = $this->conn->prepare($sql_cmd);
        //
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        //Execute Query
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }
}
