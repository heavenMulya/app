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
    <style>
        .height{
            height:10vh
        }
        .form{
            position: relative;
        }
        .form .fa-search{
            position:absolute;
            right:17px;
            top:13px;
            padding:2px;
            border-left:1px solid #d1d5db;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

               @if (session('Error'))
                    <div class="alert alert-danger">{{ session('Error') }}</div>
                @endif

                @if (session('No'))
                    <div class="alert alert-danger">{{ session('No') }}</div>
                @endif

                    <div class="col-md-12">
                        <h2 class="text-center">Data <b>Management</b></h2>
                    </div>
                    <div class="col-sm-6">
                    <div id="success" class="alert alert-success" role="alert" style="display:none;">
                       Data saved successfully!
                     </div>

                       
                    </div>
                </div>
               
            </div>
                <br><br>
            
                 <div class="container">
                    <div class="row height d-flex justify-content-center align-items-center">
                        <div class="col-md-4">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addEmployeeModal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></button>
                        </div>
                        <div class="col-md-8">
                                @csrf
                                <i class="fa fa-search"></i>
                                <input type="text" name="searching" id="searching" class="form-control form-input" placeholder="Search anything....">
                                <span class="left-pan"><i class="fa fa-microphone"></i></span>
                               
                              
                                <div id="results"></div>
                        </div>

                    </div>
                 </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Department Brand</th>
                        <th>Created By</th>
						<th>Date</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Host Name</th>
                        <th>IP Address</th>
                        <th>Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees['data'] as $employee)
                    <tr> 
                        <td>{{ $employee['Department_Brand'] }}</td>
                        <td>{{ $employee['Person_Entered'] }}</td>
                        <td>{{ $employee['Date_Entered'] }}</td>
                        <td>{{ $employee['Month_Entered'] }}</td>
                        <td>{{ $employee['Year_Entered'] }}</td>
                        <td>{{ $employee['Host_Name'] }}</td>
                        <td>{{ $employee['IP_Address'] }}</td>
                        
                        <td>
                            <button class="btn btn-info" data-toggle="modal" data-target="#editEmployeeModal{{ $employee['SNO1'] }} ">Edit</button>
                            <button href="#deleteEmployeeModal{{ $employee['SNO1'] }}" class="btn btn-danger" data-toggle="modal">Delete</button>
                        </td>
                    </tr>
                    <!-- Edit Modal HTML -->
                    <div id="editEmployeeModal{{ $employee['SNO1'] }}" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('update_brand', $employee['SNO1'] )}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Employee</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                        <div class="form-group">
                            <label>Department_Brand</label>
                            <input type="text" class="form-control" name="Department_Brand" value="{{$employee['Department_Brand']}}" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Person_Entered</label>
                            <input type="text" class="form-control" name="Person_Entered"  value="{{$employee['Person_Entered']}}"  required>
                        </div>
                        <div class="form-group">
                            <label>Date_Entered</label>
                            <input type="date" class="form-control" name="Date_Entered"  value="{{$employee['Date_Entered']}}"  required>
                        </div>
                        <div class="form-group">
                            <label>Month_Entered</label>
                            <input type="text" class="form-control" name="Month_Entered"  value="{{$employee['Month_Entered']}}"  required>
                        </div>
                        <div class="form-group">
                            <label>Year_Entered</label>
                            <input type="text" class="form-control" name="Year_Entered"  value="{{$employee['Year_Entered']}}"  required>
                        </div>
                        <div class="form-group">
                            <label>Host_Name</label>
                            <input type="text" class="form-control" name="Host_Name"  value="{{$employee['Host_Name']}}"  required>
                        </div>
                        <div class="form-group">
                            <label>IP_Address</label>
                            <input type="text" class="form-control" name="IP_Address"  value="{{$employee['IP_Address']}}"  required>
                        </div>
                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <input type="submit" class="btn btn-info" value="Update">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                      <!-- Delete Modal HTML -->
	<div id="deleteEmployeeModal{{ $employee['SNO1'] }}" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
            <form action="{{ route('delete_brand',$employee['SNO1']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
					<div class="modal-header">						
						<h4 class="modal-title">Delete Department Brand</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<p>Are you sure you want to delete these Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
               


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

<script crossorigin="anonymous">
    $(document).ready(function() {
        $('#searching').on('keyup', function() {
            let query = $(this).val();

            //console.log(query)
            if (query.length > 0) {
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/department/search',
                    type: 'GET',
                    data: { searching: query },
                    success: function(data) {
                        // Clear existing table rows
                        $('tbody').empty();

                        if (data.length > 0) {
                            data.forEach(function(employee) {
                                $('tbody').append(`
                                    <tr>
                                        <td>${employee.Department_Brand}</td>
                                        <td>${employee.Person_Entered}</td>
                                        <td>${employee.Date_Entered}</td>
                                        <td>${employee.Month_Entered}</td>
                                        <td>${employee.Year_Entered}</td>
                                        <td>${employee.Host_Name}</td>
                                        <td>${employee.IP_Address}</td>
                                        <td>
                                          <button class="btn btn-info" data-toggle="modal" data-target="#editEmployeeModal${employee.SNO1}">Edit</button>
                                          <button class="btn btn-danger" data-toggle="modal" data-target="#deleteEmployeeModal${employee.SNO1}">Delete</button>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            // If no data found, show a message
                            $('tbody').append(`
                                <tr>
                                    <td colspan="8" class="text-center">No results found</td>
                                </tr>
                            `);
                        }
                    },
                    error: function(xhr) {
                        // Handle errors
                        $('tbody').empty().append(`
                            <tr>
                                <td colspan="8" class="text-center">Error occurred while fetching results.</td>
                            </tr>
                        `);
                    }
                });
            } 
            
            else {
    $.ajax({
        url: 'http://127.0.0.1:8000/api/product_sp',
        type: 'GET',
        success: function(response) {
            $('tbody').empty();
            if (response.status === "success" && Array.isArray(response.data)) {
                // Populate the table with all employee data
                response.data.forEach(function(employee) {
                    $('tbody').append(`
                        <tr>
                            <td>${employee.Department_Brand}</td>
                            <td>${employee.Person_Entered}</td>
                            <td>${employee.Date_Entered}</td>
                            <td>${employee.Month_Entered}</td>
                            <td>${employee.Year_Entered}</td>
                            <td>${employee.Host_Name}</td>
                            <td>${employee.IP_Address}</td>
                            <td>
                                <button class="btn btn-info" data-toggle="modal" data-target="#editEmployeeModal${employee.SNO1}">Edit</button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteEmployeeModal${employee.SNO1}">Delete</button>
                            </td>
                        </tr>
                    `);
                });
            } else {
                // Handle cases where data is not found or status indicates failure
                $('tbody').append(`
                    <tr>
                        <td colspan="8" class="text-center">No data found or an error occurred.</td>
                    </tr>
                `);
            }
        },
        error: function(xhr) {
            // Handle errors
            $('tbody').empty().append(`
                <tr>
                    <td colspan="8" class="text-center">Error occurred while fetching results.</td>
                </tr>
            `);
        }
    });
}
        });
    });
</script>

            
</html>
