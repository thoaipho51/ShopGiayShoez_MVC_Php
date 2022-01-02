<?php
    class Ajax extends Controller{
        public $UserModel;
        public $ReviewModel;

        public function __construct() {
            $this->UserModel = $this->getModel('UserModel');
            $this->ReviewModel = $this->getModel('ReviewModel');
        }

        public function checkUserName()
        {
            $un = $_POST['un'];

            echo $this->UserModel->checkUserName($un);  
            // echo $un;
        }

        public function Review()
        {   
            
            $usr = $this->UserModel->ValidateToken();
            if ($usr != null) {
                
                if(isset($_POST["rating_data"]))
                {
                    $user_name = $_POST["user_name"];
                    $user_rating = $_POST["rating_data"];
                    $user_review = $_POST["user_review"];
                    $id_product = $_POST["id_product"];
                    $datatime = time();
                    
                    $this->ReviewModel->InsertReview($user_name, $user_rating, $user_review, $datatime, $id_product);
    
                    echo "Your Review & Rating Successfully Submitted";
    
                }
    
                if(isset($_POST["action"]))
                {
                    $id_product = $_POST["id_product"];
                    $average_rating = 0;
                    $total_review = 0;
                    $five_star_review = 0;
                    $four_star_review = 0;
                    $three_star_review = 0;
                    $two_star_review = 0;
                    $one_star_review = 0;
                    $total_user_rating = 0;
                    $review_content = array();
    
                    $query = "SELECT * FROM review
                    WHERE id_product = $id_product
                    ORDER BY review_id DESC
                    ";
    
                    $Result = mysqli_query($this->ReviewModel->conn, $query);
    
                    while($row = mysqli_fetch_array($Result, 1)){
                        
                        $data[] = $row;
                       
                    }
    
                    foreach($data as $row)
                    {
                        $review_content[] = array(
                            'user_name'		=>	$row["user_name"],
                            'user_review'	=>	$row["user_review"],
                            'rating'		=>	$row["user_rating"],
                            'datetime'		=>	date('l jS, F Y h:i:s A', $row["datetime"])
                        );
    
                        if($row["user_rating"] == '5')
                        {
                            $five_star_review++;
                        }
    
                        if($row["user_rating"] == '4')
                        {
                            $four_star_review++;
                        }
    
                        if($row["user_rating"] == '3')
                        {
                            $three_star_review++;
                        }
    
                        if($row["user_rating"] == '2')
                        {
                            $two_star_review++;
                        }
    
                        if($row["user_rating"] == '1')
                        {
                            $one_star_review++;
                        }
    
                        $total_review++;
    
                        $total_user_rating = $total_user_rating + $row["user_rating"];
    
                    }
    
                    $average_rating = $total_user_rating / $total_review;
    
                    $output = array(
                        'average_rating'	=>	number_format($average_rating, 1),
                        'total_review'		=>	$total_review,
                        'five_star_review'	=>	$five_star_review,
                        'four_star_review'	=>	$four_star_review,
                        'three_star_review'	=>	$three_star_review,
                        'two_star_review'	=>	$two_star_review,
                        'one_star_review'	=>	$one_star_review,
                        'review_data'		=>	$review_content
                    );
    
                    echo json_encode($output);
    
                }
            }else{
    
                if(isset($_POST["action"]))
                {
                    $id_product = $_POST["id_product"];
                    $average_rating = 0;
                    $total_review = 0;
                    $five_star_review = 0;
                    $four_star_review = 0;
                    $three_star_review = 0;
                    $two_star_review = 0;
                    $one_star_review = 0;
                    $total_user_rating = 0;
                    $review_content = array();
    
                    $query = "SELECT * FROM review
                    WHERE id_product = $id_product
                    ORDER BY review_id DESC
                    ";
    
                    $Result = mysqli_query($this->ReviewModel->conn, $query);
    
                    while($row = mysqli_fetch_array($Result, 1)){
                        
                        $data[] = $row;
                       
                    }
    
                    foreach($data as $row)
                    {
                        $review_content[] = array(
                            'user_name'		=>	$row["user_name"],
                            'user_review'	=>	$row["user_review"],
                            'rating'		=>	$row["user_rating"],
                            'datetime'		=>	date('l jS, F Y h:i:s A', $row["datetime"])
                        );
    
                        if($row["user_rating"] == '5')
                        {
                            $five_star_review++;
                        }
    
                        if($row["user_rating"] == '4')
                        {
                            $four_star_review++;
                        }
    
                        if($row["user_rating"] == '3')
                        {
                            $three_star_review++;
                        }
    
                        if($row["user_rating"] == '2')
                        {
                            $two_star_review++;
                        }
    
                        if($row["user_rating"] == '1')
                        {
                            $one_star_review++;
                        }
    
                        $total_review++;
    
                        $total_user_rating = $total_user_rating + $row["user_rating"];
    
                    }
    
                    $average_rating = $total_user_rating / $total_review;
    
                    $output = array(
                        'average_rating'	=>	number_format($average_rating, 1),
                        'total_review'		=>	$total_review,
                        'five_star_review'	=>	$five_star_review,
                        'four_star_review'	=>	$four_star_review,
                        'three_star_review'	=>	$three_star_review,
                        'two_star_review'	=>	$two_star_review,
                        'one_star_review'	=>	$one_star_review,
                        'review_data'		=>	$review_content
                    );
    
                    echo json_encode($output);
    
                }
                
            }
        }

    }
?>