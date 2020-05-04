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

$dataSourceRecordPermissions = array('brief' => new DataSourceRecordPermission('created_by', true, false, false, true, true, true),
  'brief01' => new DataSourceRecordPermission('created_by', true, false, false, true, true, true),
  'campaign_analysis' => new DataSourceRecordPermission('created_by', true, false, false, true, true, true),
  'campaign_program_name_generator' => new DataSourceRecordPermission('created_by', true, false, false, true, true, true),
  'campaign_comm_regional_approval' => new DataSourceRecordPermission('created_by', true, false, false, true, true, true),
  'campaign_tracker_utm' => new DataSourceRecordPermission('created_by', true, false, false, true, true, true),
  'campaign_import' => new DataSourceRecordPermission('created_by', true, false, false, true, true, true),
  'portal_help' => new DataSourceRecordPermission('created_by', true, false, false, true, true, true));

$tableCaptions = array('campaign_calendar' => 'Global Calendar',
'brief' => 'Campaign Brief',
'campaign_events' => 'Event List',
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
'campaign_ROI_Tracker' => 'Campaign ROI Tracker',
'campaign_analysis' => 'Campaign Analysis',
'campaign_group' => 'Campaign Tracker',
'campaign_program_name_generator' => 'Campaign Builder',
'campaign_program_name_generator.campaign_tracker_comms_local' => 'Campaign Builder->Campaign Tracker Comms',
'campaign_tracker_comms_local' => 'Comms Tracker',
'campaign_comm_regional_approval' => 'Comms Approval',
'campaign_tracker_utm' => 'UTM Link Generator',
'campaign_import' => 'Contact List Import',
'campaign_tracker_website' => 'Website Listing',
'campaign_tracker_comms' => 'Global Comms Tracker',
'campaign_tracker_design' => 'Graphic Design',
'campaign_tracker_content' => 'Web Content',
'campaign_tracker_social' => 'Social Media',
'campaign_tracker_paid' => 'Paid',
'campaign_tracker_partner' => 'Partner Program',
'campaign_tracker_pr' => 'Public Relations',
'country_list' => 'Country List',
'lookup_tracker_tactics' => 'Tactic Template',
'phpgen_user_roles' => 'User Roles',
'activity_log' => 'Activity Log',
'portal_help' => 'Portal Help',
'phpgen_users' => 'System Users');

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

    $userAuthentication = new TableBasedUserAuthentication(new UserIdentitySessionStorage(), true, $hasher, CreateTableBasedUserManager(), true, true, true);

    GetApplication()->SetUserAuthentication($userAuthentication);
    GetApplication()->SetUserGrantManager($grantManager);
    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}
