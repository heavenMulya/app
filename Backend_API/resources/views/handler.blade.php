<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                       <!-- <h2>Manage <b>data</b></h2>-->
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addEmployeeModal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></button>
                    </div>
                </div>
            </div>
              <br><br>
          
            <div class="panel panel-default text-center">

             <div class="panel-body">
               <h3 class="pannel-title">
                  No Data Available
                </h3>
               <p>
                 There is No Items To Display At This Time

                
               </p>
            </div>
            </div>
             

    <!-- Add Modal HTML -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('store_brand')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Add Departments Brand</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Department_Brand</label>
                            <input type="text" class="form-control" name="Department_Brand" required>
                        </div>
                        <div class="form-group">
                            <label>Person_Entered</label>
                            <input type="text" class="form-control" name="Person_Entered" required>
                        </div>
                        <div class="form-group">
                            <label>Date_Entered</label>
                            <input type="date" class="form-control" name="Date_Entered" required>
                        </div>
                        <div class="form-group">
                            <label>Month_Entered</label>
                            <input type="text" class="form-control" name="Month_Entered" required>
                        </div>
                        <div class="form-group">
                            <label>Year_Entered</label>
                            <input type="text" class="form-control" name="Year_Entered" required>
                        </div>
                        <div class="form-group">
                            <label>Host_Name</label>
                            <input type="text" class="form-control" name="Host_Name" required>
                        </div>
                        <div class="form-group">
                            <label>IP_Address</label>
                            <input type="text" class="form-control" name="IP_Address" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
