<div class="row" id="tabs">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
            <!-- <li><a class="nav-link clr" aria-current="page" href="<?php echo base_url(); ?>inspection/dashboard">Dashboard</a></li> -->
            </li>
            <li class="nav-item">
            <li><a class="nav-link clr" aria-current="page" href="<?php echo base_url(); ?>inspection/gri_listing">Grievance</a></li>
            </li>
            <li class="nav-item">
            <li><a class="nav-link clr" aria-current="page" href="<?php echo base_url(); ?>inspection/ins_listing">Inspection</a></li>
            </li>
        </ul>
    </div>
</div>

<style>
    .nav-link.active{
        color:red;
    }
.clr{
    color:grey;
}
a:hover{
    COLOR: #085B80; 
}
</style>
<script>
    document.oncontextmenu = document.body.oncontextmenu = function() {
        return false;
    }
</script>