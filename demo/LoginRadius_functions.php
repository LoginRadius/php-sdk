<?php
 
/*
 * Loginradius userprofile table manage
 */
function LoginRadius_userdata_format($profiledata, $subTable = false){
	$count = 1;
	if($subTable){
		foreach($profiledata as $key => $value){?>
               		<tr <?php if(($count % 2) == 0){ echo 'style="background-color:#fcfcfc"'; } ?>>                    
                            <td scope="col" ><?php echo ucfirst($key); ?></td> 
				<?php LoginRadius_Userdata_Check($value);?>
			</tr>
		<?php
			$count++;
		}
	}
	else{?>
		<table  class="gridtable">
		<tfoot>
			<?php
			foreach($profiledata as $key => $value){
                            if($key=='Quota'){continue;}?>
			<tr <?php if(($count % 2) == 0){ echo 'style="background-color:#fcfcfc"'; } ?>>
                            <th scope="col"><?php echo ucfirst($key); ?></th> 
                            <?php if(in_array($key, array('Projects','Interests','Games','Badges','IMAccounts','Addresses','Suggestions','Positions', 'Sports', 'FavoriteThings', 'Email','Languages','MutualFriends','Movies', 'CurrentStatus', 'Country', 'Educations','AgeRange','IndustriestoFollow','ProviderAccessCredential','InspirationalPeople','PhoneNumbers','Books','TeleVisionShow','Awards','Skills','RelatedProfileViews','Authors','JobBookmarks','MemberUrlResources','Publications','RecommendationsReceived','Patents','Certifications','Courses','Volunteer'))){
                                echo '<td scope="col">';
                                if(!empty($value)){
                                    LoginRadius_Horizontal_UserProfile($key, $value);
                                }
                                echo '</td>';
                            }else{?>
                                <?php LoginRadius_Userdata_Check($value);
                            }?>
			</tr>
			<?php
			}
			$count++;
			?>
			</tfoot>
		</table>
		<?php
	}
}

/*
 * Loginradius userprofile table manage
 */
