<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Expense Tracker - Dashboard</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    
    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    
    <!-- Header and Sidebar -->
    <header>
        <!-- Header content -->
    </header>
    
    <aside>
        <!-- Sidebar content -->
    </aside>
    
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Dashboard</li>
            </ol>
        </div><!--/.row-->
        
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
        </div><!--/.row-->
        
        <!-- Dashboard Statistics -->
        <div class="row">
            <!-- Today's Expense -->
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Today's Expense</h4>
                        <div class="easypiechart" id="easypiechart-blue" data-percent="0"><span class="percent">0</span></div>
                    </div>
                </div>
            </div>
            
            <!-- Yesterday's Expense -->
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Yesterday's Expense</h4>
                        <div class="easypiechart" id="easypiechart-orange" data-percent="0"><span class="percent">0</span></div>
                    </div>
                </div>
            </div>
            
            <!-- Weekly Expense -->
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Last 7 Days' Expense</h4>
                        <div class="easypiechart" id="easypiechart-teal" data-percent="0"><span class="percent">0</span></div>
                    </div>
                </div>
            </div>
            
            <!-- Monthly Expense -->
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Last 30 Days' Expense</h4>
                        <div class="easypiechart" id="easypiechart-red" data-percent="0"><span class="percent">0</span></div>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
        
        <!-- Additional Statistics -->
        <div class="row">
            <!-- Current Year Expenses -->
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Current Year Expenses</h4>
                        <div class="easypiechart" id="easypiechart-red" data-percent="0"><span class="percent">0</span></div>
                    </div>
                </div>
            </div>
            
            <!-- Total Expenses -->
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Total Expenses</h4>
                        <div class="easypiechart" id="easypiechart-red" data-percent="0"><span class="percent">0</span></div>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
    </div><!--/.main-->
    
    <!-- Footer -->
    <footer>
        <!-- Footer content -->
    </footer>
    
    <!-- Scripts -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/chart-data.js"></script>
    <script src="js/easypiechart.js"></script>
    <script src="js/easypiechart-data.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/custom.js"></script>
    <script>
        // JavaScript code for updating chart data can be added here
    </script>
</body>
</html>
