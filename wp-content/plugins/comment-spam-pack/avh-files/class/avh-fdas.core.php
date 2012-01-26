<?php
// Stop direct call
if ( preg_match( '#' . basename( __FILE__ ) . '#', $_SERVER['PHP_SELF'] ) ) {
	die( __( 'You are not allowed to call this page directly.', 'avh-fdas' ) );
}

class AVH_FDAS_Core
{
	/**
	 * Version of AVH First Defense Against Spam
	 *
	 * @var string
	 */
	var $version;
	var $db_version;

	/**
	 * Comments used in HTML do identify the plugin
	 *
	 * @var string
	 */
	var $comment;

	/**
	 * Paths and URI's of the WordPress information, 'home', 'siteurl', 'install_url', 'install_dir'
	 *
	 * @var array
	 */
	var $info;

	/**
	 * Options set for the plugin
	 *
	 * @var array
	 */
	var $options;

	/**
	 * Default options for the plugin
	 *
	 * @var array
	 */
	var $default_general_options;
	var $default_options;
	var $default_spam;
	var $default_honey;
	var $default_ipcache;
	var $default_nonces;
	var $data;
	var $default_data;
	var $default_data_lists;
	var $default_spam_data;
	var $default_nonces_data;

	/**
	 * Name of the options field in the WordPress database options table.
	 *
	 * @var string
	 */
	var $db_options_core;
	var $db_options_data;
	var $db_options_nonces;

	/**
	 * Endpoint of the stopforumspam.com API
	 *
	 * @var string
	 */
	var $stopforumspam_endpoint;

	var $searchengines;

	/**
	 * PHP5 constructor
	 *
	 */
	function __construct () {
		$this->version = "2.3.2";
		$this->db_version = 8;
		$this->comment = '<!-- AVH First Defense Against Spam - WPMU DEV Version version ' . $this->version;
		$this->db_options_core = 'avhfdas';
		$this->db_options_data = 'avhfdas_data';
		$this->db_options_nonces = 'avhfdas_nonces';

		/**
		 * Default options - General Purpose
		 */
		$this->default_general_options = array ('version' => $this->version, 'dbversion' => $this->db_version, 'use_sfs' => 1, 'use_php' => 0, 'useblacklist' => 1, 'usewhitelist' => 1, 'diewithmessage' => 1, 'emailsecuritycheck' => 0, 'useipcache' => 0, 'cron_nonces_email' => 0, 'cron_ipcache_email' => 0 );
		$this->default_spam = array ('whentoemail' => - 1, 'emailphp' => 0, 'whentodie' => 3, 'sfsapikey' => '', 'error' => 0 );
		$this->default_honey = array ('whentoemailtype' => - 1, 'whentoemail' => - 1, 'whentodietype' => 4, 'whentodie' => 25, 'phpapikey' => '', 'usehoneypot' => 0, 'honeypoturl' => '' );
		$this->default_ipcache = array ('email' => 0, 'daystokeep' => 7 );
		$this->default_spam_data = array ('190001' => 0 );
		$this->default_data_lists = array ('blacklist' => '', 'whitelist' => '' );

		/**
		 * Default Options - All as stored in the DB
		 */
		$this->default_options = array ('general' => $this->default_general_options, 'sfs' => $this->default_spam, 'php' => $this->default_honey, 'ipcache' => $this->default_ipcache );
		$this->default_data = array ('counters' => $this->default_spam_data, 'lists' => $this->default_data_lists );
		$this->default_nonces = array ('default' => $this->default_nonces_data );

		/**
		 * Set the options for the program
		 *
		 */
		$this->loadOptions();
		$this->loadData();
		$this->setTables();


		// Check if we have to do upgrades
		if ( (! isset( $this->options['general']['dbversion'] )) || $this->options['general']['dbversion'] < $this->db_version ) {
			$this->doUpgrade();
		}

		$this->searchengines = array ('0' => __( 'Undocumented', 'avh-fdas' ), '1' => 'AltaVista', '2' => 'Ask', '3' => 'Baidu', '4' => 'Excite', '5' => 'Google', '6' => 'Looksmart', '7' => 'Lycos', '8' => 'MSN', '9' => 'Yahoo', '10' => 'Cuil', '11' => 'InfoSeek', '12' => __( 'Miscellaneous', 'avh-fdas' ) );

		$info['siteurl'] = get_site_option( 'siteurl' );

		// Determine installation path & url
		// $info['home_path'] = get_home_path();
		$info['home_path'] = '';

		// Setup plugin path and url
		if ( defined( 'WPMU_PLUGIN_DIR' ) && file_exists( WPMU_PLUGIN_DIR . '/avh-fdas.php' ) ) {
			$info['plugin_dir'] = WPMU_PLUGIN_DIR . '/avh-files/';
			$info['plugin_url'] = WPMU_PLUGIN_URL . '/avh-files/';
		} else {
			$info['plugin_dir'] = WP_PLUGIN_DIR . '/' . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/';
			$info['plugin_url'] = WP_PLUGIN_URL . '/' . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/';
		}

		// Set class property for info
		$this->info = array ('home' => get_site_option( 'home' ), 'siteurl' => $info['siteurl'], 'plugin_url' => $info['plugin_url'], 'plugin_dir' => $info['plugin_dir'], 'graphics_url' => $info['plugin_url'] . '/images', 'home_path' => $info['home_path'] );
		$this->stopforumspam_endpoint = 'http://www.stopforumspam.com/api';

		// Localization.

		if ( defined( 'WPMU_PLUGIN_DIR' ) && file_exists( WPMU_PLUGIN_DIR . '/avh-fdas.php' ) ) {
			load_muplugin_textdomain( 'avh-fdas', 'avh-files/languages' );
		} else {
			load_plugin_textdomain( 'avh-fdas', false, dirname( plugin_basename( __FILE__ ) ) . '/avh-files/languages' );
		}

		return;
	}

