<?php
	include_once '../outsourced-php-code/userdata.php';
	$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
	$query = $db->prepare(
		"SELECT * FROM posts_registered_users_topics_view WHERE post_status = 0 ORDER BY post_id DESC" );
	$query->execute();
	$output = '';
	while ( $row = $query->fetch() ) {
		$output .= '
 <div class="alert alert_default">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <p>  <strong>' . $row["user_name"] . '</strong><br>
  <strong>' . $row["topic_name"] . '</strong><br>
   <small><em>' . $row["content"] . '</em></small>
  </p>
 </div>
 ';
	}
	$query = $db->prepare("UPDATE posts_registered_users_topics_view SET post_status = 1 WHERE post_status = 0");
	$query->execute();
	echo $output;

?>