<?
//ticket information
$ticket_row = mysql_fetch_array(mysql_query("SELECT * FROM tickets WHERE ID=$_REQUEST[id]"));
$cat_row = mysql_fetch_array(mysql_query("SELECT * FROM ticket_categories WHERE ID=$ticket_row[cat]"));
$ticket = new ticket($ticket_row);

//get priority
switch ($ticket->priority) {
case 1:
    $pri = "Low";
break;
case 2:
    $pri = "Normal";
break;
case 3:
    $pri = "High";
}
		
//user is allowed to view ticket
$show = $_SESSION[user][type] == "admin" ? 1: !$cat_row[hidden];

$admin_permis = ($_SESSION[user][type] == "admin" and (@in_array($cat_row[ID], $oslogin[cat_access]) or $oslogin[cat_access][0] == "all" or $oslogin[ID] == ADMIN));
$client_permis = ($_SESSION[user][type] == "client" and $ticket_row[email] == $_SESSION[user][id]);

if (!$client_permis and !$admin_permis) {
	echo "Access denied.";
}
else {
    //ticket information with transfer form
    ?>

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?
if ($err) {
?> 
<tr> 
    <td class="error"><?=$err?><?=$help_link?><p></td> 
</tr> 
<?
}
?> 
    <form action="<?=$page?>" method="POST">
	<tr>
		<td>
    <input type="hidden" name="a" value="transfer">
    <input type="hidden" name="tid" value="<?=$ticket->id?>">
	<table align="center" class="msgBorderInfo" cellspacing="1" cellpadding="3" width="100%" border=0>
	<tr>
		<td width="100" class="mainTable"><b>Ticket ID:</b></tD>
		<Td class="mainTable"><?=$ticket->id?></td>
	</tr>
	<tr>
		<td width="100" class="mainTable"><b>Status:</b></tD>
		<Td class="mainTable"><?=$ticket->status?></td>
	</tr>
	<tr>
		<td class="mainTable"><b>Subject:</b></tD>
		<Td class="mainTable"><?=stripslashes($ticket->subject)?></td>
	</tr>
	<?
	if ($ticket->name !== $ticket->email) {
	?>
	<tr>
		<td class="mainTable"><b>Name:</b></tD>
		<Td class="mainTable"><?=htmlspecialchars($ticket->name)?></td>
	</tr>
	<?
	}
	?>
    <tr>
		<td class="mainTable"><b>Email:</b></tD>
		<Td class="mainTable"><?=htmlspecialchars($ticket->email)?></td>
	</tr>
	<?
	if ($ticket->ip) {
	?>
	<tr>
		<td class="mainTable"><b>IP:</b></tD>
		<Td class="mainTable"><?=$ticket->ip?></td>
	</tr>	
    <?
    }
	if ($ticket->phone) {
	?>
	<tr>
		<td class="mainTable"><b>Phone:</b></tD>
		<Td class="mainTable"><?=$ticket->phone?></td>
	</tr>
	<?
	}
	?>
    <tr>
		<td class="mainTable"><b>Priority:</b></tD>
		<Td class="mainTable"><?=$pri?></td>
	</tr>
	</table>

	<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>
	
	<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border=0>
	<tr>
		<td width="100" class="mainTable"><b>Category:</b></tD>
		<td class="mainTable">
		<?
		//view admin category area
        if ($_SESSION[user][type] == "admin") {
		    ?>
            <table cellspacing=0 cellpadding=0 border=0><tr><td>
            
            <select name="cid">
    	    <?
    	    $cats = mysql_query("SELECT * FROM ticket_categories");
    	    while ($cat = mysql_fetch_array($cats)) {
    	        $selected = ($cat[ID] == $cat_row[ID]) ? " SELECTED": "";
    	        $cat[name] = $cat[hidden] ? "$cat[name]*": $cat[name];
    	        ?>
    	        <option value="<?=$cat[ID]?>"<?=$selected?>><?=$cat[name]?></option>
    	        <?
    	    }
    	    ?>
    	    </select>
    	    
            </td>
            <td>&nbsp;&nbsp;</td>
            <td>Optional Message:&nbsp;</td>
			<td><input type="text" size="20" name="add_msg"></td>
            <td>&nbsp;&nbsp;</td>
            <td>
            <input type="submit" name="transfer" value="Transfer" class="inputsubmit">
            </td>
            </tr>
            </table>
            <?
        }
        else {
            //plain category area
            echo $cat_row[name];
        }
        ?>
        </td>
	</tr>
	</table>
		</td>
	</tr>
	</form>
	</table>

	<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>	

	<?
	//show transfer information
	if ($ticket_row[trans_msg]) {
    	?>
    	<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border=0>
    	<tr>
    		<td width="100" class="mainTable"><b>Transfer Note:</b></tD>
    		<Td class="mainTable">
    		  <?=$ticket_row[trans_msg]?>
    		</td>
    	</tr>
    	</table>

		<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>

	   <?
	}
	
	//get all private messages if user is admin
	if ($_SESSION[user][type] == "admin") {
	    $priv_res = mysql_query("SELECT * FROM ticket_privmsg WHERE ticket='$_REQUEST[id]'");
	    $count = mysql_num_rows($priv_res);
	    if ($count) {
            ?>
    	    <table class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border=0>
    	    <tr class="mainTable">
    	    <td valign="top" width="100"><b>Private Messages</b></td>
    	    <td>
    	    <table class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border=0>
    	    <?
    		while ($priv_row = mysql_fetch_array($priv_res)) {
    		    $rep = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE ID='$priv_row[rep]'"));
    		    ?>
    		    <tr class="mainTable"><td>
                <b><?=$rep[name]?></b> (<?=date($config[time_format], time_convert($priv_row[timestamp]))?>)
                <?= $priv_row[attachment] ? " <a href='$config[attachment_url]/$priv_row[attachment]'>$priv_row[attachment]</a> " . "(" . @round(filesize("$config[attachment_dir]/$priv_row[attachment]")  / 1024, 1) . " KB)": ""?><br>
                <?=nl2br($priv_row[message])?>
                </td></tr>
    		    <?
    		}
    		?>
    		</table>
            </td>
    	    </tr>
    	    </table>

			<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>

    	    <?
	   }
	}
	    
	//get messages
	$msg_res = mysql_query("SELECT * FROM ticket_messages WHERE ticket=$ticket_row[ID] ORDER BY timestamp");
	while ($msg_row = mysql_fetch_array($msg_res)) {
	    $fstr = "";
		?>
		<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border=0>
		<tr class="msgReceived">
		<td class="msgReceived"><?=date($config[time_format], time_convert($msg_row[timestamp]))?></tr>
		<?
		
		//get file attachments
		$files = mysql_query("SELECT * FROM ticket_attachments WHERE ref=$msg_row[ID] AND type='q'");
		while ($file = mysql_fetch_array($files)) {
            $filename = substr($file[filename], 7);
            $size = @round(filesize("$config[attachment_dir]/$file[filename]") / 1024, 1);

            if ($_SESSION[user][type] == "admin") {
		      $fstr .= "<a href='$config[attachment_url]?file=$file[filename]'>" . $filename . "</a> ($size kb); ";
		    }
		    else {
		        $fstr .= "$filename ($size kb); ";
		    }
        }
        if ($fstr or ($msg_row[headers] and $_SESSION[user][type] == "admin")) {
            ?>
            <tr class="msgAttachments">
			<td class="msgAttachments">Attachment: <?=substr($fstr, $start, strlen($fstr)-2)?>
            <?
            if ($msg_row[headers]) {
                ?>
                 ( <a href="admin.php?a=headers&msg=<?=$msg_row[ID]?>" target="_new">headers</a> )
                <?
            }
            ?>
            </td>
		    </tr>
		    <?
		}
		?>
        <tr class="msgBox">
			<td align="left">
				<?
				$buffer = $msg_row[message];
				if (!strpos(strtolower($buffer), "<br>") and !strpos(strtolower($buffer), "<br />")) {
				    $buffer = nl2br($buffer);
				}
				echo stripslashes($buffer);
				?>
			</td>
		</tr>
		</table>
		
		<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>
		
        <?
        //get answers for messages
		$answers_res = mysql_query("SELECT * FROM ticket_answers WHERE reference=$msg_row[ID] ORDER BY timestamp");
		while ($answer_row = mysql_fetch_array($answers_res)) {
		    $rep = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE ID='$answer_row[rep]'"));
    		?>
    		<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border=0>
    		<tr class="msgAnswered">
    			<td class="msgAnswered"><b><?=$rep[name]?></b> (<?=date($config[time_format], time_convert($answer_row[timestamp]))?>)</td>
    		</tr>
    		<?
        	$files =  mysql_fetch_array(mysql_query("SELECT * FROM ticket_attachments WHERE ref=$answer_row[ID] AND type='a'"));
        	
            $filename=substr($files[filename],7);
            $size = @round(filesize("$config[attachment_dir]/$files[filename]") / 1024, 1);

    		if ($files[filename]) {
                $fstr = "<a href='$config[attachment_url]?file=$files[filename]'>" . $filename . "</a> ($size kb)";
                ?>
                <tr class="msgAttachments">
        		<td class="msgAttachments">Attachment: <?=$fstr?>
                </td>
        		</tr>
        		<?
    		}
    		?>
			<tr class="msgBox">
				<td align="left">
				<?
				$buffer = $answer_row[message];
				if (!strpos(strtolower($buffer), "<br>") and !strpos(strtolower($buffer), "<br />")) {
				    $buffer = nl2br($buffer);
				}
				echo stripslashes($buffer);
				?>
				</td>
			</tr>
			</table>
			
			<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>

			<?
		}
		$lastid = $_SESSION[user][type] == "admin" ? $msg_row[ID]: $ticket_row[ID];
	}

    //post message form
	if ($show) {
    	?>
    	
 
<table align="center" cellspacing="0" cellpadding="3" width="100%" border=0>
  <tr> 
    <td align="center"><br>
      <form action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?=$config[attachment_size]?>">
        <input type="hidden" name="a" value="post">
        <input type="hidden" name="id" value="<?=$lastid?>">
        <table border="0" cellspacing="0" cellpadding="5">
          <tr> 
            <td width="350"> 
              <textarea name="message" cols="50" rows="6" wrap="soft"></textarea>
            </td>
            <td valign="top"> 
              <?
    		if ($config[accept_attachments]) {
    		    ?>
              <input type="file" name="attachment">
              <?
    		}
    		?>
              <table>
                <?
            if ($_SESSION[user][type] == "admin") {
                ?>
                <tr>
                  <td> 
                    <input type="checkbox" name="priv" id="priv">
                    <label for="priv">Private Staff Message</label><br>
                    <input type="checkbox" name="close" id="close">
                    <label for="close">Reply and Close</label> </td>
                </tr>
                <?
    		}
    		?>
                <tr>
                  <td> 
                    <input class="inputsubmit" type="submit" value="Reply to Message">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </form>
    </td>
</table>

    	<table width="100%" cellpadding="3" cellspacing="0" border="0">
    		<tr>
    			<td align="center"><a href="<?=$PHP_SELF?>">Back to main</a></td>
    		</tr>
    	</table>
    	<br>
    	<?
	}
}
?>
