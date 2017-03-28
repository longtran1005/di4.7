<?php

    ini_set('display_errors', false);
    ini_set('max_execution_time', 600);

const CLASS_WIDGET = 'widget';
const CLASS_WIDGET_RIGHT = 'widget imgright';
const CLASS_WIDGET_LEFT = 'widget imgleft';
const FONT_SIZE_HEADER_NORMAL = 'headline-normal';
const FONT_SIZE_HEADER_BIG = 'headline-big';
const FONT_SIZE_HEADER_BIGGEST = 'headline-biggest';
const TYPE_DISPLAY_LEFT = 'image-left';
const TYPE_DISPLAY_RIGHT = 'image-right';
const TYPE_DISPLAY_CENTER = '';
const DIS_AUTH = "WebApiAuth";
const DIS_LOGIN_USERNAME = "Borsappen";
const DIS_LOGIN_PWD = "jv5CUSz74unk6uFd4CXb";
const DIS_PREPATH = "/webapi/";
const DI_SERVICE_PROD = "http://www.di.se";


if ($_GET['callback']) {
    //jsonp called
    header('Content-type: application/x-javascript');
}else{
    header('content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
}




$function = $_GET['function'];
if (function_exists($function)) {
    $function();
} else {
    echo json_encode(array("status" => "error", "msg" => 'function not existed1'));
    exit();
}

/*
 * Get list articles for home page
 * JSONP calling example:  $.getJSON('http://reserv.di.se/di-api-functions.php?function=getArticleList&callback=?', function(data) {
                console.log(data[0].articles);
            })
 *
 *
 */
function getArticleList(){
    require_once(dirname(__FILE__) . '/wp-load.php');


    //When setting is not get api function
    $run_api = get_option('api_setting');
    if(!$run_api){
        $rs = json_encode(array(
                'status' => 'success',
                'msg' => 'Api disabled by admin',
                'articles' => array()
            )
        );

        if ($_GET['callback']) {
            //in case JSONP
            echo $_GET['callback']."([".$rs."])";
            exit();
        } else {
            echo $rs;
            exit();
        }
    }
    $rs = "";
    $limit = $_GET['limit'];
    $cache_file = dirname( __FILE__ ) .  "/wp-content/cache/api_". md5('getArticleList').".txt";

    if (file_exists($cache_file) && (filemtime($cache_file) + 120) > time() ) {
        $list_articles = file_get_contents($cache_file);
        $list_articles = json_decode($list_articles, true);
    }

    if (!$list_articles || !is_array($list_articles)) {
//        require_once(dirname(__FILE__) . '/wp-load.php');
        $frontpage_id = get_option('page_on_front');
        $list_articles = array();
        $posts_hompage = get_field("articles_on_home_page", $frontpage_id);

        if ($posts_hompage) {
            foreach ($posts_hompage as $row) {
                $currentTime = current_time('timestamp');
                if(strtotime($row->post_date) <= $currentTime):
                $row_link = get_permalink($row->ID);
                $thumbnail = get_post_thumbnail_id($row->ID);
                $type_display = get_field('type_display_on_home_page', $row->ID);
                $title = $row->post_title;
                $summary = get_field("summary", $row->ID);
                $post_content = $row->post_content;
                $img_caption = get_post(get_post_thumbnail_id())->post_excerpt;

                $image_src = "";
                $font_size_class = "";
                $img_url = "";
                $headline_font_size = get_field('headline_font_size', $row->ID);
                $font_size_class = MipTheme_Util::getHeadlineFontSize($headline_font_size, $type_display, $row->post_title);

                if ($type_display == "image-left" || $type_display == "image-right") {
                    $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-2');

                    if ($type_display == "image-left") {
                        $class = "imgleft";
                    } else {
                        $class = "imgright";
                    }
                } else {
                    $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-wide');
                }



                $img_url = $image_src[0];
                $img_thumbnail = wp_get_attachment_image_url($thumbnail,"thumbnail");
                $img_medium = wp_get_attachment_image_url($thumbnail,"medium");
                $img_large = wp_get_attachment_image_url($thumbnail,"large");




                $record = array(
                    'row_link' => $row_link,
                    //'thumbnail' => $thumbnail,
                    //'class_display_image' => $class,
                    'summary' => $summary,
                    'title' => $title,
                    'font_size_class' => $font_size_class,
                    'img_url' => $img_url,
                    //'post_content' => $post_content
                    'type_display' => $type_display,
                    'img_thumbnail' => ($img_thumbnail) ? $img_thumbnail : null,
                    'img_medium' => ($img_medium) ? $img_medium : null,
                    'img_large' => ($img_large) ? $img_large : null,
                    'img_caption' => get_post(get_post_thumbnail_id($row->ID))->post_excerpt
                );
                array_push($list_articles, $record);
                endif; //endif
            }//endforeach

            $json_string = wp_json_encode($list_articles);

            if ($json_string) {
                file_put_contents($cache_file,$json_string);
            }
        }
    }

    if ($limit) {
        $return_articles = array_slice($list_articles, 0, $limit);
    } else {
        $return_articles = $list_articles;
    }
    $rs = json_encode(array(
            'status' => 'success',
            'articles' => $return_articles
        )
    );

    if ($_GET['callback']) {
        //in case JSONP
        echo $_GET['callback']."([".$rs."])";
        exit();
    } else {
        echo $rs;
        exit();
    }
}



function test(){
    // Step 1: Get UTC time and convert to yyyy-MM-dd hh:mm:ss
    date_default_timezone_set('GMT');
    $dateString = date('m/d/Y H:m:s');
//    $dateString = '04/15/2016 04:26:44';
//    EEE, dd MMM yyyy HH:mm:ss zzz "Thu, 14 Apr 2016 11:04:18 GMT"
    $dateServerString = date('D, d M Y H:i:s T');
//    $dateServerString = 'Fri, 15 Apr 2016 04:26:44 GMT';
    $after_url = 'teasers/haspremiumsource/maincolumn/';
    $content = 'GET' . $dateString . DIS_LOGIN_USERNAME . DIS_PREPATH.$after_url;
    $signnature = MipTheme_Util::createSignature(DIS_LOGIN_PWD, $content);

    $url = DI_SERVICE_PROD . DIS_PREPATH . $after_url;
    $header = array(
//                    'dateString' => $dateString,
        'WebApiAuth-Username' => DIS_LOGIN_USERNAME,
        'Date' => $dateServerString,
        'Authorization' => DIS_AUTH . " " . $signnature,
//                    'url' => $url
    );
//var_dump($header);die();
    $url1 = $url. "?Authorization=".$header['Authorization']."&Date=". $header['Date']."&WebApiAuth-Username=".$header['WebApiAuth-Username'];
//    $url = 'http://www.omaroid.com/php-get-and-set-custom-http-headers/';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST,0);
//    curl_setopt($ch, CURLOPT_POSTFIELDS,$header);  //Post Fields

//    curl_setopt($ch, CURLOPT_HEADER, FALSE);
//    curl_setopt($ch, CURLOPT_NOBODY, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, DIS_LOGIN_USERNAME.":".DIS_LOGIN_PWD);

//    echo $url1;die();
    $headers = array();
    $headers[] = 'X-Apple-Tz: 0';
    $headers[] = 'X-Apple-Store-Front: 143444,12';
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
//    $headers[] = 'Accept-Encoding: gzip, deflate, UTF-8';
    $headers[] = 'Accept-Language: en-US,en;q=0.5';
    $headers[] = 'Cache-Control: no-cache';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
//    $headers[] = 'Host: '.$url;
    $headers[] = 'Referer: '.$url; //Your referrer address
    $headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';
    $headers[] = 'X-MicrosoftAjax: Delta=true';
    $headers[] = 'Date: '. $dateServerString;
    $headers[] = 'Authorization: ' . DIS_AUTH . " " . $signnature;
    $headers[] = 'WebApiAuth-Username: '. DIS_LOGIN_USERNAME;

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec ($ch);

    curl_close ($ch);

    print_r(json_encode( $server_output)) ;die();


}

function crawlArticlesList(){
    require_once(dirname(__FILE__) . '/wp-load.php');
//    if(!$_GET['count']){
//        MipTheme_Util::createTableStoreLinkArticle();
//        $listArticle = MipTheme_Util::crawlArticleList();
//        print_r($listArticle);
//        if($listArticle) {
//            foreach($listArticle as $article) {
//                MipTheme_Util::insertDataToCrawlerLinkPost($article);
//            }
//        }
//    }
//    $data = MipTheme_Util::getDataFromCrawlerLinkPost();
//    MipTheme_Util::deleteDataOfCrawlerLinkPost($data['id']);
//    if($data){
//        $detail = MipTheme_Util::getArticleDetail($data['post_url']);
////        print_r($detail);die();
//        if($detail){
//            $data['img_article_url'] = $detail['img_article_url'];
//            $data['post_content'] = $detail['content'];
//            $data['img_author_url'] = $detail['img_author_url'];
//            $data['author_name'] = $detail['author_name'];
//            $data['author_email'] = $detail['author_email'];
//            $data['title_for_article'] = $detail['title_for_article'];
//            $data['image_article_caption'] = $detail['image_article_caption'];
//            $data['post_date'] = date('Y-m-d H:i:s',strtotime($detail['post_date']));
//            $id = MipTheme_Util::insertPost($data);
//        }
//    }
//
//    $data = MipTheme_Util::getDataFromCrawlerLinkPost();
//    if($data){
//        header( "refresh:30;url=api-functions.php?function=crawlArticlesList&count=2" );
//    } else {
//        echo "Crawl data complete.";
//        exit;
//    }

        $listArticle = MipTheme_Util::crawlArticleList();
//        print_r($listArticle);
        if($listArticle) {
            foreach($listArticle as $data) {
                $detail = MipTheme_Util::getArticleDetail($data['post_url']);
                if($detail){
                    $data['img_article_url'] = $detail['img_article_url'];
                    $data['post_content'] = $detail['content'];
                    $data['img_author_url'] = $detail['img_author_url'];
                    $data['author_name'] = $detail['author_name'];
                    $data['author_email'] = $detail['author_email'];
                    $data['title_for_article'] = $detail['title_for_article'];
                    $data['image_article_caption'] = $detail['image_article_caption'];
                    $data['post_date'] = date('Y-m-d H:i:s',strtotime($detail['post_date']));
                    $data["img_caption"] = $detail["img_caption"];
                    $id = MipTheme_Util::insertPost($data);
                }
            }
            echo "Crawl data complete.";
            exit();
        }
}

//-----------------------------------------  BEGIN HIEULC function ------------------------
/*
 * author: HieuLC
 * desc: delete no-published post with date over 1 weeek
 */
function deleteNonPublishedOldPost (){
    require_once(dirname(__FILE__) . '/wp-load.php');
    global $wpdb;
    $sql = "DELETE FROM `wp_posts` WHERE `post_type` = 'post' AND `post_status` = 'draft' AND DATEDIFF(NOW(), `post_date`) > 7";
    $wpdb->query($sql);
    echo "Delete old articles completed.";
    exit();
}

function test1()
{
    $home_page_content = file_get_contents('http://vnexpress.net/', false, null, -1);
    //echo json_encode($home_page_content, true);
    echo $home_page_content;
    exit();
}

//-----------------------------------------  END HIEULC function ------------------------


