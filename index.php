<?php

require 'functions.php';
require 'Database.php';
require 'Response.php';
require 'router.php';

// connect to MySQL database and execute a query
$id = $_GET['id'];
$query = "SELECT * FROM posts WHERE id = ?";

$posts = $db -> query("$query", [$id])->find();

dd($posts);


//foreach($posts as $post) {
//  echo "<li>" . $post['title'] . "</li>";
//}