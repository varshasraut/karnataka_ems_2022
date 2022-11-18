   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"  crossorigin="anonymous">
  
<script type="application/javascript" crossorigin="anonymous" src="<?php echo $this->PAYTM_ENVIRONMENT; ?>/merchantpgpui/checkoutjs/merchants/<?php echo $this->PAYTM_MID; ?>.js"></script>
	  <script type="application/javascript" crossorigin="anonymous" src="{js_path}/script.js"></script>
<?php 
if(!empty($incident)){ ?>
<div class="container text-center">
      	<div class="shadow p-3 mb-5 bg-white rounded">
      		<h2>Checkout</h2>
         	<h4>Make Payment</h4>
        	<p>You are making payment of ₹<?php echo $incident[0]->pr_total_amount;?></p>
	        <div class="btn-area">
	            <button type="button" id="JsCheckoutPayment" name="submit" class="btn btn-primary">Pay Now</button>
	        </div>
      	</div>
      </div>
     <script type="application/javascript">
         document.getElementById("JsCheckoutPayment").addEventListener("click", function(){
			openJsCheckoutPopup('<?php echo $result['orderId']?>','<?php echo $result['txnToken']?>','<?php echo $result['amount']?>');
         	}
         );
      </script>
<?php }else{ ?>
      <div class="container text-center">
      	<div class="shadow p-3 mb-5 bg-white rounded">
      		<h2>Checkout</h2>
         	<h4>No record found</h4>
        	
      	</div>
      </div>
      
<?php } ?>
