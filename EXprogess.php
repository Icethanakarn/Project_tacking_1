<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
</head>
<body>
    <script>
        $(document).ready(function() {
  $('#example').DataTable({
    "columnDefs": [
      {
        "targets": [2,3],
        "render": function (data, type, row, meta) {
          return '<div class="progress">' +
                 '<div class="progress-bar" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                 '</div>' +
                 '</div>';
        }
      }
    ]
  });
});

    </script>
<table id="example" class="display" style="width:100%">
  <thead>
    <tr>
      <th>Name</th>
      <th>Position</th>
      <th>Progress</th>
      <th>Progress2</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Tiger Nixon</td>
      <td>System Architect</td>
      <td><?php echo 75; ?></td>
      <td>5</td>
    </tr>
    <tr>
      <td>Garrett Winters</td>
      <td>Accountant</td>
      <td>60</td>
      <td>10</td>
    </tr>
    <!-- ... -->
  </tbody>
</table>

</body>
</html>