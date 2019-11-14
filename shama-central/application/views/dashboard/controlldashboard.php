<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>

<?php if(count($roles_right) > 0){ ?>
<!-- right content -->
<div class="col-sm-10">
	<?php
	// require_footer 
	require APPPATH.'views/__layout/filterlayout.php';
	?>
	<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 widget" ng-init="nosales= false;sloader=0 ; salesstore='All' ; sstore = 'all'; stype = 'Column Chart' ">
		<div class="widget-header" id="widget-header" >
			<!-- widget options -->
  			<div class="option-row">
  				<ul class="widget-menu">
  					<li>	
				 		<div class="dropdown">
								<button class="btn btn-default custom-button dropdown-toggle" ng-model="sstore" type="button" data-toggle="dropdown">{{salesstore}}
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<?php  if(isset($stores)){ ?>
                            		<?php foreach ($stores as $key => $value) {?>
                            			<li>
                            				<a href="#" ng-click="changesalestore('<?php echo $value->store; ?>','<?php echo $value->name; ?>')">Store: <?php echo $value->name; ?></a>
                            			</li>
                            		<?php } ?>
                                <?php } ?>
								</ul>
							</div> 
  					</li>
  					<li>	
				 		<div class="dropdown">
								<button class="btn btn-default custom-button dropdown-toggle" type="button" data-toggle="dropdown">
									<span id="stype">{{stype}}</span>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li>
										<a href="#" ng-click="changesalechart('chart')">Column Chart</a>
										<a href="#" ng-click="changesalechart('table')">Table Chart</a>
									</li>
								</ul>
							</div> 
  					</li>
  				</ul>
  			</div>
			<!-- widget title -->
				<div class="col-lg-12 widget-title">
  				<span id="">
						Sales - {{salesstore}}
					</span>
				</div>
		</div>
		<div class="widget-body">
			<div class="col-lg-12 ">
				<div ng-if="sloader=1" class="loader-container"></div>
				<div class="dashboard-no-report-data" id="sales-no-data-container" ng-if="salesreporttype==3">
					<span>No sales data found.</span>
				</div>
				<div class="table-choice" id="sales-table" ng-if="salesreporttype == 1">
					<table class="table myclass" cellpadding="0" cellspacing="0" border="0">
				    	<thead>
				      		<tr>
				      			<th></th>
					        	<th>This YR</th>
					        	<th>Last YR</th>
					        	<th>+/-%</th>
					      	</tr>
					    </thead>
					    <tbody>
				      		<tr>
				      			<td>Today</td>
					        	<td>
					        		<span class="glyphicon {{spt}}" aria-hidden="true"></span>
					        		{{tyTodaySales}}
					        	</td>
					        	<td>{{lyTodaySales}}</td>
					        	<td>{{tSalesPercent}}</td>
					      	</tr>
				      		<tr>
				      			<td>Mth</td>
					        	<td>
					        		<span class="glyphicon {{spm}}" aria-hidden="true"></span>
					        		{{tyMonthSales}}
					        	</td>
					        	<td>{{lyMonthSales}}</td>
					        	<td>{{mSalesPercent}}</td>
					      	</tr>
				      		<tr>
				      			<td>Qtr</td>
					           	<td>
					           		<span class="glyphicon {{spq}}" aria-hidden="true"></span>
					           		{{tyQuarterSales}}
					           	</td>
					        	<td>{{lyQuarterSales}}</td>
					        	<td>{{qSalesPercent}}</td>
					      	</tr>
				      		<tr>
				      			<td>Year</td>
				        	   	<td>
				        	   		<span class="glyphicon {{spy}}" aria-hidden="true"></span>
				        	   		{{tyYearSales}}
				        	   	</td>
					        	<td>{{lyYearSales}}</td>
					        	<td>{{ySalesPercent}}</td>
					      	</tr>
					    </tbody>
					</table>
				</div>
				<div class="graph-choice" id="sales-graph-container" ng-if="salesreporttype==2">
					<div id="graph-container"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- lower row -->
		<!-- first row -->
		<div class="row">
			<div class="col-lg-12 ">
				<!-- item list-->
				<!-- item -->
				<div class="col-lg-4  widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
							<div class="col-lg-12 ">
								<!-- widget options -->
			  					<div class="widget-item-list">
			  						<ul class="nav nav-pills">
	  									<li class="dropdown">
	    									<a aria-expanded="true" data-view="all" id="st" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      <span id="option-text">All</span>
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
										    	<?php  if(isset($stores)){ ?>
	                                            	<?php foreach ($stores as $key => $value) {?>
											      		<li>
												    		<a href="#" data-view="<?php echo $value->store; ?>" id="store_value">
											    				<span class="drowdown-menu-icon">
				  													<span class="icon-location top-bar-icon"></span>
				  												</span>
						  										<span class="drowdown-menu-text">
				  													<p><?php echo strtoupper($value->store); ?></p>
				  												</span>
												    		</a>
												    	</li>
											    	<?php } ?>
		                                        <?php } ?>
										    </ul>
									  	</li>
									  	<li class="dropdown">
	    									<a aria-expanded="true" class="dropdown-toggle menu-option-click dsr"  data-toggle="dropdown" href="#"  data-view="bc" id="dsr">
										      <span id="option-text">Column Chart</span> 
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
									      		<li>
										    		<a href="#" data-view="1" data-title="Column-Chart" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Column Chart</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="2" data-title="Tabular" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Tabular</p>
		  												</span>
										    		</a>
										    	</li>
										    </ul>
									  	</li>
									</ul>
									<div class="clear"></div>
				  				</div>
								<!-- widget title -->
					  			<div class="row">
					  				<div class="col-lg-12  widget-title">
						  				<span id="">
					  						Sales -
					  					</span>
					  					<span id="sales-storenum">
					  						All
					  					</span>
					  				</div>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
							<div class="col-lg-12 custome-widget-width">
								<div>
									<div class="loader-container"></div>
									<div class="dashboard-no-report-data" id="sales-no-data-container">
										<span>No sales data found.</span>
									</div>
									<div class="table-choice " id="opt2">
										<table class="table myclass" cellpadding="0" cellspacing="0" border="0">
									    	<thead>
									      		<tr>
									      			<th></th>
										        	<th>Current</th>
										        	<th>Last</th>
										        	<th>+/-%</th>
										      	</tr>
										    </thead>
										    <tbody>
									      		<tr>
									      			<td>Day</td>
										        	<td id="tyTodaySales"></td>
										        	<td id="lyTodaySales"></td>
										        	<td id="tSalesPercent"></td>
										      	</tr>
									      		<tr>
									      			<td>Mth</td>
										        	<td id="tyMonthSales"></td>
										        	<td id="lyMonthSales"></td>
										        	<td id="mSalesPercent"></td>
										      	</tr>
									      		<tr>
									      			<td>Qtr</td>
										           	<td id="tyQuarterSales"></td>
										        	<td id="lyQuarterSales"></td>
										        	<td id="qSalesPercent"></td>
										      	</tr>
									      		<tr>
									      			<td>Year</td>
									        	   	<td id="tyYearSales"></td>
										        	<td id="lyYearSales"></td>
										        	<td id="ySalesPercent"></td>
										      	</tr>
										    </tbody>
										</table>
									</div>
									<div class="graph-choice choice active-div-element slideUp" id="opt1">
										<div id="graph-container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- item -->
				<div class="col-lg-4  widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
							<div class="col-lg-12 ">
								<!-- widget options -->
								<div class="widget-item-list">
			  						<ul class="nav nav-pills">
	  									<li class="dropdown">
	    									<a aria-expanded="true" data-view="all" id="cu" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      <span id="option-text">All</span>
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
										    	<?php  if(isset($stores)){ ?>
	                                            	<?php foreach ($stores as $key => $value) {?>
											      		<li>
												    		<a href="#" data-view="<?php echo $value->store; ?>" id="store_value">
											    				<span class="drowdown-menu-icon">
				  													<span class="icon-location top-bar-icon"></span>
				  												</span>
						  										<span class="drowdown-menu-text">
				  													<p><?php echo strtoupper($value->store); ?></p>
				  												</span>
												    		</a>
												    	</li>
											    	<?php } ?>
		                                        <?php } ?>
										    </ul>
									  	</li>
									  	<li class="dropdown">
	    									<a aria-expanded="true" class="dropdown-toggle menu-option-click dcr" data-view="bc" id="dcr"  data-toggle="dropdown" href="#">
										      <span id="option-text">Column Chart</span> 
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
									      		<li>
										    		<a href="#" data-view="columnchart" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Column Chart</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="Table" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Table</p>
		  												</span>
										    		</a>
										    	</li>
										    </ul>
									  	</li>
									</ul>
									<div class="clear"></div>
				  				</div>
								<!-- widget title -->
					  			<div class="row">
					  				<div class="col-lg-12  widget-title">
						  				<span id="">
					  						Customer -
					  					</span>
					  					<span id="customer-storenum">
					  						All
					  					</span>
					  				</div>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
							<div class="col-lg-12 custome-widget-width">
								<div>
									<div class="loader-container"></div>
									<div class="dashboard-no-report-data" id="customer-no-data-container">
										<span>No sales data found.</span>
									</div>
									<div class="table-choice" id="customer-table">
										<table class="table" cellspacing="5px">
									    	<thead>
									      		<tr>
									      			<th></th>
										        	<th>Current</th>
										        	<th>Last</th>
										        	<th>+/-%</th>
										      	</tr>
										    </thead>
										    <tbody>
									      		<tr>
									      			<td>Day</td>
								        		   	<td id="tyTodayCustomer"></td>
										        	<td id="lyTodayCustomer"></td>
										        	<td id="tCustomerPercent"></td>
										      	</tr>
									      		<tr>
									      			<td>Mth</td>
								        		   	<td id="tyMonthCustomer"></td>
										        	<td id="lyMonthCustomer"></td>
										        	<td id="mCustomerPercent"></td>
										      	</tr>
									      		<tr>
									      			<td>Qtr</td>
								        		   	<td id="tyQuarterCustomer"></td>
										        	<td id="lyQuarterCustomer"></td>
										        	<td id="qCustomerPercent"></td>
										      	</tr>
									      		<tr>
									      			<td>Year</td>
								        		   	<td id="tyYearCustomer"></td>
										        	<td id="lyYearCustomer"></td>
										        	<td id="yCustomerPercent"></td>
										      	</tr>
										    </tbody>
				  						</table>
			  						</div>
			  						<div class="graph-choice active-div-element" id="customer-graph-container">
										<div  id="customer-container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- item -->
				<div class="col-lg-4  widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
							<div class="col-lg-12 ">
								<!-- widget options -->
								<!-- widget options -->
								<div class="widget-item-list">
			  						<ul class="nav nav-pills">
	  									<li class="dropdown">
	    									<a aria-expanded="true" data-view="all" id="py" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      <span id="option-text">All</span>
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
										    	<?php  if(isset($stores)){ ?>
	                                            	<?php foreach ($stores as $key => $value) {?>
											      		<li>
												    		<a href="#" data-view="<?php echo $value->store; ?>" id="store_value">
											    				<span class="drowdown-menu-icon">
				  													<span class="icon-location top-bar-icon"></span>
				  												</span>
						  										<span class="drowdown-menu-text">
				  													<p><?php echo strtoupper($value->store); ?></p>
				  												</span>
												    		</a>
												    	</li>
											    	<?php } ?>
		                                        <?php } ?>
										    </ul>
									  	</li>
									  	<li class="dropdown">
	    									<a aria-expanded="true" class="dropdown-toggle menu-option-click dpr" data-view="cc" id="dpr" data-toggle="dropdown" href="#">
										      <span id="option-text">Column Chart</span> 
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
									      		<li>
										    		<a href="#" data-view="columnchart" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Column Chart</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="Table" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Table</p>
		  												</span>
										    		</a>
										    	</li>
										    </ul>
									  	</li>
									</ul>
									<div class="clear"></div>
				  				</div>
								<!-- widget title -->
					  			<div class="row">
					  				<div class="col-lg-12   widget-title">
						  				<span id="">
					  						Payroll -
					  					</span>
					  					<span id="payroll-storenum">
					  						All
					  					</span>
					  				</div>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
							<div class="col-lg-12 custome-widget-width">
								<div>
									<div class="loader-container"></div>
									<div class="dashboard-no-report-data" id="payroll-no-data-container">
										<span>No sales data found.</span>
									</div>
									<div class="table-choice" id="payroll-table">
										<table class="table" cellspacing="0">
									    	<thead>
									      		<tr>
									      			<th></th>
										        	<th>Current</th>
										        	<th>Last</th>
										        	<th>+/-%</th>
										      	</tr>
										    </thead>
										    <tbody>
									      		<tr>
									      			<td>Day</td>
										        	<td id="tyTodayTender"></td>
										        	<td id="lyTodayTender"></td>
										        	<td id="lyTodayTenderPerc"></td>
										      	</tr>
									      		<tr>
									      			<td>Mth</td>
										        	<td id="tyMonthTender"></td>
										        	<td id="lyMonthTender"></td>
										        	<td id="lyMonthTenderPerc"></td>
										      	</tr>
									      		<tr>
									      			<td>Qtr</td>
										        	<td id="tyQuarterTender"></td>
										        	<td id="lyQuarterTender"></td>
										        	<td id="lyQuarterTenderPerc"></td>
										      	</tr>
									      		<tr>
									      			<td>Year</td>
										        	<td id="tyYearTender"></td>
										        	<td id="lyYearTender"></td>
										        	<td id="lyYearTenderPerc"></td>
										      	</tr>
										    </tbody>
									  	</table>
									</div>
									<div class="graph-choice active-div-element" id="payroll-graph-container">
										<div  id="payroll-container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- second row -->
		<div class="row">
			<div class="col-lg-12 ">
				<!-- item list-->
				<!-- item -->
				<div class="col-lg-4 widget widget">
					<div class="row">
						<div class="row widget-header" id="widget-header" >
							<div class="col-lg-12 ">
								<!-- widget options -->
								<!-- widget options -->
								<div class="widget-item-list">
			  						<ul class="nav nav-pills">
	  									<li class="dropdown">
	    									<a aria-expanded="true" data-view="all" id="gm" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      <span id="option-text">All</span>
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
										    	<?php  if(isset($stores)){ ?>
	                                            	<?php foreach ($stores as $key => $value) {?>
											      		<li>
												    		<a href="#" data-view="<?php echo $value->store; ?>" id="store_value">
											    				<span class="drowdown-menu-icon">
				  													<span class="icon-location top-bar-icon"></span>
				  												</span>
						  										<span class="drowdown-menu-text">
				  													<p><?php echo strtoupper($value->store); ?></p>
				  												</span>
												    		</a>
												    	</li>
											    	<?php } ?>
		                                        <?php } ?>
										    </ul>
									  	</li>
									  	<li class="dropdown">
	    									<a aria-expanded="true" class="dropdown-toggle menu-option-click" data-view="bc" id="gmr" data-toggle="dropdown" href="#">
										      <span id="option-text">Column Chart</span> 
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
									      		<li>
										    		<a href="#" data-view="columnchart" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Column Chart</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="Table" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Table</p>
		  												</span>
										    		</a>
										    	</li>
										    </ul>
									  	</li>
									</ul>
									<div class="clear"></div>
				  				</div>
								<!-- widget title -->
					  			<div class="row widget-title col-lg-12 ">
					  				<span id="">
					  					Gross Margin -
					  				</span>
					  				<span id="gm-storenum">
					  					All
					  				</span>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
							<div class="col-lg-12 custome-widget-width">
								<div>
									<div class="loader-container"></div>
									<div class="dashboard-no-report-data" id="gmargin-data-no-container">
										<span>No sales data found.</span>
									</div>
									<div class="table-choice" id="gmargin-table">
										<table class="table" cellspacing="5px">
									    	<thead>
									      		<tr>
									      			<th></th>
										        	<th>Current</th>
										        	<th>Last</th>
										        	<th>+/-%</th>
										      	</tr>
										    </thead>
										    <tbody>
									      		<tr>
									      			<td>Day</td>
								        		   	<td id="tyTodaySalesMargin"></td>
										        	<td id="lyTodaySalesMargin"></td>
										        	<td id="tGrossMargin"></td>
										      	</tr>
									      		<tr>
									      			<td>Mth</td>
								        		   	<td id="tyMonthSalesMargin"></td>
										        	<td id="lyMonthSalesMargin"></td>
										        	<td id="mGrossMargin"></td>
										      	</tr>
									      		<tr>
									      			<td>Qtr</td>
										    	   	<td id="tyQuarterSalesMargin"></td>
										        	<td id="lyQuarterSalesMargin"></td>
										        	<td id="qGrossMargin"></td>
							 			      	</tr>
									      		<tr>
									      			<td>Year</td>
									        	   	<td id="tyYearSalesMargin"></td>
										        	<td id="lyYearSalesMargin"></td>
										        	<td id="yGrossMargin"></td>
										      	</tr>
										    </tbody>
									  	</table>
									</div>
									<div class="graph-choice active-div-element" id="gmargin-graph-container">
										<div id="gross-margin-container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- item -->
				<div class="col-lg-4 widget widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
							<div class="col-lg-12  ">
								<!-- widget options -->
								<!-- widget options -->
								<div class="widget-item-list">
			  						<ul class="nav nav-pills">
	  									<li class="dropdown">
	    									<a aria-expanded="true" data-view="all" id="spc" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      <span id="option-text">All</span>
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
										    	<?php  if(isset($stores)){ ?>
	                                            	<?php foreach ($stores as $key => $value) {?>
											      		<li>
												    		<a href="#" data-view="<?php echo $value->store; ?>" id="store_value">
											    				<span class="drowdown-menu-icon">
				  													<span class="icon-location top-bar-icon"></span>
				  												</span>
						  										<span class="drowdown-menu-text">
				  													<p><?php echo strtoupper($value->store); ?></p>
				  												</span>
												    		</a>
												    	</li>
											    	<?php } ?>
		                                        <?php } ?>
										    </ul>
									  	</li>
									  	<li class="dropdown">
	    									<a aria-expanded="true" class="dropdown-toggle menu-option-click" data-view="bc" id="spcr" data-toggle="dropdown" href="#">
										      <span id="option-text">Column Chart</span> 
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
									      		<li>
										    		<a href="#" data-view="columnchart" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Column Chart</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="Table" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Table</p>
		  												</span>
										    		</a>
										    	</li>
										    </ul>
									  	</li>
									</ul>
									<div class="clear"></div>
				  				</div>
								<!-- widget title -->
					  			<div class="row widget-title col-lg-12 ">
					  				<span id="">
					  					Sales Per Customer -
					  				</span>
					  				<span id="spc-storenum">
					  					All
					  				</span>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
							<div class="col-lg-12 custome-widget-width">
								<div>
									<div class="loader-container"></div>
									<div class="dashboard-no-report-data" id="spcustomer-no-data-container">
										<span>No sales data found.</span>
									</div>
									<div class="table-choice" id="spcustomer-table">
										<table class="table" cellspacing="5px" >
									    	<thead>
									      		<tr>
									      			<th></th>
										        	<th>Current</th>
										        	<th>Last YR</th>
										        	<th>+/-%</th>
										      	</tr>
										    </thead>
										    <tbody>
									      		<tr>
									      			<td>Day</td>
										        	<td id="tyTodaySalesPerCutomer"></td>
										        	<td id="lyTodaySalesPerCutomer"></td>
										        	<td id="tSalesPerCutomer"></td>
										      	</tr>
									      		<tr>
									      			<td>Mth</td>
										        	<td id="tymSalesPerCutomer"></td>
										        	<td id="lymSalesPerCutomer"></td>
										        	<td id="mSalesPerCutomer"></td>
										      	</tr>
									      		<tr>
									      			<td>Qtr</td>
										        	<td id="tyqSalesPerCutomer"></td>
										        	<td id="lyqSalesPerCutomer"></td>
										        	<td id="qSalesPerCutomer"></td>
										      	</tr>
									      		<tr>
									      			<td>Year</td>
										        	<td id="tySalesPerCutomer"></td>
										        	<td id="lySalesPerCutomer"></td>
										        	<td id="ySalesPerCutomer"></td>
										      	</tr>
										    </tbody>
									  	</table>
									</div>
									<div class="graph-choice active-div-element" id="spcustomer-graph-container">
										<div id="salespercustomer-container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- item -->
				<div class="col-lg-4  widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
							<div class="col-lg-12  ">
								<!-- widget options -->
								<!-- widget options -->
								<div class="widget-item-list">
			  						<ul class="nav nav-pills">
	  									<li class="dropdown">
	    									<a aria-expanded="true" data-view="all" id="tt" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      <span id="option-text">All</span>
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
										    	<?php  if(isset($stores)){ ?>
	                                            	<?php foreach ($stores as $key => $value) {?>
											      		<li>
												    		<a href="#" data-view="<?php echo $value->store; ?>" id="store_value">
											    				<span class="drowdown-menu-icon">
				  													<span class="icon-location top-bar-icon"></span>
				  												</span>
						  										<span class="drowdown-menu-text">
				  													<p><?php echo strtoupper($value->store); ?></p>
				  												</span>
												    		</a>
												    	</li>
											    	<?php } ?>
		                                        <?php } ?>
										    </ul>
									  	</li>
									  	<li class="dropdown">
	    									<a aria-expanded="true" class="dropdown-toggle menu-option-click" data-view="pc" id="tr" data-toggle="dropdown" href="#">
										      <span id="option-text">Pie Chart</span> 
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
									      		<li>
										    		<a href="#" data-view="pie chart" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Pie Chart</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="Table" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Table</p>
		  												</span>
										    		</a>
										    	</li>
										    </ul>
									  	</li>
									</ul>
									<div class="clear"></div>
				  				</div>
								<!-- widget title -->
					  			<div class="row widget-title col-lg-12 ">
					  				<span id="">
					  					Tender Types -
					  				</span>
					  				<span id="tt-storenum">
					  					All
					  				</span>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
							<div class="col-lg-12 custome-widget-width">
								<div>
									<div class="loader-container"></div>
									<div class="dashboard-no-report-data" id="ttypes-no-data-container">
										<span>No payroll data found.</span>
									</div>
									<div class="table-choice" id="ttypes-table">
										<table class="table" cellspacing="5px">
									    	<thead>
									      		<tr>
									      			<th></th>
										        	<th>YTD</th>
										        	<th>%</th>
										      	</tr>
										    </thead>
										    <tbody>
									      		<tr>
									      			<td>Cash</td>
										        	<td id="tenderCash"></td>
										        	<td id="tenderCashPercent"></td>
										      	</tr>
									      		<tr>
									      			<td>Credit</td>
										        	<td id="tenderCredit"></td>
										        	<td id="tenderCreditPercent"> </td>
										      	</tr>
									      		<tr>
									      			<td>Cheque</td>
										        	<td id="tenderCheque"></td>
										        	<td id="tenderChequePercent"></td>
										      	</tr>
										    </tbody>
									  	</table>
									</div>
									<div class="graph-choice active-div-element" id="ttypes-graph-container">
										<div  id="tendertypes-container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="col-lg-4  widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
							<div class="col-lg-12  ">
								<!-- widget options -->
								<!-- widget options -->
								<div class="widget-item-list">
			  						<ul class="nav nav-pills">
	  									<li class="dropdown">
	    									<a aria-expanded="true" data-view="all" id="tt" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      <span id="option-text">All</span>
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
										    	<?php  if(isset($stores)){ ?>
	                                            	<?php foreach ($stores as $key => $value) {?>
											      		<li>
												    		<a href="#" data-view="<?php echo $value->store; ?>" id="store_value">
											    				<span class="drowdown-menu-icon">
				  													<span class="icon-location top-bar-icon"></span>
				  												</span>
						  										<span class="drowdown-menu-text">
				  													<p><?php echo strtoupper($value->store); ?></p>
				  												</span>
												    		</a>
												    	</li>
											    	<?php } ?>
		                                        <?php } ?>
										    </ul>
									  	</li>
									  	<li class="dropdown">
	    									<a aria-expanded="true" class="dropdown-toggle menu-option-click" data-view="pc" id="tr" data-toggle="dropdown" href="#">
										      <span id="option-text">Pie Chart</span> 
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
									      		<li>
										    		<a href="#" data-view="pie chart" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Pie Chart</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="Table" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Table</p>
		  												</span>
										    		</a>
										    	</li>
										    </ul>
									  	</li>
									</ul>
									<div class="clear"></div>
				  				</div>
								<!-- widget title -->
					  			<div class="row widget-title col-lg-12 ">
					  				<span id="">
					  					Tender Types -
					  				</span>
					  				<span id="tt-storenum">
					  					All
					  				</span>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
							<div class="col-lg-12 custome-widget-width">
								<div>
									<div class="loader-container"></div>
									<div class="dashboard-no-report-data" id="ttypes-no-data-container">
										<span>No payroll data found.</span>
									</div>
									<div class="table-choice" id="ttypes-table">
										<table class="table" cellspacing="5px">
									    	<thead>
									      		<tr>
									      			<th></th>
										        	<th>YTD</th>
										        	<th>%</th>
										      	</tr>
										    </thead>
										    <tbody>
									      		<tr>
									      			<td>Cash</td>
										        	<td id="tenderCash"></td>
										        	<td id="tenderCashPercent"></td>
										      	</tr>
									      		<tr>
									      			<td>Credit</td>
										        	<td id="tenderCredit"></td>
										        	<td id="tenderCreditPercent"> </td>
										      	</tr>
									      		<tr>
									      			<td>Cheque</td>
										        	<td id="tenderCheque"></td>
										        	<td id="tenderChequePercent"></td>
										      	</tr>
										    </tbody>
									  	</table>
									</div>
									<div class="graph-choice active-div-element" id="ttypes-graph-container">
										<div  id="tendertypes-container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>


			</div>
		</div>
		<!-- third row -->
		<div class="row">
			<div class="col-lg-12">
				<!-- item -->
				<div class="<?php if($this->session->userdata('userRole') == 4){ echo "col-lg-4" ;}else{ echo "col-lg-4";} ?> widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
							<div class="col-lg-12">
								<!-- widget options -->
								<!-- widget options -->
								<div class="widget-item-list">
			  						<ul class="nav nav-pills">
	  									<li class="dropdown">
	    									<a aria-expanded="true"  id="widget-date" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      	<span class="widget-start-date-text" id="widget-start-date-text"></span>
												<span class="widget-end-date-text" id="widget-end-date-text"></span>
										      <span class="caret"></span>
										    </a>
										    <div class="widget-date-picker-container">
												<?php $attributes = array('name' => 'widget-date-data', 'id' => 'widget-date-data','class'=>'form-horizontal'); echo form_open('', $attributes);?>
													<fieldset>
														<div id="date-filter">
										                    <div class="form-group">
										                        <div class="col-lg-8 widget-date-box-container">
										                            <input type="text" class="form-control widgetInputFromDate" id="widgetInputFromDate" value="" name="widgetInputFromDate" placeholder="Date">
										                        </div>
										                        <div class="col-lg-4 widget-date-button-container">
										                            <button type="submit" class="btn btn-default">Apply</button>
									                        		<a href="#" id="widget-date-filter-cancel">Cancel</a>
										                        </div>
										                    </div>
									                    </div>
								                	</fieldset>    
												<?php echo form_close();?>
											</div>
									  	</li>
	  									<li class="dropdown">
	    									<a aria-expanded="true" data-view="all" id="tf" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      <span id="option-text">All</span>
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
										    	<?php  if(isset($stores)){ ?>
	                                            	<?php foreach ($stores as $key => $value) {?>
											      		<li>
												    		<a href="#" data-view="<?php echo $value->store; ?>" id="store_value">
											    				<span class="drowdown-menu-icon">
				  													<span class="icon-location top-bar-icon"></span>
				  												</span>
						  										<span class="drowdown-menu-text">
				  													<p><?php echo strtoupper($value->store); ?></p>
				  												</span>
												    		</a>
												    	</li>
											    	<?php } ?>
		                                        <?php } ?>
										    </ul>
									  	</li>
									  	<li class="dropdown">
	    									<a aria-expanded="true" data-view="Department" id="current_top_active" class="dropdown-toggle menu-option-click" data-toggle="dropdown" href="#">
										      <span id="option-text">Departments</span>
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
								    	  		<li>
										    		<a href="#" data-view="Department" id="top_five_attr_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-sitemap top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Departments</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="User" id="top_five_attr_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-user top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Users</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="Store" id="top_five_attr_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-shop-1 top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Stores</p>
		  												</span>
										    		</a>
										    	</li>
										    </ul>
									  	</li>
									  	<li class="dropdown">
	    									<a aria-expanded="true" class="dropdown-toggle menu-option-click" data-view="pc" id="tr" data-toggle="dropdown" href="#">
										      <span id="option-text">Pie Chart</span> 
										      <span class="caret"></span>
										    </a>
										    <ul class="dropdown-menu">
									      		<li>
										    		<a href="#" data-view="pie chart" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Pie Chart</p>
		  												</span>
										    		</a>
										    	</li>
										    	<li>
										    		<a href="#" data-view="Table" id="user_selecting_data_population_type">
									    				<span class="drowdown-menu-icon">
		  													<span class="icon-signal top-bar-icon"></span>
		  												</span>
				  										<span class="drowdown-menu-text">
		  													<p>Table</p>
		  												</span>
										    		</a>
										    	</li>
										    </ul>
									  	</li>
									</ul>
									<div class="clear"></div>
				  				</div>
								<!-- widget title -->
					  			<div class="row">
					  				<div class="col-lg-12 widget-title">
						  				<span id="">
					  						Top 5 - <span id="topfive-report-text">Departments -</span> 
					  					</span>
					  					<span id="topfive-storenum">
					  						All
					  					</span>
					  				</div>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
							<div class="col-lg-12 custome-widget-width">
								<div>
									<div class="loader-container"></div>
									<div class="dashboard-no-report-data" id="ttypes-no-data-container">
										<span>No payroll data found.</span>
									</div>
									<div class="table-choice" id="topfive-report-table">
										<table class="table" id="depart_store_table" cellspacing="5px" >
									    	<thead>
									      		<tr>
									      	    	<th>Name</th>
										        	<th>Cost</th>
										        	<th>Sales</th>
										      	</tr>
										    </thead>
										    <tbody id="depart_store_table_body">
										    </tbody>
									  	</table>
									  	<table class="table" id="user_table" cellspacing="5px">
									    	<thead>
									      		<tr>
									      	    	<th>Name</th>
										        	<th>Store</th>
										        	<th>Sales</th>
										      	</tr>
										    </thead>
										    <tbody id="user_table_body">
										    </tbody>
									  	</table>
									</div>
									<div class="graph-choice active-div-element">
										<div  id="topfive-report-container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- item -->
				<div class="col-lg-4 widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
							<div class="col-lg-12 ">
								<!-- widget title -->
					  			<div class="row">
					  				<div class="col-lg-12  widget-title">
						  				<span id="">
					  						System Health Check 
					  					</span>
					  				</div>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
							<div class="col-lg-12">
								<div>
									<div class="loader-container"></div>
									<div class="system-health-check-choice active-div-element">
										<table class="table" >
									    	<thead id="system-health-check-thead">
									      		<tr>
									      			<th></th>
													<th>Network</th>
													<th>System</th>
													<th>Back-up</th>
													<th>Anti-virus</th>
													<th>Software</th>
										      	</tr>
										    </thead>
										    <tbody id="health-check-list"></tbody>
									  	</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- item -->
				<?php
					// require_footer 
					require APPPATH.'views/ci/dss-widget-1.php';
				?>
			</div>
		</div>

</div>
<?php } else{ echo "<p class='access-denied'><span class='icon-warning'></span> Access denied</p>";} ?>
<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>
<script type="text/javascript">
	var videoCamlist = new Array();
	var defaultSoruce = '';
	var videoPlaying = '' ;
	var topfiveData = '';
	var eventDates = '';
	/*
     * ---------------------------------------------------------
     *   Set date time text in report text
     * ---------------------------------------------------------
     */
	setDateTime(reportdata.sdate,reportdata.edate);
	function setDateTime(startdate,enddate)
	{
		$("#report-start-date-text").text(startdate);
	}
	setWidgetDateTime(reportdata.sdate,reportdata.edate);
	function setWidgetDateTime(startdate,enddate) {
		$("#widget-start-date-text").text(startdate);
		$("#widget-end-date-text").text(enddate);
	}
	
	/*
     * ---------------------------------------------------------
     *   Set date in datepicker plugin
     * ---------------------------------------------------------
     */
	setFilterDate(reportdata.sdate,reportdata.edate);
	function setFilterDate(startdate,enddate)
	{
		$('input[name="inputFromDate"]').daterangepicker({ 
			showDropdowns: true,
			singleDatePicker: true,
	        startDate:startdate ,
	        locale: {
	            format: 'MM/DD/YYYY'
	        }
		});
	}

	/*
     * ---------------------------------------------------------
     *   Set date in datepicker plugin
     * ---------------------------------------------------------
     */
	setWidgetFilterDate(reportdata.sdate,reportdata.edate);
	function setWidgetFilterDate(startdate,enddate)
	{
		$('input[name="widgetInputFromDate"]').daterangepicker({ 
			showDropdowns: true,
			startDate:startdate ,
			endDate:enddate ,
			linkedCalendars: false,
	        locale: {
	            format: 'MM/DD/YYYY'
	        }
		});
	}

	/*
     * ---------------------------------------------------------
     *   Filter datepicker value
     * ---------------------------------------------------------
     */
	function getFilterDate()
	{
		var selectedDate = $("#inputFromDate").val();
		var bdate = new Date(selectedDate)
       	var startdate = bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
    	reportdata.sdate = startdate;
	}

	function getWidgetFilterDate() {
		var selectedDate = $("#widgetInputFromDate").val();
		var splitdate = selectedDate.split(' - ');
       	var bdate = new Date(splitdate[0])
       	var edate = new Date(splitdate[1])
       	var startdate = bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
       	var enddate = edate.getMonth() + 1 + "/"+edate.getDate() + "/" + edate.getFullYear();
       	reportdata.wsdate = startdate;
       	reportdata.wedate = enddate;
	}
	var storejsondata ="" ;
	var customerjsondata ="";
	var payrolljsondata ="";
	var grossmarginjsondata ="";
	var salespercustomerjsondata ="";
	var tenderjsondata =""; 
	
	// Dashboard
	var widgetUrlList = {
		st:"<?php echo $path_url; ?>api/getDashboardSalesReport/format/json",
		cu:"<?php echo $path_url; ?>api/getDashboardCustomerReport/format/json",
		py:"<?php echo $path_url; ?>api/getDashboardPayrollReport/format/json",
		gm:"<?php echo $path_url; ?>api/getDashboardGrossMarginReport/format/json",
		spc:"<?php echo $path_url; ?>api/getDashboardSalesPerCustomerReport/format/json",
		tt:"<?php echo $path_url; ?>api/getDashboardTenderTypesReport/format/json"
	}
    $(document).ready(function(){
    	
		/*
		 * ---------------------------------------------------------
		 *   Change store name
		 * ---------------------------------------------------------
		 */
		function changeStoreName (inputElement,storevalue) {
			$("#"+inputElement).text(storevalue);
		}

    	/*
	     * ---------------------------------------------------------
	     *   Init widgets
	     * ---------------------------------------------------------
	     */
	    intiWidget ();
		function intiWidget () {
			getDashboardSalesReport(); 
		 	getDashboardCustomerReport();
		 	getDashboardPayrollReport();
		 	getDashboardGrossMarginReport();
		 	getDashboardSalesPerPersonReport();
		 	getDashboardTenderTypesReport();
		}

		/*
		 * ---------------------------------------------------------
		 *   Function populate data
		 * ---------------------------------------------------------
		 */
		function populatedata (selectedwidget,storenumdata) {
			switch(selectedwidget){
		    	case 'st':
		    		urlpath = widgetUrlList.st;
		    		changeStoreName ("sales-storenum",$(this).attr('data-view'));
		    		ajaxfunc(urlpath,storenumdata,dashboardSalesFail,generalSalesResponse);
		    		google.charts.setOnLoadCallback(drawSalesChart());
		    	break;

		    	case 'cu':
		    		urlpath = widgetUrlList.cu;
		    		changeStoreName ("customer-storenum",$(this).attr('data-view'));
		    		ajaxfunc(urlpath,storenumdata,dashboardCustomerFail,getCustomerResponse);
					google.charts.setOnLoadCallback(drawCustomerChart());
				break;

		    	case 'py':
		    		urlpath = widgetUrlList.py;
		    		changeStoreName ("payroll-storenum",$(this).attr('data-view'));
		    		ajaxfunc(urlpath,storenumdata,dashboardPayrollFail,getPayrollResponse);
					google.charts.setOnLoadCallback(drawPayrollChart());
		    	break;

		    	case 'gm':
		    		urlpath = widgetUrlList.gm;
		    		changeStoreName ("gm-storenum",$(this).attr('data-view'));
		    		ajaxfunc(urlpath,storenumdata,dashboardGMarginFail,getGrossMargin);
		    		google.charts.setOnLoadCallback(drawGrossMarginChart());
		    	break;

		    	case 'spc':
		    		urlpath = widgetUrlList.spc;
		    		changeStoreName ("spc-storenum",$(this).attr('data-view'));
					ajaxfunc(urlpath,storenumdata,dashboardSPCustomerFail,getSalesPerPerson);
		    		google.charts.setOnLoadCallback(drawSalesPerCustomerChart());
		    	break;

		    	case 'tt':
		    		urlpath = widgetUrlList.tt;
		    		changeStoreName ("tt-storenum",$(this).attr('data-view'));
					ajaxfunc(urlpath,storenumdata,dashboardTTypesFail,getTenderType);
		    		google.charts.setOnLoadCallback(drawTenderTypesChart());
		    	break;

		    	case 'tf':
		    		$("#tf").attr('data-view',$(this).attr('data-view'));
		    		$("#tf").attr('data-view',$(this).attr('data-view').trim());
        			$("#topfive-storenum").text($(this).attr('data-view').trim());

		    		changeStoreName ("topfive-storenum",$(this).attr('data-view'));
					google.charts.setOnLoadCallback(topFiveDepartment($("#current_top_active").attr('data-view'),$(this).attr('data-view'),$("#inputFromDate").val(),$("#inputToDate").val()));
		    	break;
		    }
		}

		/*
		 * ---------------------------------------------------------
		 *   Get data according to store filter
		 * ---------------------------------------------------------
		 */

		$(document).on('click','#store_value',function(){
	      	
	        var storenumdata = ({ 
        			'storenum' : $(this).attr('data-view').trim(),
        			'datefrom':reportdata.sdate,
        			'dateto':reportdata.edate
	        	}); 

			$(this).parent().parent().parent().find('span#option-text').text($(this).attr('data-view').trim());
			var selectDataType = $(this).parent().parent().parent().find('a.menu-option-click').attr('id');				
	       	$(this).parent().eq(8).find('div.widget-body div.loader-container').show();
	        switch(selectDataType){
	        	case 'st':
	        		urlpath = "<?php echo $path_url; ?>api/getDashboardSalesReport/format/json";
	        		$("#sales-storenum").text($(this).attr('data-view').trim());
	        		ajaxfunc(urlpath,storenumdata,dashboardSalesFail,generalSalesResponse);
	        		google.charts.setOnLoadCallback(drawSalesChart());
	        	break;

	        	case 'cu':
	        		urlpath = "<?php echo $path_url; ?>api/getDashboardCustomerReport/format/json";
        			$("#customer-storenum").text($(this).attr('data-view').trim());
        			ajaxfunc(urlpath,storenumdata,dashboardCustomerFail,getCustomerResponse);
        			google.charts.setOnLoadCallback(drawCustomerChart());
        		break;

	        	case 'py':
	        		urlpath = "<?php echo $path_url; ?>api/getDashboardPayrollReport/format/json";
        			$("#payroll-storenum").text($(this).attr('data-view').trim());
        			ajaxfunc(urlpath,storenumdata,dashboardPayrollFail,getPayrollResponse);
        			google.charts.setOnLoadCallback(drawPayrollChart());
	        	break;

	        	case 'gm':
	        		urlpath = "<?php echo $path_url; ?>api/getDashboardGrossMarginReport/format/json";
	        		$("#gm-storenum").text($(this).attr('data-view').trim());
	        		ajaxfunc(urlpath,storenumdata,dashboardGMarginFail,getGrossMargin);
	        		google.charts.setOnLoadCallback(drawGrossMarginChart());
	        	break;

	        	case 'spc':
        			urlpath = "<?php echo $path_url; ?>api/getDashboardSalesPerCustomerReport/format/json";
	        		$("#spc-storenum").text($(this).attr('data-view').trim());
	        		ajaxfunc(urlpath,storenumdata,dashboardSPCustomerFail,getSalesPerPerson);
	        		google.charts.setOnLoadCallback(drawSalesPerCustomerChart());
	        	break;

	        	case 'tt':
        			urlpath = "<?php echo $path_url; ?>api/getDashboardTenderTypesReport/format/json";
	        		$("#tt-storenum").text($(this).attr('data-view').trim());
	        		ajaxfunc(urlpath,storenumdata,dashboardTTypesFail,getTenderType);
	        		google.charts.setOnLoadCallback(drawTenderTypesChart());
	        	break;

	        	case 'tf':
	        		$("#tf").attr('data-view',$(this).attr('data-view').trim());
        			$("#topfive-storenum").text($(this).attr('data-view').trim());
        			google.charts.setOnLoadCallback(topFiveDepartment($("#current_top_active").attr('data-view'),$(this).attr('data-view').trim(),$("#inputFromDate").val(),$("#inputToDate").val()));
	        	break;
	        }
	        $(this).parent().eq(8).find('div.widget-body div.loader-container').fadeOut();  
		});
				
		/*
		 * ---------------------------------------------------------
		 *   Get data according to date filter
		 * ---------------------------------------------------------
		 */	
		$(document).on('submit','#user-date-form',function(){
			getFilterDate();
			setDateTime(reportdata.sdate,reportdata.edate);
			$(".date-picker-container").hide();
			$("#date").show();
			$(".loader-container").show();
			intiWidget ();
			google.charts.setOnLoadCallback(drawSalesChart());
			google.charts.setOnLoadCallback(drawCustomerChart());
			google.charts.setOnLoadCallback(drawPayrollChart());
			google.charts.setOnLoadCallback(drawGrossMarginChart());
		 	google.charts.setOnLoadCallback(drawSalesPerCustomerChart());
		 	google.charts.setOnLoadCallback(drawTenderTypesChart());
			google.setOnLoadCallback(topFiveDepartment("Department","",reportdata.sdate,reportdata.edate));
			$(".loader-container").fadeOut();
			return false;
		}) ;

		$(document).on('submit','#widget-date-data',function(){
			getWidgetFilterDate();
			setWidgetDateTime(reportdata.wsdate,reportdata.wedate);
			
			$(".widget-date-picker-container").hide();
			$("#widget-date").show();
			var attrval = $("#current_top_active").attr('data-view').trim();
			$(this).parent().eq(11).find('div.widget-body div.loader-container').show();
		 	google.setOnLoadCallback(topFiveDepartment(attrval,$("#tf").attr('data-view').trim(),reportdata.wsdate,reportdata.wedate));
		  	$(this).parent().eq(11).find('div.widget-body div.loader-container').fadeOut();

			return false;
		}) ;

	 	/*
	     * ---------------------------------------------------------
	     *   Get data in top-five chart according to selected attribute
	     * ---------------------------------------------------------
	     */	
	 	$(document).on('click','#top_five_attr_type',function(){
 		  	$(this).parent().parent().parent().find('span#user-selected-data-population-option').text($(this).attr('data-view').trim());
			$("#current_top_active").attr("data-view",$(this).attr('data-view').trim());
			$("#topfive-report-text").text($(this).attr('data-view').trim());
			var attrval = $("#current_top_active").attr('data-view').trim();
		 	$(this).parent().eq(11).find('div.widget-body div.loader-container').show();
		 	google.setOnLoadCallback(topFiveDepartment(attrval,$("#tf").attr('data-view').trim(),reportdata.wsdate,reportdata.wedate));
		  	$(this).parent().eq(11).find('div.widget-body div.loader-container').fadeOut();   
	 		$(document).find('div.widget-option-popup').hide()
	 	});
	 	

		$(document).on('click','.widget-option-click',function(){

		 	$(document).find('div.widget-item-list-active').removeClass('widget-item-list-active');
		  	$(document).find('a.widget-item-list-active-link').removeClass('widget-item-list-active-link');
			var checkElement = $(this).parent().find('div.widget-option-popup');
			if($(this).attr('id') != 'date' && $(this).attr('id') != 'store' && $(this).attr('id') != 'report-container-popup'  ){
				$(this).parent().parent().parent().parent().parent().addClass('widget-item-list-active');	
				$(this).addClass('widget-item-list-active-link');
			}
			else{
				checkElement.addClass('datepicker-widget');
			}
			/*if($(this).attr('id') == 'vs'){
				getVideoDepartment();
			}*/
			if((checkElement.is('div')) && (!checkElement.is(':visible'))) {
				$(document).find('div.widget-option-popup').hide();
				checkElement.show();
  			}
  			else{
  				$(this).parent().parent().parent().parent().parent().removeClass('widget-item-list-active');
  				$(this).removeClass('widget-item-list-active-link');
  				checkElement.hide();
  			}
  			return false;
		});

		function topFiveAttr(data){}
		/*
	     * ---------------------------------------------------------
	     *   Get sales widget data
	     * ---------------------------------------------------------
	     */
	    var defaultStore = false;
	 	function getDashboardSalesReport(){
	     	urlpath = "<?php echo $path_url; ?>api/getDashboardSalesReport/format/json";
	        ajaxType = "GET";
	        var storenum = $("#st span#user-selected-data-storenum-option").text();
	        general_info  = ({	
	        					'storenum' : storenum,
	        					'datefrom':reportdata.sdate,
        						'dateto':reportdata.edate
        			});
	        ajaxfunc(urlpath,general_info,dashboardSalesFail,generalSalesResponse); 
	    }
		
		function dashboardSalesFail()
		{
			$("#sales-graph-container").hide();
			$("#sales-table").hide();
			$("#sales-no-data-container").show();
			$("#tyTodaySales").html(0);
	 		$("#lyTodaySales").html(0);
	 		$("#tSalesPercent").html(0);
			$("#tyMonthSales").html(0);
	 		$("#lyMonthSales").html(0);
	 		$("#mSalesPercent").html(0);
	 		$("#tyQuarterSales").html(0);
	 		$("#lyQuarterSales").html(0);
	 		$("#qSalesPercent").html(0);
 			$("#tyYearSales").html(0);
	 		$("#lyYearSales").html(0);
	 		$("#ySalesPercent").html(0);
	 		storejsondata = "";
		}

		function generalSalesResponse(data){
			$("#sales-no-data-container").hide();
			$("#sales-table").hide();
			$("#sales-graph-container").hide();
			var sr = $(".dsr").attr('data-view');
			
			if(sr == 'bc'){
				$("#sales-graph-container").show();
			}
			else{
				$("#sales-table").show();
			}
			if(data !=  null){
				
				$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
				if(parseInt(data.ReportData[0].change) > 0 ){
					$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
				}
				else if(parseInt(data.ReportData[0].change) == 0)
				{
					$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
				}
				$("#tyTodaySales").html($trend+""+accounting.formatMoney(data.ReportData[0].current));
		 		$("#lyTodaySales").html(accounting.formatMoney(data.ReportData[0].last ));
		 		$("#tSalesPercent").html(accounting.formatMoney(data.ReportData[0].change ));

		 		if(parseInt(data.ReportData[1].change) > 0 ){
					$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
				}
				else if(parseInt(data.ReportData[1].change) == 0)
				{
					$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
				}

				$("#tyMonthSales").html($trend+""+accounting.formatMoney(data.ReportData[1].current));
		 		$("#lyMonthSales").html(accounting.formatMoney(data.ReportData[1].last ));
		 		$("#mSalesPercent").html(accounting.formatMoney(data.ReportData[1].change ));

		 		if(parseInt(data.ReportData[2].change) > 0 ){
					$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
				}
				else if(parseInt(data.ReportData[2].change) == 0)
				{
					$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
				}

				$("#tyQuarterSales").html($trend+""+accounting.formatMoney( data.ReportData[2].current ));
		 		$("#lyQuarterSales").html(accounting.formatMoney( data.ReportData[2].last));
		 		$("#qSalesPercent").html(accounting.formatMoney( data.ReportData[2].change ));

		 		if(parseInt(data.ReportData[3].change) > 0 ){
					$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
				}
				else if(parseInt(data.ReportData[3].change) == 0)
				{
					$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
				}

		 		$("#tyYearSales").html($trend+""+accounting.formatMoney(data.ReportData[3].current));
		 		$("#lyYearSales").html(accounting.formatMoney(data.ReportData[3].last));
		 		$("#ySalesPercent").html(accounting.formatMoney(data.ReportData[3].change ));
		 		storejsondata = data;
		 		
			}
		}
     
     	function getDashboardCustomerReport(){
	     	
	 		urlpath = "<?php echo $path_url; ?>api/getDashboardCustomerReport/format/json";
	        ajaxType = "GET";
	        var storenum = $("#cu span#user-selected-data-storenum-option").text();
	        general_info  = ({
	        					'storenum' : storenum,
	        					'datefrom':reportdata.sdate,
        						'dateto':reportdata.edate
        			});
	        ajaxfunc(urlpath,general_info,dashboardCustomerFail,getCustomerResponse); 

	    }

	    function dashboardCustomerFail()
	    {
    		$("#customer-graph-container").hide();
			$("#customer-table").hide();
			$("#customer-no-data-container").show();
			$("#tyTodayCustomer").html(0);
	 		$("#lyTodayCustomer").html(0);
	 		$("#tCustomerPercent").html(0);
	 		$("#tyMonthCustomer").html(0);
	 		$("#lyMonthCustomer").html(0);
	 		$("#mCustomerPercent").html(0);
 			$("#tyQuarterCustomer").html(0);
	 		$("#lyQuarterCustomer").html(0);
	 		$("#qCustomerPercent").html(0) ;
	 		$("#tyYearCustomer").html(0);
	 		$("#lyYearCustomer").html(0);
	 		$("#yCustomerPercent").html(0);
	 	
	 		customerjsondata = "";
	    }
	 	function getCustomerResponse(customer)
		{
			$("#customer-graph-container").hide();
			$("#customer-table").hide();
			$("#customer-no-data-container").hide();
			var sr = $("#dcr").attr('data-view');
			if(sr == 'bc'){
				$("#customer-graph-container").show();
			}

			else{
				$("#customer-table").show();
			}
			if(customer != null)
			{
				$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
				if(parseInt(customer.ReportData[0].change) > 0 ){
					$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
				}
				else if(parseInt(customer.ReportData[0].change) == 0){
					$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
				}

				$("#tyTodayCustomer").html($trend+""+accounting.formatMoney(customer.ReportData[0].current));
		 		$("#lyTodayCustomer").html(accounting.formatMoney(customer.ReportData[0].last));
		 		$("#tCustomerPercent").html(accounting.formatMoney(customer.ReportData[0].change));

		 		$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
				if(parseInt(customer.ReportData[1].change) > 0 ){
					$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
				}
				else if(parseInt(customer.ReportData[1].change) == 0){
					$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
				}

				$("#tyMonthCustomer").html($trend+""+accounting.formatMoney(customer.ReportData[1].current));
		 		$("#lyMonthCustomer").html(accounting.formatMoney(customer.ReportData[1].last));
		 		$("#mCustomerPercent").html(accounting.formatMoney(customer.ReportData[1].change));

		 		$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
				if(parseInt(customer.ReportData[2].change) > 0 ){
					$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
				}
				else if(parseInt(customer.ReportData[2].change) == 0){
					$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
				}

				$("#tyQuarterCustomer").html($trend+""+accounting.formatMoney(customer.ReportData[2].current));
		 		$("#lyQuarterCustomer").html(accounting.formatMoney(customer.ReportData[2].last));
		 		$("#qCustomerPercent").html(accounting.formatMoney(customer.ReportData[2].change )) ;

		 		$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
				if(parseInt(customer.ReportData[3].change) > 0 ){
					$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
				}
				else if(parseInt(customer.ReportData[3].change) == 0){
					$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
				}

				$("#tyYearCustomer").html($trend+""+accounting.formatMoney(customer.ReportData[3].current));
		 		$("#lyYearCustomer").html(accounting.formatMoney(customer.ReportData[3].last));
		 		$("#yCustomerPercent").html(accounting.formatMoney(customer.ReportData[3].change));
				customerjsondata = customer;
			}
		}

		function getDashboardPayrollReport(){
	     	
	 		urlpath = "<?php echo $path_url; ?>api/getDashboardPayrollReport/format/json";
	        ajaxType = "GET";
	        var storenum = $("#py span#user-selected-data-storenum-option").text();
	        general_info  = ({
	        					'storenum' : storenum,
	        					'datefrom':reportdata.sdate,
        						'dateto':reportdata.edate
        			});
	        ajaxfunc(urlpath,general_info,dashboardPayrollFail,getPayrollResponse); 

	    }
		function dashboardPayrollFail()
		{
			$("#payroll-graph-container").hide();
			$("#payroll-table").hide();
			$("#payroll-no-data-container").show();
			$("#tyTodayTender").html(0);
	 		$("#lyTodayTender").html(0);	 		
	 		$("#lyTodayTenderPerc").html(0);

			$("#tyMonthTender").html(0);
	 		$("#lyMonthTender").html(0);	 		
	 		$("#lyMonthTenderPerc").html(0);
	 		
	 		$("#tyQuarterTender").html(0);
	 		$("#lyQuarterTender").html(0);	
	 		$("#lyQuarterTenderPerc").html(0);

			$("#tyYearTender").html(0);
	 		$("#lyYearTender").html(0);
	 		$("#lyYearTenderPerc").html(0);
	 		payrolljsondata = "";
		}		
		function getPayrollResponse(payroll)
		{
			$("#payroll-graph-container").hide();
			$("#payroll-table").hide();
			$("#payroll-no-data-container").hide();
			var sr = $(".dpr").attr('data-view');
			if(sr == 'cc'){
				$("#payroll-graph-container").show();
			}
			else{
				$("#payroll-table").show();
			}

			if(payroll != null)
			{
				$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
				if(parseInt(payroll.ReportData[0].change) > 0 ){
					$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
				}
				else if(parseInt(payroll.ReportData[0].change) == 0)
				{
					$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
				}

				$("#tyTodayTender").html(accounting.formatMoney(payroll.ReportData[0].current));
		 		$("#lyTodayTender").html(accounting.formatMoney(payroll.ReportData[0].last));	 		
		 		$("#lyTodayTenderPerc").html(accounting.formatMoney(payroll.ReportData[0].change));

				$("#tyMonthTender").html(accounting.formatMoney(payroll.ReportData[1].current));
		 		$("#lyMonthTender").html(accounting.formatMoney(payroll.ReportData[1].last));	 		
		 		$("#lyMonthTenderPerc").html(accounting.formatMoney(payroll.ReportData[1].change));
		 		
		 		$("#tyQuarterTender").html(accounting.formatMoney(payroll.ReportData[2].current));
		 		$("#lyQuarterTender").html(accounting.formatMoney(payroll.ReportData[2].last));	
		 		$("#lyQuarterTenderPerc").html(accounting.formatMoney(payroll.ReportData[2].change));

				$("#tyYearTender").html(accounting.formatMoney(payroll.ReportData[3].current));
		 		$("#lyYearTender").html(accounting.formatMoney(payroll.ReportData[3].last));
		 		$("#lyYearTenderPerc").html(accounting.formatMoney(payroll.ReportData[3].change));
		 		payrolljsondata = payroll;
			}
		}

		function getDashboardGrossMarginReport(){
	     	
	 		urlpath = "<?php echo $path_url; ?>api/getDashboardGrossMarginReport/format/json";
	        ajaxType = "GET";
	        var storenum = $("#gm span#user-selected-data-storenum-option").text();
	        general_info  = ({
	        					'storenum' : storenum,
	        					'datefrom':reportdata.sdate,
        						'dateto':reportdata.edate
        			});
	        ajaxfunc(urlpath,general_info,dashboardGMarginFail,getGrossMargin); 
	    }

	    function dashboardGMarginFail()
	    {
	    	$("#gmargin-graph-container").hide();
			$("#gmargin-table").hide();
			$("#gmargin-data-no-container").show();

			$("#tyTodaySalesMargin").html(0);
	 		$("#lyTodaySalesMargin").html(0);
	 		$("#tGrossMargin").html(0) ;

	 		$("#tyMonthSalesMargin").html(0);
	 		$("#lyMonthSalesMargin").html(0);
	 		$("#mGrossMargin").html(0) ;

	 		$("#tyQuarterSalesMargin").html(0);
	 		$("#lyQuarterSalesMargin").html(0);
	 		$("#qGrossMargin").html(0);

			$("#tyYearSalesMargin").html(0);
	 		$("#lyYearSalesMargin").html(0);
	 		$("#yGrossMargin").html(0);
	 		grossmarginjsondata = "";
	    }

		function getGrossMargin(gmargin)
		{
			$("#gmargin-graph-container").hide();
			$("#gmargin-table").hide();
			$("#gmargin-data-no-container").hide();
			var sr = $("#gmr").attr('data-view');
			
			if(sr == 'bc'){
				$("#gmargin-graph-container").show();
			}
			else{
				$("#gmargin-table").show();
			}

			$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
			if(parseInt(gmargin.ReportData[0].change) > 0 ){
				$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
			}
			else if(parseInt(gmargin.ReportData[0].change) == 0)
			{
				$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
			}

			$("#tyTodaySalesMargin").html($trend+""+accounting.formatMoney(gmargin.ReportData[0].current));
	 		$("#lyTodaySalesMargin").html(accounting.formatMoney(gmargin.ReportData[0].last));
	 		$("#tGrossMargin").html(accounting.formatMoney(gmargin.ReportData[0].change)) ;
										    
	 		$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
			if(parseInt(gmargin.ReportData[1].change) > 0 ){
				$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
			}
			else if(parseInt(gmargin.ReportData[1].change) == 0){
				$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
			}

	 		$("#tyMonthSalesMargin").html($trend+""+accounting.formatMoney(gmargin.ReportData[1].current));
	 		$("#lyMonthSalesMargin").html(accounting.formatMoney(gmargin.ReportData[1].last));
	 		$("#mGrossMargin").html(accounting.formatMoney(gmargin.ReportData[1].change)) ;
			
			$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
			if(parseInt(gmargin.ReportData[2].change) > 0 ){
				$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
			}
			else if(parseInt(gmargin.ReportData[2].change) == 0)
			{
				$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
			}

			$("#tyQuarterSalesMargin").html($trend+""+accounting.formatMoney(gmargin.ReportData[2].current));
	 		$("#lyQuarterSalesMargin").html(accounting.formatMoney(gmargin.ReportData[2].last));
	 		$("#qGrossMargin").html(accounting.formatMoney(gmargin.ReportData[2].change));
			
			$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
			if(parseInt(gmargin.ReportData[3].change) > 0 ){
				$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
			}
			else if(parseInt(gmargin.ReportData[3].change) == 0)
			{
				$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
			}

			$("#tyYearSalesMargin").html($trend+""+accounting.formatMoney(gmargin.ReportData[3].current));
	 		$("#lyYearSalesMargin").html(accounting.formatMoney(gmargin.ReportData[3].last));
	 		$("#yGrossMargin").html(accounting.formatMoney(gmargin.ReportData[3].change));
			grossmarginjsondata = gmargin;

		}

		function getDashboardSalesPerPersonReport(){
	     	
	 		urlpath = "<?php echo $path_url; ?>api/getDashboardSalesPerCustomerReport/format/json";
	        ajaxType = "GET";
	        var storenum = $("#spcr span#user-selected-data-storenum-option").text();
	        general_info  = ({
	        					'storenum' : storenum,
	        					'datefrom':reportdata.sdate,
        						'dateto':reportdata.edate
        			});
	        ajaxfunc(urlpath,general_info,dashboardSPCustomerFail,getSalesPerPerson); 
	    }

	    function dashboardSPCustomerFail()
	    {
	    	$("#spcustomer-graph-container").hide();
			$("#spcustomer-table").hide();
			$("#spcustomer-no-data-container").show();
			$("#tyTodaySalesPerCutomer").html(0);
	 		$("#lyTodaySalesPerCutomer").html(0);
	 		$("#tSalesPerCutomer").html(0);

			$("#tymSalesPerCutomer").html(0);
	 		$("#lymSalesPerCutomer").html(0);
	 		$("#mSalesPerCutomer").html(0);

	 		$("#tyqSalesPerCutomer").html(0);
	 		$("#lyqSalesPerCutomer").html(0);
	 		$("#qSalesPerCutomer").html(0) ;


	 		$("#tySalesPerCutomer").html(0);
	 		$("#lySalesPerCutomer").html(0);
	 		$("#ySalesPerCutomer").html(0);
	 		salespercustomerjsondata = "";
	    }

		function getSalesPerPerson(person)
		{
			$("#spcustomer-graph-container").hide();
			$("#spcustomer-table").hide();
			$("#spcustomer-no-data-container").hide();
			var sr = $("#spcr").attr('data-view');
			if(sr == 'bc'){
				$("#spcustomer-graph-container").show();
			}
			else{
				$("#spcustomer-table").show();
			}
			$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
			if(parseInt(person.ReportData[0].change) > 0 ){
				$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
			}
			else if(parseInt(person.ReportData[0].change) == 0)
			{
				$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
			}
     
     		$("#tyTodaySalesPerCutomer").html($trend+""+accounting.formatMoney(person.ReportData[0].current));
	 		$("#lyTodaySalesPerCutomer").html(accounting.formatMoney(person.ReportData[0].last));
	 		$("#tSalesPerCutomer").html(accounting.formatMoney(person.ReportData[0].change));

			$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
			if(parseInt(person.ReportData[1].change) > 0 ){
				$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
			}
			else if(parseInt(person.ReportData[1].change) == 0)
			{
				$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
			}

			$("#tymSalesPerCutomer").html($trend+""+accounting.formatMoney(person.ReportData[1].current));
	 		$("#lymSalesPerCutomer").html(accounting.formatMoney(person.ReportData[1].last));
	 		$("#mSalesPerCutomer").html(accounting.formatMoney(person.ReportData[1].change));

	 		$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
			if(parseInt(person.ReportData[2].change) > 0 ){
				$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
			}
			else if(parseInt(person.ReportData[2].change) == 0)
			{
				$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
			}

			$("#tyqSalesPerCutomer").html($trend+""+accounting.formatMoney(person.ReportData[2].current));
	 		$("#lyqSalesPerCutomer").html(accounting.formatMoney(person.ReportData[2].last));
	 		$("#qSalesPerCutomer").html(accounting.formatMoney(person.ReportData[2].change)) ;

	 		$trend = '<span class="glyphicon glyphicon-arrow-down trend-down" aria-hidden="true"></span>';
			if(parseInt(person.ReportData[3].change) > 0 ){
				$trend = '<span class="glyphicon glyphicon-arrow-up trend-up" aria-hidden="true"></span>';
			}
			else if(parseInt(person.ReportData[3].change) == 0)
			{
				$trend = '<span class="glyphicon glyphicon-arrow-right trend-no-change" aria-hidden="true"></span>';
			}

	 		$("#tySalesPerCutomer").html($trend+""+accounting.formatMoney(person.ReportData[3].current));
	 		$("#lySalesPerCutomer").html(accounting.formatMoney(person.ReportData[3].last));
	 		$("#ySalesPerCutomer").html(accounting.formatMoney(person.ReportData[3].change));
	 		salespercustomerjsondata = person;
		}

		function getDashboardTenderTypesReport(){
	     	
	 		urlpath = "<?php echo $path_url; ?>api/getDashboardTenderTypesReport/format/json";
	        ajaxType = "GET";
	        var storenum = $("#tt span#user-selected-data-storenum-option").text();
	        general_info  = ({
	        					'storenum' : storenum,
	        					'datefrom':reportdata.sdate,
        						'dateto':reportdata.edate
        			});
	        ajaxfunc(urlpath,general_info,dashboardTTypesFail,getTenderType); 
	    }

	    function dashboardTTypesFail()
	    {
	    	$("#ttypes-graph-container").hide();
			$("#ttypes-table").hide();
			$("#ttypes-no-data-container").show();

			$("#tenderCash").html(0);
	 		$("#tenderCredit").html(0);
	 		$("#tenderCheque").html(0);
	 		
	 		$("#tenderCashPercent").html(0);
	 		$("#tenderCreditPercent").html(0);
	 		$("#tenderChequePercent").html(0);
	 		tenderjsondata = "";
	    }

		function getTenderType(tender)
		{
			$("#ttypes-graph-container").hide();
			$("#ttypes-table").hide();
			$("#ttypes-no-data-container").hide();
			var sr = $("#tr").attr('data-view');
			if(sr == 'pc'){
				$("#ttypes-graph-container").show();
			}
			else{
				$("#ttypes-table").show();
			}
			if(tender.ReportData.cash != 0 || tender.ReportData.crdcard1 != 0 || tender.ReportData.pcheck != 0 ){
				$("#tenderCash").html(accounting.formatMoney(tender.ReportData.cash));
		 		$("#tenderCredit").html(accounting.formatMoney(tender.ReportData.crdcard1));
		 		$("#tenderCheque").html(accounting.formatMoney(tender.ReportData.pcheck));
		 		
		 		$("#tenderCashPercent").html(accounting.formatMoney(tender.ReportData.pcheck));
		 		$("#tenderCreditPercent").html(accounting.formatMoney(tender.ReportData.pcheck));
		 		$("#tenderChequePercent").html(accounting.formatMoney(tender.ReportData.pcheck));
		 		tenderjsondata = tender;
			}
			else{
				tenderjsondata = "";
				$("#ttypes-graph-container").hide();
				$("#ttypes-table").hide();
				$("#ttypes-no-data-container").show();

				$("#tenderCash").html(0);
		 		$("#tenderCredit").html(0);
		 		$("#tenderCheque").html(0);
		 		
		 		$("#tenderCashPercent").html(0);
		 		$("#tenderCreditPercent").html(0);
		 		$("#tenderChequePercent").html(0);
			}
		}

		google.charts.setOnLoadCallback(drawSalesChart());
	  	function drawSalesChart() {

	  		if(storejsondata != '')
	  		{
	  			$("#graph-container").show();
  				var data = new google.visualization.DataTable();
		       	data.addColumn('string', 'Period');
				data.addColumn('number', 'Current');
		        data.addColumn('number', 'Last');
		        
		        var tod = storejsondata.ReportData[0].current;
		      
		        data.addRows([['Day', tod , storejsondata.ReportData[0].last  ]]);  
		        data.addRows([['Month', storejsondata.ReportData[1].current , storejsondata.ReportData[1].last  ]]);  
		        data.addRows([['Quarter', storejsondata.ReportData[2].current , storejsondata.ReportData[2].last   ]]);  
		        data.addRows([['Year', storejsondata.ReportData[3].current , storejsondata.ReportData[3].last  ]]);  
		        var options = {
		            title : 'Sales -'+$("#st #user-selected-data-storenum-option").text(),
		            legend: {position: 'top'},
		            isStacked: false,
		            hAxis: {
		              title: 'Period'
		            },
		            vAxis: {
	              		title: 'Sales',
           				logScale: true
		            }
		        };
		        

		  		var chart = new google.visualization.ColumnChart(document.getElementById('graph-container'));
		      	// Wait for the chart to finish drawing before calling the getImageURI() method.
		      	google.visualization.events.addListener(chart, 'ready', function () {
		        	var content = '<img class="upper" src="' + chart.getImageURI() + '">';
		      		$("#bar_div").append(content);
		      	});
		        chart.draw(data, options);
	  		}
	  		else{
	  			$("#graph-container").hide();
	  		}
	  	}
  	
	  	google.charts.setOnLoadCallback(drawCustomerChart());
	  	function drawCustomerChart() {
	  		if(customerjsondata !=  '')
	  		{
	  			$("#customer-container").show();
	  			var data = new google.visualization.DataTable();
		       	data.addColumn('string', 'Period');
				data.addColumn('number', 'Current');
		        data.addColumn('number', 'Last');
		        
		        data.addRows([['Day', customerjsondata.ReportData[0].current , customerjsondata.ReportData[0].last  ]]); 
		        data.addRows([['Month', customerjsondata.ReportData[1].current , customerjsondata.ReportData[1].last  ]]);  
		        data.addRows([['Quarter', customerjsondata.ReportData[2].current , customerjsondata.ReportData[2].last   ]]);  
		        data.addRows([['Year', customerjsondata.ReportData[3].current , customerjsondata.ReportData[3].last  ]]);  
		        var options = {
		            title : 'Customer -'+$("#cu #user-selected-data-storenum-option").text(),
		            legend: {position: 'top'},
		            isStacked: false,
		            hAxis: {
		              title: 'Period'
		            },
		            vAxis: {
		              title: 'Sales',
		              logScale: true
		            }
		        };
		        

		  		var chart = new google.visualization.ColumnChart(document.getElementById('customer-container'));
		      	// Wait for the chart to finish drawing before calling the getImageURI() method.
		      	google.visualization.events.addListener(chart, 'ready', function () {
		        	var content = '<img class="upper" src="' + chart.getImageURI() + '">';
		      		$("#bar_div").append(content);
		      	});
		        chart.draw(data, options);
	  		}
	      	else{
	  			$("#customer-container").hide();
	  		}
	  	}

	  	google.charts.setOnLoadCallback(drawPayrollChart());
	  	function drawPayrollChart() {
	  		
	  	 	if(payrolljsondata != '')
	  	 	{
	  	 		$("#payroll-container").show();
				var data = new google.visualization.DataTable();
		       	data.addColumn('string', 'Period');
				data.addColumn('number', 'Current');
		        data.addColumn('number', 'Last');

			    data.addRows([['Day', payrolljsondata.ReportData[0].current , payrolljsondata.ReportData[0].last   ]]); 
		        data.addRows([['Month', payrolljsondata.ReportData[1].current , payrolljsondata.ReportData[1].last   ]]);  
		        data.addRows([['Quarter', payrolljsondata.ReportData[2].current , payrolljsondata.ReportData[2].last   ]]);  
		        data.addRows([['Year', payrolljsondata.ReportData[3].current , payrolljsondata.ReportData[3].last  ]]); 
		        var options = {
		            title : 'Payroll -'+$("#py #user-selected-data-storenum-option").text(),
		            isStacked: false,
		            legend: {position: 'top'},
		            hAxis: {
		              title: 'Period'
		            },
		            vAxis: {
		              title: 'Sales',
		              logScale: true
		            }
		        };
		        var chart = new google.visualization.ColumnChart(document.getElementById('payroll-container'));
		      	// Wait for the chart to finish drawing before calling the getImageURI() method.
		      	google.visualization.events.addListener(chart, 'ready', function () {
		        	var content = '<img class="upper" src="' + chart.getImageURI() + '">';
		      		$("#bar_div").append(content);
		      	});
		        chart.draw(data, options);
	  	 	}
	  	 	else{
	  			$("#payroll-container").hide();
	  		}
	  	}

	  	google.charts.setOnLoadCallback(drawGrossMarginChart());
	  	function drawGrossMarginChart() {
	  		if(grossmarginjsondata != '')
	  		{
	  			$("#gross-margin-container").show();
	  			var data = new google.visualization.DataTable();
		       	data.addColumn('string', 'Period');
				data.addColumn('number', 'Current');
		        data.addColumn('number', 'Last');

			    data.addRows([['Day', grossmarginjsondata.ReportData[0].current , grossmarginjsondata.ReportData[0].last   ]]); 
		        data.addRows([['Month', grossmarginjsondata.ReportData[1].current , grossmarginjsondata.ReportData[1].last   ]]);  
		        data.addRows([['Quarter', grossmarginjsondata.ReportData[2].current , grossmarginjsondata.ReportData[2].last   ]]);  
		        data.addRows([['Year', grossmarginjsondata.ReportData[3].current , grossmarginjsondata.ReportData[3].last  ]]); 
		        var options = {
		            title : 'Gross Margin -'+$("#gm #user-selected-data-storenum-option").text(),
		            isStacked: false,
		            legend: {position: 'top'},
		            hAxis: {
		              title: 'Period'
		            },
		            vAxis: {
		              title: 'Sales'
		            }
		        };
		        var chart = new google.visualization.ColumnChart(document.getElementById('gross-margin-container'));
		      	// Wait for the chart to finish drawing before calling the getImageURI() method.
		      	google.visualization.events.addListener(chart, 'ready', function () {
		        	var content = '<img class="upper" src="' + chart.getImageURI() + '">';
		      		$("#bar_div").append(content);
		      	});
		        chart.draw(data, options);
	  		}
	  		else{
	  			$("#gross-margin-container").hide();
	  		}
	      	
	  	}

	  	google.charts.setOnLoadCallback(drawSalesPerCustomerChart());
	  	function drawSalesPerCustomerChart() {
	  		if(salespercustomerjsondata != '')
	  		{
	  			$("#salespercustomer-container").show();
  				var data = new google.visualization.DataTable();
		       	data.addColumn('string', 'Period');
				data.addColumn('number', 'Current');
		        data.addColumn('number', 'Last');
		       
		        data.addRows([['Day', salespercustomerjsondata.ReportData[0].current , salespercustomerjsondata.ReportData[0].last     ]]);  
		        data.addRows([['Month', salespercustomerjsondata.ReportData[1].current , salespercustomerjsondata.ReportData[1].last    ]]);  
		        data.addRows([['Quarter', salespercustomerjsondata.ReportData[2].current , salespercustomerjsondata.ReportData[2].last   ]]);  
		        data.addRows([['Year',  salespercustomerjsondata.ReportData[3].current , salespercustomerjsondata.ReportData[3].last  ]]);  
		        var options = {
		            title : 'Sales Per Customer -'+$("#spc #user-selected-data-storenum-option").text(),
		            isStacked: false,
		            legend: {position: 'top'},
		            hAxis: {
		              title: 'Period'
		            },
		            vAxis: {
		              title: 'Sales'
		            }
		        };

		        var chart = new google.visualization.ColumnChart(document.getElementById('salespercustomer-container'));
		      	// Wait for the chart to finish drawing before calling the getImageURI() method.
		      	google.visualization.events.addListener(chart, 'ready', function () {
		        	var content = '<img class="upper" src="' + chart.getImageURI() + '">';
		      		$("#bar_div").append(content);
		      	});
		        chart.draw(data, options);
	  		}
	  		else{
	  			$("#salespercustomer-container").hide();
	  		}
	      
	  	}

	  	google.charts.setOnLoadCallback(drawTenderTypesChart());
	  	function drawTenderTypesChart() {
	  		if(tenderjsondata != '')
	  		{
	  			$("#tendertypes-container").show()
  				var data = new google.visualization.DataTable();
		       	data.addColumn('string', 'This YR');
				data.addColumn('number', 'Type');
		 			  
		        data.addRows([['Cash', tenderjsondata.ReportData.cash ]]);  
		        data.addRows([['Credit', tenderjsondata.ReportData.crdcard1  ]]);  
		        data.addRows([['Cheque', tenderjsondata.ReportData.pcheck ]]);  
		        var options = {
		            title : 'Tender Types -'+$("#tt #user-selected-data-storenum-option").text(),
		            isStacked: false,
		       		chartArea:{width:'70%',height:'70%'}
		          
		        };
		       	
		         var chart = new google.visualization.PieChart(document.getElementById('tendertypes-container'));
		      	// Wait for the chart to finish drawing before calling the getImageURI() method.
		      	google.visualization.events.addListener(chart, 'ready', function () {
		        	var content = '<img class="upper" src="' + chart.getImageURI() + '">';
		      		$("#bar_div").append(content);
		      	});
		        chart.draw(data, options);
	  		}
	  		else{
	  			$("#tendertypes-container").hide();
	  		}
	      	
	  	}

	  	google.setOnLoadCallback(topFiveDepartment("Department","",reportdata.wsdate,reportdata.wedate));
	 	function topFiveDepartment(default_filter,storenum,startdate,enddate){
	 		
	        urlpath = "<?php echo $path_url; ?>api/getTopFiveDespartmentReport/format/json";
	        ajaxType = "GET";

	        var general_info  = ({'default_filter':default_filter,"storenum":storenum,"datefrom":startdate,"dateto":enddate});
	        ajaxfunc(urlpath,general_info,dashboardSalesFail,setTopFiveChartData); 
	    };
	    
	    function setTopFiveChartData(response)
	    {
    	 	var data = new google.visualization.DataTable();
	       	data.addColumn('string', 'Name');
			data.addColumn('number', 'Sales');
			for (var i = response.ReportData.length - 1; i >= 0; i--) {
		 		data.addRows([[response.ReportData[i].name, response.ReportData[i].sales ]]);  
		  	}		  
	        
		    var options = {
		  		title: 'PieChart',
		       	pieHole: 0.55,
		       	chartArea:{width:'70%',height:'90%'}
		    };

		    var chart = new google.visualization.PieChart(document.getElementById('topfive-report-container'));
	    	google.visualization.events.addListener(chart, 'ready', function () {
	        	var content = '<img class="upper" src="' + chart.getImageURI() + '">';
	      		$("#bar_div").append(content);
	      	});
		    chart.draw(data, options);
		    topfiveData = response;
		    topfivetable();
	    }    
	      
	    function topfivetable() {
	     	var cont_str = '';
	     	if($("#current_top_active").attr('data-view') == "User" ){
	     		$("#user_table").show();
	     		$("#depart_store_table").hide();
	     	}
	     	else{
	     		$("#user_table").hide();
	     		$("#depart_store_table").show();
	     	}
	     	$("#user_table_body").html('');
	     	$("#depart_store_table_body").html('');
	     	for (var i = 0; i <= topfiveData.ReportData.length - 1; i++) {
	     		if($("#current_top_active").attr('data-view') == "User"){
	     			cont_str += "<tr>";
	     			cont_str += "<td>"+topfiveData.ReportData[i].name+"</td>";
	     			cont_str += "<td>"+topfiveData.ReportData[i].storenum+"</td>";
	     			cont_str += "<td>"+topfiveData.ReportData[i].sales+"</td>";
	     			cont_str += "</tr>";
	     		}
	     		else{
	     			cont_str += "<tr>";
	     			cont_str += "<td>"+topfiveData.ReportData[i].name+"</td>";
	     			cont_str += "<td>"+topfiveData.ReportData[i].sales+"</td>";
	     			cont_str += "<td>"+topfiveData.ReportData[i].cost+"</td>";
	     			cont_str += "</tr>";
	     		}
	     	}
	     	if($("#current_top_active").attr('data-view') == "User"){
	     		$("#user_table_body").html(cont_str);	
	     	}
	     	else{
	     		$("#depart_store_table_body").html(cont_str);
	     	}
     	} 
	});  

   //	google.load("visualization", "1", { packages: ["corechart","gauge","bar"] });
	
    $(window).bind("load", function() {
    	$(".se-pre-con").fadeOut();
		
		/*
	     * ---------------------------------------------------------
	     *   Server list 
	     * ---------------------------------------------------------
	     */
	 	serverList();
	    function serverList()
	    {
			urlpath = "<?php echo $path_url; ?>api/serverList/format/json";
	        ajaxType = "GET";
	        serverdata  = "";
	        ajaxfunc(urlpath,serverdata,serverFailureResponseHandler,serverlistReponseHandler); 
	    }
	    
	    function serverFailureResponseHandler(){}

	    function serverlistReponseHandler(response)
	    {
	    	var cont_str = '';
	    	var counter = 1;

	    	if(response != null && response != false){
	    		$("#health-check-list").html('');
	    		detailItem  =1;

	    		$.each(response.serversitename,function(index,key){
	    			$.each(response.serversitename,function(index,key){
						cont_str += "<tr>";
	        			cont_str += "<td><a href='systemhealthreport?sk="+response.serverkey[counter][detailItem]+"'>"+response.serversitename[counter]+" / "+response.serveraname[counter][detailItem]+"</a></td>";
	        			cont_str += "<td>"+(response.serverstatus[counter][detailItem] == "ok" ? "<div id='status-ok'></div>" : "<div id='status-error'></div>" )+"</td>";
	        			cont_str += "<td>"+(response.servertray[counter][detailItem] == 1 ? "<div id='status-ok'></div>" : "<div id='status-error'></div>" )+"</td>";
	        			cont_str += "<td>"+(response.serverbackup[counter][detailItem] == 1 ? "<div id='status-ok'></div>" : "<div id='status-error'></div>" )+"</td>";
	        			cont_str += "<td>"+(response.serverantivirus[counter][detailItem] == 1 ? "<div id='status-ok'></div>" : "<div id='status-error'></div>" )+"</td>";
	        			cont_str += "<td>"+(response.serversoftware[counter][detailItem] == 1 ? "<div id='status-ok'></div>" : "<div id='status-error'></div>" )+"</td>";
	        			cont_str += "</tr>";
	        			detailItem++;	
	    			});
	    			counter++;
	    		});
	    	}
	    	$("#health-check-list").html(cont_str);
	    }    
	   
	    /*
	     * ---------------------------------------------------------
	     *   Workstation list 
	     * ---------------------------------------------------------
	     */
	     workstationList();
	    function workstationList()
	    {
			urlpath = "<?php echo $path_url; ?>api/workstationList/format/json";
	        ajaxType = "GET";
	        workstationdata  = "";
	        ajaxfunc(urlpath,workstationdata,workstationFailureResponseHandler,workstationReponseHandler); 
	  	}

	  	function workstationFailureResponseHandler(){}

	  	function workstationReponseHandler(response)
	  	{
	  		var cont_str = '';
	    	var counter = 1;

	    	if(response != null && response != false){
	    		$.each(response.workstationsitename,function(index,key){
	    			var detailItem  = 1;
	    			$.each(response.workstationname[counter],function(index,key){
						var network_info = "<div id='status-ok'></div>";
						var system_info = "<div id='status-ok'></div>";
						if(response.workstationstatus[counter][detailItem] == "ispdownown" || response.workstationstatus[counter][detailItem] == "offline" || response.workstationstatus[counter][detailItem] == "error" || response.workstationstatus[counter][detailItem] == "inactive" || response.workstationstatus[counter][detailItem] == "overdue"){
							network_info = "<div id='status-ok'></div>";
						}

						if(response.workstationstatus[counter][detailItem] == "ispdownown" || response.workstationstatus[counter][detailItem] == "offline"){
							system_info = "<div id='status-error'></div>";
							network_info = "<div id='status-error'></div>";
						}
						if(response.workstationstatus[counter][detailItem] == "error" || response.workstationstatus[counter][detailItem] == "inactive" || response.workstationstatus[counter][detailItem] == "overdue"){
							system_info = "<div id='status-alert'></div>";
						}

						cont_str += "<tr>";
	        			cont_str += "<td><a href='systemhealthreport?wk="+response.workstationkey[counter][detailItem]+"'>"+response.workstationsitename[counter]+" / "+response.workstationname[counter][detailItem]+"</a></td>";
	        			cont_str += "<td>"+network_info+"</td>";
	        			cont_str += "<td>"+system_info+"</td>";
	        			cont_str += "<td>"+(response.workstationbackup[counter][detailItem] == 1 ? "<div id='status-ok'></div>" : "<div id='status-error'></div>" )+"</td>";
	        			cont_str += "<td>"+(response.workstationantivirus[counter][detailItem] == 1 ? "<div id='status-ok'></div>" : "<div id='status-error'></div>" )+"</td>";
	        			cont_str += "<td>"+(response.workstationsoftware[counter][detailItem] == 1 ? "<div id='status-ok'></div>" : "<div id='status-error'></div>" )+"</td>";
	        			cont_str += "</tr>";
	        			detailItem++;	
	    			});
	    			counter++;
	    		});
	    	}

	    	$("#health-check-list").append(cont_str);
	  	}
	});
	
