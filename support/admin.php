<?
session_start();
@header("Cache-control: private");

include_once("class.ticket.php");
include_once("config.php");

session_register("view");
session_register("user");

if ($_POST[view_answered_x]) {
    $_SESSION[view] = "Answered";
}
elseif ($_POST[view_closed_x]) {
    $_SESSION[view] = "Closed";
}
elseif ($_POST[view_open_x]) {
    $_SESSION[view] = "Open";
}

if (!$_REQUEST[a]) {
    if ($_POST[close_x]) {
        $_REQUEST[a] = "close";
    }
    elseif ($_POST[reopen_x]) {
        $_REQUEST[a] = "reopen";
    }
    elseif ($_POST[delete_x]) {
        $_REQUEST[a] = "delete";
    }
}

if ($config[answer_method] == "pop3") {
    @include_once("automail.php");
}

if ((!$_POST[username] or !$_POST[password]) and $_SESSION[user][type] !== "admin" and !$_POST[submit]) {
    $inc = "admin_login";
}
else {
    $a = strtolower($_REQUEST[a]);
    
    $_SESSION[user][id] = $_POST[login_user] ? $_POST[login_user]: $_SESSION[user][id];
    $_SESSION[user][pass] = $_POST[login_pass] ? md5($_POST[login_pass]): $_SESSION[user][pass];

    $oslogin = login("admin", $_SESSION[user][id], $_SESSION[user][pass]);
    if ($oslogin[ID]) {
        $_SESSION[user][type] = "admin";
        $oslogin[cat_access] = explode(":", $oslogin[cat_access]);
    }
	if ($oslogin[name]) {
		switch ($a) {
			case "view":
			    $titles[viewticket] .= " [#$id]";
				$inc = "viewticket";
			break;
            case "delete":
                if (count($_POST[t])) {
				    foreach ($_POST[t] as $id => $val) {
                        DeleteTicket($id);
					}
				}
			break;
			case "close":
                if (count($_POST[t])) {
					foreach ($_POST[t] as $id => $val) {
						CloseTicket($id);
					}
				}
            break;
			case "reopen":
				if (count($_POST[t])) {
                    foreach ($_POST[t] as $id => $val) {
						ReopenTicket($id);
					}
				}
			break;
			case "post":
			if ($_POST[message]) {
				$reps_row = mysql_fetch_array(mysql_query("SELECT ID FROM ticket_reps WHERE username='" . $_SESSION[user][id] . "'"));
				$msg_row = mysql_fetch_array(mysql_query("SELECT ticket FROM ticket_messages WHERE ID='$_POST[id]'"));

                $id = $_REQUEST[id];
                $_REQUEST[id] = $msg_row[ticket];
                if (!$_POST[priv]) {
                     if ($config[attachment_size] >= $_FILES[attachment][size])
		     	$iid = PostAnswer($_POST[message], $reps_row[ID], $id, $_FILES[attachment]);
		     else
		     	$iid = PostAnswer($_POST[message], $reps_row[ID], $id);

        			if ($iid) {
					    $ext = preg_replace("/.*\.(.{3,4})$/", "$1", $_FILES[attachment][name]);
					    if ($_FILES[attachment][name]) {
					    	if ($config[accept_attachments] and stristr($config[filetypes], ".$ext;") && $_FILES['attachment']['size'] != 0 && $_FILES['attachment']['size']<$config[attachment_size]) {
								 mt_srand(time());
								 $rand = mt_rand(100000, 999999);

	        				     $attach = $rand . "_" . $_FILES[attachment][name];
	        			         copy($_FILES[attachment][tmp_name], "$config[attachment_dir]/" . $attach);
	        			         mysql_query("INSERT INTO ticket_attachments (ticket, ref, filename, type) VALUES ('$_REQUEST[id]', '$iid', '$attach', 'a')");
		        			}
                                                else if($_FILES['attachment']['size'] == 0 || $_FILES['attachment']['size']>=$config[attachment_size]){
	        			    	    $err = "Wrong file size.<p>Maximum File Size (bytes):".$config[attachment_size]."<p>";
                                                }
	        			        else {
	        			    	    $err = "We don't support the file type '$ext'.<p>";
						}
					    }

                        if ($close) {
    				        CloseTicket($id);
                            $inc = "main";
                        }
                        else {
    				        $inc = "viewticket";
    				    }
    				}
    				else {
    				    $err = "Could not post your message.";
    				}
    			}
    			else {
    			    $gmtime = (time() - date("Z")) + 3600;
					$ext = preg_replace("/.*\.(.{3,4})$/", "$1", $_FILES[attachment][name]);
					if ($_FILES[attachment][name]) {
					    if ($config[accept_attachments] and strstr($config[filetypes], ".$ext;") && $_FILES[attachment][size] !=0 && $_FILES['attachment']['size'] < $config[attachment_size]) {
          					mt_srand(time());
							$rand = mt_rand(100000, 999999);
								 
	    			         $attachment = $rand . "_" . $_FILES[attachment][name];
	    			         copy($_FILES[attachment][tmp_name], "$config[attachment_dir]/" . $attachment);
    			        }
                                else if($_FILES['attachment']['size'] == 0 || $_FILES['attachment']['size']>=$config[attachment_size]){
       			    	    $err = "Wrong file size.<p>Maximum File Size (bytes):".$config[attachment_size]."<p>";
                                }
    			        else {
	        			    $err = "We don't support the file type '$ext'.<p>";
						}
    			    }
    			    else {
    			        $attachment = "";
    			    }
    			    mysql_query("INSERT INTO ticket_privmsg (ticket, rep, message, attachment, timestamp) VALUES ('$_REQUEST[id]', " . $reps_row[ID] . ", '$_POST[message]', '$attachment', FROM_UNIXTIME('$gmtime') + 0)");
    			    $inc = "viewticket";
    			}
    			if ($_POST[close]) {
			    $inc = "main";
    			    mysql_query("UPDATE tickets SET status='closed' WHERE ID='$_REQUEST[id]'");
    			}
    		}
    		else {
    		    $err = "Required fields missing.";
    		}
			break;
			case "logout":
                session_destroy();
                $inc = "admin_login";
            break;
            case "headers":
                $message = mysql_fetch_array(mysql_query("SELECT headers FROM ticket_messages WHERE ID='$_GET[msg]'"));
                echo nl2br(htmlspecialchars($message[headers]));
                die();
            break;
            case "my":
                if (!$_POST[submit]) {
                    $inc = "my";
                }
                else {
                    $err = "";
                    $passcheck = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE username='" . $_SESSION[user][id] . "' AND password=MD5('$_POST[password]')"));
                    if (!$passcheck[ID]) {
                        $err .= "Invalid password.<br>";
                    }
                    $usercheck = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE username='$usercheck'"));
                    if ($usercheck[ID] and $_POST[username] !== $_SESSION[user][id]) {
                        $err .= "Username already exists.<br>";
                    }
                    if ($_POST[npassword] !== $_POST[vpassword]) {
                        $err .= "New password and verify password must be the same.<br>";
                    }
                    if (!$_POST[name] or !$_POST[email] or !$_POST[password] or !$_POST[username]) {
                        $err .= "Required fields missing.<br>";
                    }
				    if (!$err) {
				        if ($_POST[npassword]) {
				            $password = $_POST[npassword];
				        }
				        else {
				            $password = $_POST[password];
				        }
                        mysql_query("UPDATE ticket_reps SET username='$_POST[username]',
                                                            name='$_POST[name]',
                                                            email='$_POST[email]',
                                                            password=MD5('$password'),
                                                            signature='$sig'
                                                        WHERE username='" . $_SESSION[user][id] . "'");
                        $_SESSION[user][pass] = md5($password);
                        $_SESSION[user][id] = $_POST[username];					}
                }
            break;
            case "pref":
            if ($oslogin[pref] or $oslogin[ID] == ADMIN) {
            	if ($_POST[remove_filetype] and $_POST[filetypes]) {
					mysql_query("UPDATE ticket_config SET filetypes = REPLACE(filetypes, '$_POST[filetypes];', '')");
					$config = mysql_fetch_array(mysql_query("SELECT * FROM ticket_config"));
				}
				elseif ($_POST[add_filetype] and $_POST[ext]) {
					mysql_query("UPDATE ticket_config SET filetypes = CONCAT(filetypes, '$_POST[ext];')");
					$config = mysql_fetch_array(mysql_query("SELECT * FROM ticket_config"));
				}
				
				if (!$_POST[submit]) {
                    $inc = "pref";
                }
                else {
                    if($_POST[accept_attachments] and !file_exists($_POST[attachment_dir])) {
                       $err = "Attachment folder is invalid or does not exists.<br>";
							  $inc = "pref";
                    }
						 /*
						  elseif($_POST[accept_attachments] and !fopen($_POST[attachment_dir])){
							  $err = "Attachment folder has invalid permission. chmod to 777<br>";
                       $inc = "pref";
						  }
							*/
                    else {
                        $_POST[accept_attachments] = isset($_POST[accept_attachments]);
                        $_POST[remove_original] = isset($_POST[remove_original]);
                        $_POST[search_disp] = isset($_POST[search_disp]);
                        $_POST[save_headers] = isset($_POST[save_headers]);

                        mysql_query("UPDATE ticket_config SET accept_attachments='$_POST[accept_attachments]',
                                                              timezone='$_POST[timezone]',
                                                              attachment_size='$_POST[attachment_size]',
                                                              attachment_url='$_POST[attachment_url]',
                                                              attachment_dir='$_POST[attachment_dir]',
                                                              answer_method='$_POST[answer_method]',
                                                              min_interval='$_POST[min_interval]',
                                                              ticket_max='$_POST[ticket_max]',
                                                              remove_original='$_POST[remove_original]',
                                                              remove_tag='$_POST[remove_tag]',
                                                              search_disp='$_POST[search_disp]',
                                                              umq='$_POST[umq]',
                                                              save_headers='$_POST[save_headers]',
                                                              time_format='$_POST[time_format]',
                                                              tickets_per_page='$_POST[tickets_per_page]',
                                                              root_url='$_POST[root_url]'");
                    }
						  if($config[root_url] and !$err) {
                        header("Location: admin.php");
                    }
                }
            }
            break;
            case "mail":
            if ($oslogin[mail] or $oslogin[ID] == ADMIN) {
                if (!$_POST[submit]) {
                    $inc = "mail";
                }
                else {
                    $_POST[alert_new] = isset($_POST[alert_new]);
                    $_POST[ticket_response] = isset($_POST[ticket_response]);
                    $_POST[message_response] = isset($_POST[message_response]);
                    $_POST[limit_response] = isset($_POST[limit_response]);
                    $_POST[trans_response] = isset($_POST[trans_response]);

                    mysql_query("UPDATE ticket_config SET   ticket_response='$_POST[ticket_response]',
                    										ticket_subj='$_POST[ticket_subj]',
                                                            ticket_msg='$_POST[ticket_msg]',
                                                            message_response='$_POST[message_response]',
                                                            message_subj='$_POST[message_subj]',
                                                            message_msg='$_POST[message_msg]',
                                                            limit_response='$_POST[limit_response]',
                                                            limit_email='$_POST[limit_email]',
                                                            limit_subj='$_POST[limit_subj]',
                                                            limit_msg='$_POST[limit_msg]',
                                                            trans_response='$_POST[trans_response]',
                                                            trans_subj='$_POST[trans_subj]',
                                                            trans_msg='$_POST[trans_msg]',
                                                            alert_new='$_POST[alert_new]',
                                                            alert_user='$_POST[alert_user]',
                                                            alert_email='$_POST[alert_email]',
                                                            alert_subj='$_POST[alert_subj]',
                                                            alert_msg='$_POST[alert_msg]'");
                }
            }
            break;
            case "cat":
            if ($oslogin[cat] or $oslogin[ID] == ADMIN) {
                if ($_POST[submit]) {
                    $_POST[hidden] = isset($_POST[hidden]);
                    
                    $namecheck = mysql_fetch_array(mysql_query("SELECT * FROM ticket_categories WHERE name='$_POST[name]'"));
                    $err = "";
                    if (!$_POST[name] or !$_POST[email]) {
                        $err .= "Required fields missing.<br>";
                    }
                    if ($namecheck[name] and ($_POST[name] !== $_POST[old_name])) {
                        $err .= "Category already exists.<br>";
                    }
				    if (!$err) {
                        mysql_query("UPDATE ticket_categories SET name='$_POST[name]',
                                                                  pophost='$_POST[pophost]',
                                                                  popuser='$_POST[popuser]',
                                                                  poppass='$_POST[poppass]',
                                                                  email='$_POST[email]',
                                                                  signature='$_POST[sig]',
                                                                  hidden='$_POST[hidden]'
                                                               WHERE ID=$_POST[c_id]");
					}
				}
                elseif ($_POST[delete]) {
            	    $rnum = mysql_num_rows(mysql_query("SELECT * FROM ticket_categories"));
            	    $err = "";
                    if ($rnum == 1) {
            	       $err = "Must have at least one representative.";
            	    }
            	    if (!$err) {
                	   mysql_query("DELETE FROM ticket_categories WHERE ID=$_POST[c_id]");
                	}
            	}
                elseif ($_POST[add]) {
                    $namecheck = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE name='$_POST[name]'"));
                    $err = "";
                    if (!$_POST[name] or !$_POST[email]) {
                        $err .= "Required fields missing.<br>";
                    }
                    if ($namecheck[name]) {
                        $err .= "Category already exists.<br>";
                    }
                    if (!$err) {
                        $_POST[hidden] = isset($_POST[hidden]);
                        mysql_query("INSERT INTO ticket_categories (name, pophost, popuser, poppass, email, signature, hidden)
                                                                VALUES
                                        ('$_POST[name]', '$_POST[pophost]', '$_POST[popuser]', '$_POST[poppass]', '$_POST[email]', '$_POST[sig]', '$_POST[hidden]')");
					}
                }
                else {
                    $inc = "cat";
                }
            }
            break;
            case "rep":
            if ($oslogin[rep] or $oslogin[ID] == ADMIN) {
				if ($_POST[submit]) {
				    $usercheck = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE username='$_POST[username]'"));
				    $namecheck = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE name='$_POST[name]'"));
				    $err = "";
				    
				    $psql = $_POST[password] ? "password=MD5('$_POST[password]'),": "";
                    if (!$_POST[name] or !$_POST[email] or !$_POST[group]) {
                        $err .= "Required fields missing.<br>";
                    }
                    if ($namecheck[name] and $_POST[name] !== $_POST[old_name]) {
                        $err .= "Name already exists.<br>";
                    }
                    if ($usercheck[username] and $_POST[username] !== $_POST[old_username]) {
                        $err .= "Representative username already exists.<br>";
                    }
				    if (!$err) {
                        mysql_query("UPDATE ticket_reps SET username='$_POST[username]',
                                                            name='$_POST[name]',
                                                            email='$_POST[email]',
                                                            $psql
                                                            signature='$_POST[sig]',
                                                            user_group='$_POST[group]'
                                                        WHERE ID='$r_id'");
					}
                }
            	elseif ($_POST[delete]) {
            	    $rnum = mysql_num_rows(mysql_query("SELECT * FROM ticket_reps"));
            	    $err = "";
                    if ($rnum == 1) {
            	       $err = "Must have at least one representative.";
            	    }
            	    if (!$err) {
	                   mysql_query("DELETE FROM ticket_reps WHERE ID='$_POST[r_id]'");
	                }
                }
                elseif ($_POST[add]) {
                    $usercheck = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE username='$_POST[username]'"));
                    $err = "";
                    if (!$_POST[name] or !$_POST[email] or !$_POST[username] or !$_POST[password] or !$_POST[group]) {
                        $err .= "Required fields missing.<br>";
                    }
                    if ($usercheck[name]) {
                        $err .= "Representative username already exists.<br>";
                    }
                    if (!$err) {
                        mysql_query("INSERT INTO ticket_reps (name, email, username, password, user_group, signature)
                                                            VALUES
                                                ('$_POST[name]', '$_POST[email]', '$_POST[username]', MD5('$_POST[password]'), '$_POST[group]', '$_POST[sig]')");
                    }
                }
                else {
                	$inc = "rep";
                }
            }
            break;
            case "transfer":
                $c = mysql_fetch_array(mysql_query("SELECT cat FROM tickets WHERE ID=$_POST[tid]"));
                $cat = mysql_fetch_array(mysql_query("SELECT * FROM ticket_categories WHERE ID=$c[cat]"));
                $cat2 = mysql_fetch_array(mysql_query("SELECT * FROM ticket_categories WHERE ID=$_POST[cid]"));
                
                if ($_POST[add_msg]) {
                    $_POST[add_msg] = "<br>$_POST[add_msg]";
                }
                $_POST[add_msg] = "Transferred from $cat[name] category:$_POST[add_msg]";
                
            	mysql_query("UPDATE tickets SET cat=$_POST[cid], trans_msg='$_POST[add_msg]' WHERE ID=$_POST[tid]");

            	if ($config[trans_response] and !$cat2[hidden]) {
            	   $sql = mysql_fetch_array(mysql_query("SELECT * FROM tickets WHERE ID=$_POST[tid]"));
            	   $c = mysql_fetch_array(mysql_query("SELECT * FROM ticket_categories WHERE ID=$_POST[cid]"));
            	   
            	   $config[trans_subj] = str_replace("%ticket", $tid, $config[trans_subj]);
            	   $config[trans_msg] = str_replace("%cat_name", $c[name], $config[trans_msg]);
                   $config[trans_msg] = str_replace("%trans_msg", $add_msg, $config[trans_msg]);
	               $config[trans_msg] = str_replace("%url", $config[root_url], $config[trans_msg]);
	               
                   mail($sql[email], $config[trans_subj], $config[trans_msg], "From: $c[email]\n");
            	}
            break;
            case "user_group":
            if ($oslogin[user_group] or $oslogin[ID] == ADMIN) {
                if ($_POST[submit]) {
                	$_POST[rep] = isset($_POST[rep]);
                    $_POST[cat] = isset($_POST[cat]);
                    $_POST[group] = isset($_POST[group]);
                    $_POST[pref] = isset($_POST[pref]);
                    $_POST[mail] = isset($_POST[mail]);
                    $_POST[banlist] = isset($_POST[banlist]);

                    if ($_POST[cat_access][all]) {
                        $ca = "all";
                    }
                    else {
                        if (count($_POST[cat_access])) {
                            foreach ($_POST[cat_access] as $id => $val) {
                                if ($val == "on") {
                                    $ca .= "$id:";
                                }
                            }
                        }
                        $ca = substr($ca, 0, strlen($ca)-1);
                    }
                    
                    $namecheck = mysql_fetch_array(mysql_query("SELECT * FROM ticket_groups WHERE name='$_POST[name]'"));
                    $err = "";
                    if ($_POST[name] == "Administrator") {
                        $err .= "Cannot alter Administrator group.<br>";
                    }
                    if (!$_POST[name]) {
                        $err .= "Required fields missing.<br>";
                    }
                    if ($namecheck[name] and ($_POST[name] !== $_POST[old_name])) {
                        $err .= "User group already exists.<br>";
                    }
                    if (!$err) {
                        mysql_query("UPDATE ticket_groups SET name='$_POST[name]',
                                                              rep='$_POST[rep]',
                                                              cat='$_POST[cat]',
                                                              user_group='$_POST[group]',
                                                              pref='$_POST[pref]',
                                                              mail='$_POST[mail]',
                                                              banlist='$_POST[banlist]',
                                                              cat_access='$ca'
                                                           WHERE ID='$_POST[g_id]'");
                    }
                }
                elseif ($_POST[delete]) {
                    $err = "";
                	if ($_POST[g_id] == 1) {
                	   $err .= "Cannot delete administrator user group.<br>";
                    }
                	if ($oslogin[ID] == $_POST[g_id]) {
                	    $err .= "Cannot delete user group: still in use.<br>";
                	}
                	if (!$err) {
                	    mysql_query("DELETE FROM ticket_groups WHERE ID='$_POST[g_id]'");
                	}
                }
                elseif ($_POST[add]) {
                	$_POST[rep] = isset($_POST[rep]);
                    $_POST[cat] = isset($_POST[cat]);
                    $_POST[group] = isset($_POST[group]);
                    $_POST[pref] = isset($_POST[pref]);
                    $_POST[mail] = isset($_POST[mail]);
                    $_POST[banlist] = isset($_POST[banlist]);
                    if (count($_POST[cat_access])) {
                        foreach ($_POST[cat_access] as $id => $val) {
                            if ($val == "on") {
                                $ca .= "$id:";
                            }
                        }
                    }
                    $ca = substr($ca, 0, strlen($ca)-1);

                    $namecheck = mysql_fetch_array(mysql_query("SELECT * FROM ticket_groups WHERE name='$_POST[name]'"));
                    $err = "";
                    if (!$_POST[name]) {
                        $err .= "Required fields missing.<br>";
                    }
                    if ($namecheck[name]) {
                        $err .= "User group already exists.<br>";
                    }
                    if (!$err) {
                	   mysql_query("INSERT INTO ticket_groups (name, rep, cat, user_group, pref, mail, banlist, cat_access)
                                                    VALUES
                                ('$_POST[name]', '$_POST[rep]', '$_POST[cat]', '$_POST[group]', '$_POST[pref]', '$_POST[mail]', '$_POST[banlist]', '$ca')");
    				}
                }
                else {
                	$inc = "user_group";
                }
            }
			break;
            case "banlist":
            if ($oslogin[banlist] or $oslogin[ID] == ADMIN) {
                if (!$_POST[submit]) {
                    $inc = "banlist";
                }
				include ("fn.php");
				$page="admin.php";
				$displayRecs = 20;
				$recRange = 10;
				$dbwhere = "";
				$masterdetailwhere = "";
				$searchwhere = "";
				$a_search = "";
				$b_search = "";
				$whereClause = "";

				// get search criteria for basic search
				$pSearch = @$_GET["psearch"];
				$pSearchType = @$_GET["psearchtype"];
				if ($pSearch <> "") {
					$pSearch = str_replace("'", "\'", $pSearch);	
					if ($pSearchType <> "")	{
						while (strpos($pSearch, "  ") > 0) {
							$pSearch = str_Replace("  ", " ",$pSearch);
						}
						$arpSearch = explode(" ", trim($pSearch));
						foreach ($arpSearch as $kw) {
							$b_search .= "(";
							$b_search .= "`value` LIKE '%" . trim($kw) . "%' OR ";
							if (substr($b_search, -4) == " OR ") {
								$b_search = substr($b_search, 0, strlen($b_search)-4);
							}
							$b_search .= ") " . $pSearchType . " ";
						}
					}	else {
						$b_search .= "`value` LIKE '%" . $pSearch . "%' OR ";
					}
				}
				if (substr($b_search, -4) == " OR ") {
					$b_search = substr($b_search, 0, strlen($b_search)-4);
				}
				if (substr($b_search, -5) == " AND ") {
					$b_search = substr($b_search, 0, strlen($b_search)-5);
				}

				// build search criteria
				if ($a_search <> "") {
					$searchwhere = $a_search; //advanced search
				}	elseIf ($b_search <> "") {
					$searchwhere = $b_search; //basic search
				}

				// save search criteria
				if ($searchwhere <> "") {
					$_SESSION["ticket_banlist_searchwhere"] = $searchwhere;	
					$startRec = 1; //reset start record counter (new search)
					$_SESSION["ticket_banlist_REC"] = $startRec;
				}	else {
					$searchwhere = @$_SESSION["ticket_banlist_searchwhere"];
				}

				// get clear search cmd
				if (@$_GET["cmd"] <> "") {
					$cmd = $_GET["cmd"];
					if (strtoupper($cmd) == "RESET") {
						$searchwhere = ""; //reset search criteria
						$_SESSION["ticket_banlist_searchwhere"] = $searchwhere;
					}	elseif (strtoupper($cmd) == "RESETALL") {		
						$searchwhere = ""; //reset search criteria
						$_SESSION["ticket_banlist_searchwhere"] = $searchwhere;
					}	
					$startRec = 1; //reset start record counter (reset command)
					$_SESSION["ticket_banlist_REC"] = $startRec;
				}

				// build dbwhere
				if ($masterdetailwhere <> "" ) {
					$dbwhere .= "(" . $masterdetailwhere . ") AND ";
				}
				if ($searchwhere <> "" ) {
					$dbwhere .= "(" . $searchwhere . ") AND ";
				}
				if (strlen($dbwhere) > 5) {
					$dbwhere = substr($dbwhere, 0, strlen($dbwhere)-5); // trim rightmost AND
				}

				// default order
				$DefaultOrder = "";
				$DefaultOrderType = "";

				// default filter
				$DefaultFilter = "";

				// check for an Order parameter
				$OrderBy = "";
				if (@$_GET["order"] <> "") {
					$OrderBy = $_GET["order"];

					// check if an ASC/DESC toggle is required
					if (@$_SESSION["ticket_banlist_OB"] == $OrderBy) {
						if (@$_SESSION["ticket_banlist_OT"] == "ASC") {
							$_SESSION["ticket_banlist_OT"] = "DESC";
						} else {
							$_SESSION["ticket_banlist_OT"] = "ASC";
						}
					} else {
						$_SESSION["ticket_banlist_OT"] = "ASC";
					}
					$_SESSION["ticket_banlist_OB"] = $OrderBy;
					$_SESSION["ticket_banlist_REC"] = 1;
				} else {
					$OrderBy = @$_SESSION["ticket_banlist_OB"];
					if ($OrderBy == "") {
						$OrderBy = $DefaultOrder;
						$_SESSION["ticket_banlist_OB"] = $OrderBy;
						$_SESSION["ticket_banlist_OT"] = $DefaultOrderType;
					}
				}
				$conn = mysql_connect($db_host, $db_user, $db_pass);
				mysql_select_db($db_name);

				// build SQL
				$strsql = "SELECT * FROM `ticket_banlist`";
				if ($DefaultFilter <> "") {
					$whereClause .= "(" . $DefaultFilter . ") AND ";
				}
				if ($dbwhere <> "" ) {
					$whereClause .= "(" . $dbwhere . ") AND ";
				}
				if (substr($whereClause, -5) == " AND ") {
					$whereClause = substr($whereClause, 0, strlen($whereClause)-5);
				}
				if ($whereClause <> "") {
					$strsql .= " WHERE " . $whereClause;
				}
				if ($OrderBy <> "") {
					$strsql .= " ORDER BY `" . $OrderBy . "` " . @$_SESSION["ticket_banlist_OT"];
				}

				//echo $strsql; // comment out this line to view the SQL
				$rs = mysql_query($strsql);
				$totalRecs = intval(@mysql_num_rows($rs));

				// check for a START parameter
				if (@$_GET["start"] <> "") {
					$startRec = $_GET["start"];
					$_SESSION["ticket_banlist_REC"] = $startRec;
				}	elseif (@$_GET["pageno"] <> "") {
					$pageno = $_GET["pageno"];
					if (is_numeric($pageno)) {
						$startRec = ($pageno - 1)*$displayRecs + 1;
						if ($startRec <= 0) {
							$startRec = 1;
						} elseIf ($startRec >= (($totalRecs-1)/$displayRecs)*$displayRecs+1) {
							$startRec = (($totalRecs-1)/$displayRecs)*$displayRecs + 1;
						}
						$_SESSION["ticket_banlist_REC"] = $startRec;
					} else {
						$startRec = @$_SESSION["ticket_banlist_REC"];
						if (!is_numeric($startRec)) {			
							$startRec = 1; // reset start record counter
							$_SESSION["ticket_banlist_REC"] = $startRec;
						}
					}
				}	else {
					$startRec = @$_SESSION["ticket_banlist_REC"];
					if (!is_numeric($startRec)) {		
						$startRec = 1; // reset start record counter
						$_SESSION["ticket_banlist_REC"] = $startRec;
					}
				}	
			}
            break;
            case "banlist_add":
            if ($oslogin[banlist] or $oslogin[ID] == ADMIN) {
                if (!$_POST[submit]) {
                    $inc = "banlist_add";
                }
				include ("fn.php");
				ob_start();

				// get action
				$ab = @$_POST["ab"];
				if (empty($ab)) {
					$key = @$_GET["key"];
					if ($key <> "")	{
					$ab = "C"; // copy record
					} else{
							$ab = "I"; // display blank record
						}
					}

				// open connection to the database
				$conn = mysql_connect($db_host, $db_user, $db_pass);
				mysql_select_db($db_name);
				switch ($ab) {
					case "C": // get a record to display
						$tkey = "" . $key . "";
						$strsql = "SELECT * FROM `ticket_banlist` WHERE `value_id`=" . $tkey;
						$rs = mysql_query($strsql);
						if (mysql_num_rows($rs) == 0) {
							ob_end_clean();
							header("Location: admin.php?a=banlist");
						} else {
							$row = mysql_fetch_array($rs);

						// get the field contents
							$x_value = @$row["value"]; 
						}
						mysql_free_result($rs);
						break;
					case "A": // add

						// get the form values
						$x_value = @$_POST["x_value"];
						$x_value_id = @$_POST["x_value_id"];

						// add the values into an array

						// value
						$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_value) : $x_value;
						$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
						$fieldList["`value`"] = $theValue;

						// insert into database
						$strsql = "INSERT INTO `ticket_banlist` (";
						$strsql .= implode(",", array_keys($fieldList));
						$strsql .= ") VALUES (";
						$strsql .= implode(",", array_values($fieldList));
						$strsql .= ")";
					 	mysql_query($strsql, $conn) or die(mysql_error());
						mysql_close($conn);
						ob_end_clean();
						header("Location: admin.php?a=banlist");
						break;
				}
			}
            break;
            case "banlist_delete":
            if ($oslogin[banlist] or $oslogin[ID] == ADMIN) {
                if (!$_POST[submit]) {
                    $inc = "banlist_delete";
                }
				include ("fn.php");
				ob_start();
				$page="admin.php";
				// multiple delete records
				$key = @$_POST["key"];
				if (count($key) == 0) {
				header("Location: ticket_banlistlist.php");
				}
				$sqlKey = "";
				foreach ($key as $reckey) {	
				$reckey = trim($reckey);

				// build the SQL
				$sqlKey .= "(" . "`value_id`=" . "" . $reckey . "" . " AND ";
				if (substr($sqlKey, -5) == " AND ")	{
                $sqlKey = substr($sqlKey, 0, strlen($sqlKey)-5);
				} 
			    $sqlKey .= ") OR ";
				}
				if (substr($sqlKey, -4) == " OR ") {
				$sqlKey = substr($sqlKey, 0, strlen($sqlKey)-4);
				}
				// get action
				$ab = @$_POST["ab"];
				if (empty($ab)) {
				$ab = "I";	// display
				}

				// open connection to the database
				$conn = mysql_connect($db_host, $db_user, $db_pass);
				mysql_select_db($db_name);
				switch ($ab)
			{
			case "I": // display
			$strsql = "SELECT * FROM `ticket_banlist` WHERE " . $sqlKey;
			$rs = mysql_query($strsql, $conn) or die(mysql_error());
			if (mysql_num_rows($rs) == 0) {
			ob_end_clean();
			header("Location: admin.php?a=banlist");
				}
				break;
				case "D": // delete
				$strsql = "DELETE FROM `ticket_banlist` WHERE " . $sqlKey;
				$rs =	mysql_query($strsql) or die(mysql_error());
				mysql_close($conn);
				ob_end_clean();
				header("Location: admin.php?a=banlist");
				break;
				}
			}
            break;
            case "banlist_edit":
            if ($oslogin[banlist] or $oslogin[ID] == ADMIN) {
                if (!$_POST[submit]) {
                    $inc = "banlist_edit";
                }
				include ("fn.php");
				ob_start();
				$page="admin.php";
				$key = @$_GET["key"];
				if (empty($key)) {
					$key = @$_POST["key"];
				}
				if (empty($key)) {
					header("Location: admin.php?a=banlist");
				}

				// get action
				$ab = @$_POST["ab"];
				if (empty($ab)) {
					$ab = "I";	//display with input box
				}

				// get fields from form
				$x_value = @$_POST["x_value"];
				$x_value_id = @$_POST["x_value_id"];

				// open connection to the database
				$conn = mysql_connect($db_host, $db_user, $db_pass);
				mysql_select_db($db_name);
				switch ($ab)
				{
					case "I": // get a record to display
						$tkey = "" . $key . "";
						$strsql = "SELECT * FROM `ticket_banlist` WHERE `value_id`=" . $tkey;
						$rs = mysql_query($strsql) or die(mysql_error());
						if (!($row = mysql_fetch_array($rs))) {
				     	ob_end_clean();
						header("Location: admin.php?a=banlist");
						}

						// get the field contents
						$x_value = @$row["value"];
						$x_value_id = @$row["value_id"];
						mysql_free_result($rs);		
						break;
					case "U": // update
						$tkey = "" . $key . "";

						// get the form values
						$x_value = @$_POST["x_value"];
						$x_value_id = @$_POST["x_value_id"];

						// add the values into an array

						// value
						$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_value) : $x_value;
						$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
						$fieldList["`value`"] = $theValue;

						// update
						$updateSQL = "UPDATE `ticket_banlist` SET ";
						foreach ($fieldList as $key=>$temp) {
							$updateSQL .= "$key = $temp, ";			
						}
						if (substr($updateSQL, -2) == ", ") {
							$updateSQL = substr($updateSQL, 0, strlen($updateSQL)-2);
						}
						$updateSQL .= " WHERE `value_id`=".$tkey;
				  	$rs = mysql_query($updateSQL, $conn) or die(mysql_error());
						ob_end_clean();
						header("Location: admin.php?a=banlist");
				}
			}
            break;
		}
	}
    else {
        $login_err = true;
        $inc = "admin_login";
	}
}
$inc = !$inc ? "main": $inc;

include_once("$include_dir/header.php");
include_once("$include_dir/$inc.php");
include_once("$include_dir/footer.php");
?>
