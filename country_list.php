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
    
    
    
    class country_listPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Country List');
            $this->SetMenuLabel('Country List');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $this->dataset->addFields(
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
            $this->dataset->AddLookupField('c_Region', 'lookup_region', new StringField('Region'), new StringField('Region', false, false, false, false, 'c_Region_Region', 'c_Region_Region_lookup_region'), 'c_Region_Region_lookup_region');
            $this->dataset->AddLookupField('Sub_Region', 'lookup_sub_regions', new StringField('Sub_Region'), new StringField('Sub_Region', false, false, false, false, 'Sub_Region_Sub_Region', 'Sub_Region_Sub_Region_lookup_sub_regions'), 'Sub_Region_Sub_Region_lookup_sub_regions');
            $this->dataset->AddLookupField('Territories', 'lookup_territory', new StringField('Territory'), new StringField('Territory', false, false, false, false, 'Territories_Territory', 'Territories_Territory_lookup_territory'), 'Territories_Territory_lookup_territory');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new CustomPageNavigator('partition', $this, $this->dataset, 'Group by Regions', $result);
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
                new FilterColumn($this->dataset, 'Country_ID', 'Country_ID', 'Country ID'),
                new FilterColumn($this->dataset, 'Country_Name', 'Country_Name', 'Country Name'),
                new FilterColumn($this->dataset, 'Dialing_Code', 'Dialing_Code', 'Dialing Code'),
                new FilterColumn($this->dataset, '2_ISO', '2_ISO', '2 ISO'),
                new FilterColumn($this->dataset, 'Preferred_Langauge', 'Preferred_Langauge', 'Preferred Langauge'),
                new FilterColumn($this->dataset, 'c_Region', 'c_Region_Region', 'Region'),
                new FilterColumn($this->dataset, 'Sub_Region', 'Sub_Region_Sub_Region', 'Sub Region'),
                new FilterColumn($this->dataset, 'Territories', 'Territories_Territory', 'Territories')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Country_Name'])
                ->addColumn($columns['Dialing_Code'])
                ->addColumn($columns['2_ISO'])
                ->addColumn($columns['Preferred_Langauge'])
                ->addColumn($columns['c_Region'])
                ->addColumn($columns['Sub_Region'])
                ->addColumn($columns['Territories']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('c_Region')
                ->setOptionsFor('Sub_Region')
                ->setOptionsFor('Territories');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('country_name_edit');
            $main_editor->SetMaxLength(44);
            
            $filterBuilder->addColumn(
                $columns['Country_Name'],
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
            
            $main_editor = new TextEdit('dialing_code_edit');
            $main_editor->SetMaxLength(22);
            
            $filterBuilder->addColumn(
                $columns['Dialing_Code'],
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
            
            $main_editor = new TextEdit('2_iso_edit');
            $main_editor->SetMaxLength(2);
            
            $filterBuilder->addColumn(
                $columns['2_ISO'],
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
            
            $main_editor = new TextEdit('preferred_langauge_edit');
            $main_editor->SetMaxLength(10);
            
            $filterBuilder->addColumn(
                $columns['Preferred_Langauge'],
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
            
            $main_editor = new DynamicCombobox('c_region_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_country_list_c_Region_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('c_Region', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_country_list_c_Region_search');
            
            $text_editor = new TextEdit('c_Region');
            
            $filterBuilder->addColumn(
                $columns['c_Region'],
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
            $main_editor->SetHandlerName('filter_builder_country_list_Sub_Region_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Sub_Region', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_country_list_Sub_Region_search');
            
            $text_editor = new TextEdit('Sub_Region');
            
            $filterBuilder->addColumn(
                $columns['Sub_Region'],
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
            
            $main_editor = new DynamicCombobox('territories_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_country_list_Territories_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Territories', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_country_list_Territories_search');
            
            $text_editor = new TextEdit('Territories');
            
            $filterBuilder->addColumn(
                $columns['Territories'],
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
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country_Name', 'Country_Name', 'Country Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Dialing_Code field
            //
            $column = new TextViewColumn('Dialing_Code', 'Dialing_Code', 'Dialing Code', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for 2_ISO field
            //
            $column = new TextViewColumn('2_ISO', '2_ISO', '2 ISO', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Preferred_Langauge field
            //
            $column = new TextViewColumn('Preferred_Langauge', 'Preferred_Langauge', 'Preferred Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('c_Region', 'c_Region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('Sub_Region', 'Sub_Region_Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('Territories', 'Territories_Territory', 'Territories', $this->dataset);
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
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country_Name', 'Country_Name', 'Country Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Dialing_Code field
            //
            $column = new TextViewColumn('Dialing_Code', 'Dialing_Code', 'Dialing Code', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for 2_ISO field
            //
            $column = new TextViewColumn('2_ISO', '2_ISO', '2 ISO', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Preferred_Langauge field
            //
            $column = new TextViewColumn('Preferred_Langauge', 'Preferred_Langauge', 'Preferred Langauge', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('c_Region', 'c_Region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('Sub_Region', 'Sub_Region_Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('Territories', 'Territories_Territory', 'Territories', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Country_Name field
            //
            $editor = new TextEdit('country_name_edit');
            $editor->SetMaxLength(44);
            $editColumn = new CustomEditColumn('Country Name', 'Country_Name', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Dialing_Code field
            //
            $editor = new TextEdit('dialing_code_edit');
            $editor->SetMaxLength(22);
            $editColumn = new CustomEditColumn('Dialing Code', 'Dialing_Code', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for 2_ISO field
            //
            $editor = new TextEdit('2_iso_edit');
            $editor->SetMaxLength(2);
            $editColumn = new CustomEditColumn('2 ISO', '2_ISO', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Preferred_Langauge field
            //
            $editor = new TextEdit('preferred_langauge_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Preferred Langauge', 'Preferred_Langauge', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for c_Region field
            //
            $editor = new DynamicCombobox('c_region_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'c_Region', 'c_Region_Region', 'edit_country_list_c_Region_search', $editor, $this->dataset, $lookupDataset, 'Region', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Sub_Region field
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
            $editColumn = new DynamicLookupEditColumn('Sub Region', 'Sub_Region', 'Sub_Region_Sub_Region', 'edit_country_list_Sub_Region_search', $editor, $this->dataset, $lookupDataset, 'Sub_Region', 'Sub_Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Territories field
            //
            $editor = new DynamicCombobox('territories_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Territories', 'Territories', 'Territories_Territory', 'edit_country_list_Territories_search', $editor, $this->dataset, $lookupDataset, 'Territory', 'Territory', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Country_Name field
            //
            $editor = new TextEdit('country_name_edit');
            $editor->SetMaxLength(44);
            $editColumn = new CustomEditColumn('Country Name', 'Country_Name', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Dialing_Code field
            //
            $editor = new TextEdit('dialing_code_edit');
            $editor->SetMaxLength(22);
            $editColumn = new CustomEditColumn('Dialing Code', 'Dialing_Code', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for 2_ISO field
            //
            $editor = new TextEdit('2_iso_edit');
            $editor->SetMaxLength(2);
            $editColumn = new CustomEditColumn('2 ISO', '2_ISO', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Preferred_Langauge field
            //
            $editor = new TextEdit('preferred_langauge_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Preferred Langauge', 'Preferred_Langauge', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for c_Region field
            //
            $editor = new DynamicCombobox('c_region_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'c_Region', 'c_Region_Region', 'multi_edit_country_list_c_Region_search', $editor, $this->dataset, $lookupDataset, 'Region', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Sub_Region field
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
            $editColumn = new DynamicLookupEditColumn('Sub Region', 'Sub_Region', 'Sub_Region_Sub_Region', 'multi_edit_country_list_Sub_Region_search', $editor, $this->dataset, $lookupDataset, 'Sub_Region', 'Sub_Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Territories field
            //
            $editor = new DynamicCombobox('territories_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Territories', 'Territories', 'Territories_Territory', 'multi_edit_country_list_Territories_search', $editor, $this->dataset, $lookupDataset, 'Territory', 'Territory', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Country_Name field
            //
            $editor = new TextEdit('country_name_edit');
            $editor->SetMaxLength(44);
            $editColumn = new CustomEditColumn('Country Name', 'Country_Name', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Dialing_Code field
            //
            $editor = new TextEdit('dialing_code_edit');
            $editor->SetMaxLength(22);
            $editColumn = new CustomEditColumn('Dialing Code', 'Dialing_Code', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for 2_ISO field
            //
            $editor = new TextEdit('2_iso_edit');
            $editor->SetMaxLength(2);
            $editColumn = new CustomEditColumn('2 ISO', '2_ISO', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Preferred_Langauge field
            //
            $editor = new TextEdit('preferred_langauge_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Preferred Langauge', 'Preferred_Langauge', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for c_Region field
            //
            $editor = new DynamicCombobox('c_region_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Region', 'c_Region', 'c_Region_Region', 'insert_country_list_c_Region_search', $editor, $this->dataset, $lookupDataset, 'Region', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Sub_Region field
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
            $editColumn = new DynamicLookupEditColumn('Sub Region', 'Sub_Region', 'Sub_Region_Sub_Region', 'insert_country_list_Sub_Region_search', $editor, $this->dataset, $lookupDataset, 'Sub_Region', 'Sub_Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Territories field
            //
            $editor = new DynamicCombobox('territories_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Territories', 'Territories', 'Territories_Territory', 'insert_country_list_Territories_search', $editor, $this->dataset, $lookupDataset, 'Territory', 'Territory', '');
            $editColumn->SetAllowSetToNull(true);
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
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country_Name', 'Country_Name', 'Country Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Dialing_Code field
            //
            $column = new TextViewColumn('Dialing_Code', 'Dialing_Code', 'Dialing Code', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for 2_ISO field
            //
            $column = new TextViewColumn('2_ISO', '2_ISO', '2 ISO', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Preferred_Langauge field
            //
            $column = new TextViewColumn('Preferred_Langauge', 'Preferred_Langauge', 'Preferred Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('c_Region', 'c_Region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('Sub_Region', 'Sub_Region_Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('Territories', 'Territories_Territory', 'Territories', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country_Name', 'Country_Name', 'Country Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Dialing_Code field
            //
            $column = new TextViewColumn('Dialing_Code', 'Dialing_Code', 'Dialing Code', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for 2_ISO field
            //
            $column = new TextViewColumn('2_ISO', '2_ISO', '2 ISO', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Preferred_Langauge field
            //
            $column = new TextViewColumn('Preferred_Langauge', 'Preferred_Langauge', 'Preferred Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('c_Region', 'c_Region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('Sub_Region', 'Sub_Region_Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('Territories', 'Territories_Territory', 'Territories', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country_Name', 'Country_Name', 'Country Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Dialing_Code field
            //
            $column = new TextViewColumn('Dialing_Code', 'Dialing_Code', 'Dialing Code', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for 2_ISO field
            //
            $column = new TextViewColumn('2_ISO', '2_ISO', '2 ISO', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Preferred_Langauge field
            //
            $column = new TextViewColumn('Preferred_Langauge', 'Preferred_Langauge', 'Preferred Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('c_Region', 'c_Region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('Sub_Region', 'Sub_Region_Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('Territories', 'Territories_Territory', 'Territories', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
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
        
        private $partitions = array(1 => array('\'Americas\''), 2 => array('\'EMEA\''), 3 => array('\'INDOPAC\''), 4 => array('\'China\''), 5 => array('\'Japan\''), 6 => array('\'Korea\''));
        
        function partition_GetPartitionsHandler(&$partitions)
        {
            $partitions[1] = 'Americas';
            $partitions[2] = 'EMEA';
            $partitions[3] = 'INDOPAC';
            $partitions[4] = 'China';
            $partitions[5] = 'Japan';
            $partitions[6] = 'Korea';
        }
        
        function partition_GetPartitionConditionHandler($partitionName, &$condition)
        {
            $condition = '';
            if (isset($partitionName) && isset($this->partitions[$partitionName]))
                foreach ($this->partitions[$partitionName] as $value)
                    AddStr($condition, sprintf('(c_Region = %s)', $this->PrepareTextForSQL($value)), ' OR ');
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
                          <div class="mark-bd-placeholder-img mr-3"><img src="http://mktportal.mscsoftware.com/icons/globe-color.png" width="80" height="79"></div>
                          <div class="mark-media-body">
                            <h5 class="mt-0 h5">What will you find here</h5>
                            <p class="mark-p">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            <a href="http://mktportal.mscsoftware.com/master_campaign_global.php" class="stretched-link">Go to Master Campaign</a>
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_country_list_c_Region_search', 'Region', 'Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_country_list_Sub_Region_search', 'Sub_Region', 'Sub_Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_country_list_Territories_search', 'Territory', 'Territory', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_country_list_c_Region_search', 'Region', 'Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_country_list_Sub_Region_search', 'Sub_Region', 'Sub_Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_country_list_Territories_search', 'Territory', 'Territory', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_country_list_c_Region_search', 'Region', 'Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_country_list_Sub_Region_search', 'Sub_Region', 'Sub_Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_country_list_Territories_search', 'Territory', 'Territory', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_country_list_c_Region_search', 'Region', 'Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_country_list_Sub_Region_search', 'Sub_Region', 'Sub_Region', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_country_list_Territories_search', 'Territory', 'Territory', null, 20);
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
        $Page = new country_listPage("country_list", "country_list.php", GetCurrentUserPermissionSetForDataSource("country_list"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("country_list"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
