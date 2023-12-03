<style>
    .nav-item:hover{
        background-color: crimson;
        border-radius: 2em 2em;
        
    }
   
</style>
 
<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top ">
            <!-- Content -->
            <div class="container-fluid">
                <!-- Brand -->
                <a href="index.php" class="navbar-brand">Project Tracking</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#Nav_bar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Menu -->
                <div class="collapse navbar-collapse" id="Nav_bar">
                    <ul class="navbar-nav ">
                        <li class="nav-item ">
                            <a href="tem_index.php" class="nav-link  actb">Create Project</a>
                        </li>
                        <li class="nav-item">
                            <a href="tem_task.php" class="nav-link">Task</a>
                        </li>
                        <li class="nav-item">
                            <a href="tem_display.php" class="nav-link">Display</a>
                        </li>
                        <li class="nav-item">
                            <a href="tem_report.php" class="nav-link">Report</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <script type="text/javascript">
            $(document).ready(function () {
                $("ul.navbar-nav > li > a").click(
                  function (e) {
                    $("ul.navbar-nav > li").removeClass(
                      "active");
                    $("ul.navbar-nav > li > a").css(
                      "color", "");
 
                    $(this).addClass("active");
                    $(this).css("color", "red");
                });
            });
        </script>