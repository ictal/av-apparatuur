<?php

require_once dirname(__FILE__) . '/../config.php';

include 'encryption.php';

class Database
{

    private $_host;
    private $_user;
    private $_pass;
    private $_name;

    private $pdo;

    function __construct($HOST = DB_HOST, $USER = DB_USER, $PASS = DB_PASS, $NAME = DB_NAME)
    {

        $this->_host = $HOST;
        $this->_user = $USER;
        $this->_pass = $PASS;
        $this->_name = $NAME;

        $this->connect();
    }

    public function query($sql, $values = false)
    {

        $sth = $this->pdo->prepare($sql);

        if ($values) {

            if (!is_array($values)) {

                $sth->execute(array($values));

            } else {

                $sth->execute($values);

            }


        } else {

            $sth->execute();

        }

        return $sth;
    }

    public function fetch($sql, $values = false)
    {
        return $this->query($sql, $values)->fetch(PDO::FETCH_ASSOC);

    }

    public function fetchAll($sql, $values = false)
    {
        return $this->query($sql, $values)->fetchAll(PDO::FETCH_ASSOC);

    }


    public function rowCount($sql, $values = false)
    {
        return $this->query($sql, $values)->rowCount();
    }

    public function existUser($username, $password)
    {
        $user = $this->fetch("SELECT password_salt FROM users WHERE username = ?", $username);
        if ($user) {
            $input_password = Encryption::_hash($password, $user['password_salt']);
            $result = $this->fetch("SELECT 1 FROM users WHERE username = ? AND password = ?", array($username, $input_password));
            return $result;
        }
        return false;
    }

    public function getUser($username, $arg = '*')
    {
        $result = $this->fetch("SELECT $arg FROM users Where username = ? ", array($username));

        if (count($result) == 1 && is_array($result)) {
            $result = implode($result);
        }

        return $result;
    }

    public function addUser($user)
    {

        //has_user password;
        $salt = Encryption::generateSalt();
        $password = Encryption::_hash($user['password'], $salt);

        //add salt and hashed password to user
        $user['password'] = $password;
        $user['password_salt'] = $salt;

        //execute query and return result;
        $user = array_values($user->getContainer());

        print_r($user);
        return $this->query("INSERT INTO users (username, student_number, password, email, first_name, tsn_voegsel, last_name, mobile, password_salt ) VALUES  ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ", $user);

    }

    public function addToSerial($id, $serial)
    {
        $sql = 'INSERT INTO serial (product_id, serial) VALUES( ?, ?)';
        return $this->query($sql, array($id, $serial));
    }

    public function addProduct($name, $description, $img)
    {
        $sql = 'INSERT INTO products (name, description, img) VALUES( ?, ?, ?)';
        return $this->query($sql, array($name, $description, $img));
    }

    public function getProductId($name)
    {
        $sql = 'SELECT id FROM products WHERE name = ?';
        return $this->fetch($sql, array($name));
    }

    public function updateUser($user_id, $user_details, $update_details, $table = 'users')
    {

        //implode user_details array to test = ?, name = ?,
        $ud = implode(' = ?, ', $user_details) . " = ?";

        //push user user_id to the end of the array.
        array_push($update_details, $user_id);

        print_r($user_details);
        print_r($update_details);
        return $this->query("UPDATE $table  SET $ud WHERE id = ?", $update_details);

    }

    public function deleteProduct($id)
    {
        $times = count($_POST['products']);

        $product_id = array_fill(0, $times, "?");
        $product_id = implode(',', $product_id);

        $sql = "DELETE FROM products WHERE id IN ( $product_id)";
        return $this->query($sql, $id);

    }

    public function updateProduct($post_array)
    {

        $product_id = $post_array['id'];
        unset($post_array['id']);

        $new_array = array_values($post_array);
        array_push($new_array, $product_id);

        print_r($new_array);

        $sql = "UPDATE products set description = ?, name = ?, serial_number = ? WHERE id = ?";

        return $this->query($sql, $new_array);


    }

    public function updateReservation($username, $user_details, $update_details, $table = 'user')
    {

        //implode user_details array to test = ?, name = ?,
        $ud = implode(' = ?, ', $user_details) . " = ?";

        //push user Username to the end of the array.
        array_push($update_details, $username)[0];
        return $this->query("UPDATE $table  SET $ud WHERE user_id = ?", $update_details);

    }

    public function connect()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->_host;dbname=$this->_name", $this->_user, $this->_pass, array(PDO::ATTR_PERSISTENT => true));
            #echo 'Connecting established!' ."\n";
        } catch (PDOException $e) {

            echo 'Could not connect to the database. Error Code ' . $e->getCode();
        }
    }

	public function getInsertedLastId() {
		return $this->pdo->lastInsertId();
	}
    public function destroy()
    {
        $this->pdo = null;
    }

}


?>