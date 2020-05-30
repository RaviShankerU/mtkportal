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
    
    
    
    class campaign_program_name_generator_campaign_tracker_comms_localPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Campaign Tracker: Comms');
            $this->SetMenuLabel('Comms Tracker');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_comms_local`');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_tracker_local_id', true, true, true),
                    new StringField('trackerid'),
                    new IntegerField('program_generator_name_id'),
                    new IntegerField('master_campaign_id'),
                    new StringField('email_name'),
                    new StringField('campaign_type'),
                    new StringField('cregion'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new IntegerField('tracker_status'),
                    new IntegerField('campaign_utm_id'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('show_events_cal'),
                    new IntegerField('region_approval'),
                    new StringField('region_approved_by'),
                    new DateTimeField('region_approved_date'),
                    new StringField('created_by'),
                    new DateTimeField('created_date')
                )
            );
            $this->dataset->AddLookupField('program_generator_name_id', 'campaign_program_name_generator', new IntegerField('program_generator_name_id'), new StringField('campaign_program_name', false, false, false, false, 'program_generator_name_id_campaign_program_name', 'program_generator_name_id_campaign_program_name_campaign_program_name_generator'), 'program_generator_name_id_campaign_program_name_campaign_program_name_generator');
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
            $this->dataset->AddLookupField('campaign_type', 'lookup_campaign_type', new StringField('Type_Value'), new StringField('Type', false, false, false, false, 'campaign_type_Type', 'campaign_type_Type_lookup_campaign_type'), 'campaign_type_Type_lookup_campaign_type');
            $this->dataset->AddLookupField('tracker_status', 'lookup_status_types', new IntegerField('Status_Type_ID'), new StringField('Status_Type', false, false, false, false, 'tracker_status_Status_Type', 'tracker_status_Status_Type_lookup_status_types'), 'tracker_status_Status_Type_lookup_status_types');
            $this->dataset->AddLookupField('campaign_utm_id', '(SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL)', new IntegerField('campaign_utm_id'), new StringField('utm_created', false, false, false, false, 'campaign_utm_id_utm_created', 'campaign_utm_id_utm_created_lookup_utm_filtered'), 'campaign_utm_id_utm_created_lookup_utm_filtered');
            $this->dataset->AddLookupField('cregion', 'lookup_region', new StringField('Region_Value'), new StringField('Region', false, false, false, false, 'cregion_Region', 'cregion_Region_lookup_region'), 'cregion_Region_lookup_region');
            if (!$this->GetSecurityInfo()->HasAdminGrant()) {
                $this->dataset->setRlsPolicy(new RlsPolicy('created_by', GetApplication()->GetCurrentUserId()));
            }
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(10);
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
                new FilterColumn($this->dataset, 'campaign_tracker_local_id', 'campaign_tracker_local_id', 'Campaign Tracker Local Id'),
                new FilterColumn($this->dataset, 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Program Generator Name Id'),
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request'),
                new FilterColumn($this->dataset, 'campaign_type', 'campaign_type_Type', 'Campaign Type'),
                new FilterColumn($this->dataset, 'email_name', 'email_name', 'Email Name'),
                new FilterColumn($this->dataset, 'campaign_description', 'campaign_description', 'Campaign Description'),
                new FilterColumn($this->dataset, 'campaign_publish_date', 'campaign_publish_date', 'Send Date'),
                new FilterColumn($this->dataset, 'tracker_status', 'tracker_status_Status_Type', 'Send Status'),
                new FilterColumn($this->dataset, 'campaign_utm_id', 'campaign_utm_id_utm_created', 'UTM Tracking'),
                new FilterColumn($this->dataset, 'trackerid', 'trackerid', 'Trackerid'),
                new FilterColumn($this->dataset, 'cregion', 'cregion_Region', 'Region'),
                new FilterColumn($this->dataset, 'region_approval', 'region_approval', 'Region Approval'),
                new FilterColumn($this->dataset, 'region_approved_by', 'region_approved_by', 'Region Approved By'),
                new FilterColumn($this->dataset, 'region_approved_date', 'region_approved_date', 'Region Approved Date'),
                new FilterColumn($this->dataset, 'show_events_cal', 'show_events_cal', 'Show Events Cal'),
                new FilterColumn($this->dataset, 'created_by', 'created_by', 'Created By'),
                new FilterColumn($this->dataset, 'created_date', 'created_date', 'Created Date'),
                new FilterColumn($this->dataset, 'modified_by', 'modified_by', 'Modified By'),
                new FilterColumn($this->dataset, 'modified_date', 'modified_date', 'Modified Date')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['campaign_tracker_local_id'])
                ->addColumn($columns['program_generator_name_id'])
                ->addColumn($columns['master_campaign_id'])
                ->addColumn($columns['campaign_type'])
                ->addColumn($columns['email_name'])
                ->addColumn($columns['campaign_description'])
                ->addColumn($columns['campaign_publish_date'])
                ->addColumn($columns['tracker_status'])
                ->addColumn($columns['campaign_utm_id'])
                ->addColumn($columns['cregion'])
                ->addColumn($columns['show_events_cal'])
                ->addColumn($columns['modified_by'])
                ->addColumn($columns['modified_date']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('campaign_type')
                ->setOptionsFor('campaign_publish_date')
                ->setOptionsFor('tracker_status')
                ->setOptionsFor('cregion')
                ->setOptionsFor('modified_date');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('campaign_tracker_local_id_edit');
            
            $filterBuilder->addColumn(
                $columns['campaign_tracker_local_id'],
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
            
            $main_editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('program_generator_name_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_id_search');
            
            $filterBuilder->addColumn(
                $columns['program_generator_name_id'],
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
            
            $main_editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('master_campaign_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search');
            
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
            
            $main_editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_campaign_type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('campaign_type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_campaign_type_search');
            
            $filterBuilder->addColumn(
                $columns['campaign_type'],
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
            
            $main_editor = new TextEdit('email_name_edit');
            
            $filterBuilder->addColumn(
                $columns['email_name'],
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
            
            $main_editor = new TextEdit('campaign_description_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['campaign_description'],
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
            
            $main_editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['campaign_publish_date'],
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
            
            $main_editor = new DynamicCombobox('tracker_status_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_tracker_status_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('tracker_status', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_tracker_status_search');
            
            $filterBuilder->addColumn(
                $columns['tracker_status'],
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
            
            $main_editor = new DynamicCombobox('campaign_utm_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('campaign_utm_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search');
            
            $filterBuilder->addColumn(
                $columns['campaign_utm_id'],
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
            
            $main_editor = new DynamicCombobox('cregion_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_cregion_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('cregion', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_cregion_search');
            
            $text_editor = new TextEdit('cregion');
            
            $filterBuilder->addColumn(
                $columns['cregion'],
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
            
            $main_editor = new TextEdit('region_approval_edit');
            
            $filterBuilder->addColumn(
                $columns['region_approval'],
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
            
            $main_editor = new TextEdit('region_approved_by_edit');
            $main_editor->SetMaxLength(65);
            
            $filterBuilder->addColumn(
                $columns['region_approved_by'],
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
            
            $main_editor = new DateTimeEdit('region_approved_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['region_approved_date'],
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
            
            $main_editor = new ComboBox('show_events_cal');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['show_events_cal'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('modified_by_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['modified_by'],
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
            
            $main_editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['modified_date'],
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
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Send Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('tracker_status', 'tracker_status_Status_Type', 'Send Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Events Cal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Program Generator Name Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_idModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Send Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('tracker_status', 'tracker_status_Status_Type', 'Send Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for utm_created field
            //
            $column = new TextViewColumn('campaign_utm_id', 'campaign_utm_id_utm_created', 'UTM Tracking', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Events Cal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Program Generator Name Id', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'edit_campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brief Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'edit_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_type field
            //
            $editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Type', 'campaign_type', 'campaign_type_Type', 'edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_type_search', $editor, $this->dataset, $lookupDataset, 'Type_Value', 'Type', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for email_name field
            //
            $editor = new TextEdit('email_name_edit');
            $editColumn = new CustomEditColumn('Email Name', 'email_name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_description field
            //
            $editor = new TextEdit('campaign_description_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Campaign Description', 'campaign_description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Send Date', 'campaign_publish_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tracker_status field
            //
            $editor = new DynamicCombobox('tracker_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $editColumn = new DynamicLookupEditColumn('Send Status', 'tracker_status', 'tracker_status_Status_Type', 'edit_campaign_program_name_generator_campaign_tracker_comms_local_tracker_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_utm_id field
            //
            $editor = new DynamicCombobox('campaign_utm_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_utm_filtered');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new StringField('utm_created')
                )
            );
            $lookupDataset->setOrderByField('utm_created', 'ASC');
            $editColumn = new DynamicLookupEditColumn('UTM Tracking', 'campaign_utm_id', 'campaign_utm_id_utm_created', 'edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', $editor, $this->dataset, $lookupDataset, 'campaign_utm_id', 'utm_created', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cregion field
            //
            $editor = new DynamicCombobox('cregion_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'cregion', 'cregion_Region', '_campaign_program_name_generator_campaign_tracker_comms_local_cregion_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for show_events_cal field
            //
            $editor = new CheckBox('show_events_cal_edit');
            $editColumn = new CustomEditColumn('Show Events Cal', 'show_events_cal', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Program Generator Name Id', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brief Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_type field
            //
            $editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Type', 'campaign_type', 'campaign_type_Type', 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_type_search', $editor, $this->dataset, $lookupDataset, 'Type_Value', 'Type', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for email_name field
            //
            $editor = new TextEdit('email_name_edit');
            $editColumn = new CustomEditColumn('Email Name', 'email_name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_description field
            //
            $editor = new TextEdit('campaign_description_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Campaign Description', 'campaign_description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Send Date', 'campaign_publish_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tracker_status field
            //
            $editor = new DynamicCombobox('tracker_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $editColumn = new DynamicLookupEditColumn('Send Status', 'tracker_status', 'tracker_status_Status_Type', 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_tracker_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_utm_id field
            //
            $editor = new DynamicCombobox('campaign_utm_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_utm_filtered');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new StringField('utm_created')
                )
            );
            $lookupDataset->setOrderByField('utm_created', 'ASC');
            $editColumn = new DynamicLookupEditColumn('UTM Tracking', 'campaign_utm_id', 'campaign_utm_id_utm_created', 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', $editor, $this->dataset, $lookupDataset, 'campaign_utm_id', 'utm_created', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cregion field
            //
            $editor = new DynamicCombobox('cregion_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'cregion', 'cregion_Region', 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_cregion_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for show_events_cal field
            //
            $editor = new CheckBox('show_events_cal_edit');
            $editColumn = new CustomEditColumn('Show Events Cal', 'show_events_cal', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Program Generator Name Id', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'insert_campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brief Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'insert_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_type field
            //
            $editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Type', 'campaign_type', 'campaign_type_Type', 'insert_campaign_program_name_generator_campaign_tracker_comms_local_campaign_type_search', $editor, $this->dataset, $lookupDataset, 'Type_Value', 'Type', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for email_name field
            //
            $editor = new TextEdit('email_name_edit');
            $editColumn = new CustomEditColumn('Email Name', 'email_name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_description field
            //
            $editor = new TextEdit('campaign_description_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Campaign Description', 'campaign_description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Send Date', 'campaign_publish_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tracker_status field
            //
            $editor = new DynamicCombobox('tracker_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $editColumn = new DynamicLookupEditColumn('Send Status', 'tracker_status', 'tracker_status_Status_Type', 'insert_campaign_program_name_generator_campaign_tracker_comms_local_tracker_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_utm_id field
            //
            $editor = new DynamicCombobox('campaign_utm_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_utm_filtered');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new StringField('utm_created')
                )
            );
            $lookupDataset->setOrderByField('utm_created', 'ASC');
            $editColumn = new DynamicLookupEditColumn('UTM Tracking', 'campaign_utm_id', 'campaign_utm_id_utm_created', 'insert_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', $editor, $this->dataset, $lookupDataset, 'campaign_utm_id', 'utm_created', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cregion field
            //
            $editor = new DynamicCombobox('cregion_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'cregion', 'cregion_Region', 'insert_campaign_program_name_generator_campaign_tracker_comms_local_cregion_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for show_events_cal field
            //
            $editor = new CheckBox('show_events_cal_edit');
            $editColumn = new CustomEditColumn('Show Events Cal', 'show_events_cal', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('No Approved');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for campaign_tracker_local_id field
            //
            $column = new NumberViewColumn('campaign_tracker_local_id', 'campaign_tracker_local_id', 'Campaign Tracker Local Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Program Generator Name Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Send Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('tracker_status', 'tracker_status_Status_Type', 'Send Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for utm_created field
            //
            $column = new TextViewColumn('campaign_utm_id', 'campaign_utm_id_utm_created', 'UTM Tracking', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for region_approval field
            //
            $column = new NumberViewColumn('region_approval', 'region_approval', 'Region Approval', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for region_approved_by field
            //
            $column = new TextViewColumn('region_approved_by', 'region_approved_by', 'Region Approved By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for region_approved_date field
            //
            $column = new DateTimeViewColumn('region_approved_date', 'region_approved_date', 'Region Approved Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Events Cal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for campaign_tracker_local_id field
            //
            $column = new NumberViewColumn('campaign_tracker_local_id', 'campaign_tracker_local_id', 'Campaign Tracker Local Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Program Generator Name Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Send Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('tracker_status', 'tracker_status_Status_Type', 'Send Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for utm_created field
            //
            $column = new TextViewColumn('campaign_utm_id', 'campaign_utm_id_utm_created', 'UTM Tracking', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for region_approval field
            //
            $column = new NumberViewColumn('region_approval', 'region_approval', 'Region Approval', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for region_approved_by field
            //
            $column = new TextViewColumn('region_approved_by', 'region_approved_by', 'Region Approved By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for region_approved_date field
            //
            $column = new DateTimeViewColumn('region_approved_date', 'region_approved_date', 'Region Approved Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Events Cal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Program Generator Name Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Send Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('tracker_status', 'tracker_status_Status_Type', 'Send Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for utm_created field
            //
            $column = new TextViewColumn('campaign_utm_id', 'campaign_utm_id_utm_created', 'UTM Tracking', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for region_approval field
            //
            $column = new NumberViewColumn('region_approval', 'region_approval', 'Region Approval', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for region_approved_by field
            //
            $column = new TextViewColumn('region_approved_by', 'region_approved_by', 'Region Approved By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for region_approved_date field
            //
            $column = new DateTimeViewColumn('region_approved_date', 'region_approved_date', 'Region Approved Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Events Cal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalSingleRecordView() { return true; }
        
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
    
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
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setDescription('<div class="mark-media mark-position-relative">
            	<div class="mark-bd-placeholder-img mr-3"><img src="apps/icons/comms-color.png" width="80" height="79"></div>
            	<div class="mark-media-body">
            		<h5 class="mt-0 h5">What will you find here</h5>
            		<p class="mark-p">The Comms Tracker works side by side with the Program Generator and the Events List to displaying newly targetted channel communications in the Campaign Calendar.</p>
            		<i class="far fa-life-ring"></i> If you need more help go to <a href="portal_help.php?partitionpage=3" class="stretched-link">portal help</a> section!
            	</div>
            </div>');
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_comms_local_campaign_type_search', 'Type_Value', 'Type', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_comms_local_tracker_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_utm_filtered');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new StringField('utm_created')
                )
            );
            $lookupDataset->setOrderByField('utm_created', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', 'campaign_utm_id', 'utm_created', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_comms_local_cregion_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_campaign_type_search', 'Type_Value', 'Type', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_tracker_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_utm_filtered');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new StringField('utm_created')
                )
            );
            $lookupDataset->setOrderByField('utm_created', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', 'campaign_utm_id', 'utm_created', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_cregion_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_type_search', 'Type_Value', 'Type', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_comms_local_tracker_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_utm_filtered');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new StringField('utm_created')
                )
            );
            $lookupDataset->setOrderByField('utm_created', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', 'campaign_utm_id', 'utm_created', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, '_campaign_program_name_generator_campaign_tracker_comms_local_cregion_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_type_search', 'Type_Value', 'Type', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_tracker_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_utm_filtered');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new StringField('utm_created')
                )
            );
            $lookupDataset->setOrderByField('utm_created', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', 'campaign_utm_id', 'utm_created', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_cregion_search', 'Region_Value', 'Region', null, 20);
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
            if ($success) {
            
              // Check if record data was modified
            
              $dataMofified  = 
            
                 $oldRowData['trackerid'] !== $rowData['trackerid'] ||
                 $oldRowData['program_generator_name_id'] !== $rowData['program_generator_name_id'] ||
                 $oldRowData['master_campaign_id'] !== $rowData['master_campaign_id'] ||
                 $oldRowData['email_name'] !== $rowData['email_name'] ||
                 $oldRowData['campaign_type'] !== $rowData['campaign_type'] ||
                 $oldRowData['cregion'] !== $rowData['cregion'] ||
                 $oldRowData['campaign_publish_date'] !== $rowData['campaign_publish_date'] ||
                 $oldRowData['campaign_description'] !== $rowData['campaign_description'] ||
                 $oldRowData['tracker_status'] !== $rowData['tracker_status'] ||
                 $oldRowData['campaign_utm_id'] !== $rowData['campaign_utm_id'] ||
                 $oldRowData['created_by'] !== $rowData['created_by'];
            
              if ($dataMofified) {
            
                $modified_by = $rowData['modified_by'];
                $modified_date = $rowData['modified_date'];
                $program_generator_name_id = $rowData['program_generator_name_id'];
                $master_campaign_id = $rowData['master_campaign_id'];
                $trackerid = $rowData['trackerid'];
                $emailname = $rowData['email_name'];
                $cregion = $rowData['cregion'];
                $description = $rowData['campaign_description'];
                $startdate = $rowData['campaign_publish_date'];
            
                $sql = 
            
                  "CALL campaignCommsLocaltoGlobalCalendar('$program_generator_name_id', '$modified_by', '$modified_date', '$master_campaign_id', '$trackerid', '$emailname', '$cregion', '$description', '$startdate', '$startdate');";
                  $this->GetConnection()->ExecSQL($sql);
                  
                  $message = '<p>Record processed successfully, goto Comms Tracker (Local) to update the send dates .</p>';
                  
                  sendMailMessage('lance.spurgeon@hexagon.com', 'Message subject', 'Message body');
              }                                    
            }
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
            
                  $modified_by = $rowData['modified_by'];
                  $modified_date = $rowData['modified_date'];
                  $campaign_tracker_local_id = $rowData['campaign_tracker_local_id'];
                  $trackerid = $rowData['trackerid'];
            
                $sql = 
            
                  "CALL campaignCalendarDelete('$modified_by', '$modified_date', $campaign_tracker_local_id, $trackerid,'0');";
                  $this->GetConnection()->ExecSQL($sql);
                  
                  $message = '<p>Record removed from the Global Campaign Calendar.</p>';
            }
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
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class campaign_program_name_generator_campaign_tracker_webcastPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Campaign Tracker: Webcast');
            $this->SetMenuLabel('Webcast Tracker');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_webcast`');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_tracker_webcast_id', true, true, true),
                    new StringField('trackerid'),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('program_generator_name_id'),
                    new StringField('webcast_name'),
                    new StringField('cregion'),
                    new DateField('webcast_publish_date'),
                    new IntegerField('webcast_status'),
                    new TimeField('modified_start_time'),
                    new TimeField('modified_end_time'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('show_events_cal'),
                    new StringField('created_by'),
                    new DateTimeField('created_date')
                )
            );
            $this->dataset->AddLookupField('program_generator_name_id', 'campaign_program_name_generator', new IntegerField('program_generator_name_id'), new StringField('campaign_program_name', false, false, false, false, 'program_generator_name_id_campaign_program_name', 'program_generator_name_id_campaign_program_name_campaign_program_name_generator'), 'program_generator_name_id_campaign_program_name_campaign_program_name_generator');
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
            $this->dataset->AddLookupField('webcast_status', 'lookup_status_types', new IntegerField('Status_Type_ID'), new StringField('Status_Type', false, false, false, false, 'webcast_status_Status_Type', 'webcast_status_Status_Type_lookup_status_types'), 'webcast_status_Status_Type_lookup_status_types');
            $this->dataset->AddLookupField('cregion', 'lookup_region', new IntegerField('Region_ID'), new StringField('Region', false, false, false, false, 'cregion_Region', 'cregion_Region_lookup_region'), 'cregion_Region_lookup_region');
            if (!$this->GetSecurityInfo()->HasAdminGrant()) {
                $this->dataset->setRlsPolicy(new RlsPolicy('created_by', GetApplication()->GetCurrentUserId()));
            }
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(10);
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
                new FilterColumn($this->dataset, 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder'),
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request'),
                new FilterColumn($this->dataset, 'webcast_name', 'webcast_name', 'Webcast Name'),
                new FilterColumn($this->dataset, 'campaign_tracker_webcast_id', 'campaign_tracker_webcast_id', 'Campaign Tracker Webcast Id'),
                new FilterColumn($this->dataset, 'trackerid', 'trackerid', 'Trackerid'),
                new FilterColumn($this->dataset, 'webcast_status', 'webcast_status_Status_Type', 'Webcast Status'),
                new FilterColumn($this->dataset, 'cregion', 'cregion_Region', 'Region'),
                new FilterColumn($this->dataset, 'webcast_publish_date', 'webcast_publish_date', 'Webcast Publish Date'),
                new FilterColumn($this->dataset, 'modified_start_time', 'modified_start_time', 'Start Time'),
                new FilterColumn($this->dataset, 'modified_end_time', 'modified_end_time', 'End Time'),
                new FilterColumn($this->dataset, 'show_events_cal', 'show_events_cal', 'Show Global Calendar'),
                new FilterColumn($this->dataset, 'modified_by', 'modified_by', 'Modified By'),
                new FilterColumn($this->dataset, 'modified_date', 'modified_date', 'Modified Date'),
                new FilterColumn($this->dataset, 'created_by', 'created_by', 'Created By'),
                new FilterColumn($this->dataset, 'created_date', 'created_date', 'Created Date')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['program_generator_name_id'])
                ->addColumn($columns['webcast_name'])
                ->addColumn($columns['webcast_status'])
                ->addColumn($columns['cregion'])
                ->addColumn($columns['webcast_publish_date'])
                ->addColumn($columns['modified_start_time'])
                ->addColumn($columns['modified_end_time'])
                ->addColumn($columns['show_events_cal'])
                ->addColumn($columns['modified_by'])
                ->addColumn($columns['modified_date']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('webcast_status')
                ->setOptionsFor('cregion')
                ->setOptionsFor('webcast_publish_date')
                ->setOptionsFor('modified_start_time')
                ->setOptionsFor('modified_end_time')
                ->setOptionsFor('modified_date');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_webcast_program_generator_name_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('program_generator_name_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_webcast_program_generator_name_id_search');
            
            $filterBuilder->addColumn(
                $columns['program_generator_name_id'],
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
            
            $main_editor = new TextEdit('webcast_name_edit');
            
            $filterBuilder->addColumn(
                $columns['webcast_name'],
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
            
            $main_editor = new DynamicCombobox('webcast_status_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_webcast_webcast_status_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('webcast_status', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_webcast_webcast_status_search');
            
            $filterBuilder->addColumn(
                $columns['webcast_status'],
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
            
            $main_editor = new DynamicCombobox('cregion_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_webcast_cregion_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('cregion', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_webcast_cregion_search');
            
            $text_editor = new TextEdit('cregion');
            
            $filterBuilder->addColumn(
                $columns['cregion'],
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
            
            $main_editor = new DateTimeEdit('webcast_publish_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['webcast_publish_date'],
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
            
            $main_editor = new TimeEdit('modified_start_time_edit', 'H:i:s');
            
            $filterBuilder->addColumn(
                $columns['modified_start_time'],
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
            
            $main_editor = new TimeEdit('modified_end_time_edit', 'H:i:s');
            
            $filterBuilder->addColumn(
                $columns['modified_end_time'],
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
            
            $main_editor = new ComboBox('show_events_cal');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['show_events_cal'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('modified_by_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['modified_by'],
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
            
            $main_editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['modified_date'],
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
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for webcast_name field
            //
            $column = new TextViewColumn('webcast_name', 'webcast_name', 'Webcast Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('webcast_status', 'webcast_status_Status_Type', 'Webcast Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for webcast_publish_date field
            //
            $column = new DateTimeViewColumn('webcast_publish_date', 'webcast_publish_date', 'Webcast Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for modified_start_time field
            //
            $column = new DateTimeViewColumn('modified_start_time', 'modified_start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for modified_end_time field
            //
            $column = new DateTimeViewColumn('modified_end_time', 'modified_end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Global Calendar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for webcast_name field
            //
            $column = new TextViewColumn('webcast_name', 'webcast_name', 'Webcast Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('webcast_status', 'webcast_status_Status_Type', 'Webcast Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for webcast_publish_date field
            //
            $column = new DateTimeViewColumn('webcast_publish_date', 'webcast_publish_date', 'Webcast Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_start_time field
            //
            $column = new DateTimeViewColumn('modified_start_time', 'modified_start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_end_time field
            //
            $column = new DateTimeViewColumn('modified_end_time', 'modified_end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Global Calendar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Builder', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'edit_campaign_program_name_generator_campaign_tracker_webcast_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for webcast_name field
            //
            $editor = new TextEdit('webcast_name_edit');
            $editColumn = new CustomEditColumn('Webcast Name', 'webcast_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for webcast_status field
            //
            $editor = new DynamicCombobox('webcast_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $editColumn = new DynamicLookupEditColumn('Webcast Status', 'webcast_status', 'webcast_status_Status_Type', 'edit_campaign_program_name_generator_campaign_tracker_webcast_webcast_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cregion field
            //
            $editor = new DynamicCombobox('cregion_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'cregion', 'cregion_Region', 'edit_campaign_program_name_generator_campaign_tracker_webcast_cregion_search', $editor, $this->dataset, $lookupDataset, 'Region_ID', 'Region', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for webcast_publish_date field
            //
            $editor = new DateTimeEdit('webcast_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Webcast Publish Date', 'webcast_publish_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for modified_start_time field
            //
            $editor = new TimeEdit('modified_start_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Start Time', 'modified_start_time', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for modified_end_time field
            //
            $editor = new TimeEdit('modified_end_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('End Time', 'modified_end_time', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for show_events_cal field
            //
            $editor = new CheckBox('show_events_cal_edit');
            $editColumn = new CustomEditColumn('Show Global Calendar', 'show_events_cal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Builder', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'multi_edit_campaign_program_name_generator_campaign_tracker_webcast_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for webcast_name field
            //
            $editor = new TextEdit('webcast_name_edit');
            $editColumn = new CustomEditColumn('Webcast Name', 'webcast_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for webcast_status field
            //
            $editor = new DynamicCombobox('webcast_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $editColumn = new DynamicLookupEditColumn('Webcast Status', 'webcast_status', 'webcast_status_Status_Type', 'multi_edit_campaign_program_name_generator_campaign_tracker_webcast_webcast_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cregion field
            //
            $editor = new DynamicCombobox('cregion_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'cregion', 'cregion_Region', 'multi_edit_campaign_program_name_generator_campaign_tracker_webcast_cregion_search', $editor, $this->dataset, $lookupDataset, 'Region_ID', 'Region', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for webcast_publish_date field
            //
            $editor = new DateTimeEdit('webcast_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Webcast Publish Date', 'webcast_publish_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for modified_start_time field
            //
            $editor = new TimeEdit('modified_start_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Start Time', 'modified_start_time', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for modified_end_time field
            //
            $editor = new TimeEdit('modified_end_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('End Time', 'modified_end_time', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for show_events_cal field
            //
            $editor = new CheckBox('show_events_cal_edit');
            $editColumn = new CustomEditColumn('Show Global Calendar', 'show_events_cal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Builder', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'insert_campaign_program_name_generator_campaign_tracker_webcast_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for webcast_name field
            //
            $editor = new TextEdit('webcast_name_edit');
            $editColumn = new CustomEditColumn('Webcast Name', 'webcast_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for webcast_status field
            //
            $editor = new DynamicCombobox('webcast_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $editColumn = new DynamicLookupEditColumn('Webcast Status', 'webcast_status', 'webcast_status_Status_Type', 'insert_campaign_program_name_generator_campaign_tracker_webcast_webcast_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cregion field
            //
            $editor = new DynamicCombobox('cregion_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'cregion', 'cregion_Region', 'insert_campaign_program_name_generator_campaign_tracker_webcast_cregion_search', $editor, $this->dataset, $lookupDataset, 'Region_ID', 'Region', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for webcast_publish_date field
            //
            $editor = new DateTimeEdit('webcast_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Webcast Publish Date', 'webcast_publish_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for modified_start_time field
            //
            $editor = new TimeEdit('modified_start_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Start Time', 'modified_start_time', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for modified_end_time field
            //
            $editor = new TimeEdit('modified_end_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('End Time', 'modified_end_time', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for show_events_cal field
            //
            $editor = new CheckBox('show_events_cal_edit');
            $editColumn = new CustomEditColumn('Show Global Calendar', 'show_events_cal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('1');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for webcast_name field
            //
            $column = new TextViewColumn('webcast_name', 'webcast_name', 'Webcast Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('webcast_status', 'webcast_status_Status_Type', 'Webcast Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for webcast_publish_date field
            //
            $column = new DateTimeViewColumn('webcast_publish_date', 'webcast_publish_date', 'Webcast Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_start_time field
            //
            $column = new DateTimeViewColumn('modified_start_time', 'modified_start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_end_time field
            //
            $column = new DateTimeViewColumn('modified_end_time', 'modified_end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Global Calendar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for webcast_name field
            //
            $column = new TextViewColumn('webcast_name', 'webcast_name', 'Webcast Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('webcast_status', 'webcast_status_Status_Type', 'Webcast Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for webcast_publish_date field
            //
            $column = new DateTimeViewColumn('webcast_publish_date', 'webcast_publish_date', 'Webcast Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_start_time field
            //
            $column = new DateTimeViewColumn('modified_start_time', 'modified_start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_end_time field
            //
            $column = new DateTimeViewColumn('modified_end_time', 'modified_end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Global Calendar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for webcast_name field
            //
            $column = new TextViewColumn('webcast_name', 'webcast_name', 'Webcast Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('webcast_status', 'webcast_status_Status_Type', 'Webcast Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('cregion', 'cregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for webcast_publish_date field
            //
            $column = new DateTimeViewColumn('webcast_publish_date', 'webcast_publish_date', 'Webcast Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_start_time field
            //
            $column = new DateTimeViewColumn('modified_start_time', 'modified_start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_end_time field
            //
            $column = new DateTimeViewColumn('modified_end_time', 'modified_end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for show_events_cal field
            //
            $column = new NumberViewColumn('show_events_cal', 'show_events_cal', 'Show Global Calendar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalSingleRecordView() { return true; }
        
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $defaultSortedColumns = array();
            $defaultSortedColumns[] = new SortColumn('webcast_publish_date', 'ASC');
            $result->setDefaultOrdering($defaultSortedColumns);
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
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setDescription('<div class="mark-media mark-position-relative">
            	<div class="mark-bd-placeholder-img mr-3"><img src="apps/icons/webcast-color.png" width="80" height="79"></div>
            	<div class="mark-media-body">
            		<h5 class="mt-0 h5">What will you find here</h5>
            		<p class="mark-p">The Webcast Tracker works side by side with the Campaign Builder to displaying a series of webcast assosciated with your campaign builder.</p>
            		<i class="far fa-life-ring"></i> If you need more help go to <a href="portal_help.php?partitionpage=3" class="stretched-link">portal help</a> section!
            	</div>
            </div>');
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_webcast_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_webcast_webcast_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_webcast_cregion_search', 'Region_ID', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_webcast_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_webcast_webcast_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_webcast_cregion_search', 'Region_ID', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_webcast_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_webcast_webcast_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_webcast_cregion_search', 'Region_ID', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_webcast_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'png\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_webcast_webcast_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_webcast_cregion_search', 'Region_ID', 'Region', null, 20);
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
            if ($success) {
            
              // Check if record data was modified
            
              $dataMofified  = 
            
                 $oldRowData['trackerid'] !== $rowData['trackerid'] ||
                 $oldRowData['program_generator_name_id'] !== $rowData['program_generator_name_id'] ||
                 $oldRowData['webcast_name'] !== $rowData['webcast_name'] ||
                 $oldRowData['cregion'] !== $rowData['cregion'] ||
                 $oldRowData['webcast_publish_date'] !== $rowData['webcast_publish_date'] ||
                 $oldRowData['webcast_status'] !== $rowData['webcast_status'] ||
                 $oldRowData['modified_start_time'] !== $rowData['modified_start_time'] ||
                 $oldRowData['modified_end_time'] !== $rowData['modified_end_time'] ||
                 $oldRowData['modified_by'] !== $rowData['modified_by'] ||
                 $oldRowData['modified_date'] !== $rowData['modified_date'] ||
                 $oldRowData['show_events_cal'] !== $rowData['show_events_cal'];
            
              if ($dataMofified) {
                
                 $campaign_tracker_webcast_id = $rowData['campaign_tracker_webcast_id'];
                 $modified_by = $rowData['modified_by'];
                 $modified_date = $rowData['modified_date'];
                 $trackerid = $rowData['trackerid'];
                 $webcastname = $rowData['webcast_name'];
                 $cregion = $rowData['cregion'];
                 $startdate = $rowData['webcast_publish_date'] . ' ' . $rowData['modified_start_time']; 
                 $enddate = $rowData['webcast_publish_date'] . ' ' . $rowData['modified_end_time'];
            
                $sql = 
            
                  "CALL campaignCommsWebcasttoGlobalCalendar($campaign_tracker_webcast_id, '$modified_by', '$modified_date', $trackerid, '$webcastname', '$cregion', '$startdate', '$enddate');";
                  $this->GetConnection()->ExecSQL($sql);
                  
                  $message = '<p>Record processed successfully, go to Webcast Tracker to update the send dates .</p>';
                  
                  sendMailMessage('lance.spurgeon@hexagon.com', 'Message subject', 'Message body');
              }                                    
            }
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
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class campaign_program_name_generator_campaign_tracker_websitePage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Campaign Tracker: Website Display Listing');
            $this->SetMenuLabel('Website Display Tracker');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_website`');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_tracker_ID', true, true, true),
                    new IntegerField('master_campaign_id', true),
                    new IntegerField('program_generator_name_id', true),
                    new StringField('trackerid'),
                    new StringField('industry'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country', true),
                    new StringField('product', true),
                    new StringField('langauge', true),
                    new StringField('event_type'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('start_date'),
                    new DateField('end_date'),
                    new TimeField('start_time'),
                    new TimeField('end_time'),
                    new StringField('deployed_by'),
                    new DateTimeField('deployed_date', true),
                    new IntegerField('deploy_website'),
                    new StringField('deploy_website_status'),
                    new DateTimeField('deploy_website_date'),
                    new StringField('listing_title'),
                    new BlobField('listing_content'),
                    new StringField('listing_cta'),
                    new StringField('listing_banner'),
                    new StringField('listing_SEO_title'),
                    new StringField('listing_SEO_keywords'),
                    new StringField('social_meta'),
                    new IntegerField('listing_show_form'),
                    new StringField('listing_url'),
                    new StringField('publish_live'),
                    new DateField('publish_live_date'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
            $this->dataset->AddLookupField('program_generator_name_id', 'campaign_program_name_generator', new IntegerField('program_generator_name_id'), new StringField('campaign_program_name', false, false, false, false, 'program_generator_name_id_campaign_program_name', 'program_generator_name_id_campaign_program_name_campaign_program_name_generator'), 'program_generator_name_id_campaign_program_name_campaign_program_name_generator');
            $this->dataset->AddLookupField('region', 'lookup_region', new StringField('Region_Value'), new StringField('Region', false, false, false, false, 'region_Region', 'region_Region_lookup_region'), 'region_Region_lookup_region');
            $this->dataset->AddLookupField('sub_region', 'lookup_region', new StringField('Region_Value'), new StringField('Region', false, false, false, false, 'sub_region_Region', 'sub_region_Region_lookup_region'), 'sub_region_Region_lookup_region');
            $this->dataset->AddLookupField('territory', 'lookup_territory', new StringField('Territory_Value'), new StringField('Territory', false, false, false, false, 'territory_Territory', 'territory_Territory_lookup_territory'), 'territory_Territory_lookup_territory');
            $this->dataset->AddLookupField('langauge', 'lookup_language', new IntegerField('language_id'), new StringField('langauge', false, false, false, false, 'langauge_langauge', 'langauge_langauge_lookup_language'), 'langauge_langauge_lookup_language');
            $this->dataset->AddLookupField('event_type', 'lookup_event_type', new IntegerField('Event_Type_ID'), new StringField('Event_Type', false, false, false, false, 'event_type_Event_Type', 'event_type_Event_Type_lookup_event_type'), 'event_type_Event_Type_lookup_event_type');
            $this->dataset->AddLookupField('deploy_website_status', 'lookup_status_types', new IntegerField('Status_Type_ID'), new StringField('Status_Type', false, false, false, false, 'deploy_website_status_Status_Type', 'deploy_website_status_Status_Type_lookup_status_types'), 'deploy_website_status_Status_Type_lookup_status_types');
            $this->dataset->AddLookupField('listing_cta', 'lookup_button_cta', new StringField('description'), new StringField('description', false, false, false, false, 'listing_cta_description', 'listing_cta_description_lookup_button_cta'), 'listing_cta_description_lookup_button_cta');
            if (!$this->GetSecurityInfo()->HasAdminGrant()) {
                $this->dataset->setRlsPolicy(new RlsPolicy('created_by', GetApplication()->GetCurrentUserId()));
            }
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(10);
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
                new FilterColumn($this->dataset, 'campaign_tracker_ID', 'campaign_tracker_ID', 'Campaign Tracker ID'),
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Brief'),
                new FilterColumn($this->dataset, 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder'),
                new FilterColumn($this->dataset, 'trackerid', 'trackerid', 'Trackerid'),
                new FilterColumn($this->dataset, 'industry', 'industry', 'Industry'),
                new FilterColumn($this->dataset, 'region', 'region_Region', 'Region'),
                new FilterColumn($this->dataset, 'sub_region', 'sub_region_Region', 'Sub Region'),
                new FilterColumn($this->dataset, 'territory', 'territory_Territory', 'Territory'),
                new FilterColumn($this->dataset, 'country', 'country', 'Country'),
                new FilterColumn($this->dataset, 'product', 'product', 'Product'),
                new FilterColumn($this->dataset, 'langauge', 'langauge_langauge', 'Langauge'),
                new FilterColumn($this->dataset, 'event_type', 'event_type_Event_Type', 'Event Type'),
                new FilterColumn($this->dataset, 'm_ID', 'm_ID', 'M ID'),
                new FilterColumn($this->dataset, 'campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date'),
                new FilterColumn($this->dataset, 'start_date', 'start_date', 'Start Date'),
                new FilterColumn($this->dataset, 'end_date', 'end_date', 'End Date'),
                new FilterColumn($this->dataset, 'start_time', 'start_time', 'Start Time'),
                new FilterColumn($this->dataset, 'end_time', 'end_time', 'End Time'),
                new FilterColumn($this->dataset, 'deployed_by', 'deployed_by', 'Created By'),
                new FilterColumn($this->dataset, 'deployed_date', 'deployed_date', 'Created Date'),
                new FilterColumn($this->dataset, 'deploy_website', 'deploy_website', 'Publish Live'),
                new FilterColumn($this->dataset, 'deploy_website_status', 'deploy_website_status_Status_Type', 'Status'),
                new FilterColumn($this->dataset, 'deploy_website_date', 'deploy_website_date', 'Deploy Website Date'),
                new FilterColumn($this->dataset, 'listing_title', 'listing_title', 'Listing Title'),
                new FilterColumn($this->dataset, 'listing_content', 'listing_content', 'Listing Content'),
                new FilterColumn($this->dataset, 'listing_cta', 'listing_cta_description', 'CTA on Button'),
                new FilterColumn($this->dataset, 'listing_banner', 'listing_banner', 'Banner URL'),
                new FilterColumn($this->dataset, 'listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title'),
                new FilterColumn($this->dataset, 'listing_SEO_keywords', 'listing_SEO_keywords', 'Listing SEO Keywords'),
                new FilterColumn($this->dataset, 'social_meta', 'social_meta', 'Social Meta'),
                new FilterColumn($this->dataset, 'listing_show_form', 'listing_show_form', 'Listing Show Form'),
                new FilterColumn($this->dataset, 'listing_url', 'listing_url', 'Listing Url'),
                new FilterColumn($this->dataset, 'publish_live', 'publish_live', 'Publish Live'),
                new FilterColumn($this->dataset, 'publish_live_date', 'publish_live_date', 'Publish Live Date'),
                new FilterColumn($this->dataset, 'modified_by', 'modified_by', 'Modified By'),
                new FilterColumn($this->dataset, 'modified_date', 'modified_date', 'Modified Date'),
                new FilterColumn($this->dataset, 'created_by', 'created_by', 'Created By'),
                new FilterColumn($this->dataset, 'created_date', 'created_date', 'Created Date')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['langauge'])
                ->addColumn($columns['event_type'])
                ->addColumn($columns['m_ID'])
                ->addColumn($columns['start_date'])
                ->addColumn($columns['end_date'])
                ->addColumn($columns['start_time'])
                ->addColumn($columns['end_time'])
                ->addColumn($columns['deployed_by'])
                ->addColumn($columns['deployed_date'])
                ->addColumn($columns['deploy_website_status'])
                ->addColumn($columns['listing_title'])
                ->addColumn($columns['listing_content'])
                ->addColumn($columns['listing_cta'])
                ->addColumn($columns['listing_banner'])
                ->addColumn($columns['listing_SEO_title'])
                ->addColumn($columns['listing_SEO_keywords'])
                ->addColumn($columns['social_meta'])
                ->addColumn($columns['listing_url']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('langauge')
                ->setOptionsFor('event_type')
                ->setOptionsFor('campaign_publish_date')
                ->setOptionsFor('start_date')
                ->setOptionsFor('end_date')
                ->setOptionsFor('deploy_website_status')
                ->setOptionsFor('modified_date');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_program_generator_name_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('program_generator_name_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_program_generator_name_id_search');
            
            $filterBuilder->addColumn(
                $columns['program_generator_name_id'],
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
            
            $main_editor = new DynamicCombobox('langauge_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_langauge_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('langauge', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_langauge_search');
            
            $text_editor = new TextEdit('langauge');
            
            $filterBuilder->addColumn(
                $columns['langauge'],
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
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_event_type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('event_type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_event_type_search');
            
            $text_editor = new TextEdit('event_type');
            
            $filterBuilder->addColumn(
                $columns['event_type'],
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
            
            $main_editor = new TextEdit('m_id_edit');
            $main_editor->SetMaxLength(11);
            
            $filterBuilder->addColumn(
                $columns['m_ID'],
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
            
            $main_editor = new DateTimeEdit('start_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['start_date'],
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
                $columns['end_date'],
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
            
            $main_editor = new TimeEdit('start_time_edit', 'H:i:s');
            
            $filterBuilder->addColumn(
                $columns['start_time'],
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
            
            $main_editor = new TimeEdit('end_time_edit', 'H:i:s');
            
            $filterBuilder->addColumn(
                $columns['end_time'],
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
            
            $main_editor = new TextEdit('deployed_by_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['deployed_by'],
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
            
            $main_editor = new DateTimeEdit('deployed_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['deployed_date'],
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
            
            $main_editor = new DynamicCombobox('deploy_website_status_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_deploy_website_status_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('deploy_website_status', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_deploy_website_status_search');
            
            $text_editor = new TextEdit('deploy_website_status');
            
            $filterBuilder->addColumn(
                $columns['deploy_website_status'],
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
            
            $main_editor = new TextEdit('listing_title_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['listing_title'],
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
            
            $main_editor = new TextEdit('listing_content');
            
            $filterBuilder->addColumn(
                $columns['listing_content'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('listing_cta_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_listing_cta_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('listing_cta', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_website_listing_cta_search');
            
            $text_editor = new TextEdit('listing_cta');
            
            $filterBuilder->addColumn(
                $columns['listing_cta'],
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
            
            $main_editor = new TextEdit('listing_banner_edit');
            
            $filterBuilder->addColumn(
                $columns['listing_banner'],
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
            
            $main_editor = new TextEdit('listing_seo_title_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['listing_SEO_title'],
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
            
            $main_editor = new TextEdit('listing_seo_keywords_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['listing_SEO_keywords'],
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
            
            $main_editor = new TextEdit('social_meta');
            
            $filterBuilder->addColumn(
                $columns['social_meta'],
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
            
            $main_editor = new TextEdit('listing_url_edit');
            
            $filterBuilder->addColumn(
                $columns['listing_url'],
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
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for deploy_website field
            //
            $column = new NumberViewColumn('deploy_website', 'deploy_website', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for start_time field
            //
            $column = new DateTimeViewColumn('start_time', 'start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for end_time field
            //
            $column = new DateTimeViewColumn('end_time', 'end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for deployed_by field
            //
            $column = new TextViewColumn('deployed_by', 'deployed_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for deployed_date field
            //
            $column = new DateTimeViewColumn('deployed_date', 'deployed_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for deploy_website field
            //
            $column = new NumberViewColumn('deploy_website', 'deploy_website', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_content field
            //
            $column = new TextViewColumn('listing_content', 'listing_content', 'Listing Content', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('listing_cta', 'listing_cta_description', 'CTA on Button', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_banner field
            //
            $column = new TextViewColumn('listing_banner', 'listing_banner', 'Banner URL', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_SEO_title field
            //
            $column = new TextViewColumn('listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_SEO_keywords field
            //
            $column = new TextViewColumn('listing_SEO_keywords', 'listing_SEO_keywords', 'Listing SEO Keywords', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for social_meta field
            //
            $column = new TextViewColumn('social_meta', 'social_meta', 'Social Meta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_url field
            //
            $column = new TextViewColumn('listing_url', 'listing_url', 'Listing Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Builder', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'edit_campaign_program_name_generator_campaign_tracker_website_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for langauge field
            //
            $editor = new DynamicCombobox('langauge_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Langauge', 'langauge', 'langauge_langauge', 'edit_campaign_program_name_generator_campaign_tracker_website_langauge_search', $editor, $this->dataset, $lookupDataset, 'language_id', 'langauge', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for event_type field
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
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Event_website_listing=\'1\''));
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'edit_campaign_program_name_generator_campaign_tracker_website_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('M ID', 'm_ID', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deployed_by field
            //
            $editor = new TextEdit('deployed_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Created By', 'deployed_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deployed_date field
            //
            $editor = new DateTimeEdit('deployed_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'deployed_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deploy_website field
            //
            $editor = new CheckBox('deploy_website_edit');
            $editColumn = new CustomEditColumn('Publish Live', 'deploy_website', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deploy_website_status field
            //
            $editor = new DynamicCombobox('deploy_website_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'website_listing\''));
            $editColumn = new DynamicLookupEditColumn('Status', 'deploy_website_status', 'deploy_website_status_Status_Type', 'edit_campaign_program_name_generator_campaign_tracker_website_deploy_website_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_title field
            //
            $editor = new TextEdit('listing_title_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Listing Title', 'listing_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_content field
            //
            $editor = new HtmlWysiwygEditor('listing_content_edit');
            $editColumn = new CustomEditColumn('Listing Content', 'listing_content', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_cta field
            //
            $editor = new DynamicCombobox('listing_cta_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('CTA on Button', 'listing_cta', 'listing_cta_description', 'edit_campaign_program_name_generator_campaign_tracker_website_listing_cta_search', $editor, $this->dataset, $lookupDataset, 'description', 'description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_banner field
            //
            $editor = new TextEdit('listing_banner_edit');
            $editColumn = new CustomEditColumn('Banner URL', 'listing_banner', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_SEO_title field
            //
            $editor = new TextEdit('listing_seo_title_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Title', 'listing_SEO_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_SEO_keywords field
            //
            $editor = new TextEdit('listing_seo_keywords_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Keywords', 'listing_SEO_keywords', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for social_meta field
            //
            $editor = new TextAreaEdit('social_meta_edit', 50, 2);
            $editor->setPlaceholder('Add your social media meta here');
            $editColumn = new CustomEditColumn('Social Meta', 'social_meta', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_url field
            //
            $editor = new TextEdit('listing_url_edit');
            $editColumn = new CustomEditColumn('Listing Url', 'listing_url', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Builder', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'multi_edit_campaign_program_name_generator_campaign_tracker_website_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for langauge field
            //
            $editor = new DynamicCombobox('langauge_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Langauge', 'langauge', 'langauge_langauge', 'multi_edit_campaign_program_name_generator_campaign_tracker_website_langauge_search', $editor, $this->dataset, $lookupDataset, 'language_id', 'langauge', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for event_type field
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
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Event_website_listing=\'1\''));
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'multi_edit_campaign_program_name_generator_campaign_tracker_website_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('M ID', 'm_ID', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for deployed_by field
            //
            $editor = new TextEdit('deployed_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Created By', 'deployed_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for deployed_date field
            //
            $editor = new DateTimeEdit('deployed_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'deployed_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for deploy_website field
            //
            $editor = new CheckBox('deploy_website_edit');
            $editColumn = new CustomEditColumn('Publish Live', 'deploy_website', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for deploy_website_status field
            //
            $editor = new DynamicCombobox('deploy_website_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'website_listing\''));
            $editColumn = new DynamicLookupEditColumn('Status', 'deploy_website_status', 'deploy_website_status_Status_Type', 'multi_edit_campaign_program_name_generator_campaign_tracker_website_deploy_website_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_title field
            //
            $editor = new TextEdit('listing_title_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Listing Title', 'listing_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_content field
            //
            $editor = new HtmlWysiwygEditor('listing_content_edit');
            $editColumn = new CustomEditColumn('Listing Content', 'listing_content', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_cta field
            //
            $editor = new DynamicCombobox('listing_cta_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('CTA on Button', 'listing_cta', 'listing_cta_description', 'multi_edit_campaign_program_name_generator_campaign_tracker_website_listing_cta_search', $editor, $this->dataset, $lookupDataset, 'description', 'description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_banner field
            //
            $editor = new TextEdit('listing_banner_edit');
            $editColumn = new CustomEditColumn('Banner URL', 'listing_banner', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_SEO_title field
            //
            $editor = new TextEdit('listing_seo_title_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Title', 'listing_SEO_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_SEO_keywords field
            //
            $editor = new TextEdit('listing_seo_keywords_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Keywords', 'listing_SEO_keywords', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for social_meta field
            //
            $editor = new TextAreaEdit('social_meta_edit', 50, 2);
            $editor->setPlaceholder('Add your social media meta here');
            $editColumn = new CustomEditColumn('Social Meta', 'social_meta', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_url field
            //
            $editor = new TextEdit('listing_url_edit');
            $editColumn = new CustomEditColumn('Listing Url', 'listing_url', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Builder', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'insert_campaign_program_name_generator_campaign_tracker_website_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for langauge field
            //
            $editor = new DynamicCombobox('langauge_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Langauge', 'langauge', 'langauge_langauge', 'insert_campaign_program_name_generator_campaign_tracker_website_langauge_search', $editor, $this->dataset, $lookupDataset, 'language_id', 'langauge', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for event_type field
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
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Event_website_listing=\'1\''));
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'insert_campaign_program_name_generator_campaign_tracker_website_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('M ID', 'm_ID', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deployed_by field
            //
            $editor = new TextEdit('deployed_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Created By', 'deployed_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deployed_date field
            //
            $editor = new DateTimeEdit('deployed_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'deployed_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deploy_website field
            //
            $editor = new CheckBox('deploy_website_edit');
            $editColumn = new CustomEditColumn('Publish Live', 'deploy_website', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deploy_website_status field
            //
            $editor = new DynamicCombobox('deploy_website_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'website_listing\''));
            $editColumn = new DynamicLookupEditColumn('Status', 'deploy_website_status', 'deploy_website_status_Status_Type', 'insert_campaign_program_name_generator_campaign_tracker_website_deploy_website_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_title field
            //
            $editor = new TextEdit('listing_title_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Listing Title', 'listing_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_content field
            //
            $editor = new HtmlWysiwygEditor('listing_content_edit');
            $editColumn = new CustomEditColumn('Listing Content', 'listing_content', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_cta field
            //
            $editor = new DynamicCombobox('listing_cta_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('CTA on Button', 'listing_cta', 'listing_cta_description', 'insert_campaign_program_name_generator_campaign_tracker_website_listing_cta_search', $editor, $this->dataset, $lookupDataset, 'description', 'description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_banner field
            //
            $editor = new TextEdit('listing_banner_edit');
            $editColumn = new CustomEditColumn('Banner URL', 'listing_banner', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_SEO_title field
            //
            $editor = new TextEdit('listing_seo_title_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Title', 'listing_SEO_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_SEO_keywords field
            //
            $editor = new TextEdit('listing_seo_keywords_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Keywords', 'listing_SEO_keywords', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for social_meta field
            //
            $editor = new TextAreaEdit('social_meta_edit', 50, 2);
            $editor->setPlaceholder('Add your social media meta here');
            $editColumn = new CustomEditColumn('Social Meta', 'social_meta', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_url field
            //
            $editor = new TextEdit('listing_url_edit');
            $editColumn = new CustomEditColumn('Listing Url', 'listing_url', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for start_time field
            //
            $column = new DateTimeViewColumn('start_time', 'start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for end_time field
            //
            $column = new DateTimeViewColumn('end_time', 'end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for deployed_by field
            //
            $column = new TextViewColumn('deployed_by', 'deployed_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for deployed_date field
            //
            $column = new DateTimeViewColumn('deployed_date', 'deployed_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_content field
            //
            $column = new TextViewColumn('listing_content', 'listing_content', 'Listing Content', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('listing_cta', 'listing_cta_description', 'CTA on Button', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_banner field
            //
            $column = new TextViewColumn('listing_banner', 'listing_banner', 'Banner URL', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_SEO_title field
            //
            $column = new TextViewColumn('listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for social_meta field
            //
            $column = new TextViewColumn('social_meta', 'social_meta', 'Social Meta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_url field
            //
            $column = new TextViewColumn('listing_url', 'listing_url', 'Listing Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for start_time field
            //
            $column = new DateTimeViewColumn('start_time', 'start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for end_time field
            //
            $column = new DateTimeViewColumn('end_time', 'end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for deployed_by field
            //
            $column = new TextViewColumn('deployed_by', 'deployed_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for deployed_date field
            //
            $column = new DateTimeViewColumn('deployed_date', 'deployed_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_content field
            //
            $column = new TextViewColumn('listing_content', 'listing_content', 'Listing Content', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('listing_cta', 'listing_cta_description', 'CTA on Button', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_banner field
            //
            $column = new TextViewColumn('listing_banner', 'listing_banner', 'Banner URL', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_SEO_title field
            //
            $column = new TextViewColumn('listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_SEO_keywords field
            //
            $column = new TextViewColumn('listing_SEO_keywords', 'listing_SEO_keywords', 'Listing SEO Keywords', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for social_meta field
            //
            $column = new TextViewColumn('social_meta', 'social_meta', 'Social Meta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_url field
            //
            $column = new TextViewColumn('listing_url', 'listing_url', 'Listing Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for start_time field
            //
            $column = new DateTimeViewColumn('start_time', 'start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for end_time field
            //
            $column = new DateTimeViewColumn('end_time', 'end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for deployed_by field
            //
            $column = new TextViewColumn('deployed_by', 'deployed_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for deployed_date field
            //
            $column = new DateTimeViewColumn('deployed_date', 'deployed_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_content field
            //
            $column = new TextViewColumn('listing_content', 'listing_content', 'Listing Content', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('listing_cta', 'listing_cta_description', 'CTA on Button', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_banner field
            //
            $column = new TextViewColumn('listing_banner', 'listing_banner', 'Banner URL', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_SEO_title field
            //
            $column = new TextViewColumn('listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_SEO_keywords field
            //
            $column = new TextViewColumn('listing_SEO_keywords', 'listing_SEO_keywords', 'Listing SEO Keywords', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for social_meta field
            //
            $column = new TextViewColumn('social_meta', 'social_meta', 'Social Meta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_url field
            //
            $column = new TextViewColumn('listing_url', 'listing_url', 'Listing Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalSingleRecordView() { return true; }
        
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
    
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
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setDescription('<div class="mark-media mark-position-relative">
                          <div class="mark-bd-placeholder-img mr-3"><img src="apps/icons/website-list-color.png" width="80" height="79"></div>
                          <div class="mark-media-body">
                            <h5 class="mt-0 h5">What will you find here</h5>
                            <p class="mark-p">Through the campaign builder an automated entry has been entered for the Event Type selected.</p>
                            <a href="http://mktportal.mscsoftware.com/apps/website_listing.php" class="stretched-link">View Live Lists</a>
                          </div>
                        </div>');
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
            $grid->SetEditClientEditorValueChangedScript('console.log(sender);
            if (sender.getFieldName() == \'language\'){
              console.log(sender.getValue());
              editors[\'language\'].enabled(sender.getValue() == \'1\');
            
              if (sender.getValue() == \'1\') { 
                 editors[\'m_ID\'].setValue(\'1012\');
                 $(\'#m_ID\').setRequired(true);
              }
              else{
                 $(\'#m_ID\').setVisible.true();
                 $(\'#m_ID\').setRequired(true);
              }
            }');
            
            $grid->SetEditClientFormLoadedScript('if (editors[\'language\'].getValue() == \'1\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1010\');
                  editors[\'m_ID\'].setEnabled(false);
               } 
            }
            else if (editors[\'language\'].getValue() == \'2\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1011\');
                  editors[\'m_ID\'].setEnabled(false);
               }
            }
            else if (editors[\'language\'].getValue() == \'3\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1013\');
                  editors[\'m_ID\'].setEnabled(false);
               }   
            }
            else if (editors[\'language\'].getValue() == \'4\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1014\');
                  editors[\'m_ID\'].setEnabled(false);
               }   
            }
            else if (editors[\'language\'].getValue() == \'5\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1015\');
                  editors[\'m_ID\'].setEnabled(false);
               }  
            }
            else if (editors[\'language\'].getValue() == \'6\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1016\');
                  editors[\'m_ID\'].setEnabled(false);
               }  
            }
            else if (editors[\'language\'].getValue() == \'7\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1017\');
                  editors[\'m_ID\'].setEnabled(false);
               }   
            }
            else if (editors[\'language\'].getValue() == \'8\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1018\');
                  editors[\'m_ID\'].setEnabled(false);
               }  
            }
            else if (editors[\'language\'].getValue() == \'9\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1019\');
                  editors[\'m_ID\'].setEnabled(false);
               }   
            }
            else if (editors[\'language\'].getValue() == \'10\') {
               if (editors[\'event_type\'].getValue() == \'13\') {
                  editors[\'m_ID\'].setValue(\'1012\');
                  editors[\'m_ID\'].setEnabled(false); 
               }
               else {
                  editors[\'m_ID\'].setValue(\'1020\');
                  editors[\'m_ID\'].setEnabled(false);
               }   
            }
            else {
                  editors[\'m_ID\'].setValue(\'1021\');
                  editors[\'m_ID\'].setEnabled(false);   
            }');
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_website_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_website_langauge_search', 'language_id', 'langauge', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Event_website_listing=\'1\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_website_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'website_listing\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_website_deploy_website_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_website_listing_cta_search', 'description', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_website_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_website_langauge_search', 'language_id', 'langauge', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Event_website_listing=\'1\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_website_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'website_listing\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_website_deploy_website_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_website_listing_cta_search', 'description', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_website_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_website_langauge_search', 'language_id', 'langauge', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Event_website_listing=\'1\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_website_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'website_listing\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_website_deploy_website_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_website_listing_cta_search', 'description', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_website_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_website_langauge_search', 'language_id', 'langauge', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Event_website_listing=\'1\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_website_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'website_listing\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_website_deploy_website_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_website_listing_cta_search', 'description', 'description', null, 20);
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
            if ($success) {
            
              // Check if record data was modified
            
              $dataMofified  = 
            
            	$oldRowData['langauge'] !== $rowData['langauge'] ||
            	$oldRowData['event_type'] !== $rowData['event_type'] ||
            	$oldRowData['deploy_website_status'] !== $rowData['deploy_website_status'];
            	
            	
              if ($dataMofified) {
            
                    $sprogram_generator_name_id = $rowData['program_generator_name_id'];
                    $trackerid = $rowData['trackerid'];
                    $event_type = $rowData['event_type'];                
            
                  
               
               if ($event_type !== '8' || $event_type !== '18') {   
            
               $sql = 
            
                  "CALL campaignTacticWebsiteListingMID($sprogram_generator_name_id, $trackerid);";
                  $this->GetConnection()->ExecSQL($sql);
               }
               
                  $message = '<p>Record processed successfully</p>';
                  
              }                                    
            }
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
                
                $briefGroup = $layout->addGroup('Request Overview', 12);
                $briefGroup->addRow()->addCol($columns['program_generator_name_id'], 12);
                $briefGroup->addRow()->addCol($columns['deployed_by'], 12);
                $briefGroup->addRow()->addCol($columns['deployed_date'], 12);
                 
                $storageGroup = $layout->addGroup('Page Content', 12);
                $storageGroup->addRow()
                    ->addCol($columns['listing_title'], 12);
                $storageGroup->addRow()
                    ->addCol($columns['listing_content'], 12);
                $storageGroup->addRow()
                    ->addCol($columns['listing_url'], 12);
                $storageGroup->addRow()
                    ->addCol($columns['listing_banner'], 12);
                $storageGroup->addRow()
                    ->addCol($columns['listing_SEO_title'], 12);
                $storageGroup->addRow()
                    ->addCol($columns['listing_SEO_keywords'], 12);
                $storageGroup->addRow()
                    ->addCol($columns['social_meta'], 12);
                $storageGroup->addRow()
                    ->addCol($columns['listing_cta'], 6)
                    ->addCol($columns['m_ID'], 6);   
            
                
                $storageGroup = $layout->addGroup('Display Status', 12);
                $storageGroup->addRow()
                    ->addCol($columns['deploy_website_status'], 8)
                    ->addCol($columns['deploy_website'], 4);   
                $storageGroup->addRow()
                    ->addCol($columns['event_type'], 8)
                    ->addCol($columns['langauge'], 4);
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
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    class campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_idModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $this->dataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for master_campaign_id field
            //
            $column = new NumberViewColumn('master_campaign_id', 'master_campaign_id', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for event_type field
            //
            $column = new NumberViewColumn('event_type', 'event_type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for sub_region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for territory field
            //
            $column = new TextViewColumn('territory', 'territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for emails_tracker field
            //
            $column = new NumberViewColumn('emails_tracker', 'emails_tracker', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for trackerid field
            //
            $column = new TextViewColumn('trackerid', 'trackerid', 'Trackerid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pregion field
            //
            $column = new TextViewColumn('pregion', 'pregion', 'Pregion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for import_total field
            //
            $column = new NumberViewColumn('import_total', 'import_total', 'Import Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for create_import_list field
            //
            $column = new NumberViewColumn('create_import_list', 'create_import_list', 'Create Import List', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_event_id field
            //
            $column = new NumberViewColumn('campaign_event_id', 'campaign_event_id', 'Campaign Event Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_time_start field
            //
            $column = new DateTimeViewColumn('campaign_time_start', 'campaign_time_start', 'Campaign Time Start', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_time_end field
            //
            $column = new DateTimeViewColumn('campaign_time_end', 'campaign_time_end', 'Campaign Time End', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for webinar_tracker field
            //
            $column = new NumberViewColumn('webinar_tracker', 'webinar_tracker', 'Webinar Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date_end field
            //
            $column = new DateTimeViewColumn('campaign_publish_date_end', 'campaign_publish_date_end', 'Campaign Publish Date End', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expired field
            //
            $column = new NumberViewColumn('expired', 'expired', 'Expired', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
    
        static public function getHandlerName() {
            return get_class() . '_modal_view';
        }
    
        public function GetModalGridViewHandler() {
            return self::getHandlerName();
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    }
    
    class campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $selectQuery = 'SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_utm_filtered');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new StringField('utm_created')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_utm_id field
            //
            $column = new NumberViewColumn('campaign_utm_id', 'campaign_utm_id', 'Campaign Utm Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for utm_created field
            //
            $column = new TextViewColumn('utm_created', 'utm_created', 'Utm Created', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
    
        static public function getHandlerName() {
            return get_class() . '_modal_view';
        }
    
        public function GetModalGridViewHandler() {
            return self::getHandlerName();
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    }
    
    class campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idNestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $selectQuery = 'SELECT campaign_utm_id,
            CONCAT(`campaign_name`, \' [ \',`content`,\' - \',`campaign_publish_date`, \' \',`created_by`,\' ]\') as utm_created
            FROM `marketing_portal_v2`.`campaign_tracker_utm`
            WHERE campaign_publish_date IS NOT NULL';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_utm_filtered');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new StringField('utm_created')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for utm_created field
            //
            $editor = new TextEdit('utm_created_edit');
            $editColumn = new CustomEditColumn('Utm Created', 'utm_created', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
       static public function getNestedInsertHandlerName()
        {
            return get_class() . '_form_insert';
        }
    
        public function GetGridInsertHandler()
        {
            return self::getNestedInsertHandlerName();
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
    }
    
    class campaign_program_name_generator_master_campaign_idModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $this->dataset->addFields(
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_type field
            //
            $column = new NumberViewColumn('campaign_type', 'campaign_type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_tier field
            //
            $column = new NumberViewColumn('campaign_tier', 'campaign_tier', 'Campaign Tier', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for channel_types field
            //
            $column = new TextViewColumn('channel_types', 'channel_types', 'Channel Types', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_status field
            //
            $column = new NumberViewColumn('campaign_status', 'campaign_status', 'Campaign Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for event_type field
            //
            $column = new NumberViewColumn('event_type', 'event_type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for b_region field
            //
            $column = new TextViewColumn('b_region', 'b_region', 'B Region', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for b_country field
            //
            $column = new TextViewColumn('b_country', 'b_country', 'B Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for est_opportunity_value_in_euros field
            //
            $column = new NumberViewColumn('est_opportunity_value_in_euros', 'est_opportunity_value_in_euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_cost field
            //
            $column = new NumberViewColumn('campaign_cost', 'campaign_cost', 'Campaign Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expected_roi_enquiries field
            //
            $column = new NumberViewColumn('expected_roi_enquiries', 'expected_roi_enquiries', 'Expected Roi Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expected_roi_ots field
            //
            $column = new NumberViewColumn('expected_roi_ots', 'expected_roi_ots', 'Expected Roi Ots', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for post_enquiries field
            //
            $column = new NumberViewColumn('post_enquiries', 'post_enquiries', 'Post Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for new_opportunities field
            //
            $column = new NumberViewColumn('new_opportunities', 'new_opportunities', 'New Opportunities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for owner_person field
            //
            $column = new TextViewColumn('owner_person', 'owner_person', 'Owner Person', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'File Upload', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Asset Upload', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for updated_by field
            //
            $column = new TextViewColumn('updated_by', 'updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for updated_date field
            //
            $column = new DateTimeViewColumn('updated_date', 'updated_date', 'Updated Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
    
        static public function getHandlerName() {
            return get_class() . '_modal_view';
        }
    
        public function GetModalGridViewHandler() {
            return self::getHandlerName();
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class campaign_program_name_generatorPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Campaign Builder');
            $this->SetMenuLabel('Campaign Builder');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $this->dataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
            $this->dataset->AddLookupField('campaign_event_id', 'campaign_events', new IntegerField('campaign_event_id'), new StringField('Event_Name', false, false, false, false, 'campaign_event_id_Event_Name', 'campaign_event_id_Event_Name_campaign_events'), 'campaign_event_id_Event_Name_campaign_events');
            $this->dataset->AddLookupField('campaign_type', 'lookup_campaign_type', new StringField('Type_Value'), new StringField('Type', false, false, false, false, 'campaign_type_Type', 'campaign_type_Type_lookup_campaign_type'), 'campaign_type_Type_lookup_campaign_type');
            $this->dataset->AddLookupField('event_type', 'lookup_event_type', new IntegerField('Event_Type_ID'), new StringField('Event_Type', false, false, false, false, 'event_type_Event_Type', 'event_type_Event_Type_lookup_event_type'), 'event_type_Event_Type_lookup_event_type');
            $this->dataset->AddLookupField('pregion', 'lookup_region', new StringField('Region_Value'), new StringField('Region', false, false, false, false, 'pregion_Region', 'pregion_Region_lookup_region'), 'pregion_Region_lookup_region');
            $this->dataset->AddLookupField('sub_region', 'lookup_sub_regions', new StringField('Sub_Region_Value'), new StringField('Sub_Region', false, false, false, false, 'sub_region_Sub_Region', 'sub_region_Sub_Region_lookup_sub_regions'), 'sub_region_Sub_Region_lookup_sub_regions');
            $this->dataset->AddLookupField('territory', 'lookup_territory', new StringField('Territory_Value'), new StringField('Territory', false, false, false, false, 'territory_Territory', 'territory_Territory_lookup_territory'), 'territory_Territory_lookup_territory');
            $this->dataset->AddLookupField('emails_tracker', 'lookup_email_tracker', new IntegerField('qty'), new StringField('email_tracker_description', false, false, false, false, 'emails_tracker_email_tracker_description', 'emails_tracker_email_tracker_description_lookup_email_tracker'), 'emails_tracker_email_tracker_description_lookup_email_tracker');
            $this->dataset->AddLookupField('webinar_tracker', 'lookup_webcast_tracker', new IntegerField('qty'), new StringField('webcast_tracker_description', false, false, false, false, 'webinar_tracker_webcast_tracker_description', 'webinar_tracker_webcast_tracker_description_lookup_webcast_tracker'), 'webinar_tracker_webcast_tracker_description_lookup_webcast_tracker');
            if (!$this->GetSecurityInfo()->HasAdminGrant()) {
                $this->dataset->setRlsPolicy(new RlsPolicy('created_by', GetApplication()->GetCurrentUserId()));
            }
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
            $partitionNavigator->SetRowsPerPage(10);
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
                new FilterColumn($this->dataset, 'program_generator_name_id', 'program_generator_name_id', 'Program Generator Name Id'),
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request'),
                new FilterColumn($this->dataset, 'campaign_event_id', 'campaign_event_id_Event_Name', 'Campaign Event'),
                new FilterColumn($this->dataset, 'trackerid', 'trackerid', 'Trackerid'),
                new FilterColumn($this->dataset, 'campaign_program_name', 'campaign_program_name', 'Campaign Program Name'),
                new FilterColumn($this->dataset, 'SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Campaign Name'),
                new FilterColumn($this->dataset, 'campaign_type', 'campaign_type_Type', 'Campaign Type'),
                new FilterColumn($this->dataset, 'event_type', 'event_type_Event_Type', 'Event Type'),
                new FilterColumn($this->dataset, 'short_description', 'short_description', 'Short Description'),
                new FilterColumn($this->dataset, 'pregion', 'pregion_Region', 'Region'),
                new FilterColumn($this->dataset, 'sub_region', 'sub_region_Sub_Region', 'Sub Region'),
                new FilterColumn($this->dataset, 'territory', 'territory_Territory', 'Territory'),
                new FilterColumn($this->dataset, 'country', 'country', 'Country'),
                new FilterColumn($this->dataset, 'industry', 'industry', 'Industry'),
                new FilterColumn($this->dataset, 'job_function', 'job_function', 'Job Function'),
                new FilterColumn($this->dataset, 'product', 'product', 'Product'),
                new FilterColumn($this->dataset, 'm_ID', 'm_ID', 'Form ID'),
                new FilterColumn($this->dataset, 'import_total', 'import_total', 'Import Total'),
                new FilterColumn($this->dataset, 'create_import_list', 'create_import_list', 'Create Import List'),
                new FilterColumn($this->dataset, 'campaign_publish_date', 'campaign_publish_date', 'Start Date'),
                new FilterColumn($this->dataset, 'campaign_publish_date_end', 'campaign_publish_date_end', 'End Date'),
                new FilterColumn($this->dataset, 'campaign_time_start', 'campaign_time_start', 'Start Time'),
                new FilterColumn($this->dataset, 'campaign_time_end', 'campaign_time_end', 'End Time'),
                new FilterColumn($this->dataset, 'emails_tracker', 'emails_tracker_email_tracker_description', 'Emails Tracker'),
                new FilterColumn($this->dataset, 'webinar_tracker', 'webinar_tracker_webcast_tracker_description', 'Webinar Tracker'),
                new FilterColumn($this->dataset, 'created_by', 'created_by', 'Created By'),
                new FilterColumn($this->dataset, 'created_date', 'created_date', 'Created Date'),
                new FilterColumn($this->dataset, 'modified_by', 'modified_by', 'Modified By'),
                new FilterColumn($this->dataset, 'modified_date', 'modified_date', 'Modified Date'),
                new FilterColumn($this->dataset, 'expired', 'expired', 'Active Campaigns')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['master_campaign_id'])
                ->addColumn($columns['campaign_event_id'])
                ->addColumn($columns['campaign_program_name'])
                ->addColumn($columns['SFDC_child_campaign'])
                ->addColumn($columns['campaign_type'])
                ->addColumn($columns['event_type'])
                ->addColumn($columns['short_description'])
                ->addColumn($columns['pregion'])
                ->addColumn($columns['sub_region'])
                ->addColumn($columns['territory'])
                ->addColumn($columns['country'])
                ->addColumn($columns['industry'])
                ->addColumn($columns['job_function'])
                ->addColumn($columns['product'])
                ->addColumn($columns['m_ID'])
                ->addColumn($columns['import_total'])
                ->addColumn($columns['create_import_list'])
                ->addColumn($columns['campaign_publish_date'])
                ->addColumn($columns['campaign_publish_date_end'])
                ->addColumn($columns['campaign_time_start'])
                ->addColumn($columns['campaign_time_end'])
                ->addColumn($columns['emails_tracker'])
                ->addColumn($columns['webinar_tracker'])
                ->addColumn($columns['created_by'])
                ->addColumn($columns['created_date'])
                ->addColumn($columns['modified_by'])
                ->addColumn($columns['modified_date']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('campaign_type')
                ->setOptionsFor('pregion')
                ->setOptionsFor('campaign_publish_date')
                ->setOptionsFor('campaign_publish_date_end')
                ->setOptionsFor('emails_tracker')
                ->setOptionsFor('created_by');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_master_campaign_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('master_campaign_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_master_campaign_id_search');
            
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
            
            $main_editor = new DynamicCombobox('campaign_event_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_event_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('campaign_event_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_event_id_search');
            
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
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('campaign_program_name_edit');
            $main_editor->SetPlaceholder('[ System generated Marketo campaign name ]');
            
            $filterBuilder->addColumn(
                $columns['campaign_program_name'],
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
            
            $main_editor = new TextEdit('sfdc_child_campaign_edit');
            $main_editor->SetMaxLength(50);
            $main_editor->SetPlaceholder('[ System generated SFDC campaign ]');
            
            $filterBuilder->addColumn(
                $columns['SFDC_child_campaign'],
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
            
            $main_editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('campaign_type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_type_search');
            
            $text_editor = new TextEdit('campaign_type');
            
            $filterBuilder->addColumn(
                $columns['campaign_type'],
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
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_event_type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('event_type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_event_type_search');
            
            $filterBuilder->addColumn(
                $columns['event_type'],
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
            
            $main_editor = new AutocompleteEditor('short_description_edit', $this->CreateLinkBuilder(), 'filter_builder_campaign_program_name_generator_short_description_ac');
            $main_editor->SetMaxLength(45);
            $main_editor->setMinimumInputLength(4);
            
            $filterBuilder->addColumn(
                $columns['short_description'],
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
            
            $main_editor = new DynamicCombobox('pregion_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_pregion_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('pregion', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_pregion_search');
            
            $text_editor = new TextEdit('pregion');
            
            $filterBuilder->addColumn(
                $columns['pregion'],
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
            
            $main_editor = new DynamicCombobox('sub_region_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_sub_region_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('sub_region', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_sub_region_search');
            
            $text_editor = new TextEdit('sub_region');
            
            $filterBuilder->addColumn(
                $columns['sub_region'],
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
            
            $main_editor = new DynamicCombobox('territory_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_territory_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('territory', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_territory_search');
            
            $text_editor = new TextEdit('territory');
            
            $filterBuilder->addColumn(
                $columns['territory'],
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
            
            $main_editor = new RemoteMultiValueSelect('country_edit', $this->CreateLinkBuilder());
            $main_editor->SetHandlerName('filter_builder_country_2_ISO_Country_Name_search');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('country');
            
            $filterBuilder->addColumn(
                $columns['country'],
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
            
            $main_editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $main_editor->SetHandlerName('filter_builder_industry_Industry_ID_Industry_Name_search');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('industry');
            
            $filterBuilder->addColumn(
                $columns['industry'],
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
            
            $main_editor = new RemoteMultiValueSelect('job_function_edit', $this->CreateLinkBuilder());
            $main_editor->SetHandlerName('filter_builder_job_function_Job_Functions_ID_Job Function_search');
            $main_editor->setMaxSelectionSize(0);
            
            $filterBuilder->addColumn(
                $columns['job_function'],
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
            
            $main_editor = new RemoteMultiValueSelect('product_edit', $this->CreateLinkBuilder());
            $main_editor->SetHandlerName('filter_builder_product_Product_Value_Product_search');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('product');
            
            $filterBuilder->addColumn(
                $columns['product'],
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
            
            $main_editor = new TextEdit('m_id_edit');
            $main_editor->SetMaxLength(11);
            
            $filterBuilder->addColumn(
                $columns['m_ID'],
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
            
            $main_editor = new TextEdit('import_total_edit');
            
            $filterBuilder->addColumn(
                $columns['import_total'],
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
            
            $main_editor = new ComboBox('create_import_list');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice('1', 'Yes, Create Import Report');
            $main_editor->addChoice('0', 'No');
            
            $multi_value_select_editor = new MultiValueSelect('create_import_list');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $filterBuilder->addColumn(
                $columns['create_import_list'],
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
            
            $main_editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['campaign_publish_date'],
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
            
            $main_editor = new DateTimeEdit('campaign_publish_date_end_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['campaign_publish_date_end'],
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
            
            $main_editor = new TimeEdit('campaign_time_start_edit', 'H:i:s');
            
            $filterBuilder->addColumn(
                $columns['campaign_time_start'],
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
            
            $main_editor = new TimeEdit('campaign_time_end_edit', 'H:i:s');
            
            $filterBuilder->addColumn(
                $columns['campaign_time_end'],
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
            
            $main_editor = new DynamicCombobox('emails_tracker_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_emails_tracker_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('emails_tracker', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_emails_tracker_search');
            
            $filterBuilder->addColumn(
                $columns['emails_tracker'],
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
            
            $main_editor = new DynamicCombobox('webinar_tracker_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_webinar_tracker_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('webinar_tracker', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_webinar_tracker_search');
            
            $filterBuilder->addColumn(
                $columns['webinar_tracker'],
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
            
            $main_editor = new TextEdit('created_by_edit');
            
            $filterBuilder->addColumn(
                $columns['created_by'],
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
                $columns['created_date'],
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
            
            $main_editor = new TextEdit('modified_by_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['modified_by'],
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
            
            $main_editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['modified_date'],
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
            
            $main_editor = new TextEdit('expired_edit');
            
            $filterBuilder->addColumn(
                $columns['expired'],
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
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionsForPage('campaign_program_name_generator.campaign_tracker_comms_local')->HasViewGrant() && $withDetails)
            {
            //
            // View column for campaign_program_name_generator_campaign_tracker_comms_local detail
            //
            $column = new DetailColumn(array('program_generator_name_id'), 'campaign_program_name_generator.campaign_tracker_comms_local', 'campaign_program_name_generator_campaign_tracker_comms_local_handler', $this->dataset, 'Comms Tracker');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('campaign_program_name_generator.campaign_tracker_webcast')->HasViewGrant() && $withDetails)
            {
            //
            // View column for campaign_program_name_generator_campaign_tracker_webcast detail
            //
            $column = new DetailColumn(array('program_generator_name_id'), 'campaign_program_name_generator.campaign_tracker_webcast', 'campaign_program_name_generator_campaign_tracker_webcast_handler', $this->dataset, 'Webcast Tracker');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('campaign_program_name_generator.campaign_tracker_website')->HasViewGrant() && $withDetails)
            {
            //
            // View column for campaign_program_name_generator_campaign_tracker_website detail
            //
            $column = new DetailColumn(array('program_generator_name_id'), 'campaign_program_name_generator.campaign_tracker_website', 'campaign_program_name_generator_campaign_tracker_website_handler', $this->dataset, 'Website Display Tracker');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->setNullLabel('No Information ');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('pregion', 'pregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_publish_date_end field
            //
            $column = new DateTimeViewColumn('campaign_publish_date_end', 'campaign_publish_date_end', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for email_tracker_description field
            //
            $column = new TextViewColumn('emails_tracker', 'emails_tracker_email_tracker_description', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
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
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_program_name_generator_master_campaign_idModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('campaign_event_id', 'campaign_event_id_Event_Name', 'Campaign Event', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Campaign Name', $this->dataset);
            $column->setNullLabel('[SFDC Campaign Required]');
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->setNullLabel('No Information ');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('pregion', 'pregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region_Sub_Region', 'Sub Region', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for import_total field
            //
            $column = new NumberViewColumn('import_total', 'import_total', 'Import Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for create_import_list field
            //
            $column = new NumberViewColumn('create_import_list', 'create_import_list', 'Create Import List', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date_end field
            //
            $column = new DateTimeViewColumn('campaign_publish_date_end', 'campaign_publish_date_end', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_time_start field
            //
            $column = new DateTimeViewColumn('campaign_time_start', 'campaign_time_start', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_time_end field
            //
            $column = new DateTimeViewColumn('campaign_time_end', 'campaign_time_end', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for email_tracker_description field
            //
            $column = new TextViewColumn('emails_tracker', 'emails_tracker_email_tracker_description', 'How many emails will you be sending?', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for webcast_tracker_description field
            //
            $column = new TextViewColumn('webinar_tracker', 'webinar_tracker_webcast_tracker_description', 'Webinar Tracker', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expired field
            //
            $column = new NumberViewColumn('expired', 'expired', 'Active Campaigns', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Do you have brief request?', 'master_campaign_id', 'master_campaign_id_campaign_name', 'edit_campaign_program_name_generator_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_event_id field
            //
            $editor = new DynamicCombobox('campaign_event_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_events`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_event_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('program_generator_name_id'),
                    new StringField('trackerid'),
                    new StringField('Event_Name'),
                    new StringField('eRegion'),
                    new StringField('Country'),
                    new StringField('Website'),
                    new StringField('Venue'),
                    new StringField('City'),
                    new IntegerField('Event_status'),
                    new IntegerField('Approval'),
                    new IntegerField('Event_Type'),
                    new IntegerField('Business_Responsible'),
                    new StringField('Owner_Person'),
                    new StringField('Brands_Attending'),
                    new DateTimeField('Start_Date'),
                    new DateTimeField('End_Date'),
                    new StringField('Objective'),
                    new IntegerField('Expected_ROI_OTS'),
                    new IntegerField('Expected_ROI_Enquiries'),
                    new IntegerField('Post_Enquiries'),
                    new IntegerField('New_Opportunities'),
                    new IntegerField('Est_Opportunity_value_in_Euros'),
                    new IntegerField('Industry'),
                    new IntegerField('Strategic_Campaign'),
                    new StringField('Short_Description'),
                    new IntegerField('Event_Cost'),
                    new IntegerField('Planned_Booth_Area'),
                    new StringField('Created_by'),
                    new StringField('Created_Date'),
                    new StringField('Updated_by'),
                    new StringField('Updated_Date'),
                    new StringField('Marketo_Campaign'),
                    new StringField('Banner'),
                    new StringField('Publish_Live'),
                    new DateField('Publish_Live_Date'),
                    new StringField('Event_Title'),
                    new StringField('SEO_Title'),
                    new StringField('finyear_date'),
                    new StringField('finmonth_date'),
                    new IntegerField('show_events_cal'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Event_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Do you have an associated Event to link?', 'campaign_event_id', 'campaign_event_id_Event_Name', 'edit_campaign_program_name_generator_campaign_event_id_search', $editor, $this->dataset, $lookupDataset, 'campaign_event_id', 'Event_Name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_program_name field
            //
            $editor = new TextEdit('campaign_program_name_edit');
            $editor->SetPlaceholder('[ System generated Marketo campaign name ]');
            $editColumn = new CustomEditColumn('Campaign Program Name', 'campaign_program_name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for SFDC_child_campaign field
            //
            $editor = new TextEdit('sfdc_child_campaign_edit');
            $editor->SetMaxLength(50);
            $editor->SetPlaceholder('[ System generated SFDC campaign ]');
            $editColumn = new CustomEditColumn('SFDC Campaign Name', 'SFDC_child_campaign', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_type field
            //
            $editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Type', 'campaign_type', 'campaign_type_Type', 'edit_campaign_program_name_generator_campaign_type_search', $editor, $this->dataset, $lookupDataset, 'Type_Value', 'Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for event_type field
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
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'edit_campaign_program_name_generator_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for short_description field
            //
            $editor = new AutocompleteEditor('short_description_edit', $this->CreateLinkBuilder(), 'edit_campaign_program_name_generator_short_description_ac');
            $editor->SetMaxLength(45);
            $editor->setMinimumInputLength(4);
            $editColumn = new CustomEditColumn('Short Description', 'short_description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for pregion field
            //
            $editor = new DynamicCombobox('pregion_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'pregion', 'pregion_Region', 'edit_campaign_program_name_generator_pregion_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for sub_region field
            //
            $editor = new DynamicCombobox('sub_region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sub Region', 'sub_region', 'sub_region_Sub_Region', 'edit_campaign_program_name_generator_sub_region_search', $editor, $this->dataset, $lookupDataset, 'Sub_Region_Value', 'Sub_Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for territory field
            //
            $editor = new ComboBox('territory_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $editColumn = new LookUpEditColumn(
                'Territory', 
                'territory', 
                $editor, 
                $this->dataset, 'Territory_Value', 'Territory', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for country field
            //
            $editor = new RemoteMultiValueSelect('country_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('edit_country_2_ISO_Country_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Country', 'country', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('edit_industry_Industry_ID_Industry_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Industry', 'industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for job_function field
            //
            $editor = new RemoteMultiValueSelect('job_function_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('edit_job_function_Job_Functions_ID_Job Function_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Job Function', 'job_function', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new RemoteMultiValueSelect('product_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('edit_product_Product_Value_Product_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Product', 'product', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Form ID', 'm_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for import_total field
            //
            $editor = new TextEdit('import_total_edit');
            $editColumn = new CustomEditColumn('Import Total', 'import_total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for create_import_list field
            //
            $editor = new RadioEdit('create_import_list_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('1', 'Yes, Create Import Report');
            $editor->addChoice('0', 'No');
            $editColumn = new CustomEditColumn('Create Import List', 'create_import_list', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Start Date', 'campaign_publish_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date_end field
            //
            $editor = new DateTimeEdit('campaign_publish_date_end_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('End Date', 'campaign_publish_date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_time_start field
            //
            $editor = new TimeEdit('campaign_time_start_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Start Time', 'campaign_time_start', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_time_end field
            //
            $editor = new TimeEdit('campaign_time_end_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('End Time', 'campaign_time_end', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for emails_tracker field
            //
            $editor = new DynamicCombobox('emails_tracker_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $editColumn = new DynamicLookupEditColumn('How many emails will you be sending?', 'emails_tracker', 'emails_tracker_email_tracker_description', 'edit_campaign_program_name_generator_emails_tracker_search', $editor, $this->dataset, $lookupDataset, 'qty', 'email_tracker_description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for webinar_tracker field
            //
            $editor = new DynamicCombobox('webinar_tracker_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_webcast_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_webcast_tracker_id', true, true, true),
                    new StringField('webcast_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $lookupDataset->setOrderByField('webcast_tracker_description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Webinar Tracker', 'webinar_tracker', 'webinar_tracker_webcast_tracker_description', 'edit_campaign_program_name_generator_webinar_tracker_search', $editor, $this->dataset, $lookupDataset, 'qty', 'webcast_tracker_description', '');
            $editColumn->SetAllowSetToNull(true);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brief Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'multi_edit_campaign_program_name_generator_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_event_id field
            //
            $editor = new DynamicCombobox('campaign_event_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_events`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_event_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('program_generator_name_id'),
                    new StringField('trackerid'),
                    new StringField('Event_Name'),
                    new StringField('eRegion'),
                    new StringField('Country'),
                    new StringField('Website'),
                    new StringField('Venue'),
                    new StringField('City'),
                    new IntegerField('Event_status'),
                    new IntegerField('Approval'),
                    new IntegerField('Event_Type'),
                    new IntegerField('Business_Responsible'),
                    new StringField('Owner_Person'),
                    new StringField('Brands_Attending'),
                    new DateTimeField('Start_Date'),
                    new DateTimeField('End_Date'),
                    new StringField('Objective'),
                    new IntegerField('Expected_ROI_OTS'),
                    new IntegerField('Expected_ROI_Enquiries'),
                    new IntegerField('Post_Enquiries'),
                    new IntegerField('New_Opportunities'),
                    new IntegerField('Est_Opportunity_value_in_Euros'),
                    new IntegerField('Industry'),
                    new IntegerField('Strategic_Campaign'),
                    new StringField('Short_Description'),
                    new IntegerField('Event_Cost'),
                    new IntegerField('Planned_Booth_Area'),
                    new StringField('Created_by'),
                    new StringField('Created_Date'),
                    new StringField('Updated_by'),
                    new StringField('Updated_Date'),
                    new StringField('Marketo_Campaign'),
                    new StringField('Banner'),
                    new StringField('Publish_Live'),
                    new DateField('Publish_Live_Date'),
                    new StringField('Event_Title'),
                    new StringField('SEO_Title'),
                    new StringField('finyear_date'),
                    new StringField('finmonth_date'),
                    new IntegerField('show_events_cal'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Event_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Event', 'campaign_event_id', 'campaign_event_id_Event_Name', 'multi_edit_campaign_program_name_generator_campaign_event_id_search', $editor, $this->dataset, $lookupDataset, 'campaign_event_id', 'Event_Name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_program_name field
            //
            $editor = new TextEdit('campaign_program_name_edit');
            $editor->SetPlaceholder('[ System generated Marketo campaign name ]');
            $editColumn = new CustomEditColumn('Campaign Program Name', 'campaign_program_name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for SFDC_child_campaign field
            //
            $editor = new TextEdit('sfdc_child_campaign_edit');
            $editor->SetMaxLength(50);
            $editor->SetPlaceholder('[ System generated SFDC campaign ]');
            $editColumn = new CustomEditColumn('SFDC Campaign Name', 'SFDC_child_campaign', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_type field
            //
            $editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Type', 'campaign_type', 'campaign_type_Type', 'multi_edit_campaign_program_name_generator_campaign_type_search', $editor, $this->dataset, $lookupDataset, 'Type_Value', 'Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for event_type field
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
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'multi_edit_campaign_program_name_generator_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for short_description field
            //
            $editor = new AutocompleteEditor('short_description_edit', $this->CreateLinkBuilder(), 'multi_edit_campaign_program_name_generator_short_description_ac');
            $editor->SetMaxLength(45);
            $editor->setMinimumInputLength(4);
            $editColumn = new CustomEditColumn('Short Description', 'short_description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for pregion field
            //
            $editor = new DynamicCombobox('pregion_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'pregion', 'pregion_Region', 'multi_edit_campaign_program_name_generator_pregion_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for sub_region field
            //
            $editor = new DynamicCombobox('sub_region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sub Region', 'sub_region', 'sub_region_Sub_Region', 'multi_edit_campaign_program_name_generator_sub_region_search', $editor, $this->dataset, $lookupDataset, 'Sub_Region_Value', 'Sub_Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for territory field
            //
            $editor = new ComboBox('territory_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $editColumn = new LookUpEditColumn(
                'Territory', 
                'territory', 
                $editor, 
                $this->dataset, 'Territory_Value', 'Territory', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for country field
            //
            $editor = new RemoteMultiValueSelect('country_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('multi_edit_country_2_ISO_Country_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Country', 'country', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('multi_edit_industry_Industry_ID_Industry_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Industry', 'industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for job_function field
            //
            $editor = new RemoteMultiValueSelect('job_function_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('multi_edit_job_function_Job_Functions_ID_Job Function_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Job Function', 'job_function', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new RemoteMultiValueSelect('product_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('multi_edit_product_Product_Value_Product_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Product', 'product', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Form ID', 'm_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for import_total field
            //
            $editor = new TextEdit('import_total_edit');
            $editColumn = new CustomEditColumn('Import Total', 'import_total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for create_import_list field
            //
            $editor = new RadioEdit('create_import_list_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('1', 'Yes, Create Import Report');
            $editor->addChoice('0', 'No');
            $editColumn = new CustomEditColumn('Create Import List', 'create_import_list', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Start Date', 'campaign_publish_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date_end field
            //
            $editor = new DateTimeEdit('campaign_publish_date_end_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('End Date', 'campaign_publish_date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_time_start field
            //
            $editor = new TimeEdit('campaign_time_start_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Start Time', 'campaign_time_start', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_time_end field
            //
            $editor = new TimeEdit('campaign_time_end_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('End Time', 'campaign_time_end', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for emails_tracker field
            //
            $editor = new DynamicCombobox('emails_tracker_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $editColumn = new DynamicLookupEditColumn('Emails Tracker', 'emails_tracker', 'emails_tracker_email_tracker_description', 'multi_edit_campaign_program_name_generator_emails_tracker_search', $editor, $this->dataset, $lookupDataset, 'qty', 'email_tracker_description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for webinar_tracker field
            //
            $editor = new DynamicCombobox('webinar_tracker_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_webcast_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_webcast_tracker_id', true, true, true),
                    new StringField('webcast_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $lookupDataset->setOrderByField('webcast_tracker_description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Webinar Tracker', 'webinar_tracker', 'webinar_tracker_webcast_tracker_description', 'multi_edit_campaign_program_name_generator_webinar_tracker_search', $editor, $this->dataset, $lookupDataset, 'qty', 'webcast_tracker_description', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editColumn = new CustomEditColumn('Created By', 'created_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for created_date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'created_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for expired field
            //
            $editor = new TextEdit('expired_edit');
            $editColumn = new CustomEditColumn('Active Campaigns', 'expired', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brief Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'insert_campaign_program_name_generator_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_event_id field
            //
            $editor = new DynamicCombobox('campaign_event_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_events`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_event_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('program_generator_name_id'),
                    new StringField('trackerid'),
                    new StringField('Event_Name'),
                    new StringField('eRegion'),
                    new StringField('Country'),
                    new StringField('Website'),
                    new StringField('Venue'),
                    new StringField('City'),
                    new IntegerField('Event_status'),
                    new IntegerField('Approval'),
                    new IntegerField('Event_Type'),
                    new IntegerField('Business_Responsible'),
                    new StringField('Owner_Person'),
                    new StringField('Brands_Attending'),
                    new DateTimeField('Start_Date'),
                    new DateTimeField('End_Date'),
                    new StringField('Objective'),
                    new IntegerField('Expected_ROI_OTS'),
                    new IntegerField('Expected_ROI_Enquiries'),
                    new IntegerField('Post_Enquiries'),
                    new IntegerField('New_Opportunities'),
                    new IntegerField('Est_Opportunity_value_in_Euros'),
                    new IntegerField('Industry'),
                    new IntegerField('Strategic_Campaign'),
                    new StringField('Short_Description'),
                    new IntegerField('Event_Cost'),
                    new IntegerField('Planned_Booth_Area'),
                    new StringField('Created_by'),
                    new StringField('Created_Date'),
                    new StringField('Updated_by'),
                    new StringField('Updated_Date'),
                    new StringField('Marketo_Campaign'),
                    new StringField('Banner'),
                    new StringField('Publish_Live'),
                    new DateField('Publish_Live_Date'),
                    new StringField('Event_Title'),
                    new StringField('SEO_Title'),
                    new StringField('finyear_date'),
                    new StringField('finmonth_date'),
                    new IntegerField('show_events_cal'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Event_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Event', 'campaign_event_id', 'campaign_event_id_Event_Name', 'insert_campaign_program_name_generator_campaign_event_id_search', $editor, $this->dataset, $lookupDataset, 'campaign_event_id', 'Event_Name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_program_name field
            //
            $editor = new TextEdit('campaign_program_name_edit');
            $editor->SetPlaceholder('[ System generated Marketo campaign name ]');
            $editColumn = new CustomEditColumn('Campaign Program Name', 'campaign_program_name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for SFDC_child_campaign field
            //
            $editor = new TextEdit('sfdc_child_campaign_edit');
            $editor->SetMaxLength(50);
            $editor->SetPlaceholder('[ System generated SFDC campaign ]');
            $editColumn = new CustomEditColumn('SFDC Campaign Name', 'SFDC_child_campaign', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_type field
            //
            $editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Type', 'campaign_type', 'campaign_type_Type', 'insert_campaign_program_name_generator_campaign_type_search', $editor, $this->dataset, $lookupDataset, 'Type_Value', 'Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for event_type field
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
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'insert_campaign_program_name_generator_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for short_description field
            //
            $editor = new AutocompleteEditor('short_description_edit', $this->CreateLinkBuilder(), 'insert_campaign_program_name_generator_short_description_ac');
            $editor->SetMaxLength(45);
            $editor->setMinimumInputLength(4);
            $editColumn = new CustomEditColumn('Short Description', 'short_description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pregion field
            //
            $editor = new DynamicCombobox('pregion_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'pregion', 'pregion_Region', 'insert_campaign_program_name_generator_pregion_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for sub_region field
            //
            $editor = new DynamicCombobox('sub_region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sub Region', 'sub_region', 'sub_region_Sub_Region', 'insert_campaign_program_name_generator_sub_region_search', $editor, $this->dataset, $lookupDataset, 'Sub_Region_Value', 'Sub_Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for territory field
            //
            $editor = new ComboBox('territory_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $editColumn = new LookUpEditColumn(
                'Territory', 
                'territory', 
                $editor, 
                $this->dataset, 'Territory_Value', 'Territory', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for country field
            //
            $editor = new RemoteMultiValueSelect('country_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('insert_country_2_ISO_Country_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Country', 'country', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('insert_industry_Industry_ID_Industry_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Industry', 'industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for job_function field
            //
            $editor = new RemoteMultiValueSelect('job_function_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('insert_job_function_Job_Functions_ID_Job Function_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Job Function', 'job_function', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new RemoteMultiValueSelect('product_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('insert_product_Product_Value_Product_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Product', 'product', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Form ID', 'm_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for import_total field
            //
            $editor = new TextEdit('import_total_edit');
            $editColumn = new CustomEditColumn('Import Total', 'import_total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for create_import_list field
            //
            $editor = new RadioEdit('create_import_list_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('1', 'Yes, Create Import Report');
            $editor->addChoice('0', 'No');
            $editColumn = new CustomEditColumn('Create Import List', 'create_import_list', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Start Date', 'campaign_publish_date', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATE%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date_end field
            //
            $editor = new DateTimeEdit('campaign_publish_date_end_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('End Date', 'campaign_publish_date_end', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATE%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_time_start field
            //
            $editor = new TimeEdit('campaign_time_start_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Start Time', 'campaign_time_start', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_TIME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_time_end field
            //
            $editor = new TimeEdit('campaign_time_end_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('End Time', 'campaign_time_end', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_TIME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for emails_tracker field
            //
            $editor = new DynamicCombobox('emails_tracker_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $editColumn = new DynamicLookupEditColumn('Emails Tracker', 'emails_tracker', 'emails_tracker_email_tracker_description', 'insert_campaign_program_name_generator_emails_tracker_search', $editor, $this->dataset, $lookupDataset, 'qty', 'email_tracker_description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for webinar_tracker field
            //
            $editor = new DynamicCombobox('webinar_tracker_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_webcast_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_webcast_tracker_id', true, true, true),
                    new StringField('webcast_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $lookupDataset->setOrderByField('webcast_tracker_description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Webinar Tracker', 'webinar_tracker', 'webinar_tracker_webcast_tracker_description', 'insert_campaign_program_name_generator_webinar_tracker_search', $editor, $this->dataset, $lookupDataset, 'qty', 'webcast_tracker_description', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editColumn = new CustomEditColumn('Created By', 'created_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_NAME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for created_date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'created_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATETIME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('campaign_event_id', 'campaign_event_id_Event_Name', 'Campaign Event', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Campaign Name', $this->dataset);
            $column->setNullLabel('[SFDC Campaign Required]');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->setNullLabel('No Information ');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('pregion', 'pregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region_Sub_Region', 'Sub Region', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for import_total field
            //
            $column = new NumberViewColumn('import_total', 'import_total', 'Import Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for create_import_list field
            //
            $column = new NumberViewColumn('create_import_list', 'create_import_list', 'Create Import List', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_publish_date_end field
            //
            $column = new DateTimeViewColumn('campaign_publish_date_end', 'campaign_publish_date_end', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_time_start field
            //
            $column = new DateTimeViewColumn('campaign_time_start', 'campaign_time_start', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_time_end field
            //
            $column = new DateTimeViewColumn('campaign_time_end', 'campaign_time_end', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for email_tracker_description field
            //
            $column = new TextViewColumn('emails_tracker', 'emails_tracker_email_tracker_description', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for webcast_tracker_description field
            //
            $column = new TextViewColumn('webinar_tracker', 'webinar_tracker_webcast_tracker_description', 'Webinar Tracker', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('campaign_event_id', 'campaign_event_id_Event_Name', 'Campaign Event', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Campaign Name', $this->dataset);
            $column->setNullLabel('[SFDC Campaign Required]');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->setNullLabel('No Information ');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('pregion', 'pregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region_Sub_Region', 'Sub Region', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for import_total field
            //
            $column = new NumberViewColumn('import_total', 'import_total', 'Import Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for create_import_list field
            //
            $column = new NumberViewColumn('create_import_list', 'create_import_list', 'Create Import List', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_publish_date_end field
            //
            $column = new DateTimeViewColumn('campaign_publish_date_end', 'campaign_publish_date_end', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_time_start field
            //
            $column = new DateTimeViewColumn('campaign_time_start', 'campaign_time_start', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_time_end field
            //
            $column = new DateTimeViewColumn('campaign_time_end', 'campaign_time_end', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for email_tracker_description field
            //
            $column = new TextViewColumn('emails_tracker', 'emails_tracker_email_tracker_description', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for webcast_tracker_description field
            //
            $column = new TextViewColumn('webinar_tracker', 'webinar_tracker_webcast_tracker_description', 'Webinar Tracker', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Event_Name field
            //
            $column = new TextViewColumn('campaign_event_id', 'campaign_event_id_Event_Name', 'Campaign Event', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Campaign Name', $this->dataset);
            $column->setNullLabel('[SFDC Campaign Required]');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->setNullLabel('No Information ');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('pregion', 'pregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region_Sub_Region', 'Sub Region', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for import_total field
            //
            $column = new NumberViewColumn('import_total', 'import_total', 'Import Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for create_import_list field
            //
            $column = new NumberViewColumn('create_import_list', 'create_import_list', 'Create Import List', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_publish_date_end field
            //
            $column = new DateTimeViewColumn('campaign_publish_date_end', 'campaign_publish_date_end', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_time_start field
            //
            $column = new DateTimeViewColumn('campaign_time_start', 'campaign_time_start', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_time_end field
            //
            $column = new DateTimeViewColumn('campaign_time_end', 'campaign_time_end', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for email_tracker_description field
            //
            $column = new TextViewColumn('emails_tracker', 'emails_tracker_email_tracker_description', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for webcast_tracker_description field
            //
            $column = new TextViewColumn('webinar_tracker', 'webinar_tracker_webcast_tracker_description', 'Webinar Tracker', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalSingleRecordView() { return true; }
        
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
        
        private $partitions = array(1 => array('\'GL-ALL\'', 
        '\'WW-ALL\''), 2 => array('\'AM-ALL\''), 3 => array('\'EM-ALL\'', 
        '\'EM-EUR\''), 4 => array('\'IN-ALL\''), 5 => array('\'JP-ALL\''), 6 => array('\'KO-ALL\''), 7 => array('\'CH-ALL\''));
        
        function partition_GetPartitionsHandler(&$partitions)
        {
            $partitions[1] = 'Global';
            $partitions[2] = 'Americas';
            $partitions[3] = 'EMEA';
            $partitions[4] = 'IndoPAC';
            $partitions[5] = 'Japan';
            $partitions[6] = 'Korea';
            $partitions[7] = 'China';
        }
        
        function partition_GetPartitionConditionHandler($partitionName, &$condition)
        {
            $condition = '';
            if (isset($partitionName) && isset($this->partitions[$partitionName]))
                foreach ($this->partitions[$partitionName] as $value)
                    AddStr($condition, sprintf('(pregion = %s)', $this->PrepareTextForSQL($value)), ' OR ');
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
            $defaultSortedColumns = array();
            $defaultSortedColumns[] = new SortColumn('campaign_publish_date', 'ASC');
            $result->setDefaultOrdering($defaultSortedColumns);
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
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setDescription('<div class="mark-media mark-position-relative">
                          <div class="mark-bd-placeholder-img mr-3"><img src="apps/icons/program-generator-color.png" width="80" height="79"></div>
                          <div class="mark-media-body">
                            <h5 class="mt-0 h5">What will you find here</h5>
                            <p class="mark-p">Step 2:  Please plan and enter the details of  your campaign here. Click on +Add New.</p>
                            <i class="far fa-life-ring"></i> If you need more help go to <a href="portal_help.php?partitionpage=6" class="stretched-link">portal help</a> section!
                          </div>
                        </div>');
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
            $grid->SetInsertClientEditorValueChangedScript('if (sender.getFieldName() == \'campaign_type\'){
              if (sender.getValue() == \'LIP\'){
                editors[\'import_total\'].setValue(\'0\');
                editors[\'import_total\'].setVisible(true); 
                editors[\'import_total\'].setRequired(true); 
                editors[\'campaign_publish_date\'].setRequired(true); 
                $(\'#import_total_edit\').next().show(); 
                editors[\'short_description\'].setValue(\'-\');    
                editors[\'create_import_list\'].setValue(\'1\');
                editors[\'create_import_list\'].setVisible(true);   
                $(\'#create_import_list_edit\').next().show();  
                editors[\'emails_tracker\'].setVisible(false); 
                editors[\'emails_tracker\'].setRequired(false); 
                editors[\'webinar_tracker\'].setVisible(false); 
                editors[\'webinar_tracker\'].setRequired(false);
                editors[\'campaign_publish_date\'].setVisible(true);
                editors[\'campaign_publish_date_end\'].setVisible(false);
              }
              else if (sender.getValue() == \'WBN\'){
                editors[\'import_total\'].setVisible(false); 
                editors[\'import_total\'].setRequired(false); 
                editors[\'campaign_time_start\'].setVisible(true); 
                editors[\'campaign_time_start\'].setRequired(true);
                editors[\'campaign_time_end\'].setVisible(true); 
                editors[\'campaign_time_end\'].setRequired(true);
                editors[\'campaign_publish_date\'].setRequired(true); 
                editors[\'campaign_publish_date_end\'].setVisible(true);
                editors[\'campaign_publish_date_end\'].setRequired(true);
                editors[\'short_description\'].setValue(\'[Enter Webinar Description]\'); 
                editors[\'create_import_list\'].setVisible(false);  
                editors[\'webinar_tracker\'].setVisible(false); 
                editors[\'webinar_tracker\'].setRequired(false);   
                editors[\'email_tracker\'].setVisible(true);
                editors[\'email_tracker\'].setRequired(true);
              }
              else if (sender.getValue() == \'WBS\'){
                editors[\'import_total\'].setVisible(false); 
                editors[\'import_total\'].setRequired(false); 
                editors[\'campaign_time_start\'].setVisible(false); 
                editors[\'campaign_time_start\'].setRequired(false);
                editors[\'campaign_time_end\'].setVisible(false); 
                editors[\'campaign_time_end\'].setRequired(false);
                editors[\'campaign_publish_date\'].setRequired(false); 
                editors[\'campaign_publish_date_end\'].setVisible(true);
                editors[\'campaign_publish_date_end\'].setRequired(true);
                editors[\'short_description\'].setValue(\'[Enter Webcast Series Description]\'); 
                editors[\'create_import_list\'].setVisible(false); 
                editors[\'emails_tracker\'].setVisible(true); 
                editors[\'emails_tracker\'].setRequired(true); 
                editors[\'webinar_tracker\'].setVisible(true); 
                editors[\'webinar_tracker\'].setRequired(true);
              }
              else{
                editors[\'import_total\'].setVisible(false); 
                $(\'#import_total_edit\').next().hide();   
                editors[\'import_total\'].setRequired(false); 
                editors[\'campaign_time_start\'].setVisible(false); 
                editors[\'campaign_time_end\'].setVisible(false);
                editors[\'short_description\'].setRequired(true);  
                editors[\'campaign_publish_date\'].setRequired(true);  
                editors[\'create_import_list\'].setVisible(false); 
                $(\'#create_import_list_edit\').next().hide();  
                editors[\'webinar_tracker\'].setVisible(false); 
                editors[\'webinar_tracker\'].setRequired(false);
                $(\'#create_webinar_tracker\').next().hide();   
                editors[\'email_tracker\'].setVisible(true);
                editors[\'email_tracker\'].setRequired(true); 
              }
            }
            
            
            if (sender.getFieldName() == \'pregion\'){
                if (sender.getValue() == \'AM-ALL\'){
                    editors[\'sub_region\'].enabled(true);
                    editors[\'sub_region\'].setRequired(true);
                    editors[\'territory\'].enabled(false);
                    editors[\'territory\'].setRequired(false);
                    }
                else if (sender.getValue() == \'EM-ALL\' || sender.getValue() == \'IN-ALL\'){
                    editors[\'sub_region\'].enabled(true);
                    editors[\'sub_region\'].setRequired(true);
                    editors[\'territory\'].enabled(true);
                    editors[\'territory\'].setRequired(true);
                }
                else if (sender.getValue() == \'WW-ALL\') {
                    editors[\'sub_region\'].enabled(false);
                    editors[\'sub_region\'].setRequired(false);
                    editors[\'territory\'].enabled(false);
                    editors[\'territory\'].setRequired(false);
                }
                else if (sender.getValue() == \'CH-ALL\' || sender.getValue() == \'JA-ALL\' || sender.getValue() == \'KO-ALL\'){
                    editors[\'sub_region\'].enabled(false);
                    editors[\'sub_region\'].setRequired(false);
                    editors[\'territory\'].enabled(false);
                    editors[\'territory\'].setRequired(false);
                }
                else{
                     editors[\'sub_region\'].enabled(true);
                     editors[\'sub_region\'].setRequired(false);
                     editors[\'territory\'].enabled(true);
                     editors[\'territory\'].setRequired(false);
                }
            }
            
            if (sender.getFieldName() == \'sub_region\'){
                if (sender.getValue() == \'EM-EUR\'){
                   editors[\'territory\'].enabled(true);
                   editors[\'territory\'].setRequired(true);
                }
                else{
                    editors[\'territory\'].enabled(false);
                    editors[\'territory\'].enabled(false);
                }
            }');
            
            $grid->SetEditClientEditorValueChangedScript('console.log(sender);
            if (sender.getFieldName() == \'campaign_type\'){
              console.log(sender.getValue());
              editors[\'campaign_status\'].enabled(sender.getValue() == \'LIP\');
            
              if (sender.getValue() == \'LIP\') { 
                 editors[\'import_total\'].setValue(null);
                 $(\'#import_total_edit\').setVisible.show();
                 editors[\'create_import_list\'].setValue(null);
                 $(\'#create_import_list_edit\').setVisible.show();
                 $(\'#emails_tracker\').setVisible.true();
              }
              else{
                 $(\'#import_total_edit\').setVisible.hide();
                 $(\'#create_import_list\').setVisible.hide();
                 $(\'#campaign_time_start\').setVisible.hide();
                 $(\'#campaign_time_end\').setVisible.hide();
                 $(\'#emails_tracker\').setRequired(true);
                 $(\'#emails_tracker\').setVisible.true();
                 $(\'#webcast_tracker\').setRequired(false);
                 $(\'#webcast_tracker\').setVisible.false();
              }
            }
            
            console.log(sender);
            if (sender.getFieldName() == \'campaign_type\'){
              console.log(sender.getValue());
              editors[\'campaign_status\'].enabled(sender.getValue() == \'WBN\');
            
              if (sender.getValue() == \'WBN\') { 
                 editors[\'import_total\'].setValue(null);
                 $(\'#import_total_edit\').setVisible.false();
                 editors[\'create_import_list\'].setValue(null);
                 $(\'#create_import_list_edit\').setVisible.false();
                 editors[\'campaign_time_start\'].setValue(null);
                 $(\'#campaign_time_start\').setRequired(true);
                 editors[\'campaign_time_end\'].setValue(null);
                 $(\'#campaign_time_end\').setRequired(true);
                 $(\'#emails_tracker\').setRequired(true);
                 $(\'#emails_tracker\').setVisible.true();
                 $(\'#webcast_tracker\').setRequired(false);
                 $(\'#webcast_tracker\').setVisible.false();
              }else{
                 $(\'#import_total_edit\').setVisible.hide();
                 $(\'#create_import_list\').setVisible.hide();
                 $(\'#campaign_time_start\').setVisible.hide();
                 $(\'#campaign_time_end\').setVisible.hide();
                 $(\'#emails_tracker\').setRequired(true);
                 $(\'#emails_tracker\').setVisible.true();
                 $(\'#webcast_tracker\').setRequired(false);
                 $(\'#webcast_tracker\').setVisible.false();
              }
            }
            
            console.log(sender);
            if (sender.getFieldName() == \'campaign_type\'){
              console.log(sender.getValue());
              editors[\'campaign_status\'].enabled(sender.getValue() == \'WBS\');
            
              if (sender.getValue() == \'WBS\') { 
                 editors[\'import_total\'].setValue(null);
                 $(\'#import_total_edit\').setVisible.false();
                 editors[\'create_import_list\'].setValue(null);
                 $(\'#create_import_list_edit\').setVisible.false();
                 editors[\'campaign_time_start\'].setValue(null);
                 $(\'#campaign_time_start\').setRequired(false);
                 editors[\'campaign_time_end\'].setValue(null);
                 $(\'#campaign_time_end\').setRequired(false);
                 editors[\'webinar_tracker\'].setValue(12);
                 $(\'#emails_tracker\').setRequired(false);
                 $(\'#emails_tracker\').setVisible.false();
                 $(\'#webcast_tracker\').setRequired(true);
                 $(\'#webcast_tracker\').setVisible.true();
              }
              else{
                 $(\'#import_total_edit\').setVisible.hide();
                 $(\'#create_import_list\').setVisible.hide();
                 $(\'#campaign_time_start\').setVisible.hide();
                 $(\'#campaign_time_end\').setVisible.hide();
                 $(\'#emails_tracker\').setRequired(true);
                 $(\'#emails_tracker\').setVisible.true();
                 $(\'#webcast_tracker\').setRequired(false);
                 $(\'#webcast_tracker\').setVisible.false();
              }
            }
            
            if (sender.getFieldName() == \'pregion\'){
                if (sender.getValue() == \'AM-ALL\'){
                    editors[\'sub_region\'].enabled(true);
                    editors[\'sub_region\'].setRequired(true);
                    editors[\'territory\'].enabled(false);
                    editors[\'territory\'].setRequired(false);
                    }
                else if (sender.getValue() == \'EM-ALL\' || sender.getValue() == \'IN-ALL\'){
                    editors[\'sub_region\'].enabled(true);
                    editors[\'sub_region\'].setRequired(true);
                    editors[\'territory\'].enabled(true);
                    editors[\'territory\'].setRequired(true);
                }
                else if (sender.getValue() == \'WW-ALL\') {
                    editors[\'sub_region\'].enabled(false);
                    editors[\'sub_region\'].setRequired(false);
                    editors[\'territory\'].enabled(false);
                    editors[\'territory\'].setRequired(false);
                }
                else if (sender.getValue() == \'CH-ALL\' || sender.getValue() == \'JA-ALL\' || sender.getValue() == \'KO-ALL\'){
                    editors[\'sub_region\'].enabled(false);
                    editors[\'sub_region\'].setRequired(false);
                    editors[\'territory\'].enabled(false);
                    editors[\'territory\'].setRequired(false);
                }
                else{
                     editors[\'sub_region\'].enabled(true);
                     editors[\'sub_region\'].setRequired(false);
                     editors[\'territory\'].enabled(true);
                     editors[\'territory\'].setRequired(false);
                }
            }
            
            if (sender.getFieldName() == \'sub_region\'){
                if (sender.getValue() == \'EM-EUR\'){
                   editors[\'territory\'].enabled(true);
                   editors[\'territory\'].setRequired(true);
                }
                else{
                    editors[\'territory\'].enabled(false);
                    editors[\'territory\'].enabled(false);
                }
            }');
            
            $grid->SetInsertClientFormLoadedScript('if (editors[\'campaign_type\'].getValue() == \'\') {
                editors[\'import_total\'].setVisible(true);
                editors[\'import_total\'].setValue(\'\');  
                editors[\'campaign_program_name\'].setValue(\'\'); 
                editors[\'SFDC_child_campaign\'].setValue(\'\');
                editors[\'create_import_list\'].setVisible(true);
                editors[\'create_import_list\'].setValue(\'\'); 
                editors[\'campaign_time_start\'].setVisible(false);
                editors[\'campaign_time_end\'].setVisible(false);
                editors[\'emails_tracker\'].setVisible(true);
                editors[\'webinar_tracker\'].setVisible(false);
                editors[\'campaign_publish_date\'].setVisible(true);
                editors[\'campaign_publish_date_end\'].setVisible(false);
            }
            else {
                editors[\'import_total\'].setVisible(false); 
                editors[\'create_import_list\'].setVisible(false);
                editors[\'campaign_program_name\'].setValue(\'\'); 
                editors[\'SFDC_child_campaign\'].setValue(\'\');
                editors[\'emails_tracker\'].setVisible(true); 
                editors[\'emails_tracker\'].setValue(\'1\');
                editors[\'webinar_tracker\'].setVisible(true); 
                editors[\'webinar_tracker\'].setValue(\'1\');
                editors[\'campaign_publish_date\'].setVisible(true);
                editors[\'campaign_publish_date_end\'].setVisible(true);
            }');
            
            $grid->SetEditClientFormLoadedScript('if (editors[\'campaign_type\'].getValue() == \'LIP\') {
                editors[\'import_total\'].setValue(\'0\');
                editors[\'import_total\'].setVisible(true);  
                editors[\'create_import_list\'].setValue(\'0\');
                editors[\'create_import_list\'].setVisible(true); 
                editors[\'campaign_time_start\'].setVisible(false);
                editors[\'campaign_time_start\'].setRequired(false); 
                editors[\'campaign_time_end\'].setVisible(false);
                editors[\'campaign_time_end\'].setRequired(false);  
                editors[\'email_tracker\'].setVisible(false);
                editors[\'email_tracker\'].setRequired(false);
                editors[\'webinar_tracker\'].setVisible(false);
                editors[\'webinar_tracker\'].setRequired(false);
            }
            else if (editors[\'campaign_type\'].getValue() == \'WBN\') {
                editors[\'import_total\'].setVisible(false);  
                editors[\'create_import_list\'].setVisible(false);
                editors[\'campaign_time_start\'].setVisible(true);
                editors[\'campaign_time_start\'].setRequired(true);
                editors[\'campaign_time_end\'].setVisible(true);
                editors[\'campaign_time_end\'].setRequired(true);  
                editors[\'email_tracker\'].setVisible(true);
                editors[\'email_tracker\'].setRequired(true);   
                editors[\'webinar_tracker\'].setEnabled(false);
                editors[\'webinar_tracker\'].setVisible(false);
                editors[\'webinar_tracker\'].setRequired(false);
                editors[\'campaign_publish_date_end\'].setVisible(true);
                editors[\'campaign_publish_date_end\'].setRequired(true);
            }
            else if (editors[\'campaign_type\'].getValue() == \'WBS\') {
                editors[\'import_total\'].setVisible(false);  
                editors[\'create_import_list\'].setVisible(false);
                editors[\'campaign_time_start\'].setVisible(false);
                editors[\'campaign_time_start\'].setRequired(false); 
                editors[\'campaign_time_end\'].setVisible(false);
                editors[\'campaign_time_end\'].setRequired(false);   
                editors[\'email_tracker\'].setVisible(false);
                editors[\'email_tracker\'].setRequired(false);
                editors[\'webinar_tracker\'].setVisible(true);
                editors[\'webinar_tracker\'].setRequired(true);
                editors[\'campaign_publish_date\'].setVisible(true);
                editors[\'campaign_publish_date\'].setRequired(true);
                editors[\'campaign_publish_date_end\'].setVisible(true);
                editors[\'campaign_publish_date_end\'].setRequired(true);
            }
            else {
                editors[\'import_total\'].setVisible(false);  
                editors[\'create_import_list\'].setVisible(false);
                editors[\'campaign_time_start\'].setVisible(false);
                editors[\'campaign_time_end\'].setVisible(false);  
                editors[\'email_tracker\'].setVisible(false);
                editors[\'email_tracker\'].setRequired(false);
                editors[\'webinar_tracker\'].setVisible(false);
                editors[\'webinar_tracker\'].setRequired(false);
                editors[\'campaign_publish_date\'].setVisible(true);
                editors[\'campaign_publish_date\'].setRequired(true);
                editors[\'campaign_publish_date_end\'].setVisible(false);
                editors[\'campaign_publish_date_end\'].setRequired(false);
            }');
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new campaign_program_name_generator_campaign_tracker_comms_localPage('campaign_program_name_generator_campaign_tracker_comms_local', $this, array('program_generator_name_id'), array('program_generator_name_id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('campaign_program_name_generator.campaign_tracker_comms_local'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('campaign_program_name_generator.campaign_tracker_comms_local'));
            $detailPage->SetHttpHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_handler');
            $handler = new PageHTTPHandler('campaign_program_name_generator_campaign_tracker_comms_local_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new campaign_program_name_generator_campaign_tracker_webcastPage('campaign_program_name_generator_campaign_tracker_webcast', $this, array('program_generator_name_id'), array('program_generator_name_id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('campaign_program_name_generator.campaign_tracker_webcast'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('campaign_program_name_generator.campaign_tracker_webcast'));
            $detailPage->SetHttpHandlerName('campaign_program_name_generator_campaign_tracker_webcast_handler');
            $handler = new PageHTTPHandler('campaign_program_name_generator_campaign_tracker_webcast_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new campaign_program_name_generator_campaign_tracker_websitePage('campaign_program_name_generator_campaign_tracker_website', $this, array('program_generator_name_id'), array('program_generator_name_id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('campaign_program_name_generator.campaign_tracker_website'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('campaign_program_name_generator.campaign_tracker_website'));
            $detailPage->SetHttpHandlerName('campaign_program_name_generator_campaign_tracker_website_handler');
            $handler = new PageHTTPHandler('campaign_program_name_generator_campaign_tracker_website_handler', $detailPage);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_events`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_event_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('program_generator_name_id'),
                    new StringField('trackerid'),
                    new StringField('Event_Name'),
                    new StringField('eRegion'),
                    new StringField('Country'),
                    new StringField('Website'),
                    new StringField('Venue'),
                    new StringField('City'),
                    new IntegerField('Event_status'),
                    new IntegerField('Approval'),
                    new IntegerField('Event_Type'),
                    new IntegerField('Business_Responsible'),
                    new StringField('Owner_Person'),
                    new StringField('Brands_Attending'),
                    new DateTimeField('Start_Date'),
                    new DateTimeField('End_Date'),
                    new StringField('Objective'),
                    new IntegerField('Expected_ROI_OTS'),
                    new IntegerField('Expected_ROI_Enquiries'),
                    new IntegerField('Post_Enquiries'),
                    new IntegerField('New_Opportunities'),
                    new IntegerField('Est_Opportunity_value_in_Euros'),
                    new IntegerField('Industry'),
                    new IntegerField('Strategic_Campaign'),
                    new StringField('Short_Description'),
                    new IntegerField('Event_Cost'),
                    new IntegerField('Planned_Booth_Area'),
                    new StringField('Created_by'),
                    new StringField('Created_Date'),
                    new StringField('Updated_by'),
                    new StringField('Updated_Date'),
                    new StringField('Marketo_Campaign'),
                    new StringField('Banner'),
                    new StringField('Publish_Live'),
                    new DateField('Publish_Live_Date'),
                    new StringField('Event_Title'),
                    new StringField('SEO_Title'),
                    new StringField('finyear_date'),
                    new StringField('finmonth_date'),
                    new IntegerField('show_events_cal'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Event_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_event_id_search', 'campaign_event_id', 'Event_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_type_search', 'Type_Value', 'Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $suggestionsDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $suggestionsDataset->addFields(
                array(
                    new StringField('short_description')
                )
            );
            $suggestionsDataset->setOrderByField('short_description', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'short_description', 'insert_campaign_program_name_generator_short_description_ac', 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_pregion_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_sub_region_search', 'Sub_Region_Value', 'Sub_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $valuesDataset->setOrderByField('Country_Name', 'ASC');
            $valuesDataset->addDistinct('2_ISO');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'insert_country_2_ISO_Country_Name_search', '2_ISO', 'Country_Name', null, 20);
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
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'insert_industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $valuesDataset->setOrderByField('Job Function', 'ASC');
            $valuesDataset->addDistinct('Job_Functions_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'insert_job_function_Job_Functions_ID_Job Function_search', 'Job_Functions_ID', 'Job Function', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $valuesDataset->setOrderByField('Product', 'ASC');
            $valuesDataset->addDistinct('Product_Value');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'insert_product_Product_Value_Product_search', 'Product_Value', 'Product', null, 30);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_emails_tracker_search', 'qty', 'email_tracker_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_webcast_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_webcast_tracker_id', true, true, true),
                    new StringField('webcast_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $lookupDataset->setOrderByField('webcast_tracker_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_webinar_tracker_search', 'qty', 'webcast_tracker_description', null, 20);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_events`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_event_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('program_generator_name_id'),
                    new StringField('trackerid'),
                    new StringField('Event_Name'),
                    new StringField('eRegion'),
                    new StringField('Country'),
                    new StringField('Website'),
                    new StringField('Venue'),
                    new StringField('City'),
                    new IntegerField('Event_status'),
                    new IntegerField('Approval'),
                    new IntegerField('Event_Type'),
                    new IntegerField('Business_Responsible'),
                    new StringField('Owner_Person'),
                    new StringField('Brands_Attending'),
                    new DateTimeField('Start_Date'),
                    new DateTimeField('End_Date'),
                    new StringField('Objective'),
                    new IntegerField('Expected_ROI_OTS'),
                    new IntegerField('Expected_ROI_Enquiries'),
                    new IntegerField('Post_Enquiries'),
                    new IntegerField('New_Opportunities'),
                    new IntegerField('Est_Opportunity_value_in_Euros'),
                    new IntegerField('Industry'),
                    new IntegerField('Strategic_Campaign'),
                    new StringField('Short_Description'),
                    new IntegerField('Event_Cost'),
                    new IntegerField('Planned_Booth_Area'),
                    new StringField('Created_by'),
                    new StringField('Created_Date'),
                    new StringField('Updated_by'),
                    new StringField('Updated_Date'),
                    new StringField('Marketo_Campaign'),
                    new StringField('Banner'),
                    new StringField('Publish_Live'),
                    new DateField('Publish_Live_Date'),
                    new StringField('Event_Title'),
                    new StringField('SEO_Title'),
                    new StringField('finyear_date'),
                    new StringField('finmonth_date'),
                    new IntegerField('show_events_cal'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Event_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_event_id_search', 'campaign_event_id', 'Event_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_type_search', 'Type_Value', 'Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $suggestionsDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $suggestionsDataset->addFields(
                array(
                    new StringField('short_description')
                )
            );
            $suggestionsDataset->setOrderByField('short_description', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'short_description', 'filter_builder_campaign_program_name_generator_short_description_ac', 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_pregion_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_sub_region_search', 'Sub_Region_Value', 'Sub_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_territory_search', 'Territory_Value', 'Territory', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $valuesDataset->setOrderByField('Country_Name', 'ASC');
            $valuesDataset->addDistinct('2_ISO');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_country_2_ISO_Country_Name_search', '2_ISO', 'Country_Name', null, 20);
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
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $valuesDataset->setOrderByField('Job Function', 'ASC');
            $valuesDataset->addDistinct('Job_Functions_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_job_function_Job_Functions_ID_Job Function_search', 'Job_Functions_ID', 'Job Function', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $valuesDataset->setOrderByField('Product', 'ASC');
            $valuesDataset->addDistinct('Product_Value');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_product_Product_Value_Product_search', 'Product_Value', 'Product', null, 30);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_emails_tracker_search', 'qty', 'email_tracker_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_webcast_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_webcast_tracker_id', true, true, true),
                    new StringField('webcast_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $lookupDataset->setOrderByField('webcast_tracker_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_webinar_tracker_search', 'qty', 'webcast_tracker_description', null, 20);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_events`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_event_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('program_generator_name_id'),
                    new StringField('trackerid'),
                    new StringField('Event_Name'),
                    new StringField('eRegion'),
                    new StringField('Country'),
                    new StringField('Website'),
                    new StringField('Venue'),
                    new StringField('City'),
                    new IntegerField('Event_status'),
                    new IntegerField('Approval'),
                    new IntegerField('Event_Type'),
                    new IntegerField('Business_Responsible'),
                    new StringField('Owner_Person'),
                    new StringField('Brands_Attending'),
                    new DateTimeField('Start_Date'),
                    new DateTimeField('End_Date'),
                    new StringField('Objective'),
                    new IntegerField('Expected_ROI_OTS'),
                    new IntegerField('Expected_ROI_Enquiries'),
                    new IntegerField('Post_Enquiries'),
                    new IntegerField('New_Opportunities'),
                    new IntegerField('Est_Opportunity_value_in_Euros'),
                    new IntegerField('Industry'),
                    new IntegerField('Strategic_Campaign'),
                    new StringField('Short_Description'),
                    new IntegerField('Event_Cost'),
                    new IntegerField('Planned_Booth_Area'),
                    new StringField('Created_by'),
                    new StringField('Created_Date'),
                    new StringField('Updated_by'),
                    new StringField('Updated_Date'),
                    new StringField('Marketo_Campaign'),
                    new StringField('Banner'),
                    new StringField('Publish_Live'),
                    new DateField('Publish_Live_Date'),
                    new StringField('Event_Title'),
                    new StringField('SEO_Title'),
                    new StringField('finyear_date'),
                    new StringField('finmonth_date'),
                    new IntegerField('show_events_cal'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Event_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_event_id_search', 'campaign_event_id', 'Event_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_type_search', 'Type_Value', 'Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $suggestionsDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $suggestionsDataset->addFields(
                array(
                    new StringField('short_description')
                )
            );
            $suggestionsDataset->setOrderByField('short_description', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'short_description', 'edit_campaign_program_name_generator_short_description_ac', 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_pregion_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_sub_region_search', 'Sub_Region_Value', 'Sub_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $valuesDataset->setOrderByField('Country_Name', 'ASC');
            $valuesDataset->addDistinct('2_ISO');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'edit_country_2_ISO_Country_Name_search', '2_ISO', 'Country_Name', null, 20);
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
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'edit_industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $valuesDataset->setOrderByField('Job Function', 'ASC');
            $valuesDataset->addDistinct('Job_Functions_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'edit_job_function_Job_Functions_ID_Job Function_search', 'Job_Functions_ID', 'Job Function', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $valuesDataset->setOrderByField('Product', 'ASC');
            $valuesDataset->addDistinct('Product_Value');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'edit_product_Product_Value_Product_search', 'Product_Value', 'Product', null, 30);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_emails_tracker_search', 'qty', 'email_tracker_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_webcast_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_webcast_tracker_id', true, true, true),
                    new StringField('webcast_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $lookupDataset->setOrderByField('webcast_tracker_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_webinar_tracker_search', 'qty', 'webcast_tracker_description', null, 20);
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
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_events`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_event_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('program_generator_name_id'),
                    new StringField('trackerid'),
                    new StringField('Event_Name'),
                    new StringField('eRegion'),
                    new StringField('Country'),
                    new StringField('Website'),
                    new StringField('Venue'),
                    new StringField('City'),
                    new IntegerField('Event_status'),
                    new IntegerField('Approval'),
                    new IntegerField('Event_Type'),
                    new IntegerField('Business_Responsible'),
                    new StringField('Owner_Person'),
                    new StringField('Brands_Attending'),
                    new DateTimeField('Start_Date'),
                    new DateTimeField('End_Date'),
                    new StringField('Objective'),
                    new IntegerField('Expected_ROI_OTS'),
                    new IntegerField('Expected_ROI_Enquiries'),
                    new IntegerField('Post_Enquiries'),
                    new IntegerField('New_Opportunities'),
                    new IntegerField('Est_Opportunity_value_in_Euros'),
                    new IntegerField('Industry'),
                    new IntegerField('Strategic_Campaign'),
                    new StringField('Short_Description'),
                    new IntegerField('Event_Cost'),
                    new IntegerField('Planned_Booth_Area'),
                    new StringField('Created_by'),
                    new StringField('Created_Date'),
                    new StringField('Updated_by'),
                    new StringField('Updated_Date'),
                    new StringField('Marketo_Campaign'),
                    new StringField('Banner'),
                    new StringField('Publish_Live'),
                    new DateField('Publish_Live_Date'),
                    new StringField('Event_Title'),
                    new StringField('SEO_Title'),
                    new StringField('finyear_date'),
                    new StringField('finmonth_date'),
                    new IntegerField('show_events_cal'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Event_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_event_id_search', 'campaign_event_id', 'Event_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value'),
                    new IntegerField('Type_WebListing')
                )
            );
            $lookupDataset->setOrderByField('Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_type_search', 'Type_Value', 'Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $suggestionsDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $suggestionsDataset->addFields(
                array(
                    new StringField('short_description')
                )
            );
            $suggestionsDataset->setOrderByField('short_description', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'short_description', 'multi_edit_campaign_program_name_generator_short_description_ac', 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_pregion_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_sub_region_search', 'Sub_Region_Value', 'Sub_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $valuesDataset->setOrderByField('Country_Name', 'ASC');
            $valuesDataset->addDistinct('2_ISO');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'multi_edit_country_2_ISO_Country_Name_search', '2_ISO', 'Country_Name', null, 20);
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
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'multi_edit_industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $valuesDataset->setOrderByField('Job Function', 'ASC');
            $valuesDataset->addDistinct('Job_Functions_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'multi_edit_job_function_Job_Functions_ID_Job Function_search', 'Job_Functions_ID', 'Job Function', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $valuesDataset->setOrderByField('Product', 'ASC');
            $valuesDataset->addDistinct('Product_Value');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'multi_edit_product_Product_Value_Product_search', 'Product_Value', 'Product', null, 30);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_emails_tracker_search', 'qty', 'email_tracker_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_webcast_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_webcast_tracker_id', true, true, true),
                    new StringField('webcast_tracker_description'),
                    new IntegerField('qty'),
                    new StringField('tracker_filters')
                )
            );
            $lookupDataset->setOrderByField('webcast_tracker_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_webinar_tracker_search', 'qty', 'webcast_tracker_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            
            
            new campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_idModalViewPage($this, GetCurrentUserPermissionsForPage('campaign_program_name_generator.campaign_tracker_comms_local.program_generator_name_id'));
            new campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage($this, GetCurrentUserPermissionsForPage('campaign_program_name_generator.campaign_tracker_comms_local.campaign_utm_id'));
            new campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idNestedPage($this, GetCurrentUserPermissionsForPage('campaign_program_name_generator.campaign_tracker_comms_local.campaign_utm_id'));
            new campaign_program_name_generator_master_campaign_idModalViewPage($this, GetCurrentUserPermissionsForPage('campaign_program_name_generator.master_campaign_id'));
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
            if ($rowData['campaign_program_name'] !='') {
                 $cellClasses['copy-program-name'] = 'copy-program-name';
            }
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
            $campaign_date_start = SMDateTime::now();
            $campaign_date_start->addDays(4);
            $campaign_date_end = SMDateTime::now();
            $campaign_date_end->addDays(7);
            
            $values['campaign_publish_date'] = $campaign_date_start;  
            $values['campaign_publish_date_end'] = $campaign_date_end;  
            
            $handled = true;
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
            if ($success) {
            
               // Check if the substring exists inside the string     
               
                    $sprogram_generator_name_id = $rowData['program_generator_name_id'];
                    $smaster_campaign_id = $rowData['master_campaign_id'];
                    $username = $page->GetEnvVar('CURRENT_USER_NAME');   
                    $trackerid = $rowData['trackerid'];        
                    $currentDateTime = SMDateTime::Now();
                    $emailcount = $rowData['emails_tracker'];
                    $importlist = $rowData['create_import_list'];
                    $sregion = $rowData['pregion'];
                    $sdescription = $rowData['short_description'];
                    
                    $event_type = $rowData['event_type']; 
                    $subregion = $rowData['sub_region'];
                    $territory = $rowData['territory'];
                    $country = $rowData['country'];
                    $industry = $rowData['industry'];
                    $product = $rowData['product'];
                    $m_id = $rowData['m_ID'];
            	$campaign_publish_date_start = $rowData['campaign_publish_date'];
            	$campaign_publish_date_end = $rowData['campaign_publish_date_end'];
            	$campaign_time_start = $rowData['campaign_time_start'];
            	$campaign_time_end = $rowData['campaign_time_end'];
            	$expired = $rowData['expired'];
                    
                    $startDateTime = $rowData['campaign_publish_date'] . " " .  $rowData['campaign_time_start'];
                    $endDateTime = $rowData['campaign_publish_date'] . " " . $rowData['campaign_time_start'];
                  
               $sql =
                                     
                  "CALL campaignProgramNameGenerator($sprogram_generator_name_id, '$smaster_campaign_id', '$username', '$currentDateTime', '$trackerid', '$importlist');";
                  $this->GetConnection()->ExecSQL($sql);
                  
               $sql =
                                     
                  "CALL campaignCampaignBuildertoGlobalCalendar($sprogram_generator_name_id, '$smaster_campaign_id', '$username', '$currentDateTime', '$trackerid', '$sregion', '$sdescription', '$startDateTime', '$endDateTime');";
                  $this->GetConnection()->ExecSQL($sql);
                  
              if (($event_type != '8') || ($event_type != '18')) {     
               $sql =
                                     
                  "CALL campaignTacticWebsiteListing('$smaster_campaign_id', $sprogram_generator_name_id, '$trackerid', '$event_type', '$sdescription', '$sregion', '$subregion', '$territory', '$country', '$industry', '$product', '$m_id', '$campaign_publish_date_start', '$campaign_publish_date_end', '$campaign_time_start', '$campaign_time_end', '$username', '$currentDateTime', '$expired');";
                  $this->GetConnection()->ExecSQL($sql);
              }
                  
                  If ($emailcount != '0'){
                     $message = '<p>Record updated successfully, goto Comms Tracker (Local) to update the send dates .</p>';
                  }
                  elseif ($importlist != '0'){
                       $message = '<p>Record processed successfully.  Go to <a href="/campaign_import.php">Import List</a> your request has been inserted, additonal update is required.</p>';
                  }
                  else{
                       $message = '<p>Record updated successfully.</p>';
                  }
            }
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
            
              // Check if record data was modified
            
              $dataMofified  = 
            
            	$oldRowData['master_campaign_id'] !== $rowData['master_campaign_id'] ||
            	$oldRowData['SFDC_child_campaign'] !== $rowData['SFDC_child_campaign'] ||
            	$oldRowData['campaign_program_name'] !== $rowData['campaign_program_name'] ||
            	$oldRowData['event_type'] !== $rowData['event_type'] ||
            	$oldRowData['short_description'] !== $rowData['short_description'] ||
            	$oldRowData['pregion'] !== $rowData['pregion'] ||
            	$oldRowData['sub_region'] !== $rowData['sub_region'] ||
            	$oldRowData['territory'] !== $rowData['territory'] ||
            	$oldRowData['country'] !== $rowData['country'] ||
            	$oldRowData['industry'] !== $rowData['industry'] ||
            	$oldRowData['job_function'] !== $rowData['job_function'] ||
            	$oldRowData['campaign_type'] !== $rowData['campaign_type'] ||
            	$oldRowData['product'] !== $rowData['product'] ||
            	$oldRowData['m_ID'] !== $rowData['m_ID'] ||
            	$oldRowData['campaign_publish_date'] !== $rowData['campaign_publish_date'] ||
            	$oldRowData['campaign_publish_date_end'] !== $rowData['campaign_publish_date_end'] ||
            	$oldRowData['campaign_time_start'] !== $rowData['campaign_time_start'] ||
            	$oldRowData['campaign_time_end'] !== $rowData['campaign_time_end'] ||
            	$oldRowData['create_import_list'] !== $rowData['create_import_list'] ||
            	$oldRowData['emails_tracker'] !== $rowData['emails_tracker'];
            	
            	
              if ($dataMofified) {
            
                    $sprogram_generator_name_id = $rowData['program_generator_name_id'];
                    $smaster_campaign_id = $rowData['master_campaign_id'];
                    $username = $page->GetEnvVar('CURRENT_USER_NAME');    
                    $trackerid = $rowData['trackerid'];       
                    $event_type = $rowData['event_type'];    
                    $sdescription = $rowData['short_description'];
                    $sregion = $rowData['pregion'];
                    $subregion = $rowData['sub_region'];
                    $territory = $rowData['territory'];
                    $country = $rowData['country'];
                    $industry = $rowData['industry'];
                    $product = $rowData['product'];
                    $m_id = $rowData['m_ID'];
            	$campaign_publish_date_start = $rowData['campaign_publish_date'];
            	$campaign_publish_date_end = $rowData['campaign_publish_date_end'];
            	$campaign_time_start = $rowData['campaign_time_start'];
            	$campaign_time_end = $rowData['campaign_time_end'];
            	$expired = $rowData['expired'];
                    
                    $currentDateTime = SMDateTime::Now();
                    $emailcount = $rowData['emails_tracker'];
                    $importlist = $rowData['create_import_list'];
                    
                    $startDateTime = $rowData['campaign_publish_date'] . " " .  $rowData['campaign_time_start'];
                    $endDateTime = $rowData['campaign_publish_date'] . " " . $rowData['campaign_time_start'];
                    
            
                $sql = 
            
                  "CALL campaignProgramNameGenerator($sprogram_generator_name_id, '$smaster_campaign_id', '$username', '$currentDateTime', $trackerid, '$importlist');";
                  $this->GetConnection()->ExecSQL($sql);
                  
               $sql =
                                     
                  "CALL campaignCampaignBuildertoGlobalCalendar($sprogram_generator_name_id, '$smaster_campaign_id', '$username', '$currentDateTime', '$trackerid', '$sregion', '$sdescription', '$startDateTime', '$endDateTime');";
                  $this->GetConnection()->ExecSQL($sql);
               
               if (($event_type != '8') || ($event_type != '18')) {   
               $sql =
                                     
                  "CALL campaignTacticWebsiteListing('$smaster_campaign_id', $sprogram_generator_name_id, '$trackerid', '$event_type', '$sdescription', '$sregion', '$subregion', '$territory', '$country', '$industry', '$product', '$m_id', '$campaign_publish_date_start', '$campaign_publish_date_end', '$campaign_time_start', '$campaign_time_end', '$username', '$currentDateTime', '$expired');";
                  $this->GetConnection()->ExecSQL($sql);
               }
               
                  If ($emailcount != '0'){
                     $message = '<p>Record processed successfully, goto Comms Tracker (Local) to update the send dates or view the child campaign.</p>';
                  }
                  elseif ($importlist != '0'){
                       $message = '<p>Record processed successfully. Go to <a href="/campaign_import.php">Import List</a> has been updated, additonal update is required.</p>';
                  }
                  else{
                       $message = '<p>Record processed successfully.</p>';
                  }
              }                                    
            }
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
            
               // Check if the substring exists inside the string     
               
               $aprogram_generator_name_id = $rowData['program_generator_name_id'];
                                       
               $sql = "CALL campaignProgramNameGeneratorDelete($aprogram_generator_name_id);";
            
               $this->GetConnection()->ExecSQL($sql);  
            
               $message = '<p>Record was deleted successfully from all tables.</p>';
            }
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
            $rootGroup = new FilterGroup(FilterGroupOperator::OPERATOR_AND,
                array(
                    new FilterCondition($columns['expired'], 
                        FilterConditionOperator::EQUALS, array(1))
                )
            );
            $filterBuilder->setFilterComponent($rootGroup);
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
            $layout->setMode(FormLayoutMode::VERTICAL);
            
            $briefGroup = $layout->addGroup('Overview', 12);
            $briefGroup->addRow()->addCol($columns['campaign_program_name'], 12);
            
            $storageGroup = $layout->addGroup('Campaign Information', 12);
            $storageGroup->addRow()
                    ->addCol($columns['master_campaign_id'], 12);
            $storageGroup->addRow()
                        ->addCol($columns['campaign_event_id'], 12);
            $storageGroup->addRow()
                    ->addCol($columns['SFDC_child_campaign'], 6)
                    ->addCol($columns['campaign_type'], 6);
            $storageGroup->addRow()
                        ->addCol($columns['event_type'], 12);
            
            $storageGroup = $layout->addGroup('Target Audience', 12);
            $storageGroup->addRow()
                    ->addCol($columns['pregion'], 4)
                    ->addCol($columns['sub_region'], 4)
                    ->addCol($columns['territory'], 4);
            $storageGroup->addRow()
                    ->addCol($columns['country'], 12);
            $storageGroup->addRow()
                    ->addCol($columns['industry'], 6)
                    ->addCol($columns['job_function'], 6);
            $storageGroup->addRow()
                    ->addCol($columns['product'], 12);
            
                
            $storageGroup = $layout->addGroup('Program Information', 12);
            $storageGroup->addRow()
                    ->addCol($columns['short_description'], 8)
                    ->addCol($columns['m_ID'], 4);
            $storageGroup->addRow()
                    ->addCol($columns['import_total'], 4)
                    ->addCol($columns['create_import_list'], 8);
            
            $storageGroup = $layout->addGroup('Campaign Type', 12);
            $storageGroup->addRow()
                    ->addCol($columns['campaign_publish_date'], 6)
                    ->addCol($columns['campaign_publish_date_end'], 6);
            $storageGroup->addRow()
                    ->addCol($columns['emails_tracker'], 12);
            $storageGroup->addRow()
                    ->addCol($columns['webinar_tracker'], 12);
            $storageGroup->addRow()
                    ->addCol($columns['campaign_time_start'], 6)
                    ->addCol($columns['campaign_time_end'], 6);
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
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new campaign_program_name_generatorPage("campaign_program_name_generator", "campaign_program_name_generator.php", GetCurrentUserPermissionsForPage("campaign_program_name_generator"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("campaign_program_name_generator"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
