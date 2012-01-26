
<table width="100%" border="0" cellspacing=0 cellpadding=0>
  <form action="admin.php" method="post">
    <input type="hidden" name="a" value="pref">
    <tr>
      <td> 
        <?
    if ($_SESSION[user][type] == "admin") {
        $access = array();
        foreach ($titles as $item => $val) {
            if ($oslogin[$item]) {
                array_push($access, "<a href=admin.php?a=$item><img src=images/buttons/$item.gif alt=$val border=0></a>");
            }
        }
        $access = join(" ", $access);
        $access = $access ? "$access": "";
        ?>
        <table width="100%" border="0" cellspacing=0 cellpadding=0>
          <tr>
            <td align="center"> 
              <?=$access?>
              <?=$access ? " ": ""?>
              <a href="admin.php?a=my"><img src=images/buttons/my.gif alt="My Account" border=0></a> 
            </td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="10"></td>
          </tr>
        </table>
        <?
    }
    ?>
        <table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableMsg">
          <tr>
            <td class="TableHeaderText" width="220">&nbsp;Attachments</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="mainTable">&nbsp;Accept file attachments:</td>
            <td class="mainTableAlt">
              <input type="checkbox" name="accept_attachments" <?=$config[accept_attachments] ? "checked": ""?>>
              &nbsp;&nbsp;<b>WARNING:</b>&nbsp;Before you enable this feature 
              you need to setup the attachment folder...and fully understand the 
              security issues related to attachments. </td>
          </tr>
          <tr>
            <td class="mainTable">&nbsp;Maximum File Size (bytes):</td>
            <td class="mainTableAlt">
              <input type="text" name="attachment_size" value="<?=$config[attachment_size]?>">
            </td>
          </tr>
          <tr>
            <td class="mainTable">&nbsp;Attachment URL path:</td>
            <td class="mainTableAlt">
              <input type="text" size=70 name="attachment_url" READONLY value="<?=$config[attachment_url]?>">
            </td>
          </tr>
          <tr>
            <td class="mainTable">&nbsp;Attachment Folder:</td>
            <td class="mainTableAlt">
              <input type="text" size=70 name="attachment_dir" value="<?=$config[attachment_dir]?>">
              <font color=red>
              <?=$attwarn?>
              </font><br/>
              For security reasons the attachment dir should reside outside the 
              web server path.<br/>
              If this is not possible due to shared hosting..etc..make sure you 
              create a blank index.html and .htaccess in attachment dir to disable 
              files execution and listing.<br/>
            </td>
          </tr>
          <tr>
            <td class="mainTable">&nbsp;Accepted File Types:</td>
            <td class="mainTableAlt"> 
              <table>
                <tr>
                  <td> 
                    <select size="5" name="filetypes">
                      <?
         			$types = explode(";", $config[filetypes]);
         			unset($types[count($types)-1]);
         			foreach ($types as $type) {
            		?>
                      <option>
                      <?=$type?>
                      </option>
                      <?}?>
                    </select>
                  </td>
                  <td valign="top"> 
                    <input type="submit" name="remove_filetype" value="Remove Type" class="inputsubmit">
                    <br>
                    <table>
                      <tr>
                        <td>
                          <input type="text" name="ext" size="4">
                        </td>
                        <td>
                          <input type="submit" name="add_filetype" value="Add" class="inputsubmit">
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td><img src="images/spacer.gif" width="1" height="5"></td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableMsg">
          <tr>
            <td class="TableHeaderText" width="220">&nbsp;Mail</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="mainTable" width="220">&nbsp;Answer Method:</td>
            <td class="mainTableAlt">
              <select name="answer_method">
                <option value="automatic" <?=$config[answer_method]=="automatic" ? "selected": ""?>>automatic</option>
                <option value="pop3" <?=$config[answer_method]=="pop3" ? "selected": ""?>>pop3</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="mainTable">&nbsp;Save Email Headers:</td>
            <td class="mainTableAlt">
              <input type="checkbox" name="save_headers" <?=$config[save_headers] ? "checked": ""?>>
            </td>
          </tr>
          <!-- <tr>
            <td class="mainTable">&nbsp;Min. Email Interval (seconds):</td>
            <td class="mainTableAlt">
              <input type="text" name="min_interval" value="<?=$config[min_interval]?>">
            </td>
          </tr> -->
          <tr>
            <td class="mainTable">&nbsp;Maximum Open Tickets:</td>
            <td class="mainTableAlt">
              <input type="text" name="ticket_max" value="<?=$config[ticket_max]?>">
            </td>
          </tr>
          <tr>
            <td class="mainTable">&nbsp;Remove Original Email:</td>
            <td class="mainTableAlt">
              <input type="checkbox" name="remove_original" <?=$config[remove_original] ? "checked": ""?>>
            </td>
          </tr>
          <tr>
            <td class="mainTable">&nbsp;Remove Tag:</td>
            <td class="mainTableAlt">
              <input type="text" name="remove_tag" value="<?=$config[remove_tag]?>">
            </td>
          </tr>
        </table>
        <table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td><img src="images/spacer.gif" width="1" height="5"></td>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableMsg">
			<tr><td class="TableHeaderText" width="220">&nbsp;Miscellaneous</td><td>&nbsp;</td></tr>
			<tr><td class="mainTable">&nbsp;osTicket URL:</td><td class="mainTableAlt"><input type="text" name="root_url" value="<?=$config[root_url]?>"></td></tr>
	        <tr class="mainTable"><td>&nbsp;Search on Main Page:</td><td class="mainTableAlt"><input type="checkbox" name="search_disp" <?=$config[search_disp] ? "checked": ""?>></td></tr>

            <tr><td class="mainTable">&nbsp;Preferred Timezone:
            </td><td class="mainTableAlt">

            <select name="timezone">
            <?
            $gmoffset = date("Z") / 3600;
            $timezones = array(""=>"Server Time (GMT $gmoffset:00)",
                               -12=>"GMT -12:00 (Eniwetok, Kwajalein)",
                               -11=>"GMT -11:00 (Midway Island, Samoa)",
                               -10=>"GMT -10:00 (Hawaii)",
                               -9=>"GMT -09:00 (Alaska)",
                               -8=>"GMT -08:00 (Pacific Time)",
                               -7=>"GMT -07:00 (Mountain Time)",
                               -6=>"GMT -06:00 (Central Time)",
                               -5=>"GMT -05:00 (Eastern Time)",
                               -4=>"GMT -04:00 (Atlantic Time)",
                               -3=>"GMT -03:00 (Greenland)",
                               -2=>"GMT -02:00 (Mid-Atlantic)",
                               -1=>"GMT -01:00 (Azores)",
                               0=>"GMT (Greenwich Mean Time)",
                               1=>"GMT +01:00 (West Central Africa)",
                               2=>"GMT +02:00 (Jerusalem)",
                               3=>"GMT +03:00 (Baghdad)",
                               4=>"GMT +04:00 (Kabul)",
                               5=>"GMT +05:00 (New Delhi)",
                               6=>"GMT +06:00 (Kathmandu)",
                               7=>"GMT +07:00 (Bangkok)",
                               8=>"GMT +08:00 (Hong Kong)",
                               9=>"GMT +09:00 (Tokyo)",
                               10=>"GMT +10:00 (Sydney)",
                               11=>"GMT +11:00 (Solomon Islands)",
                               12=>"GMT +12:00 (Fiji)",
                               13=>"GMT +13:00 (Nuku'alofa)");
            foreach ($timezones as $item => $val) {
                $selected = ($config[timezone] == $item) ? " SELECTED": "";
                ?>
                <option value="<?=$item?>"<?=$selected?>><?=$val?></option>
                <?
            }
            ?>
            </select>
            </td></tr>
            
            <tr><td class="mainTable">&nbsp;Tickets Per Page:
                </td><td class="mainTableAlt">
        	    <select name="tickets_per_page">
                <?
                for ($x = 5; $x <= 50; $x += 5) {
                    ?>
                    <option<?=$config[tickets_per_page] == $x ? " SELECTED": ""?>><?=$x?></option>
                    <?
                }
                ?>
                </select>
            </td></tr>

            <tr><td class="mainTable">&nbsp;# Answered Messages:</td><td class="mainTableAlt"><input type="text" name="umq" value="<?=$config[umq]?>"></td></tr>
	    <tr><td class="mainTable">&nbsp;Time Format:</td><td class="mainTableAlt"><input type="text" name="time_format" value="<?=$config[time_format]?>"></td></tr>
		</table>
        <p> 
          <input class="inputsubmit" type="submit" name="submit" value="Save Changes">
      </td>
    </tr>
  </form>
</table>
