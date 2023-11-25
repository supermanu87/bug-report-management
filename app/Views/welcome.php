<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Reporter System <?=$api_version?></title>
    
    <!-- Bootstrap CSS (you can replace the CDN link with your local Bootstrap file) -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <style>
        /* Add your custom styles here */
        body {
            padding-top: 60px; /* Adjust based on your navigation bar height */
        }
        .logo {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">
        <?=SITE_TITLE?> - <?=ENVIRONMENT?>  <?=$api_version?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <!-- Add your navigation links here -->
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <!-- Table -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Reporter First Name</th>
                <th scope="col">Reporter Last Name</th>
                <th scope="col">Bug Description</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bugs as $bug): ?>
                <tr>
                    <th scope="row"><?= $bug->id ?></th>
                    <td><?= $bug->reporter_first_name ?></td>
                    <td><?= $bug->reporter_last_name ?></td>
                    <td><?= $bug->bug_description ?></td>
                    <td><?= $bug->creation_date ?></td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Insert Button -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#insertModal">Insert</button>
</div>

<!-- Modal -->
<div class="modal" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertModalLabel">Insert Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form elements for inserting data here -->
                <form>
                    <div class="form-group">
                        <label for="name">Reporter First Name:</label>
                        <input type="text" class="form-control" id="reporter_first_name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="name">Reporter Last Name:</label>
                        <input type="text" class="form-control" id="reporter_last_name" placeholder="Enter last name">
                    </div>

                    <div class="form-group">
                        <label for="name">Bug Description:</label>
                        <textarea class="form-control" id="bug_description" rows="5" placeholder="Enter bug description..."></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (you can replace the CDN link with your local Bootstrap file) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>

    $('body').on('click', '.save', function() {
           
        var reporter_first_name = $('#reporter_first_name').val();
        var reporter_last_name = $('#reporter_last_name').val();
        var bug_description = $('#bug_description').val();
        
        body = JSON.stringify(
            {
                "reporter_first_name": reporter_first_name,
                "reporter_last_name": reporter_last_name,
                "bug_description": bug_description
            }
        );

        url = "<?=SITE_URL?>api/bugs/add";
        $.ajax({
        url:url,
        method:"POST",
        data: body,
        dataType: 'json',
        contentType: 'application/json',
        cache: false,
        processData:false,
        success:function(response)
        {
            $('#insertModal').modal('hide');
            if(response.status){
                Swal.fire({
                title: 'Success!',
                text: 'Bug registered successfully',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
            }else{
                Swal.fire({
                title: 'Error!',
                text: 'Error.',
                icon: 'error',
                confirmButtonText: 'OK'
            });

            

            }

        }
        });
        
        
    });

</script>
</body>
</html>
