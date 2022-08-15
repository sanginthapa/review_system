<?php

//submit_rating.php
date_default_timezone_set("asia/kathmandu");

$connect = new PDO("mysql:host=localhost;dbname=ultima", "root", "");

if(isset($_POST["rating_data"]))
{
echo "submit in process";
	$data = array(
		':user_id'		=>	$_POST["user_id"],
		':user_name'		=>	$_POST["user_name"],
		':product_id'		=>	$_POST["product_id"],
		':review_point'		=>	$_POST["rating_data"],
		':review_message'		=>	$_POST["review_message"],
		':attachment'		=>	$_POST["attachment"],
		':submit_date'		=>	time()
	);


	$query = "
	INSERT INTO reviews 
	(product_id,user_id,user_name, review_point, review_message, attachment,submit_date) 
	VALUES (:product_id,:user_id,:user_name, :review_point, :review_message, :attachment,:submit_date)
	";

	echo time();

	$statement = $connect->prepare($query);

	$statement->execute($data);

	echo "Your Review & Rating Successfully Submitted";

}

if(isset($_POST["action"]))
{
	$average_rating = 0;
	$total_review = 0;
	$five_star_review = 0;
	$four_star_review = 0;
	$three_star_review = 0;
	$two_star_review = 0;
	$one_star_review = 0;
	$total_review_point = 0;
	$review_content = array();

	$query = "SELECT * FROM reviews ORDER BY id DESC";

	$result = $connect->query($query, PDO::FETCH_ASSOC);

	foreach($result as $row)
	{
		$review_content[] = array(
			'product_id'		=>	$row["product_id"],
			'user_id'		=>	$row["user_id"],
			'user_name'		=>	$row["user_name"],
			'review_message'	=>	$row["review_message"],
			'rating'		=>	$row["review_point"],
			'attachment'		=>	$row["attachment"],
			'datetime'		=>	date('l jS, F Y h:i:s A', $row["submit_date"])
		);

		if($row["review_point"] == '5')
		{
			$five_star_review++;
		}

		if($row["review_point"] == '4')
		{
			$four_star_review++;
		}

		if($row["review_point"] == '3')
		{
			$three_star_review++;
		}

		if($row["review_point"] == '2')
		{
			$two_star_review++;
		}

		if($row["review_point"] == '1')
		{
			$one_star_review++;
		}

		$total_review++;

		$total_review_point = $total_review_point + $row["review_point"];

	}

	$average_rating = $total_review_point / $total_review;

	$output = array(
		'average_rating'	=>	number_format($average_rating, 1),
		'total_review'		=>	$total_review,
		'five_star_review'	=>	$five_star_review,
		'four_star_review'	=>	$four_star_review,
		'three_star_review'	=>	$three_star_review,
		'two_star_review'	=>	$two_star_review,
		'one_star_review'	=>	$one_star_review,
		'review_point'		=>	$review_content
	);
	echo json_encode($output);
}

?>