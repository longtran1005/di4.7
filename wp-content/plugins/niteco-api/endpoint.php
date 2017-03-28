<?php

/**
 * @package Niteco-api
 */

/**
 * Class Niteco_API_Endpoint webservice
 */
class Niteco_API_Endpoint
{
    public function __construct()
    {
        add_filter('query_vars', array($this, 'add_query_vars'), 0);
        add_action('init', array($this, 'add_endpoint'), 0);
        add_action('parse_request', array($this, 'sniff_requests'), 0);
    }

    public function is_valid_user()
    {
        return true;

        $headers = apache_request_headers();
        $authKey = @trim($headers['auth_key']);
        // for test
        if (!$authKey) {
            $authKey = @trim($_GET['auth_key']);
        }
        if ($authKey) {
            global $wpdb;
            $result = $wpdb->get_row("SELECT * FROM `wp_keys` WHERE auth_key = '$authKey'");
            if ($result && $result->id) {
                return true;
            }
        }
        return false;
    }

    public function hashCode($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function getParam($name)
    {
        if (isset($_REQUEST[$name])) {
            return $_REQUEST[$name];
        }
        return null;
    }

    public function add_query_vars($vars)
    {
        $vars[] = '__api';
        $vars[] = 'action';
        return $vars;
    }

    public function add_endpoint()
    {
        add_rewrite_rule('(.*)webservice/([^/]+)$', 'index.php?__api=1&action=$matches[2]', 'top');
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }

    public function sniff_requests(&$wp)
    {
        if (isset($wp->query_vars['__api'])) {
            header('Content-Type: application/json');
            $action = $wp->query_vars['action'];
            if ($action == 'get_authentication') {
                $this->get_authentication();
            } else {
                if (!($user = $this->is_valid_user())) {
                    $this->response('0003');
                }
                if (method_exists($this, $action)) {
                    call_user_func_array(array($this, $action), array());
                } else {
                    $this->response('0000');
                }
            }
        }
    }

    public function response($code, $response = array())
    {
        $codeMsg = array(
            '0000' => 'Error occured',
            '0001' => 'Success',
            '0002' => 'Authentication error. Try again later.',
            '0003' => 'Access denied. Please contact administrator.',
            '0004' => 'Email already registered',
            '0005' => 'Image upload error',
            '0006' => 'You are not logged in from this device',
            '0007' => 'User is inactive.',
            '0008' => 'User profile not complete',
            '0009' => 'User profile already complete.',
            '0010' => 'A password reset link has been sent to your nominated email address.',
            '0011' => 'No Categories',
            '0012' => 'No Listing',
            '0013' => 'No Articles',
            '0014' => 'Invalid Post',
            '0018' => 'Invalid Request',
            '0019' => 'Username Already Exists',
            '0020' => 'Username Available',
            '0021' => 'Email doesn\'t exists',
            '0022' => 'Old password doesn\'t match',
            '0023' => 'User already active',
            '0024' => 'Regions not found',
            '0025' => 'Email address not found.'
        );
        $returnArr = array(
            'code' => $code,
            'msg' => $codeMsg[$code],
            'date_time' => time()
        );
        $returnArr = array_merge($returnArr, $response);
		
		$rs = json_encode($returnArr);
		
		if ($_GET['callback']) {
				//in case JSONP
				header('content-type: application/json; charset=utf-8');
				header('Access-Control-Allow-Origin: *');
				echo $_GET['callback']."([".$rs."])";
				exit();
		} else {
			//jsonp called
			header('Content-type: application/x-javascript');
			echo $rs;
			exit();
		}
    }

    /***************************************************************************
     * function to support api
     ***************************************************************************/
    public function get_authentication()
    {
        global $wpdb;
        $authKey = $this->hashCode();
        $result = $wpdb->get_row("SELECT * FROM `wp_keys` WHERE auth_key = '$authKey'");
        if ($result && $result->id) {
            return $this->response('0002');
        } else {
            $wpdb->insert('wp_keys', array('auth_key' => $authKey));
            return $this->response('0001', array('authentication_key' => $authKey));
        }
        return $this->response('0000');
    }

    public function get_test()
    {
        $cat_id = $this->getParam('bokhi');

        $return = array('abc'=> $cat_id);
        return $this->response('0001', $return);
    }
	
	public function getArticleList()
	{
		//When setting is not get api function
		$run_api = get_option('api_setting');
		if(!$run_api){
			$rs = array(
					'status' => 'success',
					'msg' => 'Api disabled by admin',
					'articles' => array()				
				);
			return $this->response('0001', $rs);
		}
		$rs = "";
		$limit = $_GET['limit'];
		$cache_file = plugin_dir_path( __FILE__ ) .  "/../../cache/api_". md5('getArticleList').".txt";

		if (file_exists($cache_file) && (filemtime($cache_file) + 120) > time() ) {
			$list_articles = file_get_contents($cache_file);
			$list_articles = json_decode($list_articles, true);
		}

		if (!$list_articles || !is_array($list_articles)) {	
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
						'img_thumbnail' => wp_get_attachment_image_url($thumbnail,"thumbnail"),
						'img_medium' => wp_get_attachment_image_url($thumbnail,"medium"),
						'img_large' => wp_get_attachment_image_url($thumbnail,"large"),
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
		$rs = array(
				'status' => 'success',
				'articles' => $return_articles
		);
		return $this->response('0001', $rs);		
	}


}