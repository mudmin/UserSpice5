<?php

// Get user IP
	if(!function_exists("getIP")){
	function getIP() {
	/*
	This function will try to find out if user is coming behind proxy server. Why is this important?
	If you have high traffic web site, it might happen that you receive lot of traffic
	from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
	This function tryes to get real IP address.
	Note that getenv() function doesn't work when PHP is running as ISAPI module
	*/
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}

// Pie Chart for Page Permission Counts
if(!function_exists("fetchUserjsonPIE")){
function fetchUserjsonPIE()
	{
	// Example query
	$db = DB::getInstance();
	$stmt = $db->query("SELECT * AS ?,?
	FROM permission_page_matches LEFT JOIN permissions ON permission_id = permissions.id  GROUP BY permission_id",[sum1,name]);
	$results = $stmt->results();
	$count = $stmt->count();
	return $results;
	return $count;
	}
}

// Bar Chart for Login Counts
if(!function_exists("fetchUserjsonLG2")){
function fetchUserjsonLG2()
	{
	// Example query
	$db = DB::getInstance();
	$stmt = $db->query("SELECT * FROM audit WHERE audit_eventcode = 1 GROUP BY MINUTE(FROM_UNIXTIME(audit_timestamp)) ORDER BY audit_timestamp DESC LIMIT 100");
	$count = $stmt->count();
	$results = $stmt->results();
	return $count;
	return $results;
	}
}

// Bar Chart for Signup Counts
if(!function_exists("fetchUserjsonLG")){
function fetchUserjsonLG()
	{
	// Example query
	$db = DB::getInstance();
	$stmt = $db->query("SELECT COUNT(*) AS sum1,sign_up_stamp	FROM users GROUP BY DAY(FROM_UNIXTIME(sign_up_stamp))ORDER BY sign_up_stamp DESC");
	$stmt->execute();
	$stmt->bind_result($sum1, $name);
	while ($stmt->fetch())
		{
		$row[] = array('sum1' => $sum1, 'sign_up_stamp' => $name);
		}
	$stmt->close();
	return ($row);
	}
}


// complex query gets audit
	if(!function_exists("fetchAllLatest")){
	function fetchAllLatest($userid,$start,$end,$eventcode)
		{
		$db = DB::getInstance();
		$stmt = $db->query("SELECT
									id,
									username,
									audit_id,
									audit_userid,
									audit_userip,
									audit_othus,
									audit_eventcode,
									audit_action,
									audit_itemid,
									audit_timestamp
			FROM audit LEFT JOIN users ON audit_userid = id
									WHERE
									audit_userid != ?
									AND audit_timestamp >= ?
									AND audit_timestamp <= ?
									AND audit_eventcode = ?
									ORDER BY audit_id DESC
			",[$userid,$start,$end,$eventcode]);
			$results = $stmt->results();
			$num_returns = $stmt->count();
			return $results;
			return $num_returns;
		}
	}

// simplest count function
if(!function_exists("countStuff")){
function countStuff($what)
	{
	$db = DB::getInstance();
	$stmt = $db->query("SELECT * FROM ?",[$what]);
	$result = $stmt->results();
	$num_returns = $stmt->count();
	return $result;
	return $num_returns;
	}
}

// greedy count function with a modifier
if(!function_exists("countLoginsSince")){
function countLoginsSince($eventcode,$since) {
	$db = DB::getInstance();
	$stmt = $db->query("SELECT * FROM audit WHERE audit_eventcode = ? AND audit_timestamp > ?",[$eventcode,$since]);
	$num_returns = $stmt->count();
	return $num_returns;
	}
}

// handy ago() function for UserSpice timestamps
if(!function_exists("ago")){
function ago($time) {
    $timediff=time()-$time;
    $days=intval($timediff/86400);
    $remain=$timediff%86400;
    $hours=intval($remain/3600);
    $remain=$remain%3600;
    $mins=intval($remain/60);
    $secs=$remain%60;

    if ($secs>=0) $timestring = $secs."s";//"0m".
    if ($mins>0) $timestring = $mins."m";//.$secs."s";
    if ($hours>0) $timestring = $hours."h";//.$mins."m";
    if ($days>0) $timestring = $days."d";//.$hours."h";

    return $timestring;
}
}

//Retrieve information for admin audit
if(!function_exists("fetchAllAudit")){
	function fetchAllAudit()
		{
		$db = DB::getInstance();
		$stmt = $db->query("SELECT
				id,
				username,
				audit_id,
				audit_userid,
				audit_userip,
				audit_othus,
				audit_eventcode,
				audit_action,
				audit_itemid,
				audit_timestamp
			FROM audit LEFT JOIN users ON audit_userid = id ORDER BY audit_id DESC");
			$results = $stmt->results();
			$count = $stmt->count();
			return $results;
			return $count;
		}
	}

		//Retrieve information for user audit
	if(!function_exists("fetchUserAudit")){
	function fetchUserAudit($userid)
		{
		$db = DB::getInstance();
		$stmt = $db->query("SELECT
				id,
				username,
				audit_id,
				audit_userid,
				audit_userip,
				audit_othus,
				audit_eventcode,
				audit_action,
				audit_itemid,
				audit_timestamp

			FROM audit LEFT JOIN users ON audit_userid = id WHERE audit_userid = ? ORDER BY audit_id DESC",[$userid]) ;
			$results = $stmt->results();
			$num_returns = $stmt->count();
			return $results;
			return $num_returns;
		}
}

if(!function_exists("writeAudit")){
 function writeAudit($userid,$userip,$othus,$event,$action,$itemid=0)
	{
	$db = DB::getInstance();
	$time = time();
	$stmt = $db->query("INSERT INTO audit (
	audit_userid,audit_userip,audit_othus,audit_eventcode,audit_action,audit_itemid,audit_timestamp
	)
	VALUES (
	?,
	?,
	?,
	?,
	?,
	?,
	?
)",[$userid,$userip,$othus,$event,$action,$itemid,$time]);
	$result = $stmt->results();
	return $result;
	}
}


	?>
