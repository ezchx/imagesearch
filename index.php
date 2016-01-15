<?

// read parameters from url

$offset = $_GET['offset'];
$offset += 1;
//if ($offset == "") {$offset = 1;}
$url_split = explode('?', $_SERVER['REQUEST_URI'], 2);
$search_string = str_replace("/imagesearch/","",$url_split[0]);


// if search_string = "latest" output last 5 searches

if ($search_string === "latest") {

  mysql_connect(localhost,$username,$pw);
  @mysql_select_db($database) or die( "Unable to select database");

  $query = "SELECT search_string, time_stamp FROM image_search ORDER BY time_stamp DESC LIMIT 5";
  $result = mysql_query($query);
  mysql_close();

  while($row = mysql_fetch_assoc($result)){
    $latest_searches[] = $row;
  }

  echo json_encode($latest_searches);

  exit;

}


// save search string to database

if ($search_string != "") {

  mysql_connect(localhost,$username,$pw);
  @mysql_select_db($database) or die( "Unable to select database");

  $query = "INSERT INTO image_search(search_string) VALUES('$search_string')";

  mysql_query($query);
  mysql_close();

}


// run the Google API and save the results to an array

$url = "https://www.googleapis.com/customsearch/v1?searchType=image&cx=015245204585066338781:whl0rutdhcm&key=AIzaSyDvUqmpSvqG9M7IFf_nJA3Ddfsu7mGHmRY&q=$search_string&start=$offset";

$search_results = file_get_contents($url);
$sr = json_decode($search_results,1);


// save the selected data {image url, alt text, & page url}

foreach($sr[items] as $row) {

  $output[] = array('image_url' => $row[link], 'alt_text' => $row[snippet], 'link_url' => $row[image][contextLink]);

}


// output the results

echo json_encode($output, JSON_UNESCAPED_SLASHES);


?>