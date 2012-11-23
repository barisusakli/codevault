<?php

class Post
{
	public function createNew($params)
	{
		GLOBAL $db;
		$title =  strip_tags($params['title']);
		if(!strlen($title))
			return array("status"=>0,"message"=>"Invalid title");
		
		$queryParams[':title'] = $title;
		$queryParams[':language'] = $params['language'];
		$queryParams[':code'] = $params['code'];
		$queryParams[':created'] = time();
		
		
		$result = $db->run("INSERT INTO posts (title,language,code,created) VALUES(:title,:language,:code,:created)",$queryParams);
	
		return array("status"=>1,"message"=>"Post created","data"=>array("postID"=>$db->lastInsertId()));
	}
	
	public function getPost($params)
	{
		GLOBAL $db;
		$postID = $params['postID'];
		$result = $db->run("SELECT postID,title,language,code,created FROM posts WHERE postID=:postID",array(':postID'=>$postID))->fetch();
		
		if(!$result)
			return array("status"=>0,"message"=>"Post doesn't exist");
		
		$result['title'] = trim(strip_tags($result['title']));
		
		return array("status"=>1,"message"=>"Post retrieved","data"=>$result);
	}
	
	public function getLatestPosts($params)
	{
		GLOBAL $db;
		
		$result = $db->query("SELECT postID,title,language,code,created FROM posts ORDER BY postID DESC LIMIT 20")->fetchAll();
		
		if(!$result)
			return array("status"=>0,"message"=>"Post doesn't exist");
		
		foreach($result as &$post)
		{
			$post['title'] = trim(strip_tags($post['title']));
		}
		
		return array("status"=>1,"message"=>"Posts retrieved","data"=>$result);
	
	}
	
}


?>