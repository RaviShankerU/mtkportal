<?php

require_once 'phpgen_settings.php';
require_once 'components/application.php';
require_once 'components/security/permission_set.php';
require_once 'components/security/user_authentication/table_based_user_authentication.php';
require_once 'components/security/grant_manager/user_grant_manager.php';
require_once 'components/security/grant_manager/composite_grant_manager.php';
require_once 'components/security/grant_manager/hard_coded_user_grant_manager.php';
require_once 'components/security/grant_manager/table_based_user_grant_manager.php';
require_once 'components/security/table_based_user_manager.php';

include_once 'components/security/user_identity_storage/user_identity_session_storage.php';

require_once 'database_engine/mysql_engine.php';

$grants = array();

$appGrants = array();

$dataSourceRecordPermissions = array('brief' => new DataSourceRecordPermission('created_by', true, false, false, true, true, true));

$tableCaptions = array('campaign_calendar' => 'Campaign & Events Calendar',
'brief' => 'Campaign Brief',
'campaign_approvals' => 'Campaign Approvals',
'brief01' => 'Campaigns',
'brief01.campaign_tracker_comms' => 'Campaigns->Comms Tracker',
'brief01.campaign_tracker_content' => 'Campaigns->Website Content ',
'brief01.campaign_tracker_website' => 'Campaigns->Website Event Listing',
'brief01.campaign_tracker_social' => 'Campaigns->Social Media',
'brief01.campaign_tracker_paid' => 'Campaigns->Paid Media',
'brief01.campaign_tracker_pr' => 'Campaigns->Public Relations',
'brief01.campaign_tracker_partner' => 'Campaigns->Partner Program',
'brief01.campaign_tracker_design' => 'Campaigns->Campaign Tracker Design',
'campaign_events' => 'Event List',
'campaign_ROI_Tracker' => 'Campaign ROI Tracker',
'campaign_analysis' => 'Campaign Analysis',
'campaign_utm' => 'Campaign Utm',
'utm_tracker' => 'Utm Tracker',
'campaign_group' => 'Campaign Tracker',
'campaign_tracker_website' => 'Campaign Tracker Website',
'campaign_tracker_comms' => 'Campaign Tracker Comms',
'campaign_tracker_content' => 'Campaign Tracker Content',
'campaign_tracker_design' => 'Campaign Tracker Design',
'campaign_tracker_social' => 'Campaign Tracker Social',
'campaign_tracker_paid' => 'Campaign Tracker Paid',
'campaign_tracker_partner' => 'Campaign Tracker Partner',
'campaign_tracker_pr' => 'Campaign Tracker Pr',
'phpgen_user_roles' => 'User Roles',
'country_list' => 'Country List');

$usersTableInfo = array(
    'TableName' => 'phpgen_users',
    'UserId' => 'user_id',
    'UserName' => 'user_name',
    'Password' => 'user_password',
    'Email' => 'user_email',
    'UserToken' => 'user_token',
    'UserStatus' => 'user_status'
);

function EncryptPassword($password, &$result)
{

}

function VerifyPassword($enteredPassword, $encryptedPassword, &$result)
{

}

function BeforeUserRegistration($username, $email, $password, &$allowRegistration, &$errorMessage)
{

}    

function AfterUserRegistration($username, $email)
{

}    

function PasswordResetRequest($username, $email)
{

}

function PasswordResetComplete($username, $email)
{

}

function CreatePasswordHasher()
{
    $hasher = CreateHasher('');
    if ($hasher instanceof CustomStringHasher) {
        $hasher->OnEncryptPassword->AddListener('EncryptPassword');
        $hasher->OnVerifyPassword->AddListener('VerifyPassword');
    }
    return $hasher;
}

function CreateTableBasedGrantManager()
{
    global $tableCaptions;
    global $usersTableInfo;
    $userPermsTableInfo = array('TableName' => 'phpgen_user_perms', 'UserId' => 'user_id', 'PageName' => 'page_name', 'Grant' => 'perm_name');
    
    $tableBasedGrantManager = new TableBasedUserGrantManager(MySqlIConnectionFactory::getInstance(), GetGlobalConnectionOptions(),
        $usersTableInfo, $userPermsTableInfo, $tableCaptions, true);
    return $tableBasedGrantManager;
}

function CreateTableBasedUserManager() {
    global $usersTableInfo;
    return new TableBasedUserManager(MySqlIConnectionFactory::getInstance(), GetGlobalConnectionOptions(), $usersTableInfo, CreatePasswordHasher(), true);
}

function SetUpUserAuthorization()
{
    global $grants;
    global $appGrants;
    global $dataSourceRecordPermissions;

    $hasher = CreatePasswordHasher();

    $hardCodedGrantManager = new HardCodedUserGrantManager($grants, $appGrants);
    $tableBasedGrantManager = CreateTableBasedGrantManager();
    $grantManager = new CompositeGrantManager();
    $grantManager->AddGrantManager($hardCodedGrantManager);
    if (!is_null($tableBasedGrantManager)) {
        $grantManager->AddGrantManager($tableBasedGrantManager);
    }

    $userAuthentication = new TableBasedUserAuthentication(new UserIdentitySessionStorage(), true, $hasher, CreateTableBasedUserManager(), true, false, true);

    GetApplication()->SetUserAuthentication($userAuthentication);
    GetApplication()->SetUserGrantManager($grantManager);
    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}
