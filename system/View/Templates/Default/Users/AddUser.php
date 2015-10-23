<div class="basicContent">
    <h1>Add User</h1>
    <div class="contentBlock">
        <form name="login" method="POST">
            <div class="form_subblock">
                <h2>Personal Information</h2>
                <div class="formRow">
                    Username:
                    <div class="formInput">
                        <input type="text" name="username" value="<?php echo $this->ViewData['user']->username;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Banner ID:
                    <div class="formInput">
                        <input type="text" name="bannerid" value="<?php echo $this->ViewData['user']->bannerid;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    First Name:
                    <div class="formInput">
                        <input type="text" name="first" value="<?php echo $this->ViewData['user']->first;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Middle Name:
                    <div class="formInput">
                        <input type="text" name="middle" value="<?php echo $this->ViewData['user']->middle;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Last Name:
                    <div class="formInput">
                        <input type="text" name="last" value="<?php echo $this->ViewData['user']->last;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Primary Email:
                    <div class="formInput">
                        <input type="text" name="primaryemail" value="<?php echo $this->ViewData['user']->primaryemail;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Secondary Email:
                    <div class="formInput">
                        <input type="text" name="secondaryemail" value="<?php echo $this->ViewData['user']->secondaryemail;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Primary Phone:
                    <div class="formInput">
                        <input type="text" name="primaryphone" value="<?php echo $this->ViewData['user']->primaryphone;?>"/>
                    </div>
                </div>
                <div class="formRow">
                    Secondary Phone:
                    <div class="formInput">
                        <input type="text" name="secondaryphone" value="<?php echo $this->ViewData['user']->secondaryphone;?>"/>
                    </div>
                </div>
            </div>
            
            <div class="form_subblock right">
                <h2>Account Password</h2>
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
            </div>
            
            <div class="form_subblock right">
                <h2>Account Details</h2>
                <div class="formRow">
                    User Role:
                    <div class="formInput">
                        <?php echo $this->BuildSelect("role", $this->ViewData['CurrentUser']->SubordinateRoles, "ID", "RoleName", 4); ?>
                    </div>
                </div>
                <div class="formRow">
                    Account Created:
                    <div class="formInput">
                        Never
                    </div>
                </div>
                <div class="formRow">
                    Last Modified:
                    <div class="formInput">
                        Never
                    </div>
                </div>
                <div class="formRow">
                    Last Login:
                    <div class="formInput">
                        Never
                    </div>
                </div>
                <?php echo $this->FormToken(); ?>
            </div>
            <div class="clearfix"></div>
            
            <div style="text-align: center;">
                <div class="formRow" style="text-align: center;">
                    <input type="submit" name="save" value="Create User" class="formButton" />
                </div>
                <?php echo $this->FormToken(); ?>
            </div>
        </form>
    </div>
</div>

<div class="clearfix"></div>