
<span class="dropdown_record"> Records per page : </span>
                 
                            <?php $pg_limit=array(); if(@$page_limit!=''){ $pg_limit[$page_limit]="selected='selected'"; } ?>
              
                            <select name="records_per_page" class="dropdown_per_page">

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=10<?php if(!@$date_of_report){?>&amp;report_date_filter=true<?php }?>&amp;output_position=content' value='10' <?php echo $pg_limit['10']; ?>> 10 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=20<?php if(!@$date_of_report){?>&amp;report_date_filter=true<?php }?>&amp;output_position=content' value='20'  <?php echo $pg_limit['20']; ?>> 20 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=50<?php if(!@$date_of_report){?>&amp;report_date_filter=true<?php }?>&amp;output_position=content' value='50'  <?php echo $pg_limit['50']; ?>> 50 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=100<?php if(!@$date_of_report){?>&amp;report_date_filter=true<?php }?>&amp;output_position=content' value='100'  <?php echo $pg_limit['100']; ?>> 100 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=200<?php if(!@$date_of_report){?>&amp;report_date_filter=true<?php }?>&amp;output_position=content' value='200'  <?php echo $pg_limit['200']; ?>> 200 </option>
                     
                            </select>
