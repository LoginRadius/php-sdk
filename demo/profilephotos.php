<?php
	if(!isset($_REQUEST['lrphotoid']) || !isset($_REQUEST['lraccesstoken'])){die();}
	$lrphoto= $_REQUEST;	
	include_once('LoginRadiusSDK.php');
	$loginradius = new LoginRadius();
	$Userphotos = $loginradius->loginradius_get_photos($lrphoto['lraccesstoken'], $lrphoto['lrphotoid']);
	if(!empty($Userphotos)){?>
    <h2>photos</h2>
    <table class="gridtable" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo 'ID'; ?></th>
                    <th><?php echo 'AlbumId'; ?></th>
                    <th><?php echo 'OwnerId'; ?></th>
                    <th><?php echo 'OwnerName'; ?></th>
                    <th><?php echo 'Name'; ?></th>
                    <th><?php echo 'DirectUrl'; ?></th>
                    <th><?php echo 'ImageUrl'; ?></th>
                    <th><?php echo 'Location'; ?></th>
                    <th><?php echo 'Link'; ?></th>
                    <th><?php echo 'Description'; ?></th>
                    <th><?php echo 'Height'; ?></th>
                    <th><?php echo 'Width'; ?></th>
                    <th><?php echo 'CreatedDate'; ?></th>
                    <th><?php echo 'UpdatedDate'; ?></th>
                </tr>
            </thead>
            <tfoot>
				<?php LoginRadius_Internel_UserProfile($Userphotos);?>
			</tfoot>
        </table>
        <?php }
		else{
			die('<div id="Error">An Error has been occurred</div>');
		}
		?>