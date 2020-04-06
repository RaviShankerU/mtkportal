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
    $result[] = array('caption' => 'New Campaign', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque.');
    $result[] = array('caption' => 'Campaign Manager', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque.');
    $result[] = array('caption' => 'Campaign Planner', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque.');
    $result[] = array('caption' => 'Tools', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque.');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Campaign & Events Calendar', 'short_caption' => 'Campaign & Events Calendar', 'filename' => 'campaign_calendar.php', 'name' => 'campaign_calendar', 'group_name' => 'New Campaign', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_calendar.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="http://mktportal.mscsoftware.com/icons/event_cal.png" class="icon-size">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Campaign Calendar</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Brief', 'short_caption' => 'Campaign: Brief Request', 'filename' => 'brief.php', 'name' => 'brief', 'group_name' => 'New Campaign', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com//brief.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="http://mktportal.mscsoftware.com/icons/add.png" class="icon-size">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Campaign Request</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Approvals', 'short_caption' => 'Campaign: Brief Approvals', 'filename' => 'campaign_approvals.php', 'name' => 'campaign_approvals', 'group_name' => 'New Campaign', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_approvals.php" style="text-decoration:none;">
      <div class="card">
        <div class="card-circle">
          <img src="http://mktportal.mscsoftware.com/icons/approve.png" class="icon-size">
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
          <img src="http://mktportal.mscsoftware.com/icons/campaign.png" class="icon-size">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Campaigns</strong></span>
        <p>Approved campaigns, lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Event List', 'short_caption' => 'Event List', 'filename' => 'campaign_events.php', 'name' => 'campaign_events', 'group_name' => 'Campaign Manager', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_events.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="http://mktportal.mscsoftware.com/icons/event.png" class="icon-size">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Events</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign ROI Tracker', 'short_caption' => 'Campaign ROI Tracker', 'filename' => 'campaign_ROI_Tracker.php', 'name' => 'campaign_ROI_Tracker', 'group_name' => 'Campaign Manager', 'add_separator' => false, 'description' => '<a href="http://localhost/mportal/campaign_ROI_Tracker.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="http://localhost/mportal/icons/roi-tracker.png" class="icon-size">
      </div>
      <div class="text-content">
        <span class=card-title><strong>ROI Tracker</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Analysis', 'short_caption' => 'Campaign Analysis', 'filename' => 'campaign_analysis.php', 'name' => 'campaign_analysis', 'group_name' => 'Campaign Manager', 'add_separator' => false, 'description' => '<a href="http://localhost/mportal/campaign_analysis.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="http://localhost/mportal/icons/analytics.png" class="icon-size">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Campaign Analysis</strong></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Tracker Website', 'short_caption' => 'Campaign Tracker: Website', 'filename' => 'campaign_tracker_website.php', 'name' => 'campaign_tracker_website', 'group_name' => 'Campaign Planner', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_tracker_website.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="http://mktportal.mscsoftware.com/icons/website-list.png" class="icon-size">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Website Listing</strong></span>
        <p>Approved campaigns, lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Tracker Comms', 'short_caption' => 'Campaign Tracker: Comms', 'filename' => 'campaign_tracker_comms.php', 'name' => 'campaign_tracker_comms', 'group_name' => 'Campaign Planner', 'add_separator' => false, 'description' => '<a href="http://mktportal.mscsoftware.com/campaign_global_list.php" style="text-decoration:none;">
    <div class="card">
        <div class="card-circle">
          <img src="http://mktportal.mscsoftware.com/icons/comms.png" class="icon-size">
      </div>
      <div class="text-content">
        <span class=card-title><strong>Comms Tracker (Marketo)</strong></span>
        <p>Approved campaigns, lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque. </p>
      </div>
    </div>
    </a>');
    $result[] = array('caption' => 'Campaign Tracker Content', 'short_caption' => 'Campaign Tracker: Content', 'filename' => 'campaign_tracker_content.php', 'name' => 'campaign_tracker_content', 'group_name' => 'Campaign Planner', 'add_separator' => false, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque.');
    $result[] = array('caption' => 'Campaign Tracker Design', 'short_caption' => 'Campaign Tracker: Design', 'filename' => 'campaign_tracker_design.php', 'name' => 'campaign_tracker_design', 'group_name' => 'Campaign Planner', 'add_separator' => false, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat mattis metus at porta. Fusce arcu felis, mollis ac neque.');
    $result[] = array('caption' => 'Campaign Tracker Social', 'short_caption' => 'Campaign Tracker: Social', 'filename' => 'campaign_tracker_social.php', 'name' => 'campaign_tracker_social', 'group_name' => 'Campaign Planner', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Campaign Tracker Paid', 'short_caption' => 'Campaign Tracker: Paid', 'filename' => 'campaign_tracker_paid.php', 'name' => 'campaign_tracker_paid', 'group_name' => 'Campaign Planner', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Campaign Tracker Partner', 'short_caption' => 'Campaign Tracker: Partner', 'filename' => 'campaign_tracker_partner.php', 'name' => 'campaign_tracker_partner', 'group_name' => 'Campaign Planner', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Campaign Tracker Pr', 'short_caption' => 'Campaign Tracker: Pr', 'filename' => 'campaign_tracker_pr.php', 'name' => 'campaign_tracker_pr', 'group_name' => 'Campaign Planner', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'User Roles', 'short_caption' => 'User Roles', 'filename' => 'phpgen_user_roles.php', 'name' => 'phpgen_user_roles', 'group_name' => 'Tools', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Country List', 'short_caption' => 'Country List', 'filename' => 'country_list.php', 'name' => 'country_list', 'group_name' => 'Tools', 'add_separator' => false, 'description' => '');
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
        '<p align="right">(C) <span>2002-<script type="text/javascript">document.write(new Date().getFullYear().toString())</script></span><a href="#"> MSC Group Marketing</a>.</p>';
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

}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{

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
    return PageList::TYPE_MENU;
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
    $mailerOptions = new MailerOptions(MailerType::Sendmail, '', '');
    
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
