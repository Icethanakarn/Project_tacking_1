<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <script>
        $(document).ready(function() {
            // modal หน้าactivityNew
            $(".open_update").click(function() {

                var idx = $(this).attr('idx');

                $.post("activityNew.php", {
                        id: idx
                    },
                    function(result) {
                        $("#modal_update").html(result);
                    }
                );
                // modal หน้าactivityNew end

            });




        });
    </script>
    <!-- <a href="" class="btn btn-info open_update" data-bs-target="#add_update" data-bs-toggle="modal" idx="< ?php echo $task['task_id']; ?>">
        <i class="bi bi-plus-circle-fill"></i>เพิ่มกิจกรรมย่อย
    </a>
     <div class="modal fade modal-xl" id="add_update">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">เพิ่มกิจกรรมย่อยใน </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="modal_update"></div>
                            </div>
                        </div>

                    </div>
                </div> -->
</body>

</html>