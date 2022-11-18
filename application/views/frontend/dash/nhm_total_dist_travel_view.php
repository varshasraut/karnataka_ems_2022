   <script>
        $(".mi_loader").fadeOut("slow");
    </script>
<div class="row " style="margin-bottom:5%;">
  <div class="col-md-12 remove_padding_md6"">
      <table class="table table-bordered NHM_Dashboard">
      <thead class="">
        <tr>
        <th colspan="5" >MHEMS 108 Seva</th>
        </tr>
        <tr>
          <th style="width:20%" rowspan="2">Districts</th>
          <th colspan="2">No of Ambulances Deployed</th>
          <th colspan="2">No of Km</th>
        </tr>
        <tr>
          <th style="width:20%">ALS</th>
          <th style="width:20%">BLS</th>
          <th style="width:20%">This Month</th> 
          <th style="width:20%">Till Date</th>
       </tr>
      </thead>
      </table>
      <table class="table table-bordered NHM_Dashboard"">
        <thead >
          <?php foreach ($amb_data as $result){ ?>
            <?php 
            $till_date_km = $result->till_date_km;
            $till_sep_data = $result->till_sep_data;
            $total_till_date =  (int)$till_date_km + (int)$till_sep_data; 
            ?>
        <tr >
          <td style="width:20%"><?php echo $result->dst_name ?></td>
          <td style="width:20%"><?php echo $result->amb_als ?></td>
          <td style="width:20%"><?php echo $result->amb_bls ?></td>
          <td style="width:20%"><?php echo $result->this_month_km  ?></td>
          <td style="width:20%"><?php echo $total_till_date; ?></td>
        </tr>
        <?php } ?>
        </thead>
      </table>
  </div>
 
</div>

