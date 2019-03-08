<template>
    <div class="report-modal">
        <modal name="addons">
  			<div class="modal-header">
  				<h4 class="text-center">Report Seller :name here </h4>
  			</div>
  			<div class="modal-body">
  				<p>
  					<span>{{  }}</span>
  					<span class="pull-right addon_select">
  						<small class="cost">{{}}</small>
						<input type="checkbox" value="addon" class="addon_chkbox"</span>
  					</span>
  				</p>
  			</div>
  			<div class="modal-footer modal_btns">
  				<button class="btn btn-danger" @click.prevent="">Cancel</button>
  				<button class="btn btn-primary" @click.prevent="">Add Addons</button>
  			</div>
		</modal>
    </div>
</template>

<script>
	export default{
		
	}
</script>

