<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/mail/mailer.php';
include_once dirname(__FILE__) . '/' . 'components/mail/phpmailer_based_mailer.php';
require_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('Europe/Dublin');

function GetGlobalConnectionOptions()
{
    return
        array(
          'server' => 'marketing-portal.cdbvvuxawpkp.eu-west-2.rds.amazonaws.com',
          'port' => '3306',
          'username' => 'marketing_portal',
          'password' => 'Welcome2019!',
          'database' => 'marketing_portal_v2',
          'client_encoding' => 'utf8'
        );
}

function HasAdminPage()
{
    return true;
}

function HasHomePage()
{
    return true;
}

function GetHomeURL()
{
    return 'index.php';
}

function GetHomePageBanner()
{
    return '';
}

function GetPageGroups()
{
    $result = array();
    $result[] = array('caption' => 'New Campaign', 'description' => 'This section of the portal is the most common place to start when setting up and event or a campaign of any sort.');
    $result[] = array('caption' => 'Campaign Tools', 'description' => 'These campaign tools are carefull put together to help you track and support your campaign.');
    $result[] = array('caption' => 'Campaign Manager', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque.');
    $result[] = array('caption' => 'Global Marketing', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque.');
    $result[] = array('caption' => 'Admin Tools', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque.');
    $result[] = array('caption' => 'Default', 'description' => '');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Global Calendar', 'short_caption' => 'Campaign & Events Calendar', 'filename' => 'campaign_calendar.php', 'name' => 'campaign_calendar', 'group_name' => 'New Campaign', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_calendar.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/event_cal.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Campaign Calendar</strong></span>
        <p>Step 1:  Please check here first to see the campaigns running and to find an available date. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Brief', 'short_caption' => 'Campaign: Brief Request', 'filename' => 'brief.php', 'name' => 'brief', 'group_name' => 'New Campaign', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/brief.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/add.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Campaign Request</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Event List', 'short_caption' => 'Event List', 'filename' => 'campaign_events.php', 'name' => 'campaign_events', 'group_name' => 'New Campaign', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_events.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/event.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Events</strong></span>
        <p>Events, is a list overview for all events, virtual or location based displaying a region and global budget with your own or budget approval list.</p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Approvals', 'short_caption' => 'Campaign: Brief Approvals', 'filename' => 'campaign_approvals.php', 'name' => 'campaign_approvals', 'group_name' => 'Campaign Manager', 'add_separator' => false, 'description' => '<a href="campaign_approvals.php" style="text-decoration:none;">
      <div class="card">
        <div class="card-circle">
          <img src="apps/icons/approve.png" class="icon-size-desk">
        </div>
        <div class="text-content">
          <span class=card-title><strong>Approve & Deploy</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
       </div>
     </div>
    </a>');
    $result[] = array('caption' => 'Campaigns', 'short_caption' => 'Campaigns', 'filename' => 'campaign_global_list.php', 'name' => 'brief01', 'group_name' => 'Campaign Manager', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_global_list.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/campaign.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Campaigns</strong></span>
        <p>Approved campaigns, lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign ROI Tracker', 'short_caption' => 'Campaign ROI Tracker', 'filename' => 'campaign_ROI_Tracker.php', 'name' => 'campaign_ROI_Tracker', 'group_name' => 'Campaign Manager', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_ROI_Tracker.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/roi-tracker.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>ROI Tracker</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Analysis', 'short_caption' => 'Campaign Analysis', 'filename' => 'campaign_analysis.php', 'name' => 'campaign_analysis', 'group_name' => 'Campaign Manager', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_analysis.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/analytics.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Campaign Analysis</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Builder', 'short_caption' => 'Campaign Builder', 'filename' => 'campaign_program_name_generator.php', 'name' => 'campaign_program_name_generator', 'group_name' => 'Campaign Tools', 'add_separator' => false, 'description' => '<a href="campaign_program_name_generator.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/program-generator.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Campaign Builder</strong></span>
        <p>Step 2:  Please plan and enter the details of  your campaign here. Click on +Add New.</p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Comms Tracker', 'short_caption' => 'Campaign Tracker: Comms', 'filename' => 'campaign_tracker_comms_local.php', 'name' => 'campaign_tracker_comms_local', 'group_name' => 'Campaign Tools', 'add_separator' => false, 'description' => '<a href="campaign_tracker_comms_local.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/comms.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Comms Tracker (Local)</strong></span>
        <p>The Comms Tracker supports the Program Generator, Events displaying preplanned target list by channel in the Campaign Calendar.</p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Comms Approval', 'short_caption' => 'Campaign Comm Regional Approval', 'filename' => 'campaign_comm_regional_approval.php', 'name' => 'campaign_comm_regional_approval', 'group_name' => 'Campaign Tools', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'UTM Link Generator', 'short_caption' => 'Campaign Tracker: UTM Link Generator', 'filename' => 'campaign_tracker_utm.php', 'name' => 'campaign_tracker_utm', 'group_name' => 'Campaign Tools', 'add_separator' => false, 'description' => '<a href="campaign_tracker_utm.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/utm-tracking.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>UTM Tracking</strong></span>
        <p>Generate custom campaign tracking for your email, social, paid posts URLs, this supports the comms tracker.</p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Contact List Import', 'short_caption' => 'Contact List Import', 'filename' => 'campaign_import.php', 'name' => 'campaign_import', 'group_name' => 'Campaign Tools', 'add_separator' => false, 'description' => '<a href="campaign_import.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/import.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>List Import</strong></span>
        <p>List import is the centralised managed import register to comply with GDPR and quality data being imported into Salesforce via Marketo.</p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Website Listing', 'short_caption' => 'Campaign Tracker: Website', 'filename' => 'campaign_tracker_website.php', 'name' => 'campaign_tracker_website', 'group_name' => 'Global Marketing', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_tracker_website.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/website-list.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Website Listing</strong></span>
        <p>Approved campaigns, lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Global Comms Tracker', 'short_caption' => 'Campaign Tracker: Global Comms', 'filename' => 'campaign_tracker_comms.php', 'name' => 'campaign_tracker_comms', 'group_name' => 'Global Marketing', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_tracker_comms.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/comms.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Comms Tracker (Marketo)</strong></span>
        <p>Approved campaigns, lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Graphic Design', 'short_caption' => 'Campaign Tracker: Design', 'filename' => 'campaign_tracker_design.php', 'name' => 'campaign_tracker_design', 'group_name' => 'Global Marketing', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_tracker_design.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/design.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Graphic Design</strong></span>
        <p>Approved campaigns, lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Web Content', 'short_caption' => 'Campaign Tracker: Content', 'filename' => 'campaign_tracker_content.php', 'name' => 'campaign_tracker_content', 'group_name' => 'Global Marketing', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_tracker_content.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/web-content.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Web Content</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Social Media', 'short_caption' => 'Campaign Tracker: Social', 'filename' => 'campaign_tracker_social.php', 'name' => 'campaign_tracker_social', 'group_name' => 'Global Marketing', 'add_separator' => false, 'description' => '<a href="https://mktportal.mscsoftware.com/campaign_tracker_social.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/social-media.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Social Media</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Paid', 'short_caption' => 'Campaign Tracker: Paid', 'filename' => 'campaign_tracker_paid.php', 'name' => 'campaign_tracker_paid', 'group_name' => 'Global Marketing', 'add_separator' => false, 'description' => '<a href="https://mktportal.mscsoftware.com/campaign_tracker_paid.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/paid.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Paid Media</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Partner Program', 'short_caption' => 'Campaign Tracker: Partner', 'filename' => 'campaign_tracker_partner.php', 'name' => 'campaign_tracker_partner', 'group_name' => 'Global Marketing', 'add_separator' => false, 'description' => '<a href="https://mktportal.mscsoftware.com/campaign_tracker_partner.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/partner.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Partner Program</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Public Relations', 'short_caption' => 'Campaign Tracker: Pr', 'filename' => 'campaign_tracker_pr.php', 'name' => 'campaign_tracker_pr', 'group_name' => 'Global Marketing', 'add_separator' => false, 'description' => '<a href="https://mktportal.mscsoftware.com/campaign_tracker_pr.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/public-relations.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Public Relations</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Country List', 'short_caption' => 'Country List', 'filename' => 'country_list.php', 'name' => 'country_list', 'group_name' => 'Admin Tools', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/country_list.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/globe.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Country List</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Tactic Template', 'short_caption' => 'Tactic Template Builder', 'filename' => 'lookup_tracker_tactics.php', 'name' => 'lookup_tracker_tactics', 'group_name' => 'Admin Tools', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/lookup_tracker_tactics.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/template.png" class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Tactic Templates</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Activity Log', 'short_caption' => 'Activity Log', 'filename' => 'activity_log.php', 'name' => 'activity_log', 'group_name' => 'Admin Tools', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/activity_log.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="apps/icons/activity-log.png"  class="icon-size-desk">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Activity Log</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Portal Help', 'short_caption' => 'Portal Help', 'filename' => 'portal_help.php', 'name' => 'portal_help', 'group_name' => 'Default', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'System Users', 'short_caption' => 'System Users & Reports', 'filename' => 'phpgen_users.php', 'name' => 'phpgen_users', 'group_name' => 'Admin Tools', 'add_separator' => false, 'description' => '');
    return $result;
}

function GetPagesHeader()
{
    return
        '<div style="width:240px; padding:5px; 0;"><a href="http://mktportal.mscsoftware.com"><img src="https://documents.mscsoftware.com/cdn/farfuture/NPSxCF6sOluXCivzz8rQYbntpJ5OvR3pKrSJezOcrQ4/mtime:1575505133/sites/default/files/MSC_Cobrand.png" style="width: 190px; padding: 10px 0;"></a></div>';
}

function GetPagesFooter()
{
    return
        '<p align="right">(C) <span>2020-<script type="text/javascript">document.write(new Date().getFullYear().toString())</script></span><a href="#"> MSC Group Marketing</a>. Release Version v2.18</p>';
}

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(true);
    $page->setShowNavigation(true);
    $page->OnCustomHTMLHeader->AddListener('Global_CustomHTMLHeaderHandler');
    $page->OnGetCustomTemplate->AddListener('Global_GetCustomTemplateHandler');
    $page->OnGetCustomExportOptions->AddListener('Global_OnGetCustomExportOptions');
    $page->getDataset()->OnGetFieldValue->AddListener('Global_OnGetFieldValue');
    $page->getDataset()->OnGetFieldValue->AddListener('OnGetFieldValue', $page);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
    $grid->AfterUpdateRecord->AddListener('Global_AfterUpdateHandler');
    $grid->AfterDeleteRecord->AddListener('Global_AfterDeleteHandler');
    $grid->AfterInsertRecord->AddListener('Global_AfterInsertHandler');
}

function GetAnsiEncoding() { return 'windows-1252'; }

function Global_OnGetCustomPagePermissionsHandler(Page $page, PermissionSet &$permissions, &$handled)
{
    // do not apply these rules for site admins
    
    if (!GetApplication()->HasAdminGrantForCurrentUser()) {
    
        // retrieving the ID of the current user
        $userId = GetApplication()->GetCurrentUserId();
    
        // retrieving all user roles 
        $sql =        
          "SELECT r.role_name " .
          "FROM `phpgen_users` ur " .
          "INNER JOIN `phpgen_user_roles` r ON r.user_id = ur.user_id " .
          "WHERE ur.user_id = %d";    
        $result = $page->GetConnection()->fetchAll(sprintf($sql, $userId));
    
     
    
        // iterating through retrieved roles
        if (!empty($result)) {
           foreach ($result as $row) {
               // is current user a member of the Sales role?
               if ($row['role_name'] === 'manager') {
                 // if yes, allow all actions.
                 // otherwise default permissions for this page will be applied
                 $permissions->setGrants(true, true, true, true);
                 break;
               }                 
           }
        };    
    
        // apply the new permissions
        $handled = true;
    
    }
}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{
    $customHtmlHeaderText .= '<link rel="shortcut icon" href="https://media.mscsoftware.com/cdn/farfuture/xOwsKcC3mIm-Iqfj4r7XWg7lk-9NwPglxVzI7ZhQNBQ/mtime:1567191942/favicon.ico" type="image/vnd.microsoft.icon" />';
}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{
    if ($part == PagePart::PageList) {
          $result = 'custom_menu.tpl';
    }
}

function Global_OnGetCustomExportOptions($page, $exportType, $rowData, &$options)
{

}

function Global_OnGetFieldValue($fieldName, &$value, $tableName)
{

}

function Global_GetCustomPageList(CommonPage $page, PageList $pageList)
{

}

function Global_BeforeInsertHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeUpdateHandler($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeDeleteHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_AfterInsertHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterUpdateHandler($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterDeleteHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function GetDefaultDateFormat()
{
    return 'd-m-Y';
}

function GetFirstDayOfWeek()
{
    return 1;
}

function GetPageListType()
{
    return PageList::TYPE_SIDEBAR;
}

function GetNullLabel()
{
    return null;
}

function UseMinifiedJS()
{
    return true;
}

function GetOfflineMode()
{
    return false;
}

function GetInactivityTimeout()
{
    return 1200;
}

function GetMailer()
{
    $smtpOptions = new SMTPOptions('10.60.226.38', 25, false, '', '', '');
    $mailerOptions = new MailerOptions(MailerType::SMTP, 'mktportal@mscsoftware.com', 'MSC Marketing Portal', $smtpOptions);
    
    return PHPMailerBasedMailer::getInstance($mailerOptions);
}

function sendMailMessage($recipients, $messageSubject, $messageBody, $attachments = '', $cc = '', $bcc = '')
{
    GetMailer()->send($recipients, $messageSubject, $messageBody, $attachments, $cc, $bcc);
}

function createConnection()
{
    $connectionOptions = GetGlobalConnectionOptions();
    $connectionOptions['client_encoding'] = 'utf8';

    $connectionFactory = MySqlIConnectionFactory::getInstance();
    return $connectionFactory->CreateConnection($connectionOptions);
}
