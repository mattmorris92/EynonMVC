<div class="basicContent">
    <h1>Edit User</h1>
    <div class="contentBlock">
        <form name="login" method="POST">
            <div class="form_subblock">
                <h2>Personal Information</h2>
                <div class="formRow">
                    Username:
                    <div class="formInput">
                        <?php echo $this->ViewData['user']->Username;?>
                    </div>
                </div>
                <div class="formRow">
                    Banner ID:
                    <div class="formInput">
                        <input type="text" name="bannerid" value="<?php echo $this->ViewData['user']->SchoolID;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    First Name:
                    <div class="formInput">
                        <input type="text" name="first" value="<?php echo $this->ViewData['user']->First;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Middle Name:
                    <div class="formInput">
                        <input type="text" name="middle" value="<?php echo $this->ViewData['user']->Middle;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Last Name:
                    <div class="formInput">
                        <input type="text" name="last" value="<?php echo $this->ViewData['user']->Last;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Primary Email:
                    <div class="formInput">
                        <input type="text" name="primaryemail" value="<?php echo $this->ViewData['user']->PrimaryEmail;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Secondary Email:
                    <div class="formInput">
                        <input type="text" name="secondaryemail" value="<?php echo $this->ViewData['user']->SecondaryEmail;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Primary Phone:
                    <div class="formInput">
                        <input type="text" name="primaryphone" value="<?php echo $this->ViewData['user']->PrimaryPhone;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Secondary Phone:
                    <div class="formInput">
                        <input type="text" name="secondaryphone" value="<?php echo $this->ViewData['user']->SecondaryPhone;?>"/>
                    </div>
                </div>
            </div>
            
            <div class="form_subblock right">
                <h2>Reset Password</h2>
                <div class="formRow">
                    Current Password:
                    <div class="formInput">
                        <input type="password" name="currentpassword" />
                    </div>
                </div>
                <div class="formRow">
                    New Password:
                    <div class="formInput">
                        <input type="password" name="newpassword" />
                    </div>
                </div>
                <div class="formRow">
                    New Password Again:
                    <div class="formInput">
                        <input type="password" name="newpassword2" />
                    </div>
                </div>

                <div class="formRow" style="text-align: center;">
                    <input type="submit" name="reset_password" value="Reset Password" class="formButton" />
                </div>
            </div>
            
            <div class="form_subblock right">
                <h2>Account Details</h2>
                <div class="formRow">
                    User Role:
                    <div class="formInput">
                        <?php if ($this->ViewData['CurrentUser']->IsSuperior($this->ViewData['user'])) { ?>
                            <?php echo $this->BuildSelect("role", $this->ViewData['CurrentUser']->SubordinateRoles, "ID", "RoleName", $this->ViewData['user']->Roles[0]->ID); ?>
                        <?php }
                        else echo $this->ViewData['user']->Roles[0]->RoleName; ?>
                    </div>
                </div>
                <div class="formRow">
                    Account Created:
                    <div class="formInput">
                        <?php echo $this->ViewData['user']->DateCreated;?>
                    </div>
                </div>
                <div class="formRow">
                    Last Modified:
                    <div class="formInput">
                        <?php echo $this->ViewData['user']->LastModified;?>
                    </div>
                </div>
                <div class="formRow">
                    Last Login:
                    <div class="formInput">
                        <?php echo $this->ViewData['user']->LastLogin;?>
                    </div>
                </div>
                <?php echo $this->FormToken(); ?>
            </div>
            <div class="clearfix"></div>
            
            <div style="text-align: center;">
                <div class="formRow" style="text-align: center;">
                    <input type="submit" name="save" value="Save Changes" class="formButton" />
                    <?php if ($this->ViewData['CanDeleteUser']) { ?>
                    <input type="submit" name="delete" value="Delete User" class="formButton" onclick="return confirm('Are you sure you want to delete this user?');" />
                    <?php } ?>
                </div>
                <?php echo $this->FormToken(); ?>
            </div>
        </form>
    </div>
</div>

<div class="clearfix"></div>