	/**
	 * PHP4 constructor - Initialize the Core
	 *
	 * @return
	 */
	function AVH_FDAS_Core () {
		$this->__construct();
	}

	/**
	 * Setup DB Tables
	 * @return unknown_type
	 */
	function setTables ()
	{
		global $wpdb;

		// add DB pointer
		$wpdb->avhfdasipcache = $wpdb->prefix . 'avhfdas_ipcache';
	}

	/**
	 * Get the base directory of a directory structure
	 *
	 * @param string $directory
	 * @return string
	 *
	 */
	function getBaseDirectory ( $directory ) {
		//get public directory structure eg "/top/second/third"
		$public_directory = dirname( $directory );
		//place each directory into array
		$directory_array = explode( '/', $public_directory );
		//get highest or top level in array of directory strings
		$public_base = max( $directory_array );
		return $public_base;
	}

	/**
	 * Get the user's IP
	 *
	 * @return string
	 */
	function getUserIP ( $single = TRUE )
	{
		$ip = array ();

		if ( isset( $_SERVER ) ) {
			$ip[] = $_SERVER['REMOTE_ADDR'];

			if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
				$ip = array_merge( $ip, explode( ',', $_SERVER['HTTP_CLIENT_IP'] ) );
			}

			if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
				$ip = array_merge( $ip, explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
			}

			if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) ) {
				$ip = array_merge( $ip, explode( ',', $_SERVER['HTTP_X_REAL_IP'] ) );
			}
		} else {
			$ip[] = getenv( 'REMOTE_ADDR' );
			if ( getenv( 'HTTP_CLIENT_IP' ) ) {
				$ip = array_merge( $ip, explode( ',', getenv( 'HTTP_CLIENT_IP' ) ) );
			}

			if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
				$ip = array_merge( $ip, explode( ',', getenv( 'HTTP_X_FORWARDED_FOR' ) ) );
			}

			if ( getenv( 'HTTP_X_REAL_IP' ) ) {
				$ip = array_merge( $ip, explode( ',', getenv( 'HTTP_X_REAL_IP' ) ) );
			}
		}

		$dec_octet = '(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|[0-9])';
		$ip4_address = $dec_octet . '.' . $dec_octet . '.' . $dec_octet . '.' . $dec_octet;

		// Remove any non-IP stuff
		$x = count( $ip );
		$match = array ();
		for ( $i = 0; $i < $x; $i ++ ) {
			if ( preg_match( '/^' . $ip4_address . '$/', $ip[$i], $match ) ) {
				$ip[$i] = $match[0];
			} else {
				$ip[$i] = '';
			}
			if ( empty( $ip[$i] ) ) {
				unset( $ip[$i] );
			}
		}

		$ip = array_values( array_unique( $ip ) );
		if ( ! $ip[0] ) {
			$ip[0] = '0.0.0.0'; // for some strange reason we don't have a IP
		}
		$return = $ip[0];
		if ( ! $single ) {
			$return = join( ',', $ip );
		} else {

			// decide which IP to use, trying to avoid local addresses
			$ip = array_reverse( $ip );
			foreach ( $ip as $i ) {
				if ( preg_match( '/^(127\.|10\.|192\.168\.|172\.((1[6-9])|(2[0-9])|(3[0-1]))\.)/', $i ) ) {
					continue;
				} else {
					$return = $i;
					break;
				}
			}
		}
		return $return;
	}

	/**
	 * Local nonce creation. WordPress uses the UID and sometimes I don't want that
	 * Creates a random, one time use token.
	 *
	 * @param string|int $action Scalar value to add context to the nonce.
	 * @return string The one use form token
	 *
	 */
	function avh_create_nonce ( $action = -1 )
	{
		$i = wp_nonce_tick();
		return substr( wp_hash( $i . $action, 'nonce' ), - 12, 10 );
	}

	/**
	 * Local nonce verification. WordPress uses the UID and sometimes I don't want that
	 * Verify that correct nonce was used with time limit.
	 *
	 * The user is given an amount of time to use the token, so therefore, since the
	 * $action remain the same, the independent variable is the time.
	 *
	 * @param string $nonce Nonce that was used in the form to verify
	 * @param string|int $action Should give context to what is taking place and be the same when nonce was created.
	 * @return bool Whether the nonce check passed or failed.
	 */
	function avh_verify_nonce ( $nonce, $action = -1 )
	{
		$r = false;
		$i = wp_nonce_tick();
		// Nonce generated 0-12 hours ago
		if ( substr( wp_hash( $i . $action, 'nonce' ), - 12, 10 ) == $nonce ) {
			$r = 1;
		} elseif ( substr( wp_hash( ($i - 1) . $action, 'nonce' ), - 12, 10 ) == $nonce ) { // Nonce generated 12-24 hours ago
			$r = 2;
		}
		return $r;
	}

	/**
	 * Actual Rest Call
	 *
	 * @param array $query_array
	 * @return array
	 */
	function handleRESTcall ( $query_array )
	{
		$xml_array = array ();
		$querystring = $this->BuildQuery( $query_array );
		$url = $this->stopforumspam_endpoint . '?' . $querystring;
		// Starting with WordPress 2.7 we'll use the HTTP class.
		if ( function_exists( 'wp_remote_request' ) ) {
			$response = wp_remote_request( $url, array('user-agent' => 'WordPress/AVH '.$this->version.'; ' . get_bloginfo( 'url' )) );
			if ( ! is_wp_error( $response ) ) {
				$xml_array = $this->ConvertXML2Array( $response['body'] );
				if ( ! empty( $xml_array ) ) {
					// Did the call succeed?
					if ( 'true' == $xml_array['response_attr']['success'] ) {
						$return_array = $xml_array['response'];
					} else {
						if ( isset( $xml_array['response']['error'] ) ) {
							$return_array = array ('Error' => $xml_array['response']['error'] );
						} else {
							$return_array = array ('Error' => __( 'Unsuccesfull response from SFS', 'avh-fdas' ), 'Debug' => var_export( $response, true ) . "/n" . var_export( $xml_array, true ) );
						}
					}
				} else {
					$return_array = array ('Error' => __( 'Unknown response from stopforumspam', 'avh-fdas' ), 'Debug' => var_export( $response, true ) . "/n" . var_export( $xml_array, true ) );
				}
			} else {
				$return_array = array ('Error' => $response->errors );
			}
		}
		return ($return_array);
	}

	/**
	 * Format an error message from the WP_Error response by wp_remote_request
	 *
	 * @param array $error
	 * @return string
	 */
	function getHttpError ( $error )
	{
		if ( is_array( $error ) ) {
			foreach ( $error as $key => $value ) {
				$error_short = $key;
				$error_long = $value[0];
				$return = $error_short . ' - ' . $error_long;
			}
		} else {
			$return = $error;
		}
		return $return;
	}

	/**
	 * Convert an array into a query string
	 *
	 * @param array $array
	 * @param string $convention
	 * @return string
	 */
	function BuildQuery ( $array = NULL, $convention = '%s' ) {
		if ( count( $array ) == 0 ) {
			return '';
		} else {
			if ( function_exists( 'http_build_query' ) ) {
				$query = http_build_query( $array );
			} else {
				$query = '';
				foreach ( $array as $key => $value ) {
					if ( is_array( $value ) ) {
						$new_convention = sprintf( $convention, $key ) . '[%s]';
						$query .= $this->BuildQuery( $value, $new_convention );
					} else {
						$key = urlencode( $key );
						$value = urlencode( $value );
						$query .= sprintf( $convention, $key ) . "=$value&";
					}
				}
			}
			return $query;
		}
	}

	/**
	 * Convert XML into an array
	 *
	 * @param string $contents
	 * @param integer $get_attributes
	 * @param string $priority
	 * @return array
	 * @see http://www.bin-co.com/php/scripts/xml2array/
	 */
	function ConvertXML2Array ( $contents = '', $get_attributes = 1, $priority = 'tag' ) {
		$xml_values = '';
		$return_array = array ();
		$tag = '';
		$type = '';
		$level = 0;
		$attributes = array ();
		if ( function_exists( 'xml_parser_create' ) ) {
			$parser = xml_parser_create( 'UTF-8' );
			xml_parser_set_option( $parser, XML_OPTION_TARGET_ENCODING, "UTF-8" );
			xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
			xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 );
			xml_parse_into_struct( $parser, trim( $contents ), $xml_values );
			xml_parser_free( $parser );
			//Initializations
			$xml_array = array ();
			$parent = array ();
			$current = &$xml_array; // Reference
			// Go through the tags.
			$repeated_tag_index = array ();
			// Multiple tags with same name will be turned into an array
			foreach ( $xml_values as $data ) {
				unset( $attributes, $value ); //Remove existing values, or there will be trouble
				// This command will extract these variables into the foreach scope
				// tag(string), type(string), level(int), attributes(array).
				extract( $data ); //We could use the array by itself, but this cooler.
				$result = array ();
				$attributes_data = array ();
				if ( isset( $value ) ) {
					if ( $priority == 'tag' ) {
						$result = $value;
					} else {
						$result['value'] = $value; //Put the value in an associate array if we are in the 'Attribute' mode
					}
				}
				// Set the attributes too
				if ( isset( $attributes ) and $get_attributes ) {
					foreach ( $attributes as $attr => $val ) {
						if ( $priority == 'tag' )
							$attributes_data[$attr] = $val;
						else
							$result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
					}
				}
				// See tag status and do what's needed
				if ( $type == "open" ) { // The starting of the tag '<tag>'
					$parent[$level - 1] = &$current;
					if ( ! is_array( $current ) or (! in_array( $tag, array_keys( $current ) )) ) { //Insert New tag
						$current[$tag] = $result;
						if ( $attributes_data )
							$current[$tag . '_attr'] = $attributes_data;
						$repeated_tag_index[$tag . '_' . $level] = 1;
						$current = &$current[$tag];
					} else { // There was another element with the same tag name
						if ( isset( $current[$tag][0] ) ) { //If there is a 0th element it is already an array
							$current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
							$repeated_tag_index[$tag . '_' . $level] ++;
						} else { //This section will make the value an array if multiple tags with the same name appear together
							$current[$tag] = array ($current[$tag], $result );
							//This will combine the existing item and the new item together to make an array
							$repeated_tag_index[$tag . '_' . $level] = 2;
							if ( isset( $current[$tag . '_attr'] ) ) { // The attribute of the last(0th) tag must be moved as well
								$current[$tag]['0_attr'] = $current[$tag . '_attr'];
								unset( $current[$tag . '_attr'] );
							}
						}
						$last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
						$current = &$current[$tag][$last_item_index];
					}
				} elseif ( $type == "complete" ) { //Tags that ends in 1 line '<tag />'
					//See if the key is already taken.
					if ( ! isset( $current[$tag] ) ) { // New key
						$current[$tag] = $result;
						$repeated_tag_index[$tag . '_' . $level] = 1;
						if ( $priority == 'tag' and $attributes_data )
							$current[$tag . '_attr'] = $attributes_data;
					} else { //If taken, put all things inside a list(array)
						if ( isset( $current[$tag][0] ) and is_array( $current[$tag] ) ) {
							//This will combine the existing item and the new item together to make an array
							$current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
							if ( $priority == 'tag' and $get_attributes and $attributes_data ) {
								$current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
							}
							$repeated_tag_index[$tag . '_' . $level] ++;
						} else { //If it is not an array...
							$current[$tag] = array ($current[$tag], $result ); //...Make it an array using using the existing value and the new value
							$repeated_tag_index[$tag . '_' . $level] = 1;
							if ( $priority == 'tag' and $get_attributes ) {
								if ( isset( $current[$tag . '_attr'] ) ) { //The attribute of the last(0th) tag must be moved as well
									$current[$tag]['0_attr'] = $current[$tag . '_attr'];
									unset( $current[$tag . '_attr'] );
								}
								if ( $attributes_data ) {
									$current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
								}
							}
							$repeated_tag_index[$tag . '_' . $level] ++; //0 and 1 index is already taken
						}
					}
				} elseif ( $type == 'close' ) { //End of tag '</tag>'
					$current = &$parent[$level - 1];
				}
			}
			$return_array = $xml_array;
		}
		return ($return_array);
	}

	/**
	 * Parameter for Rest Call IP Lookup
	 *
	 * @param string $ip
	 * @return array
	 */
	function getRestIPLookup ( $ip )
	{
		$iplookup = array ('ip' => $ip );
		return $iplookup;
	}

	/*********************************
	 *                               *
	 * Methods for variable: options *
	 *                               *
	 ********************************/

	/**
	 * @param array $data
	 */
	function setOptions ( $options )
	{
		$this->options = $options;
	}

	/**
	 * return array
	 */
	function getOptions ()
	{
		return ($this->options);
	}

	/**
	 * Save all current options and set the options
	 *
	 */
	function saveOptions ( $options )
	{
		update_site_option( $this->db_options_core, $options );
		wp_cache_flush(); // Delete cache
		$this->setOptions( $options );
	}

	/**
	 * Retrieves the plugin options from the WordPress options table and assigns to class variable.
	 * If the options do not exists, like a new installation, the options are set to the default value.
	 *
	 * @return none
	 */
	function loadOptions ()
	{
		$options = get_site_option( $this->db_options_core );
		if ( false === $options ) { // New installation
			$this->resetToDefaultOptions();
		} else {
			$this->setOptions( $options );
		}
	}

	/**
	 * Get the value for an option element. If there's no option is set on the Admin page, return the default value.
	 *
	 * @param string $key
	 * @param string $option
	 * @return mixed
	 */
	function getOptionElement ( $option, $key )
	{
		if ( $this->options[$option][$key] ) {
			$return = $this->options[$option][$key]; // From Admin Page
		} else {
			$return = $this->default_options[$option][$key]; // Default
		}
		return ($return);
	}

	/**
	 * Reset to default options and save in DB
	 *
	 */
	function resetToDefaultOptions ()
	{
		$this->options = $this->default_options;
		$this->saveOptions( $this->default_options );
	}

	/******************************
	 *                            *
	 * Methods for variable: data *
	 *                            *
	 *****************************/

	/**
	 * @param array $data
	 */
	function setData ( $data )
	{
		$this->data = $data;
	}

	/**
	 * @return array
	 */
	function getData ()
	{
		return ($this->data);
	}

	/**
	 * Save all current data to the DB
	 * @param array $data
	 *
	 */
	function saveData ( $data )
	{
		update_site_option( $this->db_options_data, $data );
		wp_cache_flush(); // Delete cache
		$this->setData( $data );
	}

	/**
	 * Retrieve the data from the DB
	 *
	 * @return array
	 */
	function loadData ()
	{
		$data = get_site_option( $this->db_options_data );
		if ( false === $data ) { // New installation
			$this->resetToDefaultData();
		} else {
			$this->setData( $data );
		}
		return;
	}

	/**
	 * Get the value of a data element. If there is no value return false
	 *
	 * @param string $option
	 * @param string $key
	 * @return mixed
	 * @since 0.1
	 */
	function getDataElement ( $option, $key )
	{
		if ( $this->data[$option][$key] ) {
			$return = $this->data[$option][$key];
		} else {
			$return = false;
		}
		return ($return);
	}

	/**
	 * Reset to default data and save in DB
	 *
	 */
	function resetToDefaultData ()
	{
		$this->data = $this->default_data;
		$this->saveData( $this->default_data );
	}

	/*********************************
	 *                               *
	 * Methods for variable: comment *
	 *                               *
	 *********************************/

	/**
	 * @return string
	 */
	function getComment ( $str = '' )
	{
		return $this->comment . ' ' . trim( $str ) . ' -->';
	}

} //End Class AVH_FDAS_Core
