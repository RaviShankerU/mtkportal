<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class campaign_eventsPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Event List');
            $this->SetMenuLabel('Event List');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_events`');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_event_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new StringField('Event_Name'),
                    new StringField('eRegion'),
                    new StringField('Country'),
                    new StringField('Website'),
                    new StringField('Venue'),
                    new StringField('City'),
                    new StringField('Event_status'),
                    new StringField('Approval'),
                    new StringField('Event_Type'),
                    new StringField('Business_Responsible'),
                    new StringField('Owner_Person'),
                    new StringField('Brands_Attending'),
                    new DateTimeField('Start_Date'),
                    new DateTimeField('End_Date'),
                    new StringField('Objective'),
                    new IntegerField('Expected_ROI_OTS'),
                    new StringField('Expected_ROI_Enquiries'),
                    new StringField('Post_Enquiries'),
                    new StringField('New_Opportunities'),
                    new IntegerField('Est_Opportunity_value_in_Euros', true),
                    new StringField('Industry'),
                    new StringField('Strategic_Campaign'),
                    new StringField('Short_Description'),
                    new IntegerField('Event_Cost'),
                    new StringField('Planned_Booth_Area'),
                    new StringField('Created_by'),
                    new DateTimeField('Created_Date', true),
                    new StringField('Updated_by'),
                    new DateTimeField('Updated_Date', true),
                    new StringField('Marketo_Campaign'),
                    new StringField('Banner'),
                    new StringField('Publish_Live'),
                    new DateField('Publish_Live_Date'),
                    new StringField('Event_Title'),
                    new StringField('SEO_Title')
                )
            );
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
            $this->dataset->AddLookupField('eRegion', 'lookup_region', new StringField('Region'), new StringField('Region', false, false, false, false, 'eRegion_Region', 'eRegion_Region_lookup_region'), 'eRegion_Region_lookup_region');
            $this->dataset->AddLookupField('Country', 'country_list', new IntegerField('Country_ID'), new StringField('Country_Name', false, false, false, false, 'Country_Country_Name', 'Country_Country_Name_country_list'), 'Country_Country_Name_country_list');
            $this->dataset->AddLookupField('Event_status', '(SELECT `Status_Type_ID`, `Status_Type`, `Status_Type_Value`, `Status_Filters` 
            FROM `lookup_status_types` 
            WHERE `Status_Filters` = \'brief\')', new IntegerField('Status_Type_ID'), new StringField('Status_Type', false, false, false, false, 'Event_status_Status_Type', 'Event_status_Status_Type_lookup_status_types_planning'), 'Event_status_Status_Type_lookup_status_types_planning');
            $this->dataset->AddLookupField('Event_Type', 'lookup_event_type', new IntegerField('Event_Type_ID'), new StringField('Event_Type', false, false, false, false, 'Event_Type_Event_Type', 'Event_Type_Event_Type_lookup_event_type'), 'Event_Type_Event_Type_lookup_event_type');
            $this->dataset->AddLookupField('Business_Responsible', 'lookup_brands', new IntegerField('Brands_ID'), new StringField('Brand_Name', false, false, false, false, 'Business_Responsible_Brand_Name', 'Business_Responsible_Brand_Name_lookup_brands'), 'Business_Responsible_Brand_Name_lookup_brands');
            $this->dataset->AddLookupField('Owner_Person', 'phpgen_users', new IntegerField('user_id'), new StringField('user_name', false, false, false, false, 'Owner_Person_user_name', 'Owner_Person_user_name_phpgen_users'), 'Owner_Person_user_name_phpgen_users');
            $this->dataset->AddLookupField('Brands_Attending', 'lookup_brands', new IntegerField('Brands_ID'), new StringField('Brand_Name', false, false, false, false, 'Brands_Attending_Brand_Name', 'Brands_Attending_Brand_Name_lookup_brands'), 'Brands_Attending_Brand_Name_lookup_brands');
            $this->dataset->AddLookupField('Publish_Live', 'lookup_status_types', new IntegerField('Status_Type_ID'), new StringField('Status_Type', false, false, false, false, 'Publish_Live_Status_Type', 'Publish_Live_Status_Type_lookup_status_types'), 'Publish_Live_Status_Type_lookup_status_types');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new CustomPageNavigator('partition', $this, $this->dataset, 'Group by Region', $result);
            $partitionNavigator->OnGetPartitionCondition->AddListener('partition' . '_GetPartitionConditionHandler', $this);
            $partitionNavigator->OnGetPartitions->AddListener('partition' . '_GetPartitionsHandler', $this);
            $partitionNavigator->SetAllowViewAllRecords(true);
            $partitionNavigator->SetNavigationStyle(NS_LIST);
            $result->AddPageNavigator($partitionNavigator);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'campaign_event_id', 'campaign_event_id', 'Campaign Event Id'),
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Name'),
                new FilterColumn($this->dataset, 'Event_Name', 'Event_Name', 'Event Name'),
                new FilterColumn($this->dataset, 'eRegion', 'eRegion_Region', 'Region'),
                new FilterColumn($this->dataset, 'Country', 'Country_Country_Name', 'Country'),
                new FilterColumn($this->dataset, 'Website', 'Website', 'Website'),
                new FilterColumn($this->dataset, 'Venue', 'Venue', 'Venue'),
                new FilterColumn($this->dataset, 'City', 'City', 'City'),
                new FilterColumn($this->dataset, 'Event_status', 'Event_status_Status_Type', 'Event Status'),
                new FilterColumn($this->dataset, 'Event_Type', 'Event_Type_Event_Type', 'Event Type'),
                new FilterColumn($this->dataset, 'Business_Responsible', 'Business_Responsible_Brand_Name', 'Business Responsible'),
                new FilterColumn($this->dataset, 'Owner_Person', 'Owner_Person_user_name', 'Project Owner'),
                new FilterColumn($this->dataset, 'Brands_Attending', 'Brands_Attending_Brand_Name', 'Brands Attending'),
                new FilterColumn($this->dataset, 'Start_Date', 'Start_Date', 'Start Date'),
                new FilterColumn($this->dataset, 'End_Date', 'End_Date', 'End Date'),
                new FilterColumn($this->dataset, 'Objective', 'Objective', 'Objective'),
                new FilterColumn($this->dataset, 'Expected_ROI_OTS', 'Expected_ROI_OTS', 'Expected ROI OTS'),
                new FilterColumn($this->dataset, 'Expected_ROI_Enquiries', 'Expected_ROI_Enquiries', 'Expected ROI Enquiries'),
                new FilterColumn($this->dataset, 'Post_Enquiries', 'Post_Enquiries', 'Post Enquiries'),
                new FilterColumn($this->dataset, 'New_Opportunities', 'New_Opportunities', 'New Opportunities'),
                new FilterColumn($this->dataset, 'Industry', 'Industry', 'Industry'),
                new FilterColumn($this->dataset, 'Strategic_Campaign', 'Strategic_Campaign', 'Strategic Campaign'),
                new FilterColumn($this->dataset, 'Short_Description', 'Short_Description', 'Short Description'),
                new FilterColumn($this->dataset, 'Event_Cost', 'Event_Cost', 'Event Cost'),
                new FilterColumn($this->dataset, 'Planned_Booth_Area', 'Planned_Booth_Area', 'Planned Booth Area'),
                new FilterColumn($this->dataset, 'Created_by', 'Created_by', 'Created By'),
                new FilterColumn($this->dataset, 'Created_Date', 'Created_Date', 'Created Date'),
                new FilterColumn($this->dataset, 'Updated_by', 'Updated_by', 'Updated By'),
                new FilterColumn($this->dataset, 'Updated_Date', 'Updated_Date', 'Updated Date'),
                new FilterColumn($this->dataset, 'Marketo_Campaign', 'Marketo_Campaign', 'Marketo Campaign'),
                new FilterColumn($this->dataset, 'Banner', 'Banner', 'Banner'),
                new FilterColumn($this->dataset, 'Approval', 'Approval', 'List on Website?'),
                new FilterColumn($this->dataset, 'Publish_Live', 'Publish_Live_Status_Type', 'Publish Live'),
                new FilterColumn($this->dataset, 'Publish_Live_Date', 'Publish_Live_Date', 'Publish Live Date'),
                new FilterColumn($this->dataset, 'Event_Title', 'Event_Title', 'Event Title'),
                new FilterColumn($this->dataset, 'SEO_Title', 'SEO_Title', 'SEO Title'),
                new FilterColumn($this->dataset, 'Est_Opportunity_value_in_Euros', 'Est_Opportunity_value_in_Euros', 'Est Opportunity Value In Euros')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['campaign_event_id'])
                ->addColumn($columns['master_campaign_id'])
                ->addColumn($columns['Event_Name'])
                ->addColumn($columns['eRegion'])
                ->addColumn($columns['Country'])
                ->addColumn($columns['Website'])
                ->addColumn($columns['Venue'])
                ->addColumn($columns['City'])
                ->addColumn($columns['Event_status'])
                ->addColumn($columns['Event_Type'])
                ->addColumn($columns['Business_Responsible'])
                ->addColumn($columns['Owner_Person'])
                ->addColumn($columns['Brands_Attending'])
                ->addColumn($columns['Start_Date'])
                ->addColumn($columns['End_Date'])
                ->addColumn($columns['Objective'])
                ->addColumn($columns['Expected_ROI_OTS'])
                ->addColumn($columns['Expected_ROI_Enquiries'])
                ->addColumn($columns['Post_Enquiries'])
                ->addColumn($columns['New_Opportunities'])
                ->addColumn($columns['Industry'])
                ->addColumn($columns['Strategic_Campaign'])
                ->addColumn($columns['Short_Description'])
                ->addColumn($columns['Event_Cost'])
                ->addColumn($columns['Planned_Booth_Area'])
                ->addColumn($columns['Created_by'])
                ->addColumn($columns['Created_Date'])
                ->addColumn($columns['Updated_by'])
                ->addColumn($columns['Updated_Date'])
                ->addColumn($columns['Marketo_Campaign'])
                ->addColumn($columns['Banner'])
                ->addColumn($columns['Approval'])
                ->addColumn($columns['Publish_Live'])
                ->addColumn($columns['Publish_Live_Date'])
                ->addColumn($columns['Event_Title'])
                ->addColumn($columns['SEO_Title'])
                ->addColumn($columns['Est_Opportunity_value_in_Euros']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('master_campaign_id')
                ->setOptionsFor('eRegion')
                ->setOptionsFor('Country')
                ->setOptionsFor('Event_Type')
                ->setOptionsFor('Owner_Person')
                ->setOptionsFor('Start_Date')
                ->setOptionsFor('End_Date')
                ->setOptionsFor('Created_Date');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('campaign_event_id_edit');
            
            $filterBuilder->addColumn(
                $columns['campaign_event_id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_events_master_campaign_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('master_campaign_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_events_master_campaign_id_search');
            
            $filterBuilder->addColumn(
                $columns['master_campaign_id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('event_name_edit');
            
            $filterBuilder->addColumn(
                $columns['Event_Name'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('eregion_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_events_eRegion_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('eRegion', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_events_eRegion_search');
            
            $text_editor = new TextEdit('eRegion');
            
            $filterBuilder->addColumn(
                $columns['eRegion'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('country_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_events_Country_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Country', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_events_Country_search');
            
            $text_editor = new TextEdit('Country');
            
            $filterBuilder->addColumn(
                $columns['Country'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('website_edit');
            $main_editor->SetPlaceholder('http://');
            
            $filterBuilder->addColumn(
                $columns['Website'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('venue_edit');
            
            $filterBuilder->addColumn(
                $columns['Venue'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('city_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['City'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('event_status_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_events_Event_status_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Event_status', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_events_Event_status_search');
            
            $text_editor = new TextEdit('Event_status');
            
            $filterBuilder->addColumn(
                $columns['Event_status'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('event_type_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_events_Event_Type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Event_Type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_events_Event_Type_search');
            
            $text_editor = new TextEdit('Event_Type');
            
            $filterBuilder->addColumn(
                $columns['Event_Type'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('business_responsible_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_events_Business_Responsible_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Business_Responsible', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_events_Business_Responsible_search');
            
            $text_editor = new TextEdit('Business_Responsible');
            
            $filterBuilder->addColumn(
                $columns['Business_Responsible'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('owner_person_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_events_Owner_Person_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Owner_Person', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_events_Owner_Person_search');
            
            $text_editor = new TextEdit('Owner_Person');
            
            $filterBuilder->addColumn(
                $columns['Owner_Person'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('brands_attending_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_events_Brands_Attending_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Brands_Attending', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_events_Brands_Attending_search');
            
            $text_editor = new TextEdit('Brands_Attending');
            
            $filterBuilder->addColumn(
                $columns['Brands_Attending'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('start_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Start_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('end_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['End_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Objective');
            
            $filterBuilder->addColumn(
                $columns['Objective'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('expected_roi_ots_edit');
            $main_editor->SetPrefix('Qty ');
            
            $filterBuilder->addColumn(
                $columns['Expected_ROI_OTS'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('expected_roi_enquiries_edit');
            $main_editor->SetPrefix('Qty');
            $main_editor->SetMaxLength(10);
            
            $filterBuilder->addColumn(
                $columns['Expected_ROI_Enquiries'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('post_enquiries_edit');
            $main_editor->SetPrefix('Qty');
            $main_editor->SetMaxLength(10);
            
            $filterBuilder->addColumn(
                $columns['Post_Enquiries'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('new_opportunities_edit');
            $main_editor->SetPrefix('Qty');
            $main_editor->SetMaxLength(10);
            
            $filterBuilder->addColumn(
                $columns['New_Opportunities'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $main_editor->SetHandlerName('filter_builder_Industry_Industry_ID_Industry_Name_search');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('Industry');
            
            $filterBuilder->addColumn(
                $columns['Industry'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Strategic_Campaign');
            
            $filterBuilder->addColumn(
                $columns['Strategic_Campaign'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Short_Description');
            
            $filterBuilder->addColumn(
                $columns['Short_Description'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('event_cost_edit');
            $main_editor->SetPrefix('EURO');
            
            $filterBuilder->addColumn(
                $columns['Event_Cost'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('planned_booth_area_edit');
            $main_editor->SetSuffix('M2');
            
            $filterBuilder->addColumn(
                $columns['Planned_Booth_Area'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('created_by_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Created_by'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['Created_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('updated_by_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Updated_by'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('updated_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['Updated_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('marketo_campaign_edit');
            $main_editor->SetMaxLength(5);
            
            $filterBuilder->addColumn(
                $columns['Marketo_Campaign'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('banner_edit');
            
            $filterBuilder->addColumn(
                $columns['Banner'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('Approval');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['Approval'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('publish_live_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_events_Publish_Live_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Publish_Live', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_events_Publish_Live_search');
            
            $text_editor = new TextEdit('Publish_Live');
            
            $filterBuilder->addColumn(
                $columns['Publish_Live'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('publish_live_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Publish_Live_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('event_title_edit');
            
            $filterBuilder->addColumn(
                $columns['Event_Title'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('seo_title_edit');
            
            $filterBuilder->addColumn(
                $columns['SEO_Title'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('est_opportunity_value_in_euros_edit');
            $main_editor->SetPrefix('EURO');
            
            $filterBuilder->addColumn(
                $columns['Est_Opportunity_value_in_Euros'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new AjaxOperation(OPERATION_VIEW,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetModalGridViewHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('Event_Name', 'Event_Name', 'Event Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Event_Name_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('eRegion', 'eRegion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country', 'Country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('Event_Type', 'Event_Type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('Owner_Person', 'Owner_Person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Start_Date field
            //
            $column = new DateTimeViewColumn('Start_Date', 'Start_Date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for End_Date field
            //
            $column = new DateTimeViewColumn('End_Date', 'End_Date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Industry field
            //
            $column = new TextViewColumn('Industry', 'Industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Industry_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Event_Cost field
            //
            $column = new CurrencyViewColumn('Event_Cost', 'Event_Cost', 'Event Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Created_by field
            //
            $column = new TextViewColumn('Created_by', 'Created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Created_by_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Approval field
            //
            $column = new TextViewColumn('Approval', 'Approval', 'List on Website?', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Est_Opportunity_value_in_Euros field
            //
            $column = new CurrencyViewColumn('Est_Opportunity_value_in_Euros', 'Est_Opportunity_value_in_Euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('Event_Name', 'Event_Name', 'Event Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Event_Name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('eRegion', 'eRegion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country', 'Country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Website field
            //
            $column = new TextViewColumn('Website', 'Website', 'Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%Website%');
            $column->setTarget('');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Website_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Venue field
            //
            $column = new TextViewColumn('Venue', 'Venue', 'Venue', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Venue_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for City field
            //
            $column = new TextViewColumn('City', 'City', 'City', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('Event_status', 'Event_status_Status_Type', 'Event Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('Event_Type', 'Event_Type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Business_Responsible', 'Business_Responsible_Brand_Name', 'Business Responsible', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Business_Responsible_Brand_Name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('Owner_Person', 'Owner_Person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Brands_Attending', 'Brands_Attending_Brand_Name', 'Brands Attending', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Brands_Attending_Brand_Name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Start_Date field
            //
            $column = new DateTimeViewColumn('Start_Date', 'Start_Date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for End_Date field
            //
            $column = new DateTimeViewColumn('End_Date', 'End_Date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Objective field
            //
            $column = new TextViewColumn('Objective', 'Objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Objective_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Expected_ROI_OTS field
            //
            $column = new CurrencyViewColumn('Expected_ROI_OTS', 'Expected_ROI_OTS', 'Expected ROI OTS', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Expected_ROI_Enquiries field
            //
            $column = new TextViewColumn('Expected_ROI_Enquiries', 'Expected_ROI_Enquiries', 'Expected ROI Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Post_Enquiries field
            //
            $column = new TextViewColumn('Post_Enquiries', 'Post_Enquiries', 'Post Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for New_Opportunities field
            //
            $column = new TextViewColumn('New_Opportunities', 'New_Opportunities', 'New Opportunities', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Industry field
            //
            $column = new TextViewColumn('Industry', 'Industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Industry_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Strategic_Campaign field
            //
            $column = new TextViewColumn('Strategic_Campaign', 'Strategic_Campaign', 'Strategic Campaign', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Strategic_Campaign_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Short_Description field
            //
            $column = new TextViewColumn('Short_Description', 'Short_Description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Short_Description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Event_Cost field
            //
            $column = new CurrencyViewColumn('Event_Cost', 'Event_Cost', 'Event Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Planned_Booth_Area field
            //
            $column = new TextViewColumn('Planned_Booth_Area', 'Planned_Booth_Area', 'Planned Booth Area', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Planned_Booth_Area_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Created_by field
            //
            $column = new TextViewColumn('Created_by', 'Created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Created_by_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Updated_by field
            //
            $column = new TextViewColumn('Updated_by', 'Updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Updated_by_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Updated_Date field
            //
            $column = new DateTimeViewColumn('Updated_Date', 'Updated_Date', 'Updated Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Marketo_Campaign field
            //
            $column = new TextViewColumn('Marketo_Campaign', 'Marketo_Campaign', 'Marketo Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Banner field
            //
            $column = new TextViewColumn('Banner', 'Banner', 'Banner', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Approval field
            //
            $column = new TextViewColumn('Approval', 'Approval', 'List on Website?', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('Publish_Live', 'Publish_Live_Status_Type', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Publish_Live_Date field
            //
            $column = new DateTimeViewColumn('Publish_Live_Date', 'Publish_Live_Date', 'Publish Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Event_Title field
            //
            $column = new TextViewColumn('Event_Title', 'Event_Title', 'Event Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Event_Title_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SEO_Title field
            //
            $column = new TextViewColumn('SEO_Title', 'SEO_Title', 'SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_SEO_Title_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Est_Opportunity_value_in_Euros field
            //
            $column = new CurrencyViewColumn('Est_Opportunity_value_in_Euros', 'Est_Opportunity_value_in_Euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for master_campaign_id field
            //
            $editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Name', 'master_campaign_id', 'master_campaign_id_campaign_name', 'edit_campaign_events_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Event_Name field
            //
            $editor = new TextEdit('event_name_edit');
            $editColumn = new CustomEditColumn('Event Name', 'Event_Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for eRegion field
            //
            $editor = new DynamicCombobox('eregion_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Region', 'eRegion', 'eRegion_Region', 'edit_campaign_events_eRegion_search', $editor, $this->dataset, $lookupDataset, 'Region', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Country field
            //
            $editor = new DynamicCombobox('country_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'Country', 'Country_Country_Name', 'edit_campaign_events_Country_search', $editor, $this->dataset, $lookupDataset, 'Country_ID', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Website field
            //
            $editor = new TextEdit('website_edit');
            $editor->SetPlaceholder('http://');
            $editColumn = new CustomEditColumn('Website', 'Website', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Venue field
            //
            $editor = new TextEdit('venue_edit');
            $editColumn = new CustomEditColumn('Venue', 'Venue', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for City field
            //
            $editor = new TextEdit('city_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('City', 'City', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Event_status field
            //
            $editor = new DynamicCombobox('event_status_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT `Status_Type_ID`, `Status_Type`, `Status_Type_Value`, `Status_Filters` 
            FROM `lookup_status_types` 
            WHERE `Status_Filters` = \'brief\'';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_status_types_planning');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $editColumn = new DynamicLookupEditColumn('Event Status', 'Event_status', 'Event_status_Status_Type', 'edit_campaign_events_Event_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Event_Type field
            //
            $editor = new DynamicCombobox('event_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'Event_Type', 'Event_Type_Event_Type', 'edit_campaign_events_Event_Type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Business_Responsible field
            //
            $editor = new DynamicCombobox('business_responsible_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Business Responsible', 'Business_Responsible', 'Business_Responsible_Brand_Name', 'edit_campaign_events_Business_Responsible_search', $editor, $this->dataset, $lookupDataset, 'Brands_ID', 'Brand_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Owner_Person field
            //
            $editor = new DynamicCombobox('owner_person_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Project Owner', 'Owner_Person', 'Owner_Person_user_name', 'edit_campaign_events_Owner_Person_search', $editor, $this->dataset, $lookupDataset, 'user_id', 'user_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Brands_Attending field
            //
            $editor = new DynamicCombobox('brands_attending_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brands Attending', 'Brands_Attending', 'Brands_Attending_Brand_Name', 'edit_campaign_events_Brands_Attending_search', $editor, $this->dataset, $lookupDataset, 'Brands_ID', 'Brand_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Start_Date field
            //
            $editor = new DateTimeEdit('start_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Start Date', 'Start_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for End_Date field
            //
            $editor = new DateTimeEdit('end_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('End Date', 'End_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Objective field
            //
            $editor = new TextAreaEdit('objective_edit', 50, 4);
            $editColumn = new CustomEditColumn('Objective', 'Objective', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Expected_ROI_OTS field
            //
            $editor = new TextEdit('expected_roi_ots_edit');
            $editor->SetPrefix('Qty ');
            $editColumn = new CustomEditColumn('Expected ROI OTS', 'Expected_ROI_OTS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Expected_ROI_Enquiries field
            //
            $editor = new TextEdit('expected_roi_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Expected ROI Enquiries', 'Expected_ROI_Enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Post_Enquiries field
            //
            $editor = new TextEdit('post_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Post Enquiries', 'Post_Enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for New_Opportunities field
            //
            $editor = new TextEdit('new_opportunities_edit');
            $editor->SetPrefix('Qty');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('New Opportunities', 'New_Opportunities', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Industry field
            //
            $editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('edit_Industry_Industry_ID_Industry_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Industry', 'Industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Strategic_Campaign field
            //
            $editor = new TextAreaEdit('strategic_campaign_edit', 50, 3);
            $editColumn = new CustomEditColumn('Strategic Campaign', 'Strategic_Campaign', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Short_Description field
            //
            $editor = new TextAreaEdit('short_description_edit', 50, 8);
            $editor->setPlaceholder('Please enter your summary here of what you want to display on the website.');
            $editColumn = new CustomEditColumn('Short Description', 'Short_Description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Event_Cost field
            //
            $editor = new TextEdit('event_cost_edit');
            $editor->SetPrefix('EURO');
            $editColumn = new CustomEditColumn('Event Cost', 'Event_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Planned_Booth_Area field
            //
            $editor = new TextEdit('planned_booth_area_edit');
            $editor->SetSuffix('M2');
            $editColumn = new CustomEditColumn('Planned Booth Area', 'Planned_Booth_Area', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Created By', 'Created_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Created_Date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'Created_Date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Updated_by field
            //
            $editor = new TextEdit('updated_by_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Updated By', 'Updated_by', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Updated_Date field
            //
            $editor = new DateTimeEdit('updated_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Updated Date', 'Updated_Date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Marketo_Campaign field
            //
            $editor = new TextEdit('marketo_campaign_edit');
            $editor->SetMaxLength(5);
            $editColumn = new CustomEditColumn('Marketo Campaign', 'Marketo_Campaign', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Banner field
            //
            $editor = new TextEdit('banner_edit');
            $editColumn = new CustomEditColumn('Banner', 'Banner', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Approval field
            //
            $editor = new CheckBox('approval_edit');
            $editColumn = new CustomEditColumn('List on Website?', 'Approval', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Publish_Live field
            //
            $editor = new DynamicCombobox('publish_live_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="website_listing"'));
            $editColumn = new DynamicLookupEditColumn('Publish Live', 'Publish_Live', 'Publish_Live_Status_Type', 'edit_campaign_events_Publish_Live_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Publish_Live_Date field
            //
            $editor = new DateTimeEdit('publish_live_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Publish Live Date', 'Publish_Live_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Event_Title field
            //
            $editor = new TextEdit('event_title_edit');
            $editColumn = new CustomEditColumn('Event Title', 'Event_Title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for SEO_Title field
            //
            $editor = new TextEdit('seo_title_edit');
            $editColumn = new CustomEditColumn('SEO Title', 'SEO_Title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Est_Opportunity_value_in_Euros field
            //
            $editor = new TextEdit('est_opportunity_value_in_euros_edit');
            $editor->SetPrefix('EURO');
            $editColumn = new CustomEditColumn('Est Opportunity Value In Euros', 'Est_Opportunity_value_in_Euros', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for master_campaign_id field
            //
            $editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Name', 'master_campaign_id', 'master_campaign_id_campaign_name', 'multi_edit_campaign_events_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Event_Name field
            //
            $editor = new TextEdit('event_name_edit');
            $editColumn = new CustomEditColumn('Event Name', 'Event_Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for eRegion field
            //
            $editor = new DynamicCombobox('eregion_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Region', 'eRegion', 'eRegion_Region', 'multi_edit_campaign_events_eRegion_search', $editor, $this->dataset, $lookupDataset, 'Region', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Country field
            //
            $editor = new DynamicCombobox('country_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'Country', 'Country_Country_Name', 'multi_edit_campaign_events_Country_search', $editor, $this->dataset, $lookupDataset, 'Country_ID', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Website field
            //
            $editor = new TextEdit('website_edit');
            $editor->SetPlaceholder('http://');
            $editColumn = new CustomEditColumn('Website', 'Website', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Venue field
            //
            $editor = new TextEdit('venue_edit');
            $editColumn = new CustomEditColumn('Venue', 'Venue', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for City field
            //
            $editor = new TextEdit('city_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('City', 'City', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Event_status field
            //
            $editor = new DynamicCombobox('event_status_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT `Status_Type_ID`, `Status_Type`, `Status_Type_Value`, `Status_Filters` 
            FROM `lookup_status_types` 
            WHERE `Status_Filters` = \'brief\'';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_status_types_planning');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $editColumn = new DynamicLookupEditColumn('Event Status', 'Event_status', 'Event_status_Status_Type', 'multi_edit_campaign_events_Event_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Event_Type field
            //
            $editor = new DynamicCombobox('event_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'Event_Type', 'Event_Type_Event_Type', 'multi_edit_campaign_events_Event_Type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Business_Responsible field
            //
            $editor = new DynamicCombobox('business_responsible_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Business Responsible', 'Business_Responsible', 'Business_Responsible_Brand_Name', 'multi_edit_campaign_events_Business_Responsible_search', $editor, $this->dataset, $lookupDataset, 'Brands_ID', 'Brand_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Owner_Person field
            //
            $editor = new DynamicCombobox('owner_person_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Project Owner', 'Owner_Person', 'Owner_Person_user_name', 'multi_edit_campaign_events_Owner_Person_search', $editor, $this->dataset, $lookupDataset, 'user_id', 'user_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Brands_Attending field
            //
            $editor = new DynamicCombobox('brands_attending_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brands Attending', 'Brands_Attending', 'Brands_Attending_Brand_Name', 'multi_edit_campaign_events_Brands_Attending_search', $editor, $this->dataset, $lookupDataset, 'Brands_ID', 'Brand_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Start_Date field
            //
            $editor = new DateTimeEdit('start_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Start Date', 'Start_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for End_Date field
            //
            $editor = new DateTimeEdit('end_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('End Date', 'End_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Objective field
            //
            $editor = new TextAreaEdit('objective_edit', 50, 4);
            $editColumn = new CustomEditColumn('Objective', 'Objective', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Expected_ROI_OTS field
            //
            $editor = new TextEdit('expected_roi_ots_edit');
            $editor->SetPrefix('Qty ');
            $editColumn = new CustomEditColumn('Expected ROI OTS', 'Expected_ROI_OTS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Expected_ROI_Enquiries field
            //
            $editor = new TextEdit('expected_roi_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Expected ROI Enquiries', 'Expected_ROI_Enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Post_Enquiries field
            //
            $editor = new TextEdit('post_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Post Enquiries', 'Post_Enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for New_Opportunities field
            //
            $editor = new TextEdit('new_opportunities_edit');
            $editor->SetPrefix('Qty');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('New Opportunities', 'New_Opportunities', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Industry field
            //
            $editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('multi_edit_Industry_Industry_ID_Industry_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Industry', 'Industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Strategic_Campaign field
            //
            $editor = new TextAreaEdit('strategic_campaign_edit', 50, 3);
            $editColumn = new CustomEditColumn('Strategic Campaign', 'Strategic_Campaign', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Short_Description field
            //
            $editor = new TextAreaEdit('short_description_edit', 50, 8);
            $editor->setPlaceholder('Please enter your summary here of what you want to display on the website.');
            $editColumn = new CustomEditColumn('Short Description', 'Short_Description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Event_Cost field
            //
            $editor = new TextEdit('event_cost_edit');
            $editor->SetPrefix('EURO');
            $editColumn = new CustomEditColumn('Event Cost', 'Event_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Planned_Booth_Area field
            //
            $editor = new TextEdit('planned_booth_area_edit');
            $editor->SetSuffix('M2');
            $editColumn = new CustomEditColumn('Planned Booth Area', 'Planned_Booth_Area', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Created By', 'Created_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Created_Date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'Created_Date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Updated_by field
            //
            $editor = new TextEdit('updated_by_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Updated By', 'Updated_by', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Updated_Date field
            //
            $editor = new DateTimeEdit('updated_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Updated Date', 'Updated_Date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Marketo_Campaign field
            //
            $editor = new TextEdit('marketo_campaign_edit');
            $editor->SetMaxLength(5);
            $editColumn = new CustomEditColumn('Marketo Campaign', 'Marketo_Campaign', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Banner field
            //
            $editor = new TextEdit('banner_edit');
            $editColumn = new CustomEditColumn('Banner', 'Banner', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Approval field
            //
            $editor = new CheckBox('approval_edit');
            $editColumn = new CustomEditColumn('List on Website?', 'Approval', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Publish_Live field
            //
            $editor = new DynamicCombobox('publish_live_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="website_listing"'));
            $editColumn = new DynamicLookupEditColumn('Publish Live', 'Publish_Live', 'Publish_Live_Status_Type', 'multi_edit_campaign_events_Publish_Live_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Publish_Live_Date field
            //
            $editor = new DateTimeEdit('publish_live_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Publish Live Date', 'Publish_Live_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Event_Title field
            //
            $editor = new TextEdit('event_title_edit');
            $editColumn = new CustomEditColumn('Event Title', 'Event_Title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for SEO_Title field
            //
            $editor = new TextEdit('seo_title_edit');
            $editColumn = new CustomEditColumn('SEO Title', 'SEO_Title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Est_Opportunity_value_in_Euros field
            //
            $editor = new TextEdit('est_opportunity_value_in_euros_edit');
            $editor->SetPrefix('EURO');
            $editColumn = new CustomEditColumn('Est Opportunity Value In Euros', 'Est_Opportunity_value_in_Euros', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for master_campaign_id field
            //
            $editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Name', 'master_campaign_id', 'master_campaign_id_campaign_name', 'insert_campaign_events_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Event_Name field
            //
            $editor = new TextEdit('event_name_edit');
            $editColumn = new CustomEditColumn('Event Name', 'Event_Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for eRegion field
            //
            $editor = new DynamicCombobox('eregion_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Region', 'eRegion', 'eRegion_Region', 'insert_campaign_events_eRegion_search', $editor, $this->dataset, $lookupDataset, 'Region', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Country field
            //
            $editor = new DynamicCombobox('country_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'Country', 'Country_Country_Name', 'insert_campaign_events_Country_search', $editor, $this->dataset, $lookupDataset, 'Country_ID', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Website field
            //
            $editor = new TextEdit('website_edit');
            $editor->SetPlaceholder('http://');
            $editColumn = new CustomEditColumn('Website', 'Website', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Venue field
            //
            $editor = new TextEdit('venue_edit');
            $editColumn = new CustomEditColumn('Venue', 'Venue', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for City field
            //
            $editor = new TextEdit('city_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('City', 'City', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Event_status field
            //
            $editor = new DynamicCombobox('event_status_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT `Status_Type_ID`, `Status_Type`, `Status_Type_Value`, `Status_Filters` 
            FROM `lookup_status_types` 
            WHERE `Status_Filters` = \'brief\'';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_status_types_planning');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $editColumn = new DynamicLookupEditColumn('Event Status', 'Event_status', 'Event_status_Status_Type', 'insert_campaign_events_Event_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Event_Type field
            //
            $editor = new DynamicCombobox('event_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'Event_Type', 'Event_Type_Event_Type', 'insert_campaign_events_Event_Type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Business_Responsible field
            //
            $editor = new DynamicCombobox('business_responsible_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Business Responsible', 'Business_Responsible', 'Business_Responsible_Brand_Name', 'insert_campaign_events_Business_Responsible_search', $editor, $this->dataset, $lookupDataset, 'Brands_ID', 'Brand_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Owner_Person field
            //
            $editor = new DynamicCombobox('owner_person_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Project Owner', 'Owner_Person', 'Owner_Person_user_name', 'insert_campaign_events_Owner_Person_search', $editor, $this->dataset, $lookupDataset, 'user_id', 'user_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Brands_Attending field
            //
            $editor = new DynamicCombobox('brands_attending_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brands Attending', 'Brands_Attending', 'Brands_Attending_Brand_Name', 'insert_campaign_events_Brands_Attending_search', $editor, $this->dataset, $lookupDataset, 'Brands_ID', 'Brand_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Start_Date field
            //
            $editor = new DateTimeEdit('start_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Start Date', 'Start_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for End_Date field
            //
            $editor = new DateTimeEdit('end_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('End Date', 'End_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Objective field
            //
            $editor = new TextAreaEdit('objective_edit', 50, 4);
            $editColumn = new CustomEditColumn('Objective', 'Objective', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Expected_ROI_OTS field
            //
            $editor = new TextEdit('expected_roi_ots_edit');
            $editor->SetPrefix('Qty ');
            $editColumn = new CustomEditColumn('Expected ROI OTS', 'Expected_ROI_OTS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Expected_ROI_Enquiries field
            //
            $editor = new TextEdit('expected_roi_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Expected ROI Enquiries', 'Expected_ROI_Enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('0');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Post_Enquiries field
            //
            $editor = new TextEdit('post_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Post Enquiries', 'Post_Enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('0');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for New_Opportunities field
            //
            $editor = new TextEdit('new_opportunities_edit');
            $editor->SetPrefix('Qty');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('New Opportunities', 'New_Opportunities', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('0');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Industry field
            //
            $editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('insert_Industry_Industry_ID_Industry_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Industry', 'Industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Strategic_Campaign field
            //
            $editor = new TextAreaEdit('strategic_campaign_edit', 50, 3);
            $editColumn = new CustomEditColumn('Strategic Campaign', 'Strategic_Campaign', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Short_Description field
            //
            $editor = new TextAreaEdit('short_description_edit', 50, 8);
            $editor->setPlaceholder('Please enter your summary here of what you want to display on the website.');
            $editColumn = new CustomEditColumn('Short Description', 'Short_Description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Event_Cost field
            //
            $editor = new TextEdit('event_cost_edit');
            $editor->SetPrefix('EURO');
            $editColumn = new CustomEditColumn('Event Cost', 'Event_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('€ 0.00');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Planned_Booth_Area field
            //
            $editor = new TextEdit('planned_booth_area_edit');
            $editor->SetSuffix('M2');
            $editColumn = new CustomEditColumn('Planned Booth Area', 'Planned_Booth_Area', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Created By', 'Created_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_NAME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Created_Date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'Created_Date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATETIME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Updated_by field
            //
            $editor = new TextEdit('updated_by_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Updated By', 'Updated_by', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_NAME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Updated_Date field
            //
            $editor = new DateTimeEdit('updated_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Updated Date', 'Updated_Date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATETIME%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Marketo_Campaign field
            //
            $editor = new TextEdit('marketo_campaign_edit');
            $editor->SetMaxLength(5);
            $editColumn = new CustomEditColumn('Marketo Campaign', 'Marketo_Campaign', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Banner field
            //
            $editor = new TextEdit('banner_edit');
            $editColumn = new CustomEditColumn('Banner', 'Banner', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Approval field
            //
            $editor = new CheckBox('approval_edit');
            $editColumn = new CustomEditColumn('List on Website?', 'Approval', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('0');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Publish_Live field
            //
            $editor = new DynamicCombobox('publish_live_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="website_listing"'));
            $editColumn = new DynamicLookupEditColumn('Publish Live', 'Publish_Live', 'Publish_Live_Status_Type', 'insert_campaign_events_Publish_Live_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Publish_Live_Date field
            //
            $editor = new DateTimeEdit('publish_live_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Publish Live Date', 'Publish_Live_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Event_Title field
            //
            $editor = new TextEdit('event_title_edit');
            $editColumn = new CustomEditColumn('Event Title', 'Event_Title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for SEO_Title field
            //
            $editor = new TextEdit('seo_title_edit');
            $editColumn = new CustomEditColumn('SEO Title', 'SEO_Title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Est_Opportunity_value_in_Euros field
            //
            $editor = new TextEdit('est_opportunity_value_in_euros_edit');
            $editor->SetPrefix('EURO');
            $editColumn = new CustomEditColumn('Est Opportunity Value In Euros', 'Est_Opportunity_value_in_Euros', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('€ 0.00');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for campaign_event_id field
            //
            $column = new NumberViewColumn('campaign_event_id', 'campaign_event_id', 'Campaign Event Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('Event_Name', 'Event_Name', 'Event Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Event_Name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('eRegion', 'eRegion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country', 'Country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Website field
            //
            $column = new TextViewColumn('Website', 'Website', 'Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%Website%');
            $column->setTarget('');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Website_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Venue field
            //
            $column = new TextViewColumn('Venue', 'Venue', 'Venue', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Venue_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for City field
            //
            $column = new TextViewColumn('City', 'City', 'City', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('Event_status', 'Event_status_Status_Type', 'Event Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('Event_Type', 'Event_Type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Business_Responsible', 'Business_Responsible_Brand_Name', 'Business Responsible', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Business_Responsible_Brand_Name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('Owner_Person', 'Owner_Person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Brands_Attending', 'Brands_Attending_Brand_Name', 'Brands Attending', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Brands_Attending_Brand_Name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Start_Date field
            //
            $column = new DateTimeViewColumn('Start_Date', 'Start_Date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for End_Date field
            //
            $column = new DateTimeViewColumn('End_Date', 'End_Date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Objective field
            //
            $column = new TextViewColumn('Objective', 'Objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Objective_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Expected_ROI_OTS field
            //
            $column = new CurrencyViewColumn('Expected_ROI_OTS', 'Expected_ROI_OTS', 'Expected ROI OTS', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Expected_ROI_Enquiries field
            //
            $column = new TextViewColumn('Expected_ROI_Enquiries', 'Expected_ROI_Enquiries', 'Expected ROI Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Post_Enquiries field
            //
            $column = new TextViewColumn('Post_Enquiries', 'Post_Enquiries', 'Post Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for New_Opportunities field
            //
            $column = new TextViewColumn('New_Opportunities', 'New_Opportunities', 'New Opportunities', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Industry field
            //
            $column = new TextViewColumn('Industry', 'Industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Industry_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Strategic_Campaign field
            //
            $column = new TextViewColumn('Strategic_Campaign', 'Strategic_Campaign', 'Strategic Campaign', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Strategic_Campaign_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Short_Description field
            //
            $column = new TextViewColumn('Short_Description', 'Short_Description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Short_Description_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Event_Cost field
            //
            $column = new CurrencyViewColumn('Event_Cost', 'Event_Cost', 'Event Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Planned_Booth_Area field
            //
            $column = new TextViewColumn('Planned_Booth_Area', 'Planned_Booth_Area', 'Planned Booth Area', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Planned_Booth_Area_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Created_by field
            //
            $column = new TextViewColumn('Created_by', 'Created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Created_by_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Updated_by field
            //
            $column = new TextViewColumn('Updated_by', 'Updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Updated_by_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Updated_Date field
            //
            $column = new DateTimeViewColumn('Updated_Date', 'Updated_Date', 'Updated Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Marketo_Campaign field
            //
            $column = new TextViewColumn('Marketo_Campaign', 'Marketo_Campaign', 'Marketo Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Banner field
            //
            $column = new TextViewColumn('Banner', 'Banner', 'Banner', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Approval field
            //
            $column = new TextViewColumn('Approval', 'Approval', 'List on Website?', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('Publish_Live', 'Publish_Live_Status_Type', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Publish_Live_Date field
            //
            $column = new DateTimeViewColumn('Publish_Live_Date', 'Publish_Live_Date', 'Publish Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Event_Title field
            //
            $column = new TextViewColumn('Event_Title', 'Event_Title', 'Event Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Event_Title_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for SEO_Title field
            //
            $column = new TextViewColumn('SEO_Title', 'SEO_Title', 'SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_SEO_Title_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Est_Opportunity_value_in_Euros field
            //
            $column = new CurrencyViewColumn('Est_Opportunity_value_in_Euros', 'Est_Opportunity_value_in_Euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for campaign_event_id field
            //
            $column = new NumberViewColumn('campaign_event_id', 'campaign_event_id', 'Campaign Event Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('Event_Name', 'Event_Name', 'Event Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Event_Name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('eRegion', 'eRegion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country', 'Country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Website field
            //
            $column = new TextViewColumn('Website', 'Website', 'Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%Website%');
            $column->setTarget('');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Website_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Venue field
            //
            $column = new TextViewColumn('Venue', 'Venue', 'Venue', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Venue_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for City field
            //
            $column = new TextViewColumn('City', 'City', 'City', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('Event_status', 'Event_status_Status_Type', 'Event Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('Event_Type', 'Event_Type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Business_Responsible', 'Business_Responsible_Brand_Name', 'Business Responsible', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Business_Responsible_Brand_Name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('Owner_Person', 'Owner_Person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Brands_Attending', 'Brands_Attending_Brand_Name', 'Brands Attending', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Brands_Attending_Brand_Name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Start_Date field
            //
            $column = new DateTimeViewColumn('Start_Date', 'Start_Date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for End_Date field
            //
            $column = new DateTimeViewColumn('End_Date', 'End_Date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Objective field
            //
            $column = new TextViewColumn('Objective', 'Objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Objective_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Expected_ROI_OTS field
            //
            $column = new CurrencyViewColumn('Expected_ROI_OTS', 'Expected_ROI_OTS', 'Expected ROI OTS', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddExportColumn($column);
            
            //
            // View column for Expected_ROI_Enquiries field
            //
            $column = new TextViewColumn('Expected_ROI_Enquiries', 'Expected_ROI_Enquiries', 'Expected ROI Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Post_Enquiries field
            //
            $column = new TextViewColumn('Post_Enquiries', 'Post_Enquiries', 'Post Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for New_Opportunities field
            //
            $column = new TextViewColumn('New_Opportunities', 'New_Opportunities', 'New Opportunities', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Industry field
            //
            $column = new TextViewColumn('Industry', 'Industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Industry_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Strategic_Campaign field
            //
            $column = new TextViewColumn('Strategic_Campaign', 'Strategic_Campaign', 'Strategic Campaign', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Strategic_Campaign_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Short_Description field
            //
            $column = new TextViewColumn('Short_Description', 'Short_Description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Short_Description_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Event_Cost field
            //
            $column = new CurrencyViewColumn('Event_Cost', 'Event_Cost', 'Event Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddExportColumn($column);
            
            //
            // View column for Planned_Booth_Area field
            //
            $column = new TextViewColumn('Planned_Booth_Area', 'Planned_Booth_Area', 'Planned Booth Area', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Planned_Booth_Area_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Created_by field
            //
            $column = new TextViewColumn('Created_by', 'Created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Created_by_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for Updated_by field
            //
            $column = new TextViewColumn('Updated_by', 'Updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Updated_by_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Updated_Date field
            //
            $column = new DateTimeViewColumn('Updated_Date', 'Updated_Date', 'Updated Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for Marketo_Campaign field
            //
            $column = new TextViewColumn('Marketo_Campaign', 'Marketo_Campaign', 'Marketo Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Banner field
            //
            $column = new TextViewColumn('Banner', 'Banner', 'Banner', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Approval field
            //
            $column = new TextViewColumn('Approval', 'Approval', 'List on Website?', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('Publish_Live', 'Publish_Live_Status_Type', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Publish_Live_Date field
            //
            $column = new DateTimeViewColumn('Publish_Live_Date', 'Publish_Live_Date', 'Publish Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Event_Title field
            //
            $column = new TextViewColumn('Event_Title', 'Event_Title', 'Event Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Event_Title_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for SEO_Title field
            //
            $column = new TextViewColumn('SEO_Title', 'SEO_Title', 'SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_SEO_Title_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Est_Opportunity_value_in_Euros field
            //
            $column = new CurrencyViewColumn('Est_Opportunity_value_in_Euros', 'Est_Opportunity_value_in_Euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('Event_Name', 'Event_Name', 'Event Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Event_Name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('eRegion', 'eRegion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country', 'Country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Website field
            //
            $column = new TextViewColumn('Website', 'Website', 'Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%Website%');
            $column->setTarget('');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Website_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Venue field
            //
            $column = new TextViewColumn('Venue', 'Venue', 'Venue', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Venue_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for City field
            //
            $column = new TextViewColumn('City', 'City', 'City', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('Event_status', 'Event_status_Status_Type', 'Event Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('Event_Type', 'Event_Type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Business_Responsible', 'Business_Responsible_Brand_Name', 'Business Responsible', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Business_Responsible_Brand_Name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('Owner_Person', 'Owner_Person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Brands_Attending', 'Brands_Attending_Brand_Name', 'Brands Attending', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Brands_Attending_Brand_Name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Start_Date field
            //
            $column = new DateTimeViewColumn('Start_Date', 'Start_Date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for End_Date field
            //
            $column = new DateTimeViewColumn('End_Date', 'End_Date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Objective field
            //
            $column = new TextViewColumn('Objective', 'Objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Objective_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Expected_ROI_OTS field
            //
            $column = new CurrencyViewColumn('Expected_ROI_OTS', 'Expected_ROI_OTS', 'Expected ROI OTS', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Expected_ROI_Enquiries field
            //
            $column = new TextViewColumn('Expected_ROI_Enquiries', 'Expected_ROI_Enquiries', 'Expected ROI Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Post_Enquiries field
            //
            $column = new TextViewColumn('Post_Enquiries', 'Post_Enquiries', 'Post Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for New_Opportunities field
            //
            $column = new TextViewColumn('New_Opportunities', 'New_Opportunities', 'New Opportunities', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Industry field
            //
            $column = new TextViewColumn('Industry', 'Industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Industry_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Strategic_Campaign field
            //
            $column = new TextViewColumn('Strategic_Campaign', 'Strategic_Campaign', 'Strategic Campaign', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Strategic_Campaign_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Short_Description field
            //
            $column = new TextViewColumn('Short_Description', 'Short_Description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Short_Description_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Event_Cost field
            //
            $column = new CurrencyViewColumn('Event_Cost', 'Event_Cost', 'Event Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Planned_Booth_Area field
            //
            $column = new TextViewColumn('Planned_Booth_Area', 'Planned_Booth_Area', 'Planned Booth Area', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Planned_Booth_Area_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Created_by field
            //
            $column = new TextViewColumn('Created_by', 'Created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Created_by_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Updated_by field
            //
            $column = new TextViewColumn('Updated_by', 'Updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Updated_by_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Updated_Date field
            //
            $column = new DateTimeViewColumn('Updated_Date', 'Updated_Date', 'Updated Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Marketo_Campaign field
            //
            $column = new TextViewColumn('Marketo_Campaign', 'Marketo_Campaign', 'Marketo Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Banner field
            //
            $column = new TextViewColumn('Banner', 'Banner', 'Banner', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Approval field
            //
            $column = new TextViewColumn('Approval', 'Approval', 'List on Website?', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('Publish_Live', 'Publish_Live_Status_Type', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Publish_Live_Date field
            //
            $column = new DateTimeViewColumn('Publish_Live_Date', 'Publish_Live_Date', 'Publish Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Event_Title field
            //
            $column = new TextViewColumn('Event_Title', 'Event_Title', 'Event Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_Event_Title_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for SEO_Title field
            //
            $column = new TextViewColumn('SEO_Title', 'SEO_Title', 'SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_events_SEO_Title_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Est_Opportunity_value_in_Euros field
            //
            $column = new CurrencyViewColumn('Est_Opportunity_value_in_Euros', 'Est_Opportunity_value_in_Euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('€');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function GetEnableModalSingleRecordView() { return true; }
        
        public function GetEnableModalGridEdit() { return true; }
        
        private $partitions = array(1 => array('\'Americas\''), 2 => array('\'EMEA\''), 3 => array('\'IndoPAC\''), 4 => array('\'Japan\''), 5 => array('\'Korea\''), 6 => array('\'China\''));
        
        function partition_GetPartitionsHandler(&$partitions)
        {
            $partitions[1] = 'America';
            $partitions[2] = 'EMEA';
            $partitions[3] = 'IndoPAC';
            $partitions[4] = 'Japan';
            $partitions[5] = 'Korea';
            $partitions[6] = 'China';
        }
        
        function partition_GetPartitionConditionHandler($partitionName, &$condition)
        {
            $condition = '';
            if (isset($partitionName) && isset($this->partitions[$partitionName]))
                foreach ($this->partitions[$partitionName] as $value)
                    AddStr($condition, sprintf('(eRegion = %s)', $this->PrepareTextForSQL($value)), ' OR ');
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(false);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setDescription('<div class="mark-media mark-position-relative">
               <div class="mark-bd-placeholder-img mr-3"><img src="http://localhost/mportal/apps/icons/event-color.png" width="80" height="79"></div>
               <div class="mark-media-body">
                   <h5 class="mt-0 h5">What will you find here</h5>
                   <p class="mark-p">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                   <a href="http://localhost/mportal/" class="stretched-link">Go to Dashboard</a>
               </div>
            </div>');
            $this->SetHidePageListByDefault(true);
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
            $grid->SetEditClientEditorValueChangedScript('if (sender.getFieldName() == \'channel_types\')
            {
              console.log(sender.getValue());
              editors[\'event_type\'].enabled(sender.getValue() == 1);
              if (sender.getValue() != 0) { 
                 editors[\'event_type\'].setValue();
                 editors[\'event_type\'].setVisible(true); 
                 $(\'#event_type_edit\').next().show();
              }
              else
              {
                 editors[\'event_type\'].setVisible(false);  
                $(\'#event_type_edit\').next().hide();  
              }
            }
            
            
            if (sender.getFieldName() == \'Approval\')
            {
              console.log(sender.getValue());
              editors[\'Event_Title\'].enabled(sender.getValue() == 1);
              if (sender.getValue() != 0) { 
                 editors[\'Event_Title\'].setValue();
                 editors[\'Event_Title\'].setVisible(true); 
                 $(\'#Event_Title_edit\').next().show();
              }
              else
              {
                 editors[\'Event_Title\'].setVisible(false);  
                $(\'#Event_Title_edit\').next().hide();  
              }
              editors[\'SEO_Title\'].enabled(sender.getValue() == 1);
              if (sender.getValue() != 0) { 
                 editors[\'SEO_Title\'].setValue();
                 editors[\'SEO_Title\'].setVisible(true); 
                 $(\'#SEO_Title_edit\').next().show();
              }
              else
              {
                 editors[\'SEO_Title\'].setVisible(false);  
                $(\'#SEO_Title_edit\').next().hide();  
              }
              editors[\'Short_Description\'].enabled(sender.getValue() == 1);
              if (sender.getValue() != 0) { 
                 editors[\'Short_Description\'].setValue();
                 editors[\'Short_Description\'].setVisible(true); 
                 $(\'#Short_Description_edit\').next().show();
              }
              else
              {
                 editors[\'Short_Description\'].setVisible(false);  
                $(\'#Short_Description_edit\').next().hide();  
              }
              editors[\'Website\'].enabled(sender.getValue() == 1);
              if (sender.getValue() != 0) { 
                 editors[\'Website\'].setValue();
                 editors[\'Website\'].setVisible(true); 
                 $(\'#Website_edit\').next().show();
              }
              else
              {
                 editors[\'Website\'].setVisible(false);  
                $(\'#Website_edit\').next().hide();  
              }
              editors[\'Publish_Live\'].enabled(sender.getValue() == 1);
              if (sender.getValue() != 0) { 
                 editors[\'Publish_Live\'].setValue(16);
                 editors[\'Publish_Live\'].setVisible(true); 
                 $(\'#Publish_Live_edit\').next().show();
              }
              else
              {
                 editors[\'Publish_Live\'].setVisible(false);  
                $(\'#Publish_Live_edit\').next().hide();  
              }
              editors[\'Publish_Live_Date\'].enabled(sender.getValue() == 1);
              if (sender.getValue() != 0) { 
                 editors[\'Publish_Live_Date\'].setValue();
                 editors[\'Publish_Live_Date\'].setVisible(true); 
                 $(\'#Publish_Live_Date_edit\').next().show();
              }
              else
              {
                 editors[\'Publish_Live_Date\'].setVisible(false);  
                $(\'#Publish_Live_Date_edit\').next().hide();  
              }
              editors[\'Banner\'].enabled(sender.getValue() == 1);
              if (sender.getValue() != 0) { 
                 editors[\'Banner\'].setValue();
                 editors[\'Banner\'].setVisible(true); 
                 $(\'#Banner_Date_edit\').next().show();
              }
              else
              {
                 editors[\'Banner\'].setVisible(false);  
                $(\'#Banner_edit\').next().hide();  
              }
            }');
            
            $grid->SetEditClientFormLoadedScript('if (editors[\'Approval\'].getValue() == \'\') {
            
                editors[\'Event_Title\'].setValue(\'\');
                editors[\'Event_Title\'].setVisible(false);  
                editors[\'SEO_Title\'].setValue(\'\');
                editors[\'SEO_Title\'].setVisible(false); 
                editors[\'Short_Description\'].setValue(\'\');
                editors[\'Short_Description\'].setVisible(false); 
                editors[\'Website\'].setValue(\'\');
                editors[\'Website\'].setVisible(false); 
                editors[\'Publish_Live\'].setValue(\'\');
                editors[\'Publish_Live\'].setVisible(false); 
                editors[\'Publish_Live_Date\'].setValue(\'\');
                editors[\'Publish_Live_Date\'].setVisible(false);
                editors[\'Publish_Live_Date\'].setValue(\'\');
                editors[\'Banner\'].setVisible(false);
            }
            
            else {
                editors[\'Event_Title\'].setVisible(true);
                editors[\'SEO_Title\'].setVisible(true);
                editors[\'Short_Description\'].setVisible(true);
                editors[\'Website\'].setVisible(true);
                editors[\'Publish_Live\'].setVisible(true);
                editors[\'Publish_Live_Date\'].setVisible(true);  
                editors[\'Banner\'].setVisible(true);
            }');
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('Event_Name', 'Event_Name', 'Event Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Event_Name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry field
            //
            $column = new TextViewColumn('Industry', 'Industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Industry_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Created_by field
            //
            $column = new TextViewColumn('Created_by', 'Created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Created_by_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('Event_Name', 'Event_Name', 'Event Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Event_Name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Website field
            //
            $column = new TextViewColumn('Website', 'Website', 'Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%Website%');
            $column->setTarget('');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Website_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Venue field
            //
            $column = new TextViewColumn('Venue', 'Venue', 'Venue', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Venue_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Business_Responsible', 'Business_Responsible_Brand_Name', 'Business Responsible', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Business_Responsible_Brand_Name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Brands_Attending', 'Brands_Attending_Brand_Name', 'Brands Attending', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Brands_Attending_Brand_Name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Objective field
            //
            $column = new TextViewColumn('Objective', 'Objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Objective_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry field
            //
            $column = new TextViewColumn('Industry', 'Industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Industry_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Strategic_Campaign field
            //
            $column = new TextViewColumn('Strategic_Campaign', 'Strategic_Campaign', 'Strategic Campaign', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Strategic_Campaign_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Short_Description field
            //
            $column = new TextViewColumn('Short_Description', 'Short_Description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Short_Description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Planned_Booth_Area field
            //
            $column = new TextViewColumn('Planned_Booth_Area', 'Planned_Booth_Area', 'Planned Booth Area', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Planned_Booth_Area_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Created_by field
            //
            $column = new TextViewColumn('Created_by', 'Created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Created_by_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Updated_by field
            //
            $column = new TextViewColumn('Updated_by', 'Updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Updated_by_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Event_Title field
            //
            $column = new TextViewColumn('Event_Title', 'Event_Title', 'Event Title', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Event_Title_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for SEO_Title field
            //
            $column = new TextViewColumn('SEO_Title', 'SEO_Title', 'SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_SEO_Title_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('Event_Name', 'Event_Name', 'Event Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Event_Name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Website field
            //
            $column = new TextViewColumn('Website', 'Website', 'Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%Website%');
            $column->setTarget('');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Website_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Venue field
            //
            $column = new TextViewColumn('Venue', 'Venue', 'Venue', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Venue_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Business_Responsible', 'Business_Responsible_Brand_Name', 'Business Responsible', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Business_Responsible_Brand_Name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Brands_Attending', 'Brands_Attending_Brand_Name', 'Brands Attending', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Brands_Attending_Brand_Name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Objective field
            //
            $column = new TextViewColumn('Objective', 'Objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Objective_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry field
            //
            $column = new TextViewColumn('Industry', 'Industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Industry_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Strategic_Campaign field
            //
            $column = new TextViewColumn('Strategic_Campaign', 'Strategic_Campaign', 'Strategic Campaign', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Strategic_Campaign_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Short_Description field
            //
            $column = new TextViewColumn('Short_Description', 'Short_Description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Short_Description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Planned_Booth_Area field
            //
            $column = new TextViewColumn('Planned_Booth_Area', 'Planned_Booth_Area', 'Planned Booth Area', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Planned_Booth_Area_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Created_by field
            //
            $column = new TextViewColumn('Created_by', 'Created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Created_by_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Updated_by field
            //
            $column = new TextViewColumn('Updated_by', 'Updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Updated_by_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Event_Title field
            //
            $column = new TextViewColumn('Event_Title', 'Event_Title', 'Event Title', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Event_Title_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for SEO_Title field
            //
            $column = new TextViewColumn('SEO_Title', 'SEO_Title', 'SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_SEO_Title_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_events_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_events_eRegion_search', 'Region', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_events_Country_search', 'Country_ID', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT `Status_Type_ID`, `Status_Type`, `Status_Type_Value`, `Status_Filters` 
            FROM `lookup_status_types` 
            WHERE `Status_Filters` = \'brief\'';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_status_types_planning');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_events_Event_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_events_Event_Type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_events_Business_Responsible_search', 'Brands_ID', 'Brand_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_events_Owner_Person_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_events_Brands_Attending_search', 'Brands_ID', 'Brand_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'insert_Industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="website_listing"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_events_Publish_Live_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_events_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_events_eRegion_search', 'Region', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_events_Country_search', 'Country_ID', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT `Status_Type_ID`, `Status_Type`, `Status_Type_Value`, `Status_Filters` 
            FROM `lookup_status_types` 
            WHERE `Status_Filters` = \'brief\'';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_status_types_planning');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_events_Event_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_events_Event_Type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_events_Business_Responsible_search', 'Brands_ID', 'Brand_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_events_Owner_Person_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_events_Brands_Attending_search', 'Brands_ID', 'Brand_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_Industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_Industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_Industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="website_listing"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_events_Publish_Live_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('Event_Name', 'Event_Name', 'Event Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Event_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Website field
            //
            $column = new TextViewColumn('Website', 'Website', 'Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%Website%');
            $column->setTarget('');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Website_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Venue field
            //
            $column = new TextViewColumn('Venue', 'Venue', 'Venue', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Venue_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Business_Responsible', 'Business_Responsible_Brand_Name', 'Business Responsible', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Business_Responsible_Brand_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Brand_Name field
            //
            $column = new TextViewColumn('Brands_Attending', 'Brands_Attending_Brand_Name', 'Brands Attending', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Brands_Attending_Brand_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Objective field
            //
            $column = new TextViewColumn('Objective', 'Objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Objective_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry field
            //
            $column = new TextViewColumn('Industry', 'Industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Industry_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Strategic_Campaign field
            //
            $column = new TextViewColumn('Strategic_Campaign', 'Strategic_Campaign', 'Strategic Campaign', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Strategic_Campaign_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Short_Description field
            //
            $column = new TextViewColumn('Short_Description', 'Short_Description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Short_Description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Planned_Booth_Area field
            //
            $column = new TextViewColumn('Planned_Booth_Area', 'Planned_Booth_Area', 'Planned Booth Area', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Planned_Booth_Area_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Created_by field
            //
            $column = new TextViewColumn('Created_by', 'Created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Created_by_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Updated_by field
            //
            $column = new TextViewColumn('Updated_by', 'Updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Updated_by_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Event_Title field
            //
            $column = new TextViewColumn('Event_Title', 'Event_Title', 'Event Title', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_Event_Title_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for SEO_Title field
            //
            $column = new TextViewColumn('SEO_Title', 'SEO_Title', 'SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_events_SEO_Title_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_events_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_events_eRegion_search', 'Region', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_events_Country_search', 'Country_ID', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT `Status_Type_ID`, `Status_Type`, `Status_Type_Value`, `Status_Filters` 
            FROM `lookup_status_types` 
            WHERE `Status_Filters` = \'brief\'';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_status_types_planning');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_events_Event_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_events_Event_Type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_events_Business_Responsible_search', 'Brands_ID', 'Brand_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_events_Owner_Person_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_events_Brands_Attending_search', 'Brands_ID', 'Brand_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'edit_Industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="website_listing"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_events_Publish_Live_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_events_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_events_eRegion_search', 'Region', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_events_Country_search', 'Country_ID', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT `Status_Type_ID`, `Status_Type`, `Status_Type_Value`, `Status_Filters` 
            FROM `lookup_status_types` 
            WHERE `Status_Filters` = \'brief\'';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_status_types_planning');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_events_Event_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_events_Event_Type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_events_Business_Responsible_search', 'Brands_ID', 'Brand_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_events_Owner_Person_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brands`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Brands_ID', true, true, true),
                    new StringField('Brand_Name', true)
                )
            );
            $lookupDataset->setOrderByField('Brand_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_events_Brands_Attending_search', 'Brands_ID', 'Brand_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'multi_edit_Industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="website_listing"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_events_Publish_Live_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
            $layout->setMode(FormLayoutMode::VERTICAL);
            
            $storageGroup = $layout->addGroup('Request Overview', 12);
            $storageGroup->addRow()
                ->addCol($columns['master_campaign_id'], 12);
            $storageGroup->addRow()
                ->addCol($columns['Objective'],12);
            $storageGroup->addRow()
                ->addCol($columns['Created_by'], 6)
                ->addCol($columns['Created_Date'], 6);
                                    
            $storageGroup = $layout->addGroup('Event Planning', 12);
            $storageGroup->addRow()
                ->addCol($columns['Event_Name'],12);
            $storageGroup->addRow()
                ->addCol($columns['Strategic_Campaign'],12);
            $storageGroup->addRow()
                ->addCol($columns['Event_Type'], 6)
                ->addCol($columns['Owner_Person'], 6);
            $storageGroup->addRow()
                ->addCol($columns['Marketo_Campaign'], 12);
            $storageGroup->addRow()
                ->addCol($columns['Venue'], 8)
                ->addCol($columns['Planned_Booth_Area'], 4);
            $storageGroup->addRow()
                ->addCol($columns['Business_Responsible'],12);
            $storageGroup->addRow()
                ->addCol($columns['Brands_Attending'],12);
            
            $storageGroup = $layout->addGroup('Target Audience', 12);
            $storageGroup->addRow()
                ->addCol($columns['Country'], 4)
                ->addCol($columns['City'], 4)
                ->addCol($columns['eRegion'], 4);
            $storageGroup->addRow()
                ->addCol($columns['Industry'], 12);
                                        
            $storageGroup = $layout->addGroup('Campaign Period', 12);
            $storageGroup->addRow()
                ->addCol($columns['Start_Date'], 6)
                ->addCol($columns['End_Date'], 6);
                                    
            $storageGroup = $layout->addGroup('This Event\'s Projections', 12);
            $storageGroup->addRow()
                ->addCol($columns['Event_Cost'], 4)
                ->addCol($columns['New_Opportunities'], 4)
                ->addCol($columns['Post_Enquiries'], 4);
            $storageGroup->addRow()
                ->addCol($columns['Est_Opportunity_value_in_Euros'], 12);
            $storageGroup->addRow()
                ->addCol($columns['Expected_ROI_Enquiries'], 6)
                ->addCol($columns['Expected_ROI_OTS'], 6); 
            
            $storageGroup = $layout->addGroup('Website Listing', 12);
            $storageGroup->addRow()
                ->addCol($columns['Approval'], 4)
                ->addCol($columns['Event_Title'],8);
            $storageGroup->addRow()
                ->addCol($columns['SEO_Title'],12);
            $storageGroup->addRow()
                ->addCol($columns['Short_Description'],12);
            $storageGroup->addRow()
                ->addCol($columns['Website'],12);
            $storageGroup->addRow()
                ->addCol($columns['Publish_Live'], 6)
                ->addCol($columns['Publish_Live_Date'], 6); 
            $storageGroup->addRow()
                ->addCol($columns['Banner'],12);
                
            
                                            
            $storageGroup = $layout->addGroup('Campaign Admin', 12);
            $storageGroup->addRow()
                 ->addCol($columns['Event_status'], 9);
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new campaign_eventsPage("campaign_events", "campaign_events.php", GetCurrentUserPermissionSetForDataSource("campaign_events"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("campaign_events"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
