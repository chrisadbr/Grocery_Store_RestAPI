<?php
class Products
{
    //DB Stuff
    private $conn;
    private $table = "products";
    //
    //Declare columns
    public $product_id;
    public $name;
    public $description;
    public $price;
    public $department_id;
    public $department_name;
    public $created_at;
    //

    public function __construct($db)
    {
        $this->conn = $db;
    }
    //Create Products
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
        SET
        name = :name,
        description = :description,
        price = :price,
        department_id = :department_id';
        //
        $stmt = $this->conn->prepare($query);

        //Clean Data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->department_id = htmlspecialchars(strip_tags($this->department_id));

        //Bind Param
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':department_id', $this->department_id);

        //Execute query
        if ($stmt->execute())
            return true;
        //
        printf("Error %s\.n", $stmt->error);
        return false;
    }
    //Read Products
    public function read()
    {
        $sql_cmd = "SELECT d.name as department_name, p.product_id, p.name, p.description, p.price, p.department_id, p.created_at 
        FROM "
            . $this->table .
            " p 
        LEFT JOIN 
        departments d ON p.department_id = d.id 
        ORDER BY 
        p.created_at DESC";

        $stmt = $this->conn->prepare($sql_cmd);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    //Read one item
    public function read_single()
    {
        $sql_cmd = "SELECT d.name as department_name, p.product_id, p.name, p.description, p.price, p.department_id, p.created_at 
        FROM "
            . $this->table .
            " p 
        LEFT JOIN 
        departments d ON p.department_id = d.id 
            WHERE 
            p.product_id = ?
            LIMIT 0, 1";
        //
        $stmt = $this->conn->prepare($sql_cmd);
        $stmt->bindParam(1, $this->id);
        // execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //
        $this->id = $row['product_id'];
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->price = $row['price'];
        $this->department_id = $row['department_id'];
        $this->department_name = $row['department_name'];
        $this->created_at = $row['created_at'];
        //
    }
    // update the product
    function update()
    {

        // update query
        $query = "UPDATE
                " . $this->table . "
            SET
                name = :name,
                price = :price,
                description = :description,
                department_id = :department_id
            WHERE
                product_id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->department_id = htmlspecialchars(strip_tags($this->department_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));

        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':department_id', $this->department_id);
        $stmt->bindParam(':id', $this->product_id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    //Delete Product
    public function delete()
    {
        $sql_cmd = "DELETE 
                    FROM " . $this->table . " 
                    WHERE 
                    product_id = ?";

        $stmt = $this->conn->prepare($sql_cmd);
        //Sanitize 
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        //bind id of a record to delete
        $stmt->bindParam(1, $this->product_id);
        //Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
