<?php
class crudApp
{
    private $conn;

    public function __construct()
    {
        // #database hosts, database user, database pass, database name
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = "";
        $dbname = 'crudapp';

        $this->conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$this->conn) {
            die("Database Connection Error! !");
        }
    }
    public function add_data($data)
    {
        $s_name = $data["s_name"];
        $s_roll = $data["s_roll"];
        $s_image = $_FILES['s_image']['name'];
        $tmp_name = $_FILES['s_image']['tmp_name'];

        $query = "INSERT INTO DATA_INFO(s_name,s_roll,s_image) VALUE('$s_name',$s_roll,'$s_image')";

        if (mysqli_query($this->conn, $query)) {
            move_uploaded_file($tmp_name, 'upload/' . $s_image);
            return "Information Added Successfully";
        }
    }
    public function display_data()
    {
        $query = "SELECT * FROM data_info";
        if (mysqli_query($this->conn, $query)) {
            $returndata = mysqli_query($this->conn, $query);
            return $returndata;
        }
    }
    public function display_data_by_id($id)
    {
        $query = "SELECT * FROM data_info where id=$id";
        if (mysqli_query($this->conn, $query)) {
            $returndata = mysqli_query($this->conn, $query);
            $infoData = mysqli_fetch_assoc($returndata);
            return $infoData;
        }
    }
    public function update_data($data)
    {
        $s_name = $data['us_name'];
        $s_roll = $data['us_roll'];
        $sid = $data['s_id'];
        $st_img = $_FILES['us_image']['name'];
        $tmp_name = $_FILES['us_image']['tmp_name'];

        $query = "UPDATE data_info SET s_name='$s_name',s_roll='$s_roll',s_image='$st_img' WHERE id='$sid'";

        if (mysqli_query($this->conn, $query)) {
            move_uploaded_file($tmp_name, 'upload/' . $st_img);
            return "Informaation Updated Successfully!";
        }
    }
    public function delete_data($id)
    {
        $catch_img = "SELECT * from data_info where id=$id";
        $delete_std_info = mysqli_query($this->conn, $catch_img);
        $std_infoDel = mysqli_fetch_assoc($delete_std_info);
        $deleteImg_data = $std_infoDel['s_image'];
        $query = "DELETE from data_info WHERE id=$id";
        if (mysqli_query($this->conn, $query)) {
            unlink('upload/' . $deleteImg_data);
            

            header("Location: index.php?message=Delete success!");
        }
    }

    // public function delete_data($id){
    //     $catch_img = "SELECT * FROM students WHERE id=$id";
    //     $delete_std_info = mysqli_query($this->conn, $catch_img);
    //     $std_infoDle = mysqli_fetch_assoc($delete_std_info);
    //     $deleteImg_data = $std_infoDle['stg_img'];
    //     $query = "DELETE FROM students WHERE id=$id";
    //     if(mysqli_query($this->conn, $query)){
    //         unlink('upload/'.$deleteImg_data);
    //         return "Deleted Successfully";
    //     }
    // }
}