function LoginRadius_Horizontal_UserProfile($key, $value){
	if($key == 'ProviderAccessCredential'){?>
    <table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Type'; ?></th>
                    <th><?php echo 'Value'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Userdata_Check($value, true);?>
            </tfoot>
        </table>
	<?php
}
	elseif($key == 'Projects'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                    <th><?php echo 'Summary'; ?></th>
                    <th><?php echo 'With'; ?></th>
                    <th><?php echo 'StartDate'; ?></th>
                    <th><?php echo 'EndDate'; ?></th>
                    <th><?php echo 'IsCurrent'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table><?php
	}
        elseif(in_array($key, array('RelatedProfileViews'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'First Name'; ?></th>
                    <th><?php echo 'Last Name'; ?></th>
                    <th><?php echo 'Id'; ?></th>
               </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif($key == 'Addresses'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Type'; ?></th>
                    <th><?php echo 'Address1'; ?></th>
                    <th><?php echo 'Address2'; ?></th>
                    <th><?php echo 'City'; ?></th>
                    <th><?php echo 'State'; ?></th>
                    <th><?php echo 'PostalCode'; ?></th>
                    <th><?php echo 'Region'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table><?php
	}
        elseif($key == 'IMAccounts'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'AccountType'; ?></th>
                    <th><?php echo 'AccountName'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table><?php
	}
        elseif($key == 'Badges'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'BageId'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                    <th><?php echo 'BageMessage'; ?></th>
                    <th><?php echo 'Description'; ?></th>
                    <th><?php echo 'ImageUrl'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table><?php
	}
        elseif($key == 'PhoneNumbers'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'PhoneType'; ?></th>
                    <th><?php echo 'PhoneNumber'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table><?php
	}
	elseif($key == 'Country'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Code'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Userdata_Check($value);?>
            </tfoot>
        </table><?php
	}
	elseif($key == 'AgeRange'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Type'; ?></th>
                    <th><?php echo 'Value'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Userdata_Check($value, true);?>
            </tfoot>
        </table><?php
	}
	elseif($key == 'FavoriteThings'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                    <th><?php echo 'Type'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table><?php
	}
	elseif($key == 'Awards'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                    <th><?php echo 'Issuer'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table><?php
	}
	elseif(in_array($key, array('InspirationalPeople','IndustriestoFollow','Sports','Languages','Skills'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table><?php
	}
        elseif($key=='Suggestions'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value->CompaniestoFollow);?>
            </tfoot>
        </table><?php
	}
	
	elseif($key == 'Positions'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Position'; ?></th>
                    <th><?php echo 'Summary'; ?></th>
                    <th><?php echo 'StartDate'; ?></th>
                    <th><?php echo 'EndDate'; ?></th>
                    <th><?php echo 'IsCurrent'; ?></th>
                    <th><?php echo 'Comapny'; ?></th>
                    <th><?php echo 'Location'; ?></th>      
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table><?php
	}
	elseif(in_array($key, array('Email','Interests'))){?>
   		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Type'; ?></th>
                    <th><?php echo 'Value'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
		}
	elseif($key == 'MutualFriends'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                    <th><?php echo 'FirstName'; ?></th>
                    <th><?php echo 'LastName'; ?></th>
                    <th><?php echo 'Birthday'; ?></th>
                    <th><?php echo 'Hometown'; ?></th>
                    <th><?php echo 'Link'; ?></th>
                    <th><?php echo 'Gender'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
		}
	elseif($key == 'CurrentStatus'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Text'; ?></th>
                    <th><?php echo 'Source'; ?></th>
                    <th><?php echo 'CreatedDate'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif($key == 'Educations'){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'School'; ?></th>
                    <th><?php echo 'year'; ?></th>
                    <th><?php echo 'type'; ?></th>
                    <th><?php echo 'notes'; ?></th>
                    <th><?php echo 'activities'; ?></th>
                    <th><?php echo 'degree'; ?></th>
                    <th><?php echo 'fieldofstudy'; ?></th>
                    <th><?php echo 'StartDate'; ?></th>
                    <th><?php echo 'EndDate'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
	elseif(in_array($key, array('Movies','Games','Books','TeleVisionShow'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Category'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                    <th><?php echo 'CreatedDate'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif(in_array($key, array('Certifications'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                    <th><?php echo 'Authority'; ?></th>
                    <th><?php echo 'Number'; ?></th>
                    <th><?php echo 'StartDate'; ?></th>
                    <th><?php echo 'EndDate'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif(in_array($key, array('MemberUrlResources'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Url'; ?></th>
                    <th><?php echo 'UrlName'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif(in_array($key, array('Courses'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                    <th><?php echo 'Number'; ?></th>
                </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif(in_array($key, array('Volunteer'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Role'; ?></th>
                    <th><?php echo 'Organization'; ?></th>
                    <th><?php echo 'Cause'; ?></th>
               </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif(in_array($key, array('RecommendationsReceived'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'RecommendationType'; ?></th>
                    <th><?php echo 'RecommendationText'; ?></th>
                    <th><?php echo 'Recommender'; ?></th>
               </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif(in_array($key, array('Patents'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Title'; ?></th>
                    <th><?php echo 'Date'; ?></th>
               </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif(in_array($key, array('Publications'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'Id'; ?></th>
                    <th><?php echo 'Title'; ?></th>
                    <th><?php echo 'Publisher'; ?></th>
                    <th><?php echo 'Authors'; ?></th>
                    <th><?php echo 'Date'; ?></th>
                    <th><?php echo 'Url'; ?></th>
                    <th><?php echo 'Summary'; ?></th>
               </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
		elseif(in_array($key, array('JobBookmarks'))){?>
		<table  class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'IsApplied'; ?></th>
                    <th><?php echo 'ApplyTimestamp'; ?></th>
                    <th><?php echo 'IsSaved'; ?></th>
                    <th><?php echo 'SavedTimestamp'; ?></th>
                    <th><?php echo 'Job'; ?></th>
               </tr>
            </thead>
            <tfoot>
                <?php LoginRadius_Internel_UserProfile($value);?>
            </tfoot>
        </table>
		<?php
        }
}

/*
 * Loginradius Check userprofile table manage
 */
function LoginRadius_Userdata_Check($value){
    if(is_object($value)){
        LoginRadius_userdata_format($value,true);
    }
    elseif(is_array($value)){
        foreach($value as $aid => $avalue){
            if(is_object($avalue)){
                    LoginRadius_userdata_format($avalue);
            }else{

                    LoginRadius_Userdata_Check($avalue);
            }
        }
    }
    else{
        echo '<td scope="col" >'.ucfirst($value).'</td>';
    }
}

/*
 * Loginradius userprofile Album table manage
 */
function LoginRadius_UserAlbam($array, $album=false, $loc=''){
    if(empty($array)){return;}
	if(!is_string($array)){?>
	<tfoot>
		<?php
		$count = 1;
			foreach($array as $temp){
				?>
					<tr <?php if(($count % 2) == 0){ echo 'style="background-color:#fcfcfc"'; } ?>>
						<?php
						if(is_object($temp) && !is_int($temp)&& !empty($temp)){
							foreach($temp as $key => $val){
								if(in_array($key, array('CoverImageUrl', 'ImageUrl', 'Picture', 'Logo', 'Image'))){
                                                                    if($album){?>
                                                                    <input type="hidden" value="<?php echo $album;?>" id="lraccesstoken">
                                                                    <input type="hidden" value="<?php echo $loc;?>" id="connection_url">
                                                                    <td scope="col" ><span onClick="lrprofilephotos('<?php echo $temp->ID?>');" style="cursor:pointer;"><?php if(!empty($val)){?><img src ="<?php echo $val; ?>" width="50" height="50" /><?php }else{
echo 'views';}?></span></td><?php
									}else{?>
									<td scope="col" ><?php if(!empty($val)){?><img src ="<?php echo $val; ?>" width="50" height="50" /><?php }?></td>
									<?php
									}
								}else{
									if(is_string($val)){
										?><td scope="col"><?php echo ucfirst($val) ?></td><?php
									}else{
										LoginRadius_Userdata_Check($val);
									}
								}
							}
						}
						?>
					</tr>
				<?php
				$count++;
			}
		?>
		</tfoot>
<?php
	}
}

/*
 * Loginradius User profile Table
 */
function LoginRadius_Internel_UserProfile($array){?>
	<tfoot>
		<?php
		$count = 1;
		if(!is_string($array) && !empty($array)){
			foreach($array as $temp){?>
                            <tr <?php if(($count % 2) == 0){ echo 'style="background-color:#fcfcfc"'; } ?>>
				<?php
			if(is_object($temp) && !empty($temp)){
          		foreach($temp as $key => $val){
				if(in_array($key, array('Comapny'))){
					?><td scope="col" >
					 <table  class="gridtable" cellspacing="0">
						  <thead>
							<tr>
								<th><?php echo 'Name'; ?></th>
								<th><?php echo 'Type'; ?></th>
								<th><?php echo 'Industry'; ?></th>
							</tr>
						  </thead>
						  <tfoot><?php
							foreach($val as $k => $v){?>
							   <td scope="col"><?php echo ucfirst($v) ?></td>                                             
							   <?php
						}
                      ?></tfoot>
        				</table>
					</td>
					<?php
					}
					elseif(in_array($key, array('Authors'))){
					?><td scope="col" >
					 <table  class="gridtable" cellspacing="0">
						  <thead>
							<tr>
								<th><?php echo 'Id'; ?></th>
								<th><?php echo 'Name'; ?></th>
							</tr>
						  </thead>
						  <tfoot><?php
							foreach($val as $v){?>
							   <td scope="col"><?php echo ($v->Id) ?></td>  
                               <td scope="col"><?php echo ($v->Name) ?></td>                                             
							   <?php
						}
                      ?></tfoot>
        				</table>
					</td>
					<?php
					}
					elseif(in_array($key, array('JobBookmarks'))){
					?><td scope="col" >
					 <table  class="gridtable" cellspacing="0">
						  <thead>
							<tr>
								<th><?php echo 'Active'; ?></th>
								<th><?php echo 'Id'; ?></th>
                                <th><?php echo 'DescriptionSnippet'; ?></th>
                                <th><?php echo 'Compony'; ?></th>
                                <th><?php echo 'Company'; ?></th>
                                <th><?php echo 'Position'; ?></th>
                                <th><?php echo 'PostingTimestamp'; ?></th>
							</tr>
						  </thead>
						  <tfoot><?php
							foreach($val as $v){?>
							   <td scope="col"><?php echo ($v) ?></td>                                             
							   <?php
						}
                      ?></tfoot>
        				</table>
					</td>
					<?php
					}
					elseif(in_array($key, array('CoverImageUrl', 'ImageUrl', 'Picture', 'Logo', 'Image'))){?>
						<td scope="col" ><?php if(!empty($val)){?><img src ="<?php echo $val; ?>" width="50" height="50" /><?php }?></td>
					<?php
					}elseif(empty($val)){
                                            ?><td scope="col"></td><?php
					}else{
                                            if(isset($k) && !is_string($val)){continue;}
						LoginRadius_Userdata_Check($val);
                                            }
					}
				}
				else{
					LoginRadius_Userdata_Check($temp);
				}
				$count++;
			}
		}else{
			?><td scope="col"><?php echo ucfirst($array); ?></td><?php 
		}
		?>
			</tr>
		</tfoot>
<?php
}
?>