</script>
<script src="<?php echo $path_url; ?>js/jwplayer-7.2.4/jwplayer.js"></script>
<script>jwplayer.key="0y3P+C+rb54MzVGF0+17frTvpr7BLkR6aXY9gw==";</script>
<script type="text/javascript">
	$(window).load(function() {
		/*
	     * ---------------------------------------------------------
	     *   Handle popup 
	     * ---------------------------------------------------------
	     */
		$(document).on('click','#user_selecting_data_population_type',function(e){
			
			var id = $(this).closest(".widget");
			var opt=$(this).attr('data-view');
			if(id.find(".active").attr("id")=="opt"+opt)
      		{
       			
      		}
      		else
      		{
      			id.find(".slideUp").hide();
      			id.find(".slideUp").removeClass("slideUp");
      			id.find("#opt"+opt).addClass('slideUp');
      			
      			id.find('.view-options span#option-text').text($(this).attr("data-title"));
      		}
 			e.preventDefault();
			// if($(this).attr('data-view') == 'columnchart'){
			// 	$(this).parents().eq(8).find(".table-choice").removeClass('active-div-element');
			// 	$(this).parents().eq(8).find(".table-choice").slideUp(1000);
			// 	$(this).parents().eq(8).find(".graph-choice").addClass('active-div-element');
			// 	$(this).parents().eq(8).find(".graph-choice").slideDown(1000);
			// 	$(this).parent().parent().parent().find('span#option-text').text('Column chart');
			// 	$(this).parent().parent().parent().find('a.menu-option-click').attr('data-view',"bc");
			// }
			// else if($(this).attr('data-view') == 'pie chart'){
			// 	$(this).parents().eq(8).find(".table-choice").removeClass('active-div-element');
			// 	$(this).parents().eq(8).find(".table-choice").slideUp(1000);
			// 	$(this).parents().eq(8).find(".graph-choice").addClass('active-div-element');
			// 	$(this).parents().eq(8).find(".graph-choice").slideDown(1000);
			// 	$(this).parent().parent().parent().find('span#option-text').text('Pie Chart');
			// 	$(this).parent().parent().parent().find('a.menu-option-click').attr('data-view',"pc");
			// }
			// else if($(this).attr('data-view') == 'livefeed'){
			// 	$(this).parents().eq(8).find(".table-choice").removeClass('active-div-element');
			// 	$(this).parents().eq(8).find(".table-choice").slideUp(1000);
			// 	$(this).parents().eq(8).find(".graph-choice").addClass('active-div-element');
			// 	$(this).parents().eq(8).find(".graph-choice").slideDown(1000);
			// 	$(this).parent().parent().parent().find('span#option-text').text('Live Feed');
			// 	$(this).parent().parent().parent().find('a.menu-option-click').attr('data-view',"vc");
				
			//  	initVideoObj(videoPlaying);
			// }
			// else if($(this).attr('data-view') == 'event'){
			// 	$(this).parents().eq(8).find(".table-choice").addClass('active-div-element');
			// 	$(this).parents().eq(8).find(".graph-choice").removeClass('active-div-element');
			// 	$(this).parents().eq(8).find(".graph-choice").slideUp(1000);
			// 	$(this).parents().eq(8).find(".table-choice").slideDown(1000);
			// 	$(this).parent().parent().parent().find('span#option-text').text("Events");
			// 	$(this).parent().parent().parent().find('a.menu-option-click').attr('data-view',"vc");
				
			// }
			// else if($(this).attr('data-view') == 'Department' || $(this).attr('data-view') == 'Store' || $(this).attr('data-view') == 'User' ){
				
			// 	$("#topfive-report-text").text($(this).attr('data-view'));
			// 	$(this).parent().parent().parent().find('span#option-text').text($(this).attr('data-view'));
		 //  		var default_filter = ({ 'default_filter' : $(this).attr('data-view').trim()}); 
		 //  		$("#current_top_active").attr('data-view',$(this).attr('data-view').trim());
		  		
   //      		//google.charts.setOnLoadCallback(topFiveDepartment($(this).attr('data-view').trim(),$("#tf").attr('data-view').trim(),$("#inputFromDate").val(),$("#inputToDate").val() ));
			// }
			// else{
			// 	$(this).parents().eq(8).find(".table-choice").addClass('active-div-element');
			// 	$(this).parents().eq(8).find(".graph-choice").removeClass('active-div-element');
			// 	$(this).parents().eq(8).find(".graph-choice").slideUp(1000);
			// 	$(this).parents().eq(8).find(".table-choice").slideDown(1000);
			// 	$(this).parent().parent().parent().find('span#option-text').text($(this).attr('data-view'));
			// 	$(this).parent().parent().parent().find('a.menu-option-click').attr('data-view',"tc");
			// }
		});
	
		/*
	     * ---------------------------------------------------------
	     *   Init function
	     * ---------------------------------------------------------
	     */
		var videoData = jQuery('#videoFormFilter').serializeArray();
		getVideoCamList(videoData);

		/*
	     * ---------------------------------------------------------
	     *   Change video
	     * ---------------------------------------------------------
	     */
		$(document).on('click','.video-cam-item',function(){
			var getSoruce = $(this).attr('data-view');
			var source  ;
			$(document).find('tr.selected-row').removeClass('selected-row');
			$(this).addClass('selected-row');
			var videoCamlistContainer = videoCamlist.length - 1;
			for (var i = videoCamlistContainer; i >= 0; i--) {
				if(videoCamlist[i].source == getSoruce){
					source = setVideoCamSource(videoCamlist[i].camid,videoCamlist[i].name,videoCamlist[i].location,videoCamlist[i].department,videoCamlist[i].floor,videoCamlist[i].source);					
					setVideoPalyer(videoCamlist[i].camid,videoCamlist[i].name.trim(),videoCamlist[i].location,videoCamlist[i].department,videoCamlist[i].floor,videoCamlist[i].source);
					getVideoEvents(videoPlaying.camid,eventDates.eventstart,eventDates.eventend);
				}
			}
			initVideoObj(source);
		});

		/*
	     * ---------------------------------------------------------
	     *   Set video player to record current source
	     * ---------------------------------------------------------
	     */
		function setVideoPalyer(camid,name,location,department,floor,source)
		{
			videoPlaying = {
				camid:camid,
				name: name,
				location: location,
				department: department,
				floor: floor,
				source: source,
			}
		}

		/*
	     * ---------------------------------------------------------
	     *   Load default video palyer on page load 
	     * ---------------------------------------------------------
	     */
		function defaultVideoCamSource()
		{
			var defaultList = {
								camid:videoCamlist[0].camid,
								name:videoCamlist[0].name,
								location:videoCamlist[0].location,
								department:videoCamlist[0].department,
								Floor:videoCamlist[0].floor,
								source:videoCamlist[0].source
							}
			setVideoPalyer(videoCamlist[0].camid,videoCamlist[0].name,videoCamlist[0].location,videoCamlist[0].department,videoCamlist[0].floor,videoCamlist[0].source);			  
	 		return defaultList; 	
		}

		/*
	     * ---------------------------------------------------------
	     *   Set video palyer on click
	     * ---------------------------------------------------------
	     */
		function setVideoCamSource(camid,name,location,department,floor,source)
		{
	  		var sources={
	  						camid:camid,
	 						name:name,
	 						location:location,
	 						department:department,
	 						floor:floor,
	 						source:source
	 					};
	 		return sources ;
		}

		
	    function getVideoEvents(camid,startdate,enddate)
	    {
	    	ajaxType = "GET";
	  		urlpath = "<?php echo $path_url; ?>api/getVideoEvents/format/json";
	     	var dataString = ({'camid':camid,'fromdate':startdate,'enddate':enddate});
	     	ajaxfunc(urlpath,dataString,videoEventResponseFailure,loadVideoEventResponse);
	    }
	    function videoEventResponseFailure()
	    {
		 	$(".user-message").show();
	    	$(".message-text").text("No event found").fadeOut(10000);
	    }

	    function loadVideoEventResponse(response)
	    {
		 	if (response != null){
	            var cont_str = '';
	            $(".event-placeholder").html('');
	        	for (var i = response.cam_data.length - 1; i >= 0; i--) {
	        		cont_str += "<tr>";
					cont_str += '<td>'+datetimeconverter(response.cam_data[i].dev_time.trim())+'</td>';
				 	cont_str += '<td>'+(response.cam_data[i].etype.trim() == 'MO' ? "Motion Window":"Trigger")+'</td>';
					cont_str += '<td>'+response.cam_data[i].location+'</td>';
					cont_str += "<td><a href='videoevent/"+response.cam_data[i].id+"' title='View'><span class='glyphicon  glyphicon-eye-open' aria-hidden='true'></span></a></td>";
					cont_str += '</tr>';
	        	}
	            $(".event-placeholder").append(cont_str);
	        } 
	    } 

	 	$(".video-feed-fomr-container").click(function(){
			return false;
		});
	 	setEventsDefaultDates();
	 	/*
	     * ---------------------------------------------------------
	     *   Set week a datetime in event datepicker
	     * ---------------------------------------------------------
	     */
	     
	 	function setEventsDefaultDates(){
			var bdate = new Date();
	       	var edate = new Date();
	       	bdate.setDate(bdate.getDate()-7);
	       	var startdate = bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
	       	var starttime = bdate.getHours() + ":"+bdate.getMinutes() + ":" + bdate.getSeconds();
	       	var enddate = edate.getMonth() + 1 + "/"+edate.getDate() + "/" + edate.getFullYear();
	       	var endtime = edate.getHours()  + ":"+edate.getMinutes() + ":" + edate.getSeconds();
	       	var seventtime = startdate+" "+starttime;
			var eeventtime = enddate+" "+endtime;
			eventDates ={
				eventstart :seventtime,
				eventend :eeventtime
			}
		}

	 	setEventWidgetDateTime(eventDates.eventstart,eventDates.eventend);
		setEventWidgetFilterDate(eventDates.eventstart,eventDates.eventend);
		function setEventWidgetDateTime(startdate,enddate) {
			$("#event-widget-start-date-text").text(startdate);
			$("#event-widget-end-date-text").text(enddate);
		}
		/*
	     * ---------------------------------------------------------
	     *   Set date in datepicker plugin
	     * ---------------------------------------------------------
	     */
		
		function setEventWidgetFilterDate(startdate,enddate)
		{
			$('input[name="widgetEventInputFromDate"]').daterangepicker({ 
				showDropdowns: true,
				timePicker: true,
				timePicker24Hour: true,
				startDate: startdate,
	        	endDate: enddate,
	        	linkedCalendars: false,
		        locale: {
		            format: 'MM/DD/YYYY h:mm'
		        }
			});
		}

		$(".event-date").click(function(){
			$(this).hide();
			$(document).find("#event-widget-date-picker-container").show("slow");
			$(document).find('div.widget-item-list-active').removeClass('widget-item-list-active');
			return false;
		});

		$(".event-widget-date-filter-cancel").click(function(){
			$(document).find("#event-widget-date-picker-container").hide("slow");
			$(".event-date").show();
			return false;
		});

		function getWidgetFilterDate(iternum) {
			var inputstartdate = $("#widgetEventInputFromDate").val();
			var splitdate = inputstartdate.split(' - ');
	       	var bdate = new Date(splitdate[0])
	       	var edate = new Date(splitdate[1])
	       	var startdate = bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
	       	var starttime = bdate.getHours() + ":"+bdate.getMinutes() + ":" + bdate.getSeconds();
	       	var enddate = edate.getMonth() + 1 + "/"+edate.getDate() + "/" + edate.getFullYear();
	       	var endtime = edate.getHours()  + ":"+edate.getMinutes() + ":" + edate.getSeconds();
	       	var seventtime = startdate+" "+starttime;
			var eeventtime = enddate+" "+endtime;
			eventDates ={
				eventstart :seventtime,
				eventend :eeventtime
			}
			setWidgetDateTime(iternum,eventDates.eventstart,eventDates.eventend);
		}

		$(document).on('submit','#event-widget-date-data',function(){
			getWidgetFilterDate();
			setWidgetFilterDate(eventDates.eventstart,eventDates.eventend);
			
			$(document).find("#event-widget-date-picker-container").hide();
			$(".event-date").show();
			$(this).parent().eq(8).find('div.widget-body div.loader-container').show();
		  	getVideoEvents(videoPlaying.camid,eventDates.eventstart,eventDates.eventend);
		  	$(this).parent().eq(8).find('div.widget-body div.loader-container').fadeOut();
	    	return false;
		}) ;

		getVideoDepartment();
		/**
         * ---------------------------------------------------------
         *   Department list
         * ---------------------------------------------------------
         */
		function getVideoDepartment()
		{
			$("#vs .loader-container").show();
			urlpath = "<?php echo $path_url; ?>api/getVideoDepartments/format/json";
	        ajaxType = "GET";
	        video_departments  = "";
	        ajaxfunc(urlpath,video_departments,errorhandler,loadVideoDepartmentResponseHandler); 
	  
		}

		function loadVideoDepartmentResponseHandler(response)
		{
			if(response != null)
			{
				var departmentLenght = response.cam_data.length - 1;
				$("#inputDepartment").html('');
				var cont_str ;
				cont_str += "<option value=''>All Department</option>";
				for (var i = departmentLenght ; i >= 0; i--) {
					cont_str += "<option value='"+response.cam_data[i].department+"'>"+response.cam_data[i].department+"</option>";
				}
				$("#inputDepartment").html(cont_str);
			}

			$("#vs .loader-container").fadeOut();
		}

		function getVideoFloor()
		{
			$(".loader-container").show();
			urlpath = "<?php echo $path_url; ?>api/getVideoFloor/format/json";
	        ajaxType = "GET";
	        video_departments  = "";
	        ajaxfunc(urlpath,video_departments,errorhandler,loadVideoFloorResponseHandler); 
	  
		}
		
		$("#inputStore").on('change',function(){
			var videoData = jQuery('#videoFormFilter').serializeArray();
			getVideoCamList(videoData);
		});

		$("#inputDepartment").on('change',function(){
			var videoData = jQuery('#videoFormFilter').serializeArray();
			getVideoCamList(videoData);
		});

		$("#inputFloor").on('change',function(){
			var videoData = jQuery('#videoFormFilter').serializeArray();
			getVideoCamList(videoData);
		});

		function getVideoCamList(videoData)
		{
			urlpath = "<?php echo $path_url; ?>api/getVideoCamList/format/json";
	        ajaxType = "GET";
	        ajaxfunc(urlpath,videoData,loadVideoCamReponseFailureHandler,loadVideoCamReponseHandler); 	
		}

		function loadVideoCamReponseFailureHandler(){
			$("#video-graph-list").html('');
			var cont_str = "<tr><td colspan='5'>No record found</td></tr>";
			$("#video-graph-list").html(cont_str);
		}
		function loadVideoCamReponseHandler(response)
		{
			if(response != null)
			{
				var cont_str = '';
				
				$("#video-graph-list").html('');
				var videoCamLenght= response.length - 1;
				var serial = 1 ;
				var selectedvideo = '';
				for (var i = 0; i <= videoCamLenght; i++) {
					videoCamlist[i] = new Array();
					videoCamlist[i]['camid'] = response[i].camid;
					videoCamlist[i]['name'] = response[i].title.trim();
					videoCamlist[i]['location'] = response[i].storenum.trim();
					videoCamlist[i]['department'] = response[i].department.trim();
					videoCamlist[i]['floor'] = response[i].floor.trim();
					videoCamlist[i]['source'] = response[i].url.trim();
					
					if(i == 0){
						selectedvideo = 'selected-row';
						defaultSoruce = response[i].url.trim();
						getVideoEvents(response[i].camid,eventDates.eventstart,eventDates.eventend);
					}
					else{
						selectedvideo = '';
					}
					cont_str += '<tr class="video-cam-item row '+selectedvideo+'" data-view="'+response[i].url.trim()+'">'
					cont_str += '<td>'+serial+'</td>'
					cont_str += '<td>'+response[i].title.trim()+'</td>'
					cont_str += '<td>'+response[i].storenum.trim()+'</td>'
					cont_str += '<td>'+response[i].type.trim()+'</td>'
					cont_str += '<td><a href="#"><span class="icon-videocam"></span></a></td>';
					cont_str += '</tr>'
					serial++;
				}
				$("#video-graph-list").html(cont_str);
			}
		}

		function loadVideoFloorResponseHandler(response)
		{
			$(".loader-container").fadeOut(); 
		}
 	});
</script>