<?php
class api {
	var $url;
	
	public function get_api_data() {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
		$data = json_decode($data);

		if (!$data) {
			throw new Exception('get_api_data: No data found. ');
		}
        return $data;
    }

};

function clean_url($url) {


	if (strpos ($url, 'movies.netflix.com/WiMovie') !== false) {
		$url = parse_url($url);
		parse_str($url['path'], $query);
		$temp = preg_split("/[\/]+/", key($query));
		$url = 'http://movies.netflix.com/WiPlayer?movieid='.end($temp);
		return $url;
	} else if (strpos ($url, 'movies.netflix.com/WiPlayer') !== false) {
		$url = parse_url($url);
		parse_str($url['query'], $query);
		$url = 'http://movies.netflix.com/WiPlayer?movieid='.$query['movieid'];
		return $url;
	} else {
		return 0;
	}
}
?>