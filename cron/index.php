<?php
require_once __DIR__ .'\twitteroauth\autoload.php';
require('../wp-blog-header.php');
use Abraham\TwitterOAuth\TwitterOAuth;

$consumer = "36ckd4ByGqIkX4McszyEHv0oF";
$consumer_secret="RtaefSIDtR7WxHlm1yYaZTBkimtV0ZilfrFutskJQqXOY1PRR8";
$access = "966488852-vOfZzsK6RPyWlKvgBGj4M9pdLcHXezOYzqQidWyE";
$access_secret="JWswhNSWzrIn61YUHYFyT7ulJtdpiXFGIEhpfiy3arp2B";

$connection = new TwitterOAuth($consumer,$consumer_secret,$access,$access_secret);
$content = $connection->get("account/verify_credentials");


  $tweets = $connection->get("statuses/user_timeline",['count' => 50,'exclude_replies' => true,'screen_name'=>'altmanagerhq','result_type'=>'recent','tweet_mode'=>'extended']);

  $data;
  $data2;
  $tweet_date;
  $count = 1;
  foreach($tweets as $key) {
  $data[$count-1]=$key->full_text;
  $tweet_date[$count-1]=$key->created_at;
  $count++;
  }


  $extracted;
  $index=0;

  foreach ($data as $key => $value) {
  if(preg_match("/([$]+)(.*)(SIGNAL)+/s", $value)){


  $data2 = preg_split("/[\s,]+/", $value,4);

  unset($data2[0]);
  unset($data2[2]);
  $data2 = array_merge($data2);

  //---------name
  $extracted[$index][0]=$data2[0];

  // ------ P/V
  if(preg_match("/Price/i", $data2[1]))
  $extracted[$index][1]="Price";
  else
  $extracted[$index][1]="Volume";

  // ------ U/D
  if(preg_match("/up/i", $data2[1]))
  $extracted[$index][2]="Up";
  else
  $extracted[$index][2]="Down";

  //--- 1H value
  $data3 = preg_split("/1H \(/", $data2[1],2);
  $extracted[$index][3]=preg_split("/%\)/",$data3[1],2)[0];

  //--- 4H value
  $data3 = preg_split("/4H \(/", $data2[1],2);
  $extracted[$index][4]=preg_split("/%\)/",$data3[1],2)[0];

  // V/P change
  $data3 = preg_split("/[Price:|Volume:]+/", $data3[1],2);
  $data3 = preg_split("/(🕒)+/", $data3[1],2);


  $extracted[$index][5]=$data3[0];
  //$extracted[$index][6]=$data3[1];

  // ---- 1D value
  $data3 = preg_split("/1D \(/", $data2[1],2);
  $extracted[$index][6]=preg_split("/%\)/",$data3[1],2)[0];
  // ---- 1D %
  if($extracted[$index][1]=="Volume"){
  $data3 = preg_split("/( - )+/", $data3[1],2);
  $extracted[$index][7]=preg_split("/[\n]/",$data3[1],2)[0];
  }else
  $extracted[$index][7]="";

  //---- 7D value
  $data3 = preg_split("/7D \(/", $data2[1],2);
  $extracted[$index][8]=preg_split("/%\)/",$data3[1],2)[0];
  //---- 7D %
  if($extracted[$index][1]=="Volume"){
  $data3 = preg_split("/( - )+/", $data3[1],2);
  $extracted[$index][9]=preg_split("/[\n]/",$data3[1],2)[0];
  }else
  $extracted[$index][9]="";

  $index++;
  }

  }
    $index = 0;
$extracted = array_reverse($extracted);
  foreach ($extracted as $row){
  $dt = $tweet_date[$index];

  $postTitle = $row[0].' '.$row[1].' '.$row[2].' Signal';

  $posts = get_posts(['meta_key' => 'tweet_dateTime', 'meta_value' => $dt]);

       if (count($posts) == 0){
          $post = array(
                'post_author' =>1,
                'post_status' => 'publish',
                'post_title' => $postTitle,
                'post_content' => "
                <table  style='border: 1px solid #ddd;text-align: left;border-collapse: collapse;width: 100%;'>
                <tbody>
                <tr>
                  <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>1H: </td>
                  <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>".$row[3]."%</td>
                </tr>
                <tr>
                  <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>4H: </td>
                  <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>".$row[4]."%</td>
                </tr>
                <tr>
                <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>".$row[1].": </td>
                <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>".trim($row[5])."</td>
                </tr> 
                <tr>
                <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>1D: </td>
                <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>(".$row[6]."%) - ".$row[7]."</td>
                </tr>
                <tr>
                <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>7D: </td>
                <td  style='border: 1px solid #ddd;text-align: left;padding: 15px;'>(".$row[8]."%) - ".$row[9]."</td>
                </tr>
                </tbody>
                </table>
                "
              );
              $post_id = wp_insert_post($post);
              add_post_meta($post_id,"tweet_dateTime",$dt,true);
              $row[0] = str_replace('$', '', $row[0]);
              //wp_set_post_terms( $post_id,$row[0],'coin',true);
              wp_set_object_terms( $post_id, $row[0], 'category',true );
   
          $index++;

    }

  }
 echo "Done with fetching successfully!";
?>
