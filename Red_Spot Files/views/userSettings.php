<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form role="form">
                    <div class="form-group" id="editFirstNameFormGroup">
                        <label class="control-label" for="editFirstNameInput">First Name</label>
                        <input class="form-control" id="editFirstNameInput" placeholder="First name" type="text">
                    </div>
                    <div class="form-group" id="editNameFormGroup">
                        <label class="control-label" for="editNameInput">Last Name</label>
                        <input class="form-control" id="editLastNameInput" placeholder="Last name" type="text">
                    </div>
                    <div class="form-group" id="editEmailFormGroup">
                        <label class="control-label" for="editEmailInput">Email address</label>
                        <input class="form-control" id="editEmailInput" placeholder="Enter email" type="email">
                        <p id="changeEmailErrorParagraph" style="display: none;">Email already in use</p>
                    </div>
                    <div class="well">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="changePasswordCheckBox">Change Password</label>
                        </div>
                        <div class="form-group" id="changeCurrentPasswordFormGroup">
                            <label class="control-label" for="changeCurrentPasswordInput">Current password</label>
                            <input class="form-control" id="changeCurrentPasswordInput" placeholder="Current password" type="password" disabled="disabled">
                        </div>
                        <div class="form-group" id="changeNewPasswordFormGroup">
                            <label class="control-label" for="changeNewPasswordInput">New password</label>
                            <input class="form-control" id="changeNewPasswordInput" placeholder="New password" type="password" disabled="disabled">
                        </div>
                        <div class="form-group" id="changePasswordConfirmFormGroup">
                            <label class="control-label" for="changePasswordConfirmInput">Confirm new password</label>
                            <input class="form-control" id="changePasswordConfirmInput" placeholder="Confirm new password" type="password" disabled="disabled">
                        </div>
                        <p id="passwordMismatchError" class="text-error" style="display: none;">
                            <strong>Passwords do not match!</strong>
                        </p>
                    </div>
                </form>
                <a class="btn btn-primary pull-right" id="saveChangesButton">Save Changes</a>
                <div id="userSettingsMessageDivision" style="position: fixed; right: 0; top: 50%; z-index: 10;"></div>
            </div>
        </div>
    </div>
</div>
<script src="../js/user_settings.js"></script>
