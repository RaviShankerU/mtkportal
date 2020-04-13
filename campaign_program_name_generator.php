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
            $this->SetMenuLabel('Campaign Tracker Comms');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_comms_local`');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_tracker_local_id', true, true, true),
                    new IntegerField('program_generator_name_id'),
                    new IntegerField('master_campaign_id'),
                    new StringField('email_name'),
                    new StringField('campaign_type'),
                    new StringField('region'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new IntegerField('tracker_status'),
                    new IntegerField('campaign_utm_id'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $this->dataset->AddLookupField('program_generator_name_id', 'campaign_program_name_generator', new IntegerField('program_generator_name_id'), new StringField('campaign_program_name', false, false, false, false, 'program_generator_name_id_campaign_program_name', 'program_generator_name_id_campaign_program_name_campaign_program_name_generator'), 'program_generator_name_id_campaign_program_name_campaign_program_name_generator');
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
            $this->dataset->AddLookupField('region', 'lookup_region', new StringField('Region_Value'), new StringField('Region', false, false, false, false, 'region_Region', 'region_Region_lookup_region'), 'region_Region_lookup_region');
            $this->dataset->AddLookupField('campaign_type', 'lookup_campaign_type', new StringField('Type_Value'), new StringField('Type', false, false, false, false, 'campaign_type_Type', 'campaign_type_Type_lookup_campaign_type'), 'campaign_type_Type_lookup_campaign_type');
            $this->dataset->AddLookupField('tracker_status', 'lookup_status_types', new IntegerField('Status_Type_ID'), new StringField('Status_Type', false, false, false, false, 'tracker_status_Status_Type', 'tracker_status_Status_Type_lookup_status_types'), 'tracker_status_Status_Type_lookup_status_types');
            $this->dataset->AddLookupField('campaign_utm_id', 'campaign_tracker_utm', new IntegerField('campaign_utm_id'), new StringField('campaign_name', false, false, false, false, 'campaign_utm_id_campaign_name', 'campaign_utm_id_campaign_name_campaign_tracker_utm'), 'campaign_utm_id_campaign_name_campaign_tracker_utm');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
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
                new FilterColumn($this->dataset, 'campaign_tracker_local_id', 'campaign_tracker_local_id', 'Campaign Tracker Local Id'),
                new FilterColumn($this->dataset, 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Program Generator Name Id'),
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id_campaign_name', 'Brief Request'),
                new FilterColumn($this->dataset, 'region', 'region_Region', 'Region'),
                new FilterColumn($this->dataset, 'campaign_type', 'campaign_type_Type', 'Campaign Type'),
                new FilterColumn($this->dataset, 'email_name', 'email_name', 'Email Name'),
                new FilterColumn($this->dataset, 'campaign_description', 'campaign_description', 'Campaign Description'),
                new FilterColumn($this->dataset, 'campaign_publish_date', 'campaign_publish_date', 'Send Date'),
                new FilterColumn($this->dataset, 'tracker_status', 'tracker_status_Status_Type', 'Send Status'),
                new FilterColumn($this->dataset, 'campaign_utm_id', 'campaign_utm_id_campaign_name', 'UTM Tracking'),
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
                ->addColumn($columns['region'])
                ->addColumn($columns['campaign_type'])
                ->addColumn($columns['email_name'])
                ->addColumn($columns['campaign_description'])
                ->addColumn($columns['campaign_publish_date'])
                ->addColumn($columns['tracker_status'])
                ->addColumn($columns['campaign_utm_id'])
                ->addColumn($columns['modified_by'])
                ->addColumn($columns['modified_date']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('region')
                ->setOptionsFor('campaign_type')
                ->setOptionsFor('campaign_publish_date')
                ->setOptionsFor('tracker_status')
                ->setOptionsFor('campaign_utm_id')
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
            
            $main_editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_region_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('region', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_region_search');
            
            $text_editor = new TextEdit('region');
            
            $filterBuilder->addColumn(
                $columns['region'],
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
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_email_name_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_description_handler_list');
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
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_utm_id', 'campaign_utm_id_campaign_name', 'UTM Tracking', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage::getHandlerName());
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
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_email_name_handler_');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_description_handler_');
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
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_utm_id', 'campaign_utm_id_campaign_name', 'UTM Tracking', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage::getHandlerName());
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
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new IntegerField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new IntegerField('emails_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brief Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'edit_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'region', 'region_Region', 'edit_campaign_program_name_generator_campaign_tracker_comms_local_region_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
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
                    new StringField('Type_Value')
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
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_utm`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new IntegerField('has_brief'),
                    new StringField('master_campaign_id'),
                    new StringField('campaign_name'),
                    new StringField('campaign'),
                    new StringField('medium'),
                    new StringField('source'),
                    new StringField('term'),
                    new StringField('content'),
                    new StringField('notes'),
                    new IntegerField('type_of_page'),
                    new StringField('marketo_page'),
                    new StringField('marketo_page_name'),
                    new StringField('url'),
                    new StringField('full_url'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new StringField('short_url'),
                    new IntegerField('clicks')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('UTM Tracking', 'campaign_utm_id', 'campaign_utm_id_campaign_name', 'edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', $editor, $this->dataset, $lookupDataset, 'campaign_utm_id', 'campaign_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Modified By', 'modified_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for modified_date field
            //
            $editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Modified Date', 'modified_date', $editor, $this->dataset);
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
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new IntegerField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new IntegerField('emails_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brief Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'region', 'region_Region', 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_region_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
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
                    new StringField('Type_Value')
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
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_utm`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new IntegerField('has_brief'),
                    new StringField('master_campaign_id'),
                    new StringField('campaign_name'),
                    new StringField('campaign'),
                    new StringField('medium'),
                    new StringField('source'),
                    new StringField('term'),
                    new StringField('content'),
                    new StringField('notes'),
                    new IntegerField('type_of_page'),
                    new StringField('marketo_page'),
                    new StringField('marketo_page_name'),
                    new StringField('url'),
                    new StringField('full_url'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new StringField('short_url'),
                    new IntegerField('clicks')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('UTM Tracking', 'campaign_utm_id', 'campaign_utm_id_campaign_name', 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', $editor, $this->dataset, $lookupDataset, 'campaign_utm_id', 'campaign_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Modified By', 'modified_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for modified_date field
            //
            $editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Modified Date', 'modified_date', $editor, $this->dataset);
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
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new IntegerField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new IntegerField('emails_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Brief Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'insert_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'region', 'region_Region', 'insert_campaign_program_name_generator_campaign_tracker_comms_local_region_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
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
                    new StringField('Type_Value')
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
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_utm`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new IntegerField('has_brief'),
                    new StringField('master_campaign_id'),
                    new StringField('campaign_name'),
                    new StringField('campaign'),
                    new StringField('medium'),
                    new StringField('source'),
                    new StringField('term'),
                    new StringField('content'),
                    new StringField('notes'),
                    new IntegerField('type_of_page'),
                    new StringField('marketo_page'),
                    new StringField('marketo_page_name'),
                    new StringField('url'),
                    new StringField('full_url'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new StringField('short_url'),
                    new IntegerField('clicks')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('UTM Tracking', 'campaign_utm_id', 'campaign_utm_id_campaign_name', 'insert_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', $editor, $this->dataset, $lookupDataset, 'campaign_utm_id', 'campaign_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Modified By', 'modified_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_NAME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for modified_date field
            //
            $editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Modified Date', 'modified_date', $editor, $this->dataset);
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
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_email_name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_description_handler_print');
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
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_utm_id', 'campaign_utm_id_campaign_name', 'UTM Tracking', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_email_name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_description_handler_export');
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
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_utm_id', 'campaign_utm_id_campaign_name', 'UTM Tracking', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_Type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_email_name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_description_handler_compare');
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
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_utm_id', 'campaign_utm_id_campaign_name', 'UTM Tracking', $this->dataset);
            $column->SetOrderable(true);
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
            	<div class="mark-bd-placeholder-img mr-3"><img src="apps/icons/comms-color.png" width="80" height="79"></div>
            	<div class="mark-media-body">
            		<h5 class="mt-0 h5">What will you find here</h5>
            		<p class="mark-p">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
            		<a href="campaign_program_name_generator.php" class="stretched-link">View Live Lists</a>
            	</div>
            </div>');
            $this->SetHidePageListByDefault(true);
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_email_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_description_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_email_name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_email_name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new IntegerField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new IntegerField('emails_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_comms_local_region_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value')
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
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_utm`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new IntegerField('has_brief'),
                    new StringField('master_campaign_id'),
                    new StringField('campaign_name'),
                    new StringField('campaign'),
                    new StringField('medium'),
                    new StringField('source'),
                    new StringField('term'),
                    new StringField('content'),
                    new StringField('notes'),
                    new IntegerField('type_of_page'),
                    new StringField('marketo_page'),
                    new StringField('marketo_page_name'),
                    new StringField('url'),
                    new StringField('full_url'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new StringField('short_url'),
                    new IntegerField('clicks')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', 'campaign_utm_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new IntegerField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new IntegerField('emails_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_region_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value')
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
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_utm`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new IntegerField('has_brief'),
                    new StringField('master_campaign_id'),
                    new StringField('campaign_name'),
                    new StringField('campaign'),
                    new StringField('medium'),
                    new StringField('source'),
                    new StringField('term'),
                    new StringField('content'),
                    new StringField('notes'),
                    new IntegerField('type_of_page'),
                    new StringField('marketo_page'),
                    new StringField('marketo_page_name'),
                    new StringField('url'),
                    new StringField('full_url'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new StringField('short_url'),
                    new IntegerField('clicks')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', 'campaign_utm_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email_name field
            //
            $column = new TextViewColumn('email_name', 'email_name', 'Email Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_email_name_handler_', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_description_handler_', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new IntegerField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new IntegerField('emails_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_comms_local_region_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value')
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
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_utm`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new IntegerField('has_brief'),
                    new StringField('master_campaign_id'),
                    new StringField('campaign_name'),
                    new StringField('campaign'),
                    new StringField('medium'),
                    new StringField('source'),
                    new StringField('term'),
                    new StringField('content'),
                    new StringField('notes'),
                    new IntegerField('type_of_page'),
                    new StringField('marketo_page'),
                    new StringField('marketo_page_name'),
                    new StringField('url'),
                    new StringField('full_url'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new StringField('short_url'),
                    new IntegerField('clicks')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', 'campaign_utm_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new IntegerField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new IntegerField('emails_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_region_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value')
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
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_utm`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new IntegerField('has_brief'),
                    new StringField('master_campaign_id'),
                    new StringField('campaign_name'),
                    new StringField('campaign'),
                    new StringField('medium'),
                    new StringField('source'),
                    new StringField('term'),
                    new StringField('content'),
                    new StringField('notes'),
                    new IntegerField('type_of_page'),
                    new StringField('marketo_page'),
                    new StringField('marketo_page_name'),
                    new StringField('url'),
                    new StringField('full_url'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new StringField('short_url'),
                    new IntegerField('clicks')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_id_search', 'campaign_utm_id', 'campaign_name', null, 20);
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
    
    class campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_utm`');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_utm_id', true, true, true),
                    new IntegerField('has_brief'),
                    new StringField('master_campaign_id'),
                    new StringField('campaign_name'),
                    new StringField('campaign'),
                    new StringField('medium'),
                    new StringField('source'),
                    new StringField('term'),
                    new StringField('content'),
                    new StringField('notes'),
                    new IntegerField('type_of_page'),
                    new StringField('marketo_page'),
                    new StringField('marketo_page_name'),
                    new StringField('url'),
                    new StringField('full_url'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new StringField('short_url'),
                    new IntegerField('clicks')
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
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_notes_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for type_of_page field
            //
            $column = new NumberViewColumn('type_of_page', 'type_of_page', 'Type Of Page', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for marketo_page field
            //
            $column = new TextViewColumn('marketo_page', 'marketo_page', 'Marketo Page', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_marketo_page_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for marketo_page_name field
            //
            $column = new TextViewColumn('marketo_page_name', 'marketo_page_name', 'Marketo Page Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_marketo_page_name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for full_url field
            //
            $column = new TextViewColumn('full_url', 'full_url', 'Full Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_full_url_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_created_by_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for short_url field
            //
            $column = new TextViewColumn('short_url', 'short_url', 'Short Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_short_url_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for clicks field
            //
            $column = new NumberViewColumn('clicks', 'clicks', 'Clicks', $this->dataset);
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
            
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_notes_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for marketo_page field
            //
            $column = new TextViewColumn('marketo_page', 'marketo_page', 'Marketo Page', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_marketo_page_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for marketo_page_name field
            //
            $column = new TextViewColumn('marketo_page_name', 'marketo_page_name', 'Marketo Page Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_marketo_page_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for full_url field
            //
            $column = new TextViewColumn('full_url', 'full_url', 'Full Url', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_full_url_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_created_by_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for short_url field
            //
            $column = new TextViewColumn('short_url', 'short_url', 'Short Url', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage_short_url_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
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
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new IntegerField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new IntegerField('emails_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
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
            // View column for region field
            //
            $column = new TextViewColumn('region', 'region', 'Region', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_idModalViewPage_territory_handler_view');
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_idModalViewPage_industry_handler_view');
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
            
            
            //
            // View column for territory field
            //
            $column = new TextViewColumn('territory', 'territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_idModalViewPage_territory_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_idModalViewPage_industry_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
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
                    new DateTimeField('updated_date')
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_master_campaign_idModalViewPage_campaign_name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_master_campaign_idModalViewPage_objective_handler_view');
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_master_campaign_idModalViewPage_b_region_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for b_country field
            //
            $column = new TextViewColumn('b_country', 'b_country', 'B Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_master_campaign_idModalViewPage_b_country_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_master_campaign_idModalViewPage_industry_handler_view');
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_master_campaign_idModalViewPage_owner_person_handler_view');
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_master_campaign_idModalViewPage_file_upload_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Asset Upload', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_master_campaign_idModalViewPage_asset_upload_handler_view');
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
            
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_master_campaign_idModalViewPage_campaign_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_master_campaign_idModalViewPage_objective_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for b_region field
            //
            $column = new TextViewColumn('b_region', 'b_region', 'B Region', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_master_campaign_idModalViewPage_b_region_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for b_country field
            //
            $column = new TextViewColumn('b_country', 'b_country', 'B Country', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_master_campaign_idModalViewPage_b_country_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_master_campaign_idModalViewPage_industry_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for owner_person field
            //
            $column = new TextViewColumn('owner_person', 'owner_person', 'Owner Person', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_master_campaign_idModalViewPage_owner_person_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'File Upload', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_master_campaign_idModalViewPage_file_upload_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Asset Upload', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_master_campaign_idModalViewPage_asset_upload_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
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
            $this->SetTitle('Campaign Program Name Generator');
            $this->SetMenuLabel('Program Generator');
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
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new IntegerField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new IntegerField('emails_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
            $this->dataset->AddLookupField('campaign_type', 'lookup_campaign_type', new StringField('Type_Value'), new StringField('Type', false, false, false, false, 'campaign_type_Type', 'campaign_type_Type_lookup_campaign_type'), 'campaign_type_Type_lookup_campaign_type');
            $this->dataset->AddLookupField('event_type', 'lookup_event_type', new IntegerField('Event_Type_ID'), new StringField('Event_Type', false, false, false, false, 'event_type_Event_Type', 'event_type_Event_Type_lookup_event_type'), 'event_type_Event_Type_lookup_event_type');
            $this->dataset->AddLookupField('region', 'lookup_region', new StringField('Region_Value'), new StringField('Region', false, false, false, false, 'region_Region', 'region_Region_lookup_region'), 'region_Region_lookup_region');
            $this->dataset->AddLookupField('sub_region', 'lookup_sub_regions', new StringField('Sub_Region_Value'), new StringField('Sub_Region', false, false, false, false, 'sub_region_Sub_Region', 'sub_region_Sub_Region_lookup_sub_regions'), 'sub_region_Sub_Region_lookup_sub_regions');
            $this->dataset->AddLookupField('territory', 'lookup_territory', new StringField('Territory_Value'), new StringField('Territory', false, false, false, false, 'territory_Territory', 'territory_Territory_lookup_territory'), 'territory_Territory_lookup_territory');
            $this->dataset->AddLookupField('country', 'country_list', new StringField('2_ISO'), new StringField('Country_Name', false, false, false, false, 'country_Country_Name', 'country_Country_Name_country_list'), 'country_Country_Name_country_list');
            $this->dataset->AddLookupField('industry', 'lookup_industries', new IntegerField('Industry_ID'), new StringField('Industry_Name', false, false, false, false, 'industry_Industry_Name', 'industry_Industry_Name_lookup_industries'), 'industry_Industry_Name_lookup_industries');
            $this->dataset->AddLookupField('job_function', 'lookup_job_functions', new IntegerField('Job_Functions_ID'), new StringField('Job Function', false, false, false, false, 'job_function_Job Function', 'job_function_Job Function_lookup_job_functions'), 'job_function_Job Function_lookup_job_functions');
            $this->dataset->AddLookupField('product', 'lookup_products', new StringField('Product_Value'), new StringField('Product', false, false, false, false, 'product_Product', 'product_Product_lookup_products'), 'product_Product_lookup_products');
            $this->dataset->AddLookupField('emails_tracker', 'lookup_email_tracker', new IntegerField('lookup_email_tracker_id'), new StringField('email_tracker_description', false, false, false, false, 'emails_tracker_email_tracker_description', 'emails_tracker_email_tracker_description_lookup_email_tracker'), 'emails_tracker_email_tracker_description_lookup_email_tracker');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
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
                new FilterColumn($this->dataset, 'program_generator_name_id', 'program_generator_name_id', 'Program Generator Name Id'),
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id'),
                new FilterColumn($this->dataset, 'campaign_program_name', 'campaign_program_name', 'Campaign Program Name'),
                new FilterColumn($this->dataset, 'SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Campaign Name'),
                new FilterColumn($this->dataset, 'campaign_type', 'campaign_type_Type', 'Campaign Type'),
                new FilterColumn($this->dataset, 'event_type', 'event_type_Event_Type', 'Event Type'),
                new FilterColumn($this->dataset, 'short_description', 'short_description', 'Short Description'),
                new FilterColumn($this->dataset, 'region', 'region_Region', 'Region'),
                new FilterColumn($this->dataset, 'sub_region', 'sub_region_Sub_Region', 'Sub Region'),
                new FilterColumn($this->dataset, 'territory', 'territory_Territory', 'Territory'),
                new FilterColumn($this->dataset, 'country', 'country_Country_Name', 'Country'),
                new FilterColumn($this->dataset, 'industry', 'industry_Industry_Name', 'Industry'),
                new FilterColumn($this->dataset, 'job_function', 'job_function_Job Function', 'Job Function'),
                new FilterColumn($this->dataset, 'product', 'product_Product', 'Product'),
                new FilterColumn($this->dataset, 'm_ID', 'm_ID', 'M ID'),
                new FilterColumn($this->dataset, 'campaign_publish_date', 'campaign_publish_date', 'Go Live Date'),
                new FilterColumn($this->dataset, 'emails_tracker', 'emails_tracker_email_tracker_description', 'Emails Tracker'),
                new FilterColumn($this->dataset, 'created_by', 'created_by', 'Created By'),
                new FilterColumn($this->dataset, 'created_date', 'created_date', 'Created Date'),
                new FilterColumn($this->dataset, 'modified_by', 'modified_by', 'Modified By'),
                new FilterColumn($this->dataset, 'modified_date', 'modified_date', 'Modified Date')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['program_generator_name_id'])
                ->addColumn($columns['master_campaign_id'])
                ->addColumn($columns['campaign_program_name'])
                ->addColumn($columns['SFDC_child_campaign'])
                ->addColumn($columns['campaign_type'])
                ->addColumn($columns['event_type'])
                ->addColumn($columns['short_description'])
                ->addColumn($columns['region'])
                ->addColumn($columns['sub_region'])
                ->addColumn($columns['territory'])
                ->addColumn($columns['country'])
                ->addColumn($columns['industry'])
                ->addColumn($columns['job_function'])
                ->addColumn($columns['product'])
                ->addColumn($columns['m_ID'])
                ->addColumn($columns['campaign_publish_date'])
                ->addColumn($columns['emails_tracker'])
                ->addColumn($columns['created_by'])
                ->addColumn($columns['created_date'])
                ->addColumn($columns['modified_by'])
                ->addColumn($columns['modified_date']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('campaign_type')
                ->setOptionsFor('region')
                ->setOptionsFor('campaign_publish_date')
                ->setOptionsFor('emails_tracker');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('program_generator_name_id_edit');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
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
            
            $main_editor = new TextEdit('campaign_program_name');
            
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
            $main_editor->SetMaxLength(18);
            
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
            
            $main_editor = new Autocomplete('short_description_edit', $this->CreateLinkBuilder(), 'filter_builder_campaign_program_name_generator_short_description_ac');
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
            
            $main_editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_region_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('region', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_region_search');
            
            $text_editor = new TextEdit('region');
            
            $filterBuilder->addColumn(
                $columns['region'],
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
            
            $main_editor = new DynamicCombobox('country_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_country_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('country', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_country_search');
            
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
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('industry_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_industry_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('industry', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_industry_search');
            
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
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('job_function_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_job_function_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('job_function', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_job_function_search');
            
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
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('product_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_program_name_generator_product_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('product', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_program_name_generator_product_search');
            
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
            
            $main_editor = new TextEdit('created_by_edit');
            $main_editor->SetMaxLength(45);
            
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
            if (GetCurrentUserPermissionSetForDataSource('campaign_program_name_generator.campaign_tracker_comms_local')->HasViewGrant() && $withDetails)
            {
            //
            // View column for campaign_program_name_generator_campaign_tracker_comms_local detail
            //
            $column = new DetailColumn(array('program_generator_name_id'), 'campaign_program_name_generator.campaign_tracker_comms_local', 'campaign_program_name_generator_campaign_tracker_comms_local_handler', $this->dataset, 'Campaign Tracker Comms');
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_program_name_handler_list');
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
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Published On', $this->dataset);
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
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for program_generator_name_id field
            //
            $column = new NumberViewColumn('program_generator_name_id', 'program_generator_name_id', 'Program Generator Name Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_program_name_generator_master_campaign_idModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_program_name_handler_');
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
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->setNullLabel('');
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_territory_Territory_handler_');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('country', 'country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_industry_Industry_Name_handler_');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Job Function field
            //
            $column = new TextViewColumn('job_function', 'job_function_Job Function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Product field
            //
            $column = new TextViewColumn('product', 'product_Product', 'Product', $this->dataset);
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
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Published On', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for email_tracker_description field
            //
            $column = new TextViewColumn('emails_tracker', 'emails_tracker_email_tracker_description', 'How many emails will you be sending?', $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Master Campaign Id', 'master_campaign_id', 'master_campaign_id_campaign_name', 'edit_campaign_program_name_generator_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_program_name field
            //
            $editor = new TextAreaEdit('campaign_program_name_edit', 50, 1);
            $editColumn = new CustomEditColumn('Campaign Program Name', 'campaign_program_name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for SFDC_child_campaign field
            //
            $editor = new TextEdit('sfdc_child_campaign_edit');
            $editor->SetMaxLength(18);
            $editColumn = new CustomEditColumn('SFDC Campaign Name', 'SFDC_child_campaign', $editor, $this->dataset);
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
                    new StringField('Type_Value')
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
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'edit_campaign_program_name_generator_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for short_description field
            //
            $editor = new Autocomplete('short_description_edit', $this->CreateLinkBuilder(), 'edit_campaign_program_name_generator_short_description_ac');
            $editor->SetMaxLength(45);
            $editor->setMinimumInputLength(4);
            $editColumn = new CustomEditColumn('Short Description', 'short_description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'region', 'region_Region', 'edit_campaign_program_name_generator_region_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
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
            $editor = new DynamicCombobox('territory_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
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
            $editColumn = new DynamicLookupEditColumn('Territory', 'territory', 'territory_Territory', 'edit_campaign_program_name_generator_territory_search', $editor, $this->dataset, $lookupDataset, 'Territory_Value', 'Territory', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for country field
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
            $editColumn = new DynamicLookupEditColumn('Country', 'country', 'country_Country_Name', 'edit_campaign_program_name_generator_country_search', $editor, $this->dataset, $lookupDataset, '2_ISO', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new DynamicCombobox('industry_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Industry', 'industry', 'industry_Industry_Name', 'edit_campaign_program_name_generator_industry_search', $editor, $this->dataset, $lookupDataset, 'Industry_ID', 'Industry_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for job_function field
            //
            $editor = new DynamicCombobox('job_function_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $lookupDataset->setOrderByField('Job Function', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Job Function', 'job_function', 'job_function_Job Function', 'edit_campaign_program_name_generator_job_function_search', $editor, $this->dataset, $lookupDataset, 'Job_Functions_ID', 'Job Function', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new DynamicCombobox('product_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $lookupDataset->setOrderByField('Product', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Product', 'product', 'product_Product', 'edit_campaign_program_name_generator_product_search', $editor, $this->dataset, $lookupDataset, 'Product_Value', 'Product', '');
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
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Go Live Date', 'campaign_publish_date', $editor, $this->dataset);
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
                    new StringField('email_tracker_description')
                )
            );
            $lookupDataset->setOrderByField('email_tracker_description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('How many emails will you be sending?', 'emails_tracker', 'emails_tracker_email_tracker_description', 'edit_campaign_program_name_generator_emails_tracker_search', $editor, $this->dataset, $lookupDataset, 'lookup_email_tracker_id', 'email_tracker_description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Modified By', 'modified_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for modified_date field
            //
            $editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Modified Date', 'modified_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Master Campaign Id', 'master_campaign_id', 'master_campaign_id_campaign_name', 'multi_edit_campaign_program_name_generator_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_program_name field
            //
            $editor = new TextAreaEdit('campaign_program_name_edit', 50, 1);
            $editColumn = new CustomEditColumn('Campaign Program Name', 'campaign_program_name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for SFDC_child_campaign field
            //
            $editor = new TextEdit('sfdc_child_campaign_edit');
            $editor->SetMaxLength(18);
            $editColumn = new CustomEditColumn('SFDC Campaign Name', 'SFDC_child_campaign', $editor, $this->dataset);
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
                    new StringField('Type_Value')
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
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'multi_edit_campaign_program_name_generator_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for short_description field
            //
            $editor = new Autocomplete('short_description_edit', $this->CreateLinkBuilder(), 'multi_edit_campaign_program_name_generator_short_description_ac');
            $editor->SetMaxLength(45);
            $editor->setMinimumInputLength(4);
            $editColumn = new CustomEditColumn('Short Description', 'short_description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'region', 'region_Region', 'multi_edit_campaign_program_name_generator_region_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
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
            $editor = new DynamicCombobox('territory_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
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
            $editColumn = new DynamicLookupEditColumn('Territory', 'territory', 'territory_Territory', 'multi_edit_campaign_program_name_generator_territory_search', $editor, $this->dataset, $lookupDataset, 'Territory_Value', 'Territory', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for country field
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
            $editColumn = new DynamicLookupEditColumn('Country', 'country', 'country_Country_Name', 'multi_edit_campaign_program_name_generator_country_search', $editor, $this->dataset, $lookupDataset, '2_ISO', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new DynamicCombobox('industry_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Industry', 'industry', 'industry_Industry_Name', 'multi_edit_campaign_program_name_generator_industry_search', $editor, $this->dataset, $lookupDataset, 'Industry_ID', 'Industry_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for job_function field
            //
            $editor = new DynamicCombobox('job_function_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $lookupDataset->setOrderByField('Job Function', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Job Function', 'job_function', 'job_function_Job Function', 'multi_edit_campaign_program_name_generator_job_function_search', $editor, $this->dataset, $lookupDataset, 'Job_Functions_ID', 'Job Function', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new DynamicCombobox('product_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $lookupDataset->setOrderByField('Product', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Product', 'product', 'product_Product', 'multi_edit_campaign_program_name_generator_product_search', $editor, $this->dataset, $lookupDataset, 'Product_Value', 'Product', '');
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
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Go Live Date', 'campaign_publish_date', $editor, $this->dataset);
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
                    new StringField('email_tracker_description')
                )
            );
            $lookupDataset->setOrderByField('email_tracker_description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Emails Tracker', 'emails_tracker', 'emails_tracker_email_tracker_description', 'multi_edit_campaign_program_name_generator_emails_tracker_search', $editor, $this->dataset, $lookupDataset, 'lookup_email_tracker_id', 'email_tracker_description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(45);
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
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Modified By', 'modified_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for modified_date field
            //
            $editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Modified Date', 'modified_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Master Campaign Id', 'master_campaign_id', 'master_campaign_id_campaign_name', 'insert_campaign_program_name_generator_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_program_name field
            //
            $editor = new TextAreaEdit('campaign_program_name_edit', 50, 1);
            $editColumn = new CustomEditColumn('Campaign Program Name', 'campaign_program_name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for SFDC_child_campaign field
            //
            $editor = new TextEdit('sfdc_child_campaign_edit');
            $editor->SetMaxLength(18);
            $editColumn = new CustomEditColumn('SFDC Campaign Name', 'SFDC_child_campaign', $editor, $this->dataset);
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
                    new StringField('Type_Value')
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
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'insert_campaign_program_name_generator_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for short_description field
            //
            $editor = new Autocomplete('short_description_edit', $this->CreateLinkBuilder(), 'insert_campaign_program_name_generator_short_description_ac');
            $editor->SetMaxLength(45);
            $editor->setMinimumInputLength(4);
            $editColumn = new CustomEditColumn('Short Description', 'short_description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'region', 'region_Region', 'insert_campaign_program_name_generator_region_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
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
            $editor = new DynamicCombobox('territory_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
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
            $editColumn = new DynamicLookupEditColumn('Territory', 'territory', 'territory_Territory', 'insert_campaign_program_name_generator_territory_search', $editor, $this->dataset, $lookupDataset, 'Territory_Value', 'Territory', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for country field
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
            $editColumn = new DynamicLookupEditColumn('Country', 'country', 'country_Country_Name', 'insert_campaign_program_name_generator_country_search', $editor, $this->dataset, $lookupDataset, '2_ISO', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new DynamicCombobox('industry_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Industry', 'industry', 'industry_Industry_Name', 'insert_campaign_program_name_generator_industry_search', $editor, $this->dataset, $lookupDataset, 'Industry_ID', 'Industry_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for job_function field
            //
            $editor = new DynamicCombobox('job_function_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $lookupDataset->setOrderByField('Job Function', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Job Function', 'job_function', 'job_function_Job Function', 'insert_campaign_program_name_generator_job_function_search', $editor, $this->dataset, $lookupDataset, 'Job_Functions_ID', 'Job Function', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new DynamicCombobox('product_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $lookupDataset->setOrderByField('Product', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Product', 'product', 'product_Product', 'insert_campaign_program_name_generator_product_search', $editor, $this->dataset, $lookupDataset, 'Product_Value', 'Product', '');
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
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Go Live Date', 'campaign_publish_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
                    new StringField('email_tracker_description')
                )
            );
            $lookupDataset->setOrderByField('email_tracker_description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Emails Tracker', 'emails_tracker', 'emails_tracker_email_tracker_description', 'insert_campaign_program_name_generator_emails_tracker_search', $editor, $this->dataset, $lookupDataset, 'lookup_email_tracker_id', 'email_tracker_description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(45);
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
            // View column for program_generator_name_id field
            //
            $column = new NumberViewColumn('program_generator_name_id', 'program_generator_name_id', 'Program Generator Name Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_program_name_handler_print');
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
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->setNullLabel('');
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_territory_Territory_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('country', 'country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_industry_Industry_Name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Job Function field
            //
            $column = new TextViewColumn('job_function', 'job_function_Job Function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Product field
            //
            $column = new TextViewColumn('product', 'product_Product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Go Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for email_tracker_description field
            //
            $column = new TextViewColumn('emails_tracker', 'emails_tracker_email_tracker_description', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for program_generator_name_id field
            //
            $column = new NumberViewColumn('program_generator_name_id', 'program_generator_name_id', 'Program Generator Name Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_program_name_handler_export');
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
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->setNullLabel('');
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_territory_Territory_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('country', 'country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_industry_Industry_Name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Job Function field
            //
            $column = new TextViewColumn('job_function', 'job_function_Job Function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Product field
            //
            $column = new TextViewColumn('product', 'product_Product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Go Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for email_tracker_description field
            //
            $column = new TextViewColumn('emails_tracker', 'emails_tracker_email_tracker_description', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
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
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_campaign_program_name_handler_compare');
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
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->setNullLabel('');
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
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_territory_Territory_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('country', 'country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_program_name_generator_industry_Industry_Name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Job Function field
            //
            $column = new TextViewColumn('job_function', 'job_function_Job Function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Product field
            //
            $column = new TextViewColumn('product', 'product_Product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Go Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for email_tracker_description field
            //
            $column = new TextViewColumn('emails_tracker', 'emails_tracker_email_tracker_description', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
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
                          <div class="mark-bd-placeholder-img mr-3"><img src="apps/icons/program-generator-color.png" width="80" height="79"></div>
                          <div class="mark-media-body">
                            <h5 class="mt-0 h5">What will you find here</h5>
                            <p class="mark-p">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            <a href="campaign_global_list.php" class="stretched-link">View Live Lists</a>
                          </div>
                        </div>');
            $this->SetHidePageListByDefault(true);
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new campaign_program_name_generator_campaign_tracker_comms_localPage('campaign_program_name_generator_campaign_tracker_comms_local', $this, array('program_generator_name_id'), array('program_generator_name_id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionSetForDataSource('campaign_program_name_generator.campaign_tracker_comms_local'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('campaign_program_name_generator.campaign_tracker_comms_local'));
            $detailPage->SetHttpHandlerName('campaign_program_name_generator_campaign_tracker_comms_local_handler');
            $handler = new PageHTTPHandler('campaign_program_name_generator_campaign_tracker_comms_local_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_program_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_program_name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_territory_Territory_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_industry_Industry_Name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_program_name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_territory_Territory_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_industry_Industry_Name_handler_compare', $column);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value')
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
                    new StringField('Event_Type')
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_region_search', 'Region_Value', 'Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_territory_search', 'Territory_Value', 'Territory', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_country_search', '2_ISO', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_industry_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $lookupDataset->setOrderByField('Job Function', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_job_function_search', 'Job_Functions_ID', 'Job Function', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $lookupDataset->setOrderByField('Product', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_product_search', 'Product_Value', 'Product', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description')
                )
            );
            $lookupDataset->setOrderByField('email_tracker_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_program_name_generator_emails_tracker_search', 'lookup_email_tracker_id', 'email_tracker_description', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value')
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
                    new StringField('Event_Type')
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_region_search', 'Region_Value', 'Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_country_search', '2_ISO', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_industry_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $lookupDataset->setOrderByField('Job Function', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_job_function_search', 'Job_Functions_ID', 'Job Function', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $lookupDataset->setOrderByField('Product', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_product_search', 'Product_Value', 'Product', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description')
                )
            );
            $lookupDataset->setOrderByField('email_tracker_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_program_name_generator_emails_tracker_search', 'lookup_email_tracker_id', 'email_tracker_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_campaign_program_name_handler_', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->setNullLabel('');
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_territory_Territory_handler_', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_program_name_generator_industry_Industry_Name_handler_', $column);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value')
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
                    new StringField('Event_Type')
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_region_search', 'Region_Value', 'Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_territory_search', 'Territory_Value', 'Territory', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_country_search', '2_ISO', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_industry_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $lookupDataset->setOrderByField('Job Function', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_job_function_search', 'Job_Functions_ID', 'Job Function', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $lookupDataset->setOrderByField('Product', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_product_search', 'Product_Value', 'Product', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description')
                )
            );
            $lookupDataset->setOrderByField('email_tracker_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_program_name_generator_emails_tracker_search', 'lookup_email_tracker_id', 'email_tracker_description', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_campaign_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Type_ID', true, true, true),
                    new StringField('Type'),
                    new StringField('Type_Value')
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
                    new StringField('Event_Type')
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_region_search', 'Region_Value', 'Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_territory_search', 'Territory_Value', 'Territory', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_country_search', '2_ISO', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_industry_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_job_functions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Job_Functions_ID', true, true, true),
                    new StringField('Job Function')
                )
            );
            $lookupDataset->setOrderByField('Job Function', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_job_function_search', 'Job_Functions_ID', 'Job Function', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $lookupDataset->setOrderByField('Product', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_product_search', 'Product_Value', 'Product', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_email_tracker`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_email_tracker_id', true, true, true),
                    new StringField('email_tracker_description')
                )
            );
            $lookupDataset->setOrderByField('email_tracker_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_program_name_generator_emails_tracker_search', 'lookup_email_tracker_id', 'email_tracker_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            new campaign_program_name_generator_campaign_tracker_comms_local_campaign_utm_idModalViewPage($this, GetCurrentUserPermissionSetForDataSource('campaign_program_name_generator.campaign_tracker_comms_local.campaign_utm_id'));
            new campaign_program_name_generator_campaign_tracker_comms_local_program_generator_name_idModalViewPage($this, GetCurrentUserPermissionSetForDataSource('campaign_program_name_generator.campaign_tracker_comms_local.program_generator_name_id'));
            new campaign_program_name_generator_master_campaign_idModalViewPage($this, GetCurrentUserPermissionSetForDataSource('campaign_program_name_generator.master_campaign_id'));
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
               
               $aprogram_generator_name_id = $rowData['program_generator_name_id'];
               $amaster_campaign_id = $rowData['master_campaign_id'];
                                       
               $sql = "CALL campaignProgramNameGenerator($aprogram_generator_name_id, $amaster_campaign_id);";
            
               $this->GetConnection()->ExecSQL($sql);  
            
               $message = '<p>Record processed successfully updated.</p>';
            }
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
            
               // Check if the substring exists inside the string     
               
               $aprogram_generator_name_id = $rowData['program_generator_name_id'];
               $amaster_campaign_id = $rowData['master_campaign_id'];
                                       
               $sql = "CALL campaignProgramNameGenerator($aprogram_generator_name_id, $amaster_campaign_id);";
            
               $this->GetConnection()->ExecSQL($sql);  
            
               $message = '<p>Record processed successfully updated.</p>';
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
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
            $layout->setMode(FormLayoutMode::VERTICAL);
            
            $briefGroup = $layout->addGroup('Overview', 12);
            $briefGroup->addRow()->addCol($columns['campaign_program_name'], 12);
            
            $storageGroup = $layout->addGroup('Program Information', 12);
            $storageGroup->addRow()
                    ->addCol($columns['master_campaign_id'], 12);
            $storageGroup->addRow()
                    ->addCol($columns['SFDC_child_campaign'], 6)
                    ->addCol($columns['campaign_type'], 6);
            $storageGroup->addRow()
                        ->addCol($columns['event_type'], 12);
            
            $storageGroup = $layout->addGroup('Target Audience', 12);
            $storageGroup->addRow()
                    ->addCol($columns['region'], 4)
                    ->addCol($columns['sub_region'], 4)
                    ->addCol($columns['territory'], 4);
            $storageGroup->addRow()
                    ->addCol($columns['country'], 12);
            $storageGroup->addRow()
                    ->addCol($columns['industry'], 6)
                    ->addCol($columns['job_function'], 6);
            
                
                $storageGroup = $layout->addGroup('Program Information', 12);
                $storageGroup->addRow()
                    ->addCol($columns['short_description'], 12);
                $storageGroup->addRow()
                    ->addCol($columns['product'], 6)
                    ->addCol($columns['m_ID'], 6);
                    $storageGroup->addRow()
                    ->addCol($columns['campaign_publish_date'], 6)
                    ->addCol($columns['emails_tracker'], 6);
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
                       if (($row['role_name'] === 'manager') || ($row['role_name'] === 'regional marketing')) {
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
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new campaign_program_name_generatorPage("campaign_program_name_generator", "campaign_program_name_generator.php", GetCurrentUserPermissionSetForDataSource("campaign_program_name_generator"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("campaign_program_name_generator"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
