<div>{literal}
	<link rel="stylesheet" type="text/css" href="http://mktportal.mscsoftware.com/apps/css/calendar.css">
{/literal}
<div class="container">
	<div class="page-header">
		<div class="pull-left form-inline">
			<ul style="margin-bottom: 14px; list-style: none; display: table; padding-left: 0 !important; width: 600px;">
				<li class="li-event li-event-special">Event Campaign</li>
				<li class="li-event li-event-info">Solution Campaign</li>
				<li class="li-event li-event-success">Product Launch</li>
				<li class="li-event li-event-important">Not Specified</li>
			</ul>
		</div>
		<div class="pull-right form-inline">
			<div class="btn-group">
				<button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
				<button class="btn btn-default" data-calendar-nav="today">Today</button>
				<button class="btn btn-primary" data-calendar-nav="next">Next >></button>
			</div>
			<div class="btn-group">
				<button class="btn btn-warning" data-calendar-view="year">Year</button>
				<button class="btn btn-warning active" data-calendar-view="month">Month</button>
				<button class="btn btn-warning" data-calendar-view="week">Week</button>
				<button class="btn btn-warning" data-calendar-view="day">Day</button>
			</div>
		</div>
		<h3 style="padding-top: 25px; font-weight: 600;"></h3>
		<small>To book your brief slot click on <a href="brief.php?operation=insert">Campaign Request</a></small>
	</div>
	<div class="row">
		<div class="col-md-9">
			<div id="showEventCalendar"></div>
		</div>
		<div class="col-md-3">
			<h4>All Events List</h4>
			<ul id="eventlist" class="nav nav-list"></ul>
		</div>
	</div>
</div>
{literal}
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script type="text/javascript" src="http://mktportal.mscsoftware.com/apps/js/calendar.js"></script>
	<script type="text/javascript" src="http://mktportal.mscsoftware.com/apps/js/events.js"></script>
{/literal}
</div